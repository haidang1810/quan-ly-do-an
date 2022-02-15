<?php
    if (session_id() === '')
        session_start();
    function loadHKNH($conn) {
        $sql = "SELECT * FROM hocky_namhoc";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<option value='".$row['Id']."'>".$row['HocKy_NamHoc']."</option>";
            }
        }
    }
    if(isset($_POST['search'])){
        include("../../public/config.php");
        global $conn;
        $MaLop = $_POST['search'];
        $sql = "SELECT * FROM nopbailuanvan WHERE MaLopLV='".$MaLop."'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            echo "<table id='tablePro'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Tiêu đề</th>";
            echo "<th>Ghi chú</th>";
            echo "<th>Thời gian bắt đầu</th>";
            echo "<th>Thời gian kết thúc</th>";
            echo "<th>Số nhóm đã nộp</th>";
            echo "<th>Thao tác</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$row['TieuDe']."</td>";
                echo "<td>".$row['GhiChu']."</td>";
                echo "<td>".$row['ThoiGianBD']."</td>";
                echo "<td>".$row['ThoiGianKT']."</td>";
                $countSV = "SELECT * FROM nopluanvanct WHERE Ma='".$row['Id']."' group by Mssv";
                $resultSV = $conn->query($countSV);
                $count = $resultSV->num_rows;
                echo "<td>".$count;
                echo "<form method='POST'>";
                echo "<input type='hidden' value='../../../public/item/".$MaLop."/".$row['TieuDe']."/' name='source'>";
                echo "<input type='hidden' value='".$row['TieuDe'].".zip' name='destination'>";
                echo "<button class='btn_download_proc' name='downloadProc' type='submit'>";
                echo "<i class='fas fa-download'></i> Tải về";
                echo "</button>";
                echo "</form>";
                echo "</td>";
                echo "<td>";
                echo "<form method='POST' class='form-delete'>";
                $findClass = "SELECT Id_hknh FROM lopluanvan WHERE MaLopLV='".$MaLop."'";
                $resultClass = $conn->query($findClass);
                if($resultClass->num_rows > 0){
                    $rowClass = $resultClass->fetch_assoc();
                    $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$rowClass['Id_hknh']."'";
                    $resultHK = $conn->query($checkHK);
                    $rowHK = $resultHK->fetch_assoc();
                    if($rowHK['TrangThai']!=1){
                        echo "<button class='btn_process btn_detail'  name='detailProcess' id='".
                        $row['Id'].",".$row['TieuDe']."' type='button' onclick='showDetail(this.id)'>";
                        echo "<i class='fas fa-info-circle'></i>";
                        echo "</button>";
                    }else{
                        echo "<button class='btn_process btn_primary' id='".$row['Id'].",".$row['TieuDe']
                        .",".$row['GhiChu'].",".$row['ThoiGianBD'].",".$row['ThoiGianKT']."'  name='editProcess' 
                        onclick='showEditProcess(this.id)' type='button'>";
                        echo "<i class='fas fa-edit'></i>";
                        echo "</button>";
                        echo "<button class='btn_process btn_danger' id='".$row['Id']."' name='deleteProcess' type='button'>";
                        echo "<i class='fas fa-trash-alt'></i>";
                        echo "<button class='btn_process btn_detail'  name='detailProcess' id='".
                        $row['Id'].",".$row['TieuDe']."' type='button' onclick='showDetail(this.id)'>";
                        echo "<i class='fas fa-info-circle'></i>";
                        echo "</button>";
                    }
                }
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
        
    }
    if(isset($_POST['add'])){
        include("../../public/config.php");
        global $conn;
        $title = $_POST['tieuDe'];
        $note = $_POST['ghiChu'];
        $timeStart =$_POST['thoiGianBD'];
        $timeEnd = $_POST['thoiGianKT'];
        $class = $_POST['maLop'];
        $isFinal = $_POST['sanPham'];
        $findClass = "SELECT Id_hknh FROM lopluanvan WHERE MaLopLV='".$class."'";
        $resultClass = $conn->query($findClass);
        if($resultClass->num_rows > 0){
            $rowClass = $resultClass->fetch_assoc();
            $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$rowClass['Id_hknh']."'";
            $resultHK = $conn->query($checkHK);
            $rowHK = $resultHK->fetch_assoc();
            if($rowHK['TrangThai']!=1){
                echo 2;
            }else{
                if($isFinal==1){
                    $findFinal = "SELECT * FROM nopbailuanvan WHERE MaLopLV='".$class."' AND Loai=1";
                    $resultFinal = $conn->query($findFinal);
                    if ($resultFinal->num_rows > 0){
                        echo 3;
                        return;
                    }
                }
                $sql = "INSERT INTO nopbailuanvan(TieuDe,GhiChu,ThoiGianBD,ThoiGianKT,Loai,MaLopLV) VALUE('".$title."','".$note."','".$timeStart."','".$timeEnd."',".$isFinal.",'".$class."')";
                if(mysqli_query($conn, $sql)){ 
                    echo 1;
                    $pathClass = "../../public/item/".$class;
                    $pathTitle = "../../public/item/".$class."/".$title;
                    if(file_exists($pathClass)){                
                        if(!file_exists($pathTitle)){
                            mkdir($pathTitle, 7);
                        }
                    }else{
                        mkdir($pathClass, 7);
                        mkdir($pathTitle, 7);
                    }
                    
                } else{
                    mysqli_error($conn);
                }
            }
        }
        
    }

    if(isset($_POST['delete'])){
        include("../../public/config.php");
        global $conn;
        $id = $_POST['maTD'];
        $findTitle = "SELECT * FROM nopbailuanvan WHERE Id='".$id."'";
        $result = $conn->query($findTitle);
        $row = $result->fetch_assoc();
        $path = "../../public/item/".$row['MaLopLV']."/".$row['TieuDe']."/";
        $findDetail = "SELECT * FROM nopluanvanct WHERE Ma='".$id."'";
        $resultDetail = $conn->query($findDetail);
        if($resultDetail->num_rows <= 0){
            $sql = "DELETE FROM nopbailuanvan WHERE Id='".$id."'";
            if(mysqli_query($conn, $sql)){  
                echo 1;  
                rmdir($path);      
            } else
                echo mysqli_error($conn);
        }else echo 2;
    }

    if(isset($_POST['edit'])){
        include("../../public/config.php");
        global $conn;
        $id = $_POST['id'];
        $title = $_POST['tieuDe'];
        $note = $_POST['ghiChu'];
        $timeStart = $_POST['thoiGianBD'];
        $timeEnd = $_POST['thoiGianKT'];
        $findPro = "SELECT * FROM nopbailuanvan WHERE Id='".$id."'";
        $resultPro = $conn->query($findPro);
        if($resultPro->num_rows > 0){
            $row = $resultPro->fetch_assoc();
            $path = "../../public/item/".$row['MaLopLV']."/".$row['TieuDe'];
            $newPath = "../../public/item/".$row['MaLopLV']."/".$title;
            $sql = "UPDATE nopbailuanvan SET TieuDe='".$title."', GhiChu='".$note."',
            ThoiGianBD='".$timeStart."', ThoiGianKT='".$timeEnd."' WHERE Id='".$id."'";
            if(mysqli_query($conn, $sql)){  
                echo 1;  
                rename($path,$newPath);      
            } else{
                echo mysqli_error($conn);
            }
        }
    }

    function loadDetailProcess($conn,$id){
        //tìm lớp của tiến độ
        $findLop = "SELECT * FROM nopbailuanvan WHERE Id='".$id."'";
        $resultLop = $conn->query($findLop);
        if($resultLop->num_rows > 0){
            $rowLop = $resultLop->fetch_assoc();
            echo "<h2>Chi tiết tiến độ ".$rowLop['TieuDe']."</h2>";
            echo "<div class='table'>";
            echo "<table id='tableDetail'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Tên đề tài</th>";
            echo "<th>Sinh viên thực hiện</th>";
            echo "<th>File</th>";
            echo "<th>Thời gian Nộp</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            //tìm danh sach de tai cua lop
            $findTopic = "SELECT * FROM detailuanvan WHERE MaLopLV='".$rowLop['MaLopLV']."'";
            $resultTopic = $conn->query($findTopic);
            if($resultTopic->num_rows > 0){
                while($rowTopic = $resultTopic->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$rowTopic['Ten']."</td>";                    
                    echo "<td>";
                    echo "<ul>";
                    $sql = "SELECT * FROM sinhvien WHERE Mssv='".$rowTopic['Mssv']."'";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        echo "<li class='student'>";
                        echo "<a onclick='showDetailStudent(this.id)'id='".
                        $row['Mssv'].",".$row['HoTen'].",".$row['NamSinh'].",".
                        $row['SDT'].",".$row['DiaChi'].",".$row['Khoa'].",".
                        $row['LOP']."'>".$row['Mssv']."</a>";
                        echo "</li>";
                    }
                    echo "</ul>";
                    echo "</td>";
                    $findDetail = "SELECT * FROM nopluanvanct WHERE Ma='".$id."' AND Mssv='".$rowTopic['Mssv']."'";
                    $resultDetail = $conn->query($findDetail);
                    if($resultDetail->num_rows > 0){                                
                        echo "<td>";
                        echo "<ul>";
                        while($rowDetail = $resultDetail->fetch_assoc()){
                            $fileName = explode("/",$rowDetail['File']);
                            echo "<li class='file'><a href='../../../public/item/".$rowDetail['File']."'>".$fileName[3]."</a></li>";
                        }
                        echo "</ul>";
                        $resultDetail = $conn->query($findDetail);
                        $rowDetail = $resultDetail->fetch_assoc();
                        $pathFolder = explode("/",$rowDetail['File']);
                        echo "<form method='POST'>";
                        echo "<input type='hidden' value='../../../public/item/".$pathFolder[0]."/".$pathFolder[1]."/".$pathFolder[2]."' name='source'>";
                        echo "<input type='hidden' value='".$pathFolder[2].".zip' name='destination'>";                                
                        echo "<button class='btn_download_st' name='download' type='submit'>";
                        echo "<i class='fas fa-download'></i> Tải tất cả";
                        echo "</button>";
                        echo "</form>";
                        echo "</td>";                                
                        echo "<td>".$rowDetail['ThoiGianNop']."</td>";
                    }
                        
                    echo "</tr>";
                }
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }     
    }
    
    function Zip($source, $destination,$include_dir = false){
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }        
        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }        
        $source = str_replace('\\', '/', realpath($source));        
        if (is_dir($source) === true){
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);        
            if ($include_dir) {
                $arr = explode("/",$source);
                $maindir = $arr[count($arr)- 1];    
                $source = "";
                for ($i=0; $i < count($arr) - 1; $i++) { 
                    $source .= '/' . $arr[$i];
                }    
                $source = substr($source, 1);    
                $zip->addEmptyDir($maindir);    
            }
            foreach ($files as $file){                
                $file = str_replace('\\', '/', $file);   
                if( in_array(substr($file, strrpos($file, '/')+1), array('.', '..')) )
                    continue;        
                if (is_dir($file) === true){
                    $zip->addEmptyDir(str_replace($source . '/', '', $file));
                }
                else if (is_file($file) === true){        
                    $str1 = str_replace($source . '/', '', '/'.$file);
                    $zip->addFromString($str1, file_get_contents($file));        
                }
            }
        }
        else if (is_file($source) === true){
            $zip->addFromString(basename($source), file_get_contents($source));
        }
        
        $zip->close();
        header("Content-type: application/zip"); 
        header("Content-Disposition: attachment; filename=$destination"); 
        header("Pragma: no-cache"); 
        header("Expires: 0"); 
        readfile($destination);
        unlink($destination);
    }
    if(isset($_POST['id'])){
        include("../../public/config.php");
        global $conn;
        $hknh = $_POST['id'];
        if (session_id() === '')
        session_start();
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findND = "SELECT MaGV FROM giangvien WHERE TaiKhoan='".$data."'";
        $resultND = $conn->query($findND);
        if ($resultND->num_rows > 0) {
            $rowND = $resultND->fetch_assoc();
            $findLop = "SELECT * FROM lopluanvan WHERE MaGV='".$rowND['MaGV']."' AND Id_hknh='".$hknh."'";
            $resultLop = $conn->query($findLop);
            if($resultLop->num_rows > 0){
                while($rowLop = $resultLop->fetch_assoc()){
                    echo "<option value='".$rowLop['MaLopLV']."'>".$rowLop['MaLopLV']." ".$rowLop['TenLop']."</option>";
                }
            }
        }
    }
    
?>