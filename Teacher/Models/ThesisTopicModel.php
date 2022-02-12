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
    function loadTopic($conn,$MaLop){
        $_SESSION['LLV'] = $MaLop;
        $findDT = "SELECT * FROM detailuanvan WHERE MaLopLV='".$MaLop."'";
        $resultDT = $conn->query($findDT);
        if ($resultDT->num_rows > 0){
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
                        echo "<form method='POST' class='form-delete'>";
                        echo "<input type='hidden' value='".$rowDT['MaDT']."' name='input-delete'>";
                        echo "<button class='btn_topic btn_primary' id='".$rowDT['MaDT'].",".$rowDT['Ten'].",".$rowDT['GhiChu'].",".$rowDT['Mssv']."' type='button' onclick='showEditTopic(this.id)'><i class='fas fa-edit'></i></button>";  
                        echo "<button class='btn_topic btn_danger' name='deleteTopic' type='submit'><i class='fas fa-trash-alt'></i></button>";
                        echo "</form>";
                        echo "</td>";
                    }
                }
                echo "</tr>";
            }
        }
    }
    function addToppic($conn,$maLop,$ten,$ghiChu,$mssv){
        $findClass = "SELECT Id_hknh FROM lopluanvan WHERE MaLopLV='".$maLop."'";
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
                $findSVL = "SELECT * FROM sinhvien_luanvan WHERE Mssv='".$mssv."' AND MaLopLV='".$maLop."'";
                $resultSVL = $conn->query($findSVL);
                if($resultSVL->num_rows > 0){
                    $findSV = "SELECT * FROM detailuanvan WHERE Mssv='".$mssv."'";
                    $resultSV = $conn->query($findSV);
                    if($resultSV->num_rows <= 0){
                        $sql = "INSERT INTO detailuanvan(MaLopLV,Ten,GhiChu,Mssv) VALUE('".
                        $maLop."','".$ten."','".$ghiChu."','".$mssv."')";
                        if(mysqli_query($conn, $sql)){ 
                            echo"
                            <script>
                                Swal.fire(
                                    'Đã thêm!',
                                    'Bạn đã thêm đề tài thành công.',
                                    'success'
                                )
                            </script>
                            ";
                        } else{
                            echo"<script type='text/javascript'> alert('Lỗi: ".mysqli_error($conn)."')</script>";
                        }
                    }else echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Sinh viên đã có đề tài!'
                        })
                    </script>
                    ";
                }else 
                    echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi...',
                                text: 'Sinh viên Không học lớp ".$maLop."!'
                            })
                        </script>
                        ";
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
                    </script>
                ";
            }
        }
    }
    function deleTopic($MaDT,$conn){
        $findDK = "SELECT * FROM detailuanvan WHERE MaDT='".$MaDT."'";
        $resultDK = $conn->query($findDK);
        if ($resultDK->num_rows > 0){
            $deleTopic = "DELETE FROM detailuanvan WHERE MaDT='".$MaDT."'";
            if(mysqli_query($conn, $deleTopic)){  
                echo"
                    <script>
                        Swal.fire(
                            'Đã xoá!',
                            'Bạn đã xoá đề tài thành công.',
                            'success'
                        )
                    </script>
                    ";     
            } else{
                echo"<script type='text/javascript'> alert('".mysqli_error($conn)."')</script>";
            }
        }
        else
        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Đề tài không tồn tại!'
            })
        </script>
        ";
    }

    function editTopic($maDT,$ten, $ghiChu, $mssv,$conn){
        $findTopic = "SELECT * FROM detailuanvan WHERE MaDT='".$maDT."'";
        $resultTopic = $conn->query($findTopic);
        if($resultTopic->num_rows > 0){
            $sqlEdit = "UPDATE detailuanvan SET Ten='".$ten."', GhiChu='".$ghiChu."', Mssv='".$mssv."' WHERE MaDT='".$maDT."'";
            if(mysqli_query($conn, $sqlEdit))
                echo"
                <script>
                    Swal.fire(
                        'Đã cập nhật!',
                        'Bạn đã cập nhật đề tài thành công.',
                        'success'
                    )
                </script>
                ";
            else
                echo"<script type='text/javascript'> alert('".mysqli_error($conn)."')</script>";
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