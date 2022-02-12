<?php
    function showStudentList($conn,$MaLop){
        $findStudent = "SELECT * FROM sinhvien_hocphan WHERE MaLopHP='".$MaLop."'";
        $resultStudent = $conn->query($findStudent);
        if ($resultStudent->num_rows > 0){
            while($rowStudent = $resultStudent->fetch_assoc()){
                $sql = "SELECT * FROM sinhvien WHERE Mssv='".$rowStudent['Mssv']."'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                    echo "<tr>";
                    echo "<td><a onclick='showDetailStudent(this.id)'id='".
                    $row['Mssv'].",".$row['HoTen'].",".$row['NamSinh'].",".
                    $row['SDT'].",".$row['DiaChi'].",".$row['Khoa'].",".
                    $row['LOP']."'>".$row['Mssv']."</a></td>";
                    echo "<td>".$row['HoTen']."</td>";
                    echo "<td>".$rowStudent['DiemSo']."</td>";
                    echo "<td>".$rowStudent['DiemChu']."</td>";
                    echo "<td>";
                    echo "</button>";
                    echo "<button class='btn_List btn_primary' id='".
                    $row['Mssv'].",".$MaLop.",".$rowStudent['DiemSo']
                    .",".$rowStudent['DiemChu']."' onclick='showEditScore(this.id)' type='button'>";
                    echo "<i class='fas fa-edit'></i>";
                    echo "</button>";
                    echo "</td>";
                    echo "</tr>";
                    
                }
            }
        }
    }
    function showStudentListThesis($conn,$MaLop){
        $findStudent = "SELECT * FROM sinhvien_luanvan WHERE MaLopLV='".$MaLop."'";
        $resultStudent = $conn->query($findStudent);
        if ($resultStudent->num_rows > 0){
            while($rowStudent = $resultStudent->fetch_assoc()){
                $sql = "SELECT * FROM sinhvien WHERE Mssv='".$rowStudent['Mssv']."'";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    $row = $result->fetch_assoc();
                    echo "<tr>";
                    echo "<td><a onclick='showDetailStudent(this.id)'id='".
                    $row['Mssv'].",".$row['HoTen'].",".$row['NamSinh'].",".
                    $row['SDT'].",".$row['DiaChi'].",".$row['Khoa'].",".
                    $row['LOP']."'>".$row['Mssv']."</a></td>";
                    echo "<td>".$row['HoTen']."</td>";
                    echo "<td>".$rowStudent['DiemCTHD']."</td>";
                    echo "<td>".$rowStudent['DiemCBHD']."</td>";
                    echo "<td>".$rowStudent['DiemPB']."</td>";
                    echo "<td>".$rowStudent['DiemTB']."</td>";
                    echo "<td>".$rowStudent['DiemChu']."</td>";
                    echo "<td>";
                    echo "</button>";
                    echo "<button class='btn_List btn_primary' id='".
                    $row['Mssv'].",".$MaLop.",".$rowStudent['DiemCTHD']
                    .",".$rowStudent['DiemCBHD'].",".$rowStudent['DiemPB']
                    .",".$rowStudent['DiemTB'].",".$rowStudent['DiemChu']."' onclick='showEditLV(this.id)' type='button'>";
                    echo "<i class='fas fa-edit'></i>";
                    echo "</button>";
                    echo "</td>";
                    echo "</tr>";
                    
                }
            }
        }
    }
    function registerTopic($conn,$MaLop){
        $findDT = "SELECT * FROM detai WHERE MaLopHP='".$MaLop."'";
        $resultDT = $conn->query($findDT);
        if ($resultDT->num_rows > 0){
            while( $rowDT = $resultDT->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$rowDT['TenDeTai']."</td>";
                echo "<td>".$rowDT['GhiChu']."</td>";
                echo "<td>".$rowDT['SoThanhVien']."</td>";
                echo "<td>";
                echo "<ul>";
                $findSV = "SELECT * FROM dangkydetai WHERE MaDeTai='".$rowDT['MaDeTai']."'";
                $resultSV = $conn->query($findSV);
                if ($resultSV->num_rows > 0){
                    while( $rowSV = $resultSV->fetch_assoc()){
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
                echo "</td>";
                echo "</tr>";
            }
        }else{
            $findDT = "SELECT * FROM detailuanvan WHERE MaLopLV='".$MaLop."'";
            $resultDT = $conn->query($findDT);
            if ($resultDT->num_rows > 0){
                while( $rowDT = $resultDT->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$rowDT['Ten']."</td>";
                    echo "<td>".$rowDT['GhiChu']."</td>";
                    echo "<td>";
                    echo "<ul>";
                    $sql = "SELECT * FROM sinhvien WHERE Mssv='".$rowDT['Mssv']."'";
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
                
                    echo "</ul>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
        }
    }

    function editScore($conn,$student,$class,$score,$point){
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
                $findStu = "SELECT * FROM sinhvien_hocphan WHERE Mssv='".$student."' AND MaLopHP='".$class."'";
                $resultStu = $conn->query($findStu);
                if ($resultStu->num_rows > 0){
                    $sql = "UPDATE sinhvien_hocphan SET DiemSo='".$score."', DiemChu='".$point
                    ."' WHERE Mssv='".$student."' AND MaLopHP='".$class."'";
                    if(mysqli_query($conn, $sql)){
                        echo"
                        <script>
                            Swal.fire(
                                'Đã cập nhật!',
                                'Bạn đã cập nhật điểm thành công.',
                                'success'
                            )
                        </script>
                        ";
                    } else{
                        echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</>";
                    }
                }
            }
        }
        
    }
    function editScoreLV($conn,$diemCTHD,$diemCBHD,$diemPB,$diemTB,$diemChu,$mssv,$maLop){
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
                $findStu = "SELECT * FROM sinhvien_luanvan WHERE Mssv='".$mssv."' AND MaLopLV='".$maLop."'";
                $resultStu = $conn->query($findStu);
                if ($resultStu->num_rows > 0){
                    $sql = "UPDATE sinhvien_luanvan SET DiemCTHD='".$diemCTHD."', DiemCBHD='".$diemCBHD
                    ."', DiemPB='".$diemPB."', DiemTB='".$diemTB."', DiemChu='".$diemChu."' WHERE Mssv='".$mssv."' AND MaLopLV='".$maLop."'";
                    if(mysqli_query($conn, $sql)){
                        echo"
                            <script>
                                Swal.fire(
                                    'Đã cập nhật!',
                                    'Bạn đã cập nhật điểm thành công.',
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
    }
?>