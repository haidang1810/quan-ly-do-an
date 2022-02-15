<?php
ob_start();
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
    //function loadProcess($conn,$MaLop)
    if(isset($_POST['search'])){
        include("../../public/config.php");
        global $conn;
        $MaLop = $_POST['search'];
        $sql = "SELECT * FROM nopbai WHERE MaLopHP='".$MaLop."'";
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
                echo "<td>".$row['ThoiGianBatDau']."</td>";
                echo "<td>".$row['ThoiGianKetThuc']."</td>";
                $countSV = "SELECT * FROM nopbaichitiet WHERE Ma='".$row['Id']."' group by Mssv";
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
                $findClass = "SELECT Id_hknh FROM lophocphan WHERE MaLopHP='".$row['MaLopHP']."'";
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
                        echo "<form method='POST' class='form-delete'>";
                        echo "<button class='btn_process btn_primary' id='".$row['Id'].",".$row['TieuDe']
                        .",".$row['GhiChu'].",".$row['ThoiGianBatDau'].",".$row['ThoiGianKetThuc']."'  name='editProcess' 
                        onclick='showEditProcess(this.id)' type='button'>";
                        echo "<i class='fas fa-edit'></i>";
                        echo "</button>";
                        echo "<button class='btn_process btn_danger' id='".$row['Id']."' name='deleteProcess' type='button'>";
                        echo "<i class='fas fa-trash-alt'></i>";
                        echo "</button>";
                        echo "<button class='btn_process btn_detail'  name='detailProcess' id='".
                        $row['Id'].",".$row['TieuDe']."' type='button' onclick='showDetail(this.id)'>";
                        echo "<i class='fas fa-info-circle'></i>";
                        echo "</button>";
                        echo "</form>";
                    }
                }
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
        $findClass = "SELECT Id_hknh FROM lophocphan WHERE MaLopHP='".$class."'";
        $resultClass = $conn->query($findClass);
        if($resultClass->num_rows > 0){
            $rowClass = $resultClass->fetch_assoc();
            $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$rowClass['Id_hknh']."'";
            $resultHK = $conn->query($checkHK);
            $rowHK = $resultHK->fetch_assoc();
            if($rowHK['TrangThai']!=1){
                echo 2;
            }else {
                if($isFinal==1){
                    $findFinal = "SELECT * FROM nopbai WHERE MaLopHP='".$class."' AND Loai=1";
                    $resultFinal = $conn->query($findFinal);
                    if ($resultFinal->num_rows > 0){
                        echo 3;
                        return;
                    }
                }
                $sql = "INSERT INTO nopbai(TieuDe,GhiChu,ThoiGianBatDau,ThoiGianKetThuc,Loai,MaLopHP) VALUE('".$title."','".$note."','".$timeStart."','".$timeEnd."',".$isFinal.",'".$class."')";
                if(mysqli_query($conn, $sql)){ 
                    
                    $pathClass = "../../public/item/".$class."/";
                    $pathTitle = "../../public/item/".$class."/".$title."/";
                    if(file_exists($pathClass)){                
                        if(!file_exists($pathTitle)){
                            mkdir($pathTitle, 7);
                        }
                    }else{
                        mkdir($pathClass, 7);
                        mkdir($pathTitle, 7);
                    }
                    echo 1;
                } else{
                    echo mysqli_error($conn);
                }
            }
        }
    }

    if(isset($_POST['delete'])){
        include("../../public/config.php");
        global $conn;
        $id = $_POST['maTD'];
        $findTitle = "SELECT * FROM nopbai WHERE Id='".$id."'";
        $result = $conn->query($findTitle);
        $row = $result->fetch_assoc();
        $path = "../../public/item/".$row['MaLopHP']."/".$row['TieuDe']."/";
        $findDetail = "SELECT * FROM nopbaichitiet WHERE Ma='".$id."'";
        $resultDetail = $conn->query($findDetail);
        if($resultDetail->num_rows <= 0){
            $sql = "DELETE FROM nopbai WHERE Id='".$id."'";
            if(mysqli_query($conn, $sql)){  
                echo 1;
                rmdir($path);
            } else
                echo mysqli_error($conn);
        }else 2;
        
    }

    //unction editProcess($conn,$id,$title,$note,$timeStart,$timeEnd)
    if(isset($_POST['edit'])){
        include("../../public/config.php");
        global $conn;
        $id = $_POST['id'];
        $title = $_POST['tieuDe'];
        $note = $_POST['ghiChu'];
        $timeStart = $_POST['thoiGianBD'];
        $timeEnd = $_POST['thoiGianKT'];
        $findPro = "SELECT * FROM nopbai WHERE Id='".$id."'";
        $resultPro = $conn->query($findPro);
        if($resultPro->num_rows > 0){
            $row = $resultPro->fetch_assoc();
            $path = "../../public/item/".$row['MaLopHP']."/".$row['TieuDe'];
            $newPath = "../../public/item/".$row['MaLopHP']."/".$title;
            $sql = "UPDATE nopbai SET TieuDe='".$title."', GhiChu='".$note."',
            ThoiGianBatDau='".$timeStart."', ThoiGianKetThuc='".$timeEnd."' WHERE Id='".$id."'";
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
        $findLop = "SELECT * FROM nopbai WHERE id='".$id."'";
        $resultLop = $conn->query($findLop);
        if($resultLop->num_rows > 0){
            $rowLop = $resultLop->fetch_assoc();
            echo "<h2>Chi tiết tiến độ ".$rowLop['TieuDe']."</h2>";
            echo "<div class='table'>";
            echo "<table id='tableDetail'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Tên đề tài</th>";
            echo "<th>Nhóm sinh viên</th>";
            echo "<th>File</th>";
            echo "<th>Thời gian Nộp</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            //tìm danh sach de tai cua lop
            $findTopic = "SELECT * FROM detai WHERE MaLopHP='".$rowLop['MaLopHP']."'";
            $resultTopic = $conn->query($findTopic);
            if($resultTopic->num_rows > 0){
                while($rowTopic = $resultTopic->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$rowTopic['TenDeTai']."</td>";
                    
                    //tìm nhóm sv
                    $findSV = "SELECT * FROM dangkydetai WHERE MaDeTai='".$rowTopic['MaDeTai']."'";
                    $resultSV = $conn->query($findSV);
                    if($resultSV->num_rows > 0){
                        echo "<td>";
                        echo "<ul>";
                        while($rowSV = $resultSV->fetch_assoc()){
                            $sql = "SELECT * FROM sinhvien WHERE Mssv='".$rowSV['Mssv']."'";
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
                        }
                        echo "</ul>";
                        echo "</td>";
                        $resultSV = $conn->query($findSV);
                        $flag=0;
                        while($rowSV = $resultSV->fetch_assoc()){
                            $findDetail = "SELECT * FROM nopbaichitiet WHERE Ma='".$id."' AND Mssv='".$rowSV['Mssv']."'";
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
                                $flag=1;
                            }
                        }
                        if($flag==0)
                            echo "<td></td><td></td>";
                        
                    }else echo "<td></td><td></td><td></td>";
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
            $findLop = "SELECT * FROM lophocphan WHERE MaGV='".$rowND['MaGV']."' AND Id_hknh='".$hknh."'";
            $resultLop = $conn->query($findLop);
            if($resultLop->num_rows > 0){
                while($rowLop = $resultLop->fetch_assoc()){
                    echo "<option value='".$rowLop['MaLopHP']."'>".$rowLop['MaLopHP']." ".$rowLop['TenLop']."</option>";
                }
            }
        }
    }
    ob_flush();    
?>