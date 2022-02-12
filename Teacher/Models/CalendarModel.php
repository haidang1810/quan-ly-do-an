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

    function loadCalendar($conn,$MaHP){
        $_SESSION['LHP'] = $MaHP;
        $findCalen = "SELECT * FROM ngaybaocao WHERE MaLopHP='".$MaHP."'";
        $resultCalen = $conn->query($findCalen);
        if($resultCalen->num_rows > 0){
            while($rowCalen = $resultCalen->fetch_assoc()){
                echo "<tr>";
                $NgayBC = date("d/m/Y", strtotime($rowCalen['NgayBC']));
                echo "<td>".$NgayBC."</td>";
                echo "<td>".$rowCalen['ThoiGianBatDau']."</td>";
                echo "<td>".$rowCalen['SoNhomBC']."</td>";
                $findSVHP = "SELECT * FROM sinhvien_hocphan WHERE"
                ." MaLopHP='".$MaHP."' AND LichBaoCao='".$rowCalen['Id']."'";
                $resultSVHP = $conn->query($findSVHP);    
                if($resultSVHP->num_rows > 0){
                    echo "<td>";
                    $temp = array();
                    while($rowSVHP = $resultSVHP->fetch_assoc()){
                        $findTopic = "SELECT * FROM dangkydetai WHERE Mssv='".$rowSVHP['Mssv']."'";
                        $resultTopic = $conn->query($findTopic);
                        $rowTopic = $resultTopic->fetch_assoc();
                        $findNameTopic = "SELECT * FROM detai WHERE MaDeTai='".$rowTopic['MaDeTai']."'";
                        $resultNameTopic = $conn->query($findNameTopic);
                        $rowNameTopic = $resultNameTopic->fetch_assoc();    
                        if(array_search($rowNameTopic['TenDeTai'],$temp)==""){
                            array_push($temp,$rowNameTopic['TenDeTai']);
                            echo "<ul>";
                            echo "<li>";
                            echo $rowNameTopic['TenDeTai'];
                            echo "<ul>";
                            $findSV = "SELECT * FROM dangkydetai WHERE MaDeTai='".$rowTopic['MaDeTai']."'";
                            $resultSV = $conn->query($findSV);
                            if ($resultSV->num_rows > 0){
                                while($rowSV = $resultSV->fetch_assoc()){
                                    $sql = "SELECT * FROM sinhvien WHERE Mssv='".$rowSV['Mssv']."'";
                                    $result = $conn->query($sql);
                                    if($result->num_rows > 0){
                                        $row = $result->fetch_assoc();
                                        echo "<li>";
                                        echo "<a onclick='showDetailStudent(this.id)'id='".
                                        $row['Mssv'].",".$row['HoTen'].",".$row['NamSinh'].",".
                                        $row['SDT'].",".$row['DiaChi'].",".$row['Khoa'].",".
                                        $row['LOP']."'>".$row['Mssv']."</a>";
                                        echo "</li>";
                                    }
                                }
                            }
                            echo "</ul>";
                            echo "</li>";
                            echo "</ul>";
                        }                  
                                                
                    }   
                    echo "</td>";   
                    $findClass = "SELECT Id_hknh FROM lophocphan WHERE MaLopHP='".$MaHP."'";
                    $resultClass = $conn->query($findClass);
                    if($resultClass->num_rows > 0){
                        $rowClass = $resultClass->fetch_assoc();
                        $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$rowClass['Id_hknh']."'";
                        $resultHK = $conn->query($checkHK);
                        $rowHK = $resultHK->fetch_assoc();
                        if($rowHK['TrangThai']!=1){
                            echo "<td></td>";
                        }else{
                            echo "<td>";      
                            echo "<form method='POST'>";
                            echo "<button class='btn_Calen btn_primary' id='".$rowCalen['Id']
                            .",".$rowCalen['NgayBC'].",".$rowCalen['ThoiGianBatDau']
                            .",".$rowCalen['SoNhomBC']."' type='button' onclick='showEditCalen(this.id)'>";
                            echo "<i class='fas fa-edit'></i>";
                            echo "</button>";  
                            echo "</form>";
                            echo "</td>";
                        }    
                    }     
                    
                }else{
                    echo "<td></td>";
                    $findClass = "SELECT Id_hknh FROM lophocphan WHERE MaLopHP='".$MaHP."'";
                    $resultClass = $conn->query($findClass);
                    if($resultClass->num_rows > 0){
                        $rowClass = $resultClass->fetch_assoc();
                        $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$rowClass['Id_hknh']."'";
                        $resultHK = $conn->query($checkHK);
                        $rowHK = $resultHK->fetch_assoc();
                        if($rowHK['TrangThai']!=1){
                            echo "<td></td>";
                        }else{
                            echo "<td>";      
                            echo "<form method='POST' class='form-delete'>";
                            echo "<button class='btn_Calen btn_primary' id='".$rowCalen['Id']
                            .",".$rowCalen['NgayBC'].",".$rowCalen['ThoiGianBatDau']
                            .",".$rowCalen['SoNhomBC']."' type='button' onclick='showEditCalen(this.id)'>";
                            echo "<i class='fas fa-edit'></i>";
                            echo "</button>";
                            echo "<input type='hidden' value='".$rowCalen['Id']."' name='id-delete'>";
                            echo "<button class='btn_Calen btn_danger'  name='deleCalen' type='submit'>";
                            echo "<i class='fas fa-trash-alt'></i>";
                            echo "</button>";
                            echo "</form>";
                            echo "</td>";
                        }    
                    }
                    
                }
                echo "</tr>";
            }
        }
    }

    function addCalen($conn,$dateReport,$timeStart,$Amount,$class){
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
                $sql = "INSERT INTO ngaybaocao(NgayBC,ThoiGianBatDau,SoNhomBC,MaLopHP)"
                ."VALUE('".$dateReport."','".$timeStart."','".$Amount."','".$class."')";
                if(mysqli_query($conn, $sql)){
                    echo"
                        <script>
                            Swal.fire(
                                'Đã thêm!',
                                'Thêm lịch báo cáo thành công.',
                                'success'
                            )
                        </script>
                        ";
                } else{
                    echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                }
            }
        }
        
    }
    function deleCalen($conn, $id){
        $findCalen = "SELECT * FROM ngaybaocao WHERE Id='".$id."'";
        $resultCalen = $conn->query($findCalen);
        if($resultCalen->num_rows > 0){
            $sql = "DELETE FROM ngaybaocao WHERE Id='".$id."'";
            if(mysqli_query($conn, $sql)){
                echo"
                <script>
                    Swal.fire(
                        'Đã xoá!',
                        'Xoá lịch báo cáo thành công.',
                        'success'
                    )
                </script>
                ";  
            } else{
                echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
            }
        }else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Lịch báo cáo không tồn tại!'
            })
        </script>
        ";
    }

    function editCalen($conn,$id,$date,$time,$amount){
        $findCalen = "SELECT * FROM ngaybaocao WHERE Id='".$id."'";
        $resultCalen = $conn->query($findCalen);
        if($resultCalen->num_rows > 0){
            $sql = "UPDATE ngaybaocao SET NgayBC='".$date."', ThoiGianBatDau='".$time."', SoNhomBC='".
            $amount."' WHERE Id='".$id."'";
            if(mysqli_query($conn, $sql)){
                echo"
                    <script>
                        Swal.fire(
                            'Đã cập nhật!',
                            'Cập nhật lịch báo cáo thành công.',
                            'success'
                        )
                    </script>
                    ";
            } else{
                echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
            }
        }else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Lịch báo cáo không tồn tại!'
            })
        </script>
        ";
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
?>