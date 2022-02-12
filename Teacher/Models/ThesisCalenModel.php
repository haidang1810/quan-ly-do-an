<?php

    function loadHKNH($conn) {
        $sql = "SELECT * FROM hocky_namhoc";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<option value='".$row['Id']."'>".$row['HocKy_NamHoc']."</option>";
            }
        }
    }
    function loadCalen($conn,$MaLop){
        $_SESSION['LLV'] = $MaLop;
        $sql = "SELECT * FROM sinhvien_luanvan WHERE MaLopLV='".$MaLop."'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>";
                echo "<ul>";
                $findSV = "SELECT * FROM sinhvien WHERE Mssv='".$row['Mssv']."'";
                $resultSV = $conn->query($findSV);
                if($resultSV->num_rows > 0){
                    $rowSV = $resultSV->fetch_assoc();
                    echo "<li class='student'>";
                    echo "<a onclick='showDetailStudent(this.id)'id='".
                    $rowSV['Mssv'].",".$rowSV['HoTen'].",".$rowSV['NamSinh'].",".
                    $rowSV['SDT'].",".$rowSV['DiaChi'].",".$rowSV['Khoa'].",".
                    $rowSV['LOP']."'>".$rowSV['Mssv']."</a>";
                    echo "</li>";
                }
                echo "</ul>";
                echo "</td>";
                
                $findCalen = "SELECT * FROM lichbaove WHERE Mssv='".$row['Mssv']."'";
                $resultCalen = $conn->query($findCalen);
                //
                $findClass = "SELECT Id_hknh FROM lopluanvan WHERE MaLopLV='".$MaLop."'";
                $resultClass = $conn->query($findClass);
                if($resultClass->num_rows > 0){
                    $rowClass = $resultClass->fetch_assoc();
                    $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$rowClass['Id_hknh']."'";
                    $resultHK = $conn->query($checkHK);
                    $rowHK = $resultHK->fetch_assoc();
                
                    if($resultCalen->num_rows > 0){
                        
                        echo "<td>";
                        $rowCalen = $resultCalen->fetch_assoc();
                        echo $rowCalen['MaHD'];
                        echo "<ul>";
                        $findHD = "SELECT * FROM hoidong WHERE MaHD='".$rowCalen['MaHD']."'";
                        $resultHD = $conn->query($findHD);
                        $rowHD = $resultHD->fetch_assoc();

                        $findCTHD = "SELECT * FROM giangvien WHERE MaGV='".$rowHD['ChuTich']."'";
                        $resultCTHD = $conn->query($findCTHD);
                        $rowCTHD = $resultCTHD-> fetch_assoc();
                        echo "<li>Chủ tịch: ".$rowCTHD['HoTen']."</li>";
        
                        $findTK = "SELECT * FROM giangvien WHERE MaGV='".$rowHD['ThuKy']."'";
                        $resultTK = $conn->query($findTK);
                        $rowTK = $resultTK-> fetch_assoc();
                        echo "<li>Thư ký: ".$rowTK['HoTen']."</li>";
        
                        $findPB = "SELECT * FROM giangvien WHERE MaGV='".$rowHD['PhanBien']."'";
                        $resultPB = $conn->query($findPB);
                        $rowPB = $resultPB-> fetch_assoc();
                        echo "<li>Phản biện: ".$rowPB['HoTen']."</li>";
                        echo "</ul>";
                        echo "</td>";
                        echo "<td>".$rowCalen['BVLan1']."</td>";
                        echo "<td>".$rowCalen['BVLan2']."</td>";
                        echo "<td>";
                        if($rowHK['TrangThai']==1){
                            echo "<button class='btn_Calen btn_primary' id='".$rowCalen['MaLich'].",".$rowCalen['MaHD']
                            .",".$rowCalen['BVLan1'].",".$rowCalen['BVLan2']."' onclick='showEditCalen(this.id)' type='button'>";
                            echo "<i class='fas fa-edit'></i>";
                            echo "</button>";
                        }
                        echo "</td>";
                    }else{
                        echo "<td></td><td></td><td></td>";
                        echo "<td>";
                        if($rowHK['TrangThai']==1){
                            echo "<button class='btn_Calen btn_primary' id='".$row['Mssv']."'onclick='showEditCalen(this.id)' type='button'>";
                            echo "<i class='fas fa-edit'></i>";
                            echo "</button>";
                        }
                        echo "</td>";
                    }              
                }
                echo "</tr>";
            }
        }
        
    }
    function addProcess($conn,$maHD,$mssv,$BVLan1){
        $sql = "INSERT INTO lichbaove(MaHD,Mssv,BVLan1)".
        "VALUES('".$maHD."','".$mssv."','".$BVLan1."')";
        if(mysqli_query($conn, $sql)){  
            echo"
                <script>
                    Swal.fire(
                        'Đã cập nhật!',
                        'Bạn đã xếp lịch bảo vệ thành công.',
                        'success'
                    )
                </script>
                ";
        } else{
            echo"<script type='text/javascript'> alert('".mysqli_error($conn)."')</script>";
        }
        
    }

    function editProcess($conn,$maLich,$maHD,$BVLan1,$BVLan2){
        $findCalen = "SELECT * FROM lichbaove WHERE MaLich='".$maLich."'";
        $resultCalen = $conn->query($findCalen);
        if($resultCalen->num_rows > 0){
            if($BVLan2!=null)
                $sql = "UPDATE lichbaove SET MaHD='".$maHD."', BVLan1='".$BVLan1."',
                BVLan2='".$BVLan2."' WHERE MaLich='".$maLich."'";
            else
                $sql = "UPDATE lichbaove SET MaHD='".$maHD."', BVLan1='".$BVLan1."' WHERE MaLich='".$maLich."'";
            if(mysqli_query($conn, $sql)){  
                echo"
                    <script>
                        Swal.fire(
                            'Đã cập nhật!',
                            'Bạn đã cập nhật lịch bảo vệ thành công.',
                            'success'
                        )
                    </script>
                    ";
            } else{
                echo"<script type='text/javascript'> alert('".mysqli_error($conn)."')</script>";
            }
        }else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Lịch bảo vệ không tồn tại!'
            })
        </script>
        ";
    }

    
    if(isset($_POST['id'])){
        include("../../public/config.php");
        global $conn;
        $hknh = $_POST['id'];
        $findLop = "SELECT * FROM lopluanvan WHERE Id_hknh='".$hknh."'";
        $resultLop = $conn->query($findLop);
        if($resultLop->num_rows > 0){
            while($rowLop = $resultLop->fetch_assoc()){
                echo "<option value='".$rowLop['MaLopLV']."'>".$rowLop['MaLopLV']." ".$rowLop['TenLop']."</option>";
            }
        }
    }
    
?>