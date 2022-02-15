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
        $findDT = "SELECT * FROM detailuanvan WHERE MaLopLV='".$MaLop."'";
        $resultDT = $conn->query($findDT);
        if ($resultDT->num_rows > 0){
            echo "<table id='tableTopic'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th style='min-width:100px'>Tên đề tài</th>";
            echo "<th>Ghi chú</th>";
            echo "<th>Sinh viên thực hiện</th>";
            echo "<th>Thao tác</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($rowDT = $resultDT->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$rowDT['Ten']."</td>";
                echo "<td>".$rowDT['GhiChu']."</td>";
                $findSV = "SELECT * FROM sinhvien WHERE Mssv='".$rowDT['Mssv']."'";
                $resultSV = $conn->query($findSV);
                if($resultSV->num_rows > 0){
                    $rowSV = $resultSV->fetch_assoc();
                    echo "<td>";
                    echo "<li>";
                    echo "<a onclick='showDetailStudent(this.id)'id='".
                    $rowSV['Mssv'].",".$rowSV['HoTen'].",".$rowSV['NamSinh'].",".
                    $rowSV['SDT'].",".$rowSV['DiaChi'].",".$rowSV['Khoa'].",".
                    $rowSV['LOP']."'>".$rowSV['Mssv']."</a>";
                    echo "</li>";
                    echo "</td>";
                }
                $findClass = "SELECT Id_hknh FROM lopluanvan WHERE MaLopLV='".$MaLop."'";
                $resultClass = $conn->query($findClass);
                if($resultClass->num_rows > 0){
                    $rowClass = $resultClass->fetch_assoc();
                    $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$rowClass['Id_hknh']."'";
                    $resultHK = $conn->query($checkHK);
                    $rowHK = $resultHK->fetch_assoc();
                    if($rowHK['TrangThai']!=1){
                        echo"<td></td>";
                    }else{
                        echo "<td>";
                        echo "<form method='POST' >";
                        echo "<input type='hidden' value='".$rowDT['MaDT']."' name='input-delete'>";
                        echo "<button class='btn_topic btn_primary' id='".$rowDT['MaDT'].",".$rowDT['Ten'].",".$rowDT['GhiChu'].",".$rowDT['Mssv']."' type='button' onclick='showEditTopic(this.id)'><i class='fas fa-edit'></i></button>";  
                        echo "<button class='btn_topic btn_danger' id='".$rowDT['MaDT']."' type='button'><i class='fas fa-trash-alt'></i></button>";
                        echo "</form>";
                        echo "</td>";
                    }
                }
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
    }
    
    if(isset($_POST['add'])){
        include("../../public/config.php");
        global $conn;
        $maLop = $_POST['maLop'];
        $ten = $_POST['tenDT'];
        $ghiChu =$_POST['ghiChu'];
        $mssv = $_POST['mssv'];
        $findClass = "SELECT Id_hknh FROM lopluanvan WHERE MaLopLV='".$maLop."'";
        $resultClass = $conn->query($findClass);
        if($resultClass->num_rows > 0){
            $rowClass = $resultClass->fetch_assoc();
            $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$rowClass['Id_hknh']."'";
            $resultHK = $conn->query($checkHK);
            $rowHK = $resultHK->fetch_assoc();
            if($rowHK['TrangThai']!=1){
                echo 2;
            }else{
                $findSVL = "SELECT * FROM sinhvien_luanvan WHERE Mssv='".$mssv."' AND MaLopLV='".$maLop."'";
                $resultSVL = $conn->query($findSVL);
                if($resultSVL->num_rows > 0){
                    $findSV = "SELECT * FROM detailuanvan WHERE Mssv='".$mssv."'";
                    $resultSV = $conn->query($findSV);
                    if($resultSV->num_rows <= 0){
                        $sql = "INSERT INTO detailuanvan(MaLopLV,Ten,GhiChu,Mssv) VALUE('".
                        $maLop."','".$ten."','".$ghiChu."','".$mssv."')";
                        if(mysqli_query($conn, $sql)){ 
                            echo 1;
                        } else{
                            echo"<script type='text/javascript'> alert('Lỗi: ".mysqli_error($conn)."')</script>";
                        }
                    }else echo 3;
                }
            }
        }
    }
    function multiAdd($conn,$file,$lopLV){
        $findClass = "SELECT Id_hknh FROM lopluanvan WHERE MaLopLV='".$lopLV."'";
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
                    $ten = $sheetData[$i]['A'];
                    $ghiChu = $sheetData[$i]['B'];
                    $mssv = $sheetData[$i]['C'];
                    if(empty($ten)||empty($mssv)){
                        $error.=$i." ";
                        continue;
                    }

                    if(!is_numeric($mssv)){
                        $error.=$i." ";
                        continue;
                    }
                    
                    $findSVL = "SELECT * FROM sinhvien_luanvan WHERE Mssv='".$mssv."' AND MaLopLV='".$lopLV."'";
                    $resultSVL = $conn->query($findSVL);
                    if($resultSVL->num_rows <= 0){
                        $error.=$i." ";
                        continue;
                    }
                    
                    $findSV = "SELECT * FROM detailuanvan WHERE Mssv='".$mssv."'";
                    $resultSV = $conn->query($findSV);
                    if($resultSV->num_rows > 0){
                        $error.=$i." ";
                        continue;
                    }
                    $sql = "INSERT INTO detailuanvan(MaLopLV,Ten,GhiChu,Mssv)
                    VALUES('".$lopLV."','".$ten."','".$ghiChu."','".$mssv."')";
                    if(mysqli_query($conn, $sql)){
                        $success++;
                    }else
                    {
                        $error.=$i." ";
                    }
                }
                if(empty($error))
                    echo"
                    <script>
                        Swal.fire(
                            'Đã thêm!',
                            'Bạn đã thêm thành công ".$success." đề tài.',
                            'success'
                        )
                        setTimeout(() => {
                            window.location.href = window.location.href; 
                        }, 1500);
                    </script>
                ";
                else
                    echo"
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Đã thêm!',
                            text: 'Bạn đã thêm thành công ".$success." đề tài.',
                            footer: 'Các hàng bị lỗi: ".$error."'
                        })
                        setTimeout(() => {
                            window.location.href = window.location.href; 
                        }, 1500);
                    </script>
                ";
            }
        }
    }
    //function deleTopic($MaDT,$conn)
    if(isset($_POST['delete'])){
        include("../../public/config.php");
        global $conn;
        $MaDT = $_POST['maDT'];
        $findDK = "SELECT * FROM detailuanvan WHERE MaDT='".$MaDT."'";
        $resultDK = $conn->query($findDK);
        if ($resultDK->num_rows > 0){
            $deleTopic = "DELETE FROM detailuanvan WHERE MaDT='".$MaDT."'";
            if(mysqli_query($conn, $deleTopic)){  
                echo 1;     
            } else{
                echo mysqli_error($conn);
            }
        }
    }

    
    if(isset($_POST['edit'])){
        include("../../public/config.php");
        global $conn;
        $maDT = $_POST['maDT'];
        $ten = $_POST['tenDT'];
        $ghiChu = $_POST['ghiChu'];
        $findTopic = "SELECT * FROM detailuanvan WHERE MaDT='".$maDT."'";
        $resultTopic = $conn->query($findTopic);
        if($resultTopic->num_rows > 0){
            $sqlEdit = "UPDATE detailuanvan SET Ten='".$ten."', GhiChu='".$ghiChu."' WHERE MaDT='".$maDT."'";
            if(mysqli_query($conn, $sqlEdit))
                echo 1;
            else
                echo mysqli_error($conn);
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