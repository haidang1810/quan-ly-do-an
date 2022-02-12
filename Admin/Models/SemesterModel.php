<?php
    if (session_id() === '')
        session_start();

    function loadHKNH($conn){
        $sql = "SELECT * FROM hocky_namhoc ORDER BY Id";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>";
                echo $row['HocKy_NamHoc'];
                echo "</td>";
                $NgayBD = date("d/m/Y", strtotime($row['NgayBD']));
                $NgayKT = date("d/m/Y", strtotime($row['NgayKT']));
                echo "<td>".$NgayBD."</td>";
                echo "<td>".$NgayKT."</td>";
                echo "<td>";
                if($row['TrangThai']==0){
                    echo "<form method='POST' class='changStatus'>";
                    echo "<input type='hidden' value='".$row['Id']."' name='id_status'>";
                    echo "<button class='btn_semester btn_danger' id='".$row['Id']
                    ."' type='submit'>";
                    echo "Không trong thời gian</button>";
                    echo "</form>";
                }else{
                    echo "<button class='btn_semester btn_detail' type='button'>";
                    echo "Hiện tại</button>";
                }
                echo "</td>";
                echo "<td>";
                
                echo "<button class='btn_semester btn_primary' id='".$row['Id']
                .".".$row['HocKy_NamHoc'].".".$row['NgayBD'].".".$row['NgayKT']."' type='button' onclick='showEditModal(this.id)'>";
                echo "<i class='fas fa-edit'></i>";
                echo "</button>";
                echo "<input type='hidden' value='".$row['Id']."' name='id_hknh'>";
                
                echo "</td>";
                echo "</tr>";
            }
        }
    }
    function AddSemester($conn,$name,$start,$end){
        $sql = "INSERT INTO hocky_namhoc(HocKy_NamHoc,TrangThai,NgayBD,NgayKT) 
        VALUES('".$name."',0,'".$start."','".$end."')";
        if(mysqli_query($conn, $sql)){
            echo"
                <script>
                    Swal.fire(
                        'Đã thêm!',
                        'Bạn đã thêm học kỳ thành công.',
                        'success'
                    )
                </script>
                ";   
        }
    }
    function UpdateSemester($conn,$id,$name,$start,$end){
        $findHK = "SELECT * FROM hocky_namhoc WHERE Id=".$id;
        $resultHK = $conn->query($findHK);
        if($resultHK->num_rows > 0){
            $sql = "UPDATE hocky_namhoc SET 
            HocKy_NamHoc='".$name."', NgayBD='".$start."', NgayKt='".$end
            ."' WHERE Id=".$id;
            if(mysqli_query($conn, $sql)){
                echo"
                    <script>
                        Swal.fire(
                            'Đã cập nhật!',
                            'Bạn đã cập nhật trạng tháiss thành công.',
                            'success'
                        )
                    </script>
                    ";   
            }else echo "Lỗi";
        }else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Học kỳ không tôn tại!'
            })
        </script>
        ";
    }
    function ChangeStatus($conn,$id){
        $findHK = "SELECT * FROM hocky_namhoc WHERE Id=".$id;
        $resultHK = $conn->query($findHK);
        if($resultHK->num_rows > 0){
            $change = "UPDATE hocky_namhoc SET TrangThai=0";
            if(mysqli_query($conn, $change)){
                $sql = "UPDATE hocky_namhoc SET TrangThai=1 WHERE Id=".$id;
                if(mysqli_query($conn, $sql)){
                    echo"
                        <script>
                            Swal.fire(
                                'Đã cập nhật!',
                                'Bạn đã cập nhật trạng tháiss thành công.',
                                'success'
                            )
                        </script>
                        ";   
                }else echo "Lỗi";
            }else echo "Lỗi";
            
        }else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Học kỳ không tôn tại!'
            })
        </script>
        ";
    }
?>