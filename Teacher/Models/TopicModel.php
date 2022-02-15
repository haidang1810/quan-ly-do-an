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




    function multiAdd($conn,$file,$class){
        $findClass = "SELECT Id_hknh FROM lophocphan WHERE MaLopHP='".$class."'";
        $resultClass = $conn->query($findClass);
        if($resultClass->num_rows > 0){
            $rowClass = $resultClass->fetch_assoc();
            $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$rowClass['Id_hknh']."'";
            $resultHK = $conn->query($checkHK);
            $rowHK = $resultHK->fetch_assoc();
            if($rowHK['TrangThai']!=1){
                echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi...',
                        text: 'Học kỳ đã kết thúc!'
                    })
                </script>
                ";
            }else{
                $objReader = PHPExcel_IOFactory::createReaderForFile($file);
                $objReader->setLoadSheetsOnly("Sheet1");

                $objExcel = $objReader->load($file);
                $sheetData = $objExcel->getActiveSheet()->toArray("null",true,true,true);
                $success=0;
                $error = "";
                for($i=2;$i<=count($sheetData);$i++){
                    $name = $sheetData[$i]['A'];
                    $amount = $sheetData[$i]['B'];
                    $note = $sheetData[$i]['C'];
                    if(empty($name)||empty($amount)){
                        $error.=$i." ";
                        continue;
                    }      
                    
                    $sql = "INSERT INTO detai(TenDeTai,GhiChu,SoThanhVien,MaLopHP)
                    VALUES('".$name."','".$note."',".$amount.",'".$class."')";
                    if(mysqli_query($conn, $sql)){
                        $success++;
                    }else
                    {
                        $error.=$i." ";
                    }
                }
                if(empty($error)){
                    echo"
                        <script>
                            Swal.fire(
                                'Đã thêm!',
                                'Bạn đã thêm thành công ".$success." đề tài.',
                                'success'
                            )
                        </script>
                    ";
                }else{
                    echo"
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Đã thêm!',
                                text: 'Bạn đã thêm thành công ".$success." đề tài.',
                                footer: 'Các hàng bị lỗi: ".$error."'
                            })
                        </script>
                    ";
                }
            }
        }
        
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
    if(isset($_POST['search'])){
        include("../../public/config.php");
        global $conn;
        $MaHP = $_POST['search'];
        $findClass = "SELECT Id_hknh FROM lophocphan WHERE MaLopHP='".$MaHP."'";
        $resultClass = $conn->query($findClass);
        if($resultClass->num_rows > 0){
            $rowClass = $resultClass->fetch_assoc();
            $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$rowClass['Id_hknh']."'";
            $resultHK = $conn->query($checkHK);
            $rowHK = $resultHK->fetch_assoc();
        }    
        $findTopic = "SELECT * FROM detai WHERE MaLopHP='".$MaHP."'";
        $resultTopic = $conn->query($findTopic);
        $_SESSION['LHP'] = $MaHP;
        if($resultTopic->num_rows > 0){
            echo "<table id='tableTopic'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th style='max-width:200px'>Tên đề tài</th>";
            echo "<th>Ghi chú</th>";
            echo "<th style='min-width:50px'>Số thành viên</th>";
            echo "<th style='min-width:90px'>Thao tác</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($rowTopic = $resultTopic-> fetch_assoc()){
                $findDK = "SELECT * FROM dangkydetai WHERE MaDeTai='".$rowTopic['MaDeTai']."'";
                $resultDK = $conn->query($findDK);
                if($rowHK['TrangThai']!=1){
                    echo "<tr>";
                    echo "<td>".$rowTopic['TenDeTai'] ."</td>";
                    echo "<td>".$rowTopic['GhiChu'] ."</td>";
                    echo "<td>".$rowTopic['SoThanhVien'] ."</td>";
                    echo "<td></td>";
                    echo "</tr>";
                }else if ($resultDK->num_rows <= 0){
                    echo "<tr>";
                    
                    echo "<td>".$rowTopic['TenDeTai'] ."</td>";
                    echo "<td>".$rowTopic['GhiChu'] ."</td>";
                    echo "<td>".$rowTopic['SoThanhVien'] ."</td>";
                    echo "<td>";
                    echo "<form method='POST' class='form-delete'>";
                    echo "<button class='btn_topic btn_primary' id='".$rowTopic['TenDeTai'].",".$rowTopic['MaDeTai'].",".$rowTopic['SoThanhVien'].",".$rowTopic['GhiChu']."' type='button' onclick='showEditTopic(this.id)'><i class='fas fa-edit'></i></button>";  
                    echo "<button class='btn_topic btn_danger' id='".$rowTopic['MaDeTai']."' name='deleteTopic' type='button'><i class='fas fa-trash-alt'></i></button>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                    
                }
                else{
                    echo "<tr>";
                    echo "<td>".$rowTopic['TenDeTai'] ."</td>";
                    echo "<td>".$rowTopic['GhiChu'] ."</td>";
                    echo "<td>".$rowTopic['SoThanhVien'] ."</td>";
                    echo "<td>";
                    echo "<button class='btn_topic btn_primary' id='".$rowTopic['TenDeTai'].",".$rowTopic['MaDeTai'].",".$rowTopic['SoThanhVien'].",".$rowTopic['GhiChu']."' type='button' onclick='showEditTopic(this.id)'><i class='fas fa-edit'></i></button>";  
                    echo "</td>";
                    echo "</tr>";
                }
                
            }
            echo "</tbody>";
            echo "</table>";
            
        }
    }
    if(isset($_POST['add'])){
        include("../../public/config.php");
        global $conn;
        $Ten = $_POST['tenDT'];
        $SoThanhVien = $_POST['soTV'];
        $GhiChu = $_POST['ghiChu'];
        $MaLop = $_POST['maLop'];
        $findClass = "SELECT Id_hknh FROM lophocphan WHERE MaLopHP='".$MaLop."'";
        $resultClass = $conn->query($findClass);
        if($resultClass->num_rows > 0){
            $rowClass = $resultClass->fetch_assoc();
            $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$rowClass['Id_hknh']."'";
            $resultHK = $conn->query($checkHK);
            $rowHK = $resultHK->fetch_assoc();
            if($rowHK['TrangThai']!=1){
                echo 2;
            }else{
                $sql = "INSERT INTO detai(TenDeTai,GhiChu,SoThanhVien,MaLopHP) 
                VALUES('".$Ten."','".$GhiChu."',".$SoThanhVien.",'".$MaLop."')";
                if(mysqli_query($conn, $sql)){ 
                    echo 1;
                } else{
                    echo mysqli_error($conn);
                }
            }
        }
    }
    if(isset($_POST['edit'])){
        include("../../public/config.php");
        global $conn;
        $Ma = $_POST['maDT'];
        $Ten = $_POST['tenDT'];
        $GhiChu = $_POST['ghiChu'];
        $STV = $_POST['soTV'];
        $findTopic = "SELECT * FROM detai WHERE MaDeTai='".$Ma."'";
        $resultFind = $conn->query($findTopic);
        if($resultFind->num_rows > 0){
            $sqlEdit = "UPDATE detai SET TenDeTai='".$Ten."', SoThanhVien=".$STV.", GhiChu='".$GhiChu."' WHERE MaDeTai='".$Ma."'";
            if(mysqli_query($conn, $sqlEdit)){
                echo 1;
            }
            else
                mysqli_error($conn);
        } 
    }
    if(isset($_POST['delete'])){
        include("../../public/config.php");
        global $conn;
        $MaDeTai = $_POST['maDT'];
        $findDK = "SELECT * FROM dangkydetai WHERE MaDeTai='".$MaDeTai."'";
        $resultDK = $conn->query($findDK);
        if ($resultDK->num_rows <= 0){
            $deleTopic = "DELETE FROM detai WHERE MaDeTai='".$MaDeTai."'";
            if(mysqli_query($conn, $deleTopic)){  
                echo 1;      
            } else{
                echo mysqli_error($conn);
            }
        }
    }
?>