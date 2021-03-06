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
                    echo $rowSV['Mssv'];
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
                            mysqli_error($conn);
                        }
                    }else echo 3;
                }else echo 4;
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
                if($_FILES["file"]["name"] != ''){
                    $allowed_extension = array('xls', 'csv', 'xlsx');
                    $file_array = explode(".", $_FILES["file"]["name"]);
                    $file_extension = end($file_array);

                    if(in_array($file_extension, $allowed_extension)){
                        $file_name = time() . '.' . $file_extension;
                        move_uploaded_file($_FILES['file']['tmp_name'], $file_name);
                        $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
                        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

                        $spreadsheet = $reader->load($file_name);

                        unlink($file_name);

                        $data = $spreadsheet->getActiveSheet()->toArray();
                        $error = "";
                        $success = 0;
                        $i=1;
                        foreach($data as $row){
                            if($i==1){
                                $i++;
                                continue;
                            }
                                
                            $ten = "";
                            $ghiChu = "";
                            $mssv = "";
                            if(empty($row[0])||empty($row[1])||empty($row[2])){
                                $error.=$i." ";
                                $i++;
                                continue;
                            }else{
                                $ten = $row[0];
                                $ghiChu = $row[1];
                                $mssv = $row[2];
                            } 
                            if(!is_numeric($mssv)){
                                $error.=$i." ";
                                $i++;
                                continue;
                            }
                            $findSVL = "SELECT * FROM sinhvien_luanvan WHERE Mssv='".$mssv."' AND MaLopLV='".$lopLV."'";
                            $resultSVL = $conn->query($findSVL);
                            if($resultSVL->num_rows <= 0){
                                $error.=$i." ";
                                $i++;
                                continue;
                            }
                            
                            $findSV = "SELECT * FROM detailuanvan WHERE Mssv='".$mssv."'";
                            $resultSV = $conn->query($findSV);
                            if($resultSV->num_rows > 0){
                                $error.=$i." ";
                                $i++;
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
                            $i++;
                        }
                        if(empty($error))
                            echo"
                            <script>
                                Swal.fire({
                                    title: 'Đã lưu!',
                                    text: 'Bạn đã thêm thành công ".$success." đề tài.',
                                    icon: 'success',
                                    didClose: ()=>{
                                        window.location.href = window.location.href;
                                    }
                                })
                            </script>
                        ";
                        else
                            echo"
                            <script>
                                Swal.fire({
                                    title: 'Đã lưu!',
                                    text: 'Bạn đã thêm thành công ".$success." đề tài.',
                                    icon: 'success',
                                    didClose: ()=>{
                                        window.location.href = window.location.href;
                                    }
                                })
                            </script>
                        ";
                        
                    }
                }
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