<?php
    if (session_id() === '')
        session_start();

    function loadHKNH($conn,$MaHKNH=null) {
        $sql = "SELECT * FROM hocky_namhoc";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($MaHKNH==null)
                    echo "<option value='".$row['Id']."'>".$row['HocKy_NamHoc']."</option>";
                else if($MaHKNH==$row['Id']){
                    echo "<option value='".$row['Id']."'selected='selected'>".$row['HocKy_NamHoc']."</option>";                       
                    }
                    else
                        echo "<option value='".$row['Id']."'>".$row['HocKy_NamHoc']."</option>";
            }
        }
    }
    function loadLopHP($conn,$hknh) {
        $_SESSION['HKNH'] = $hknh;
        $findLop = "SELECT * FROM lophocphan WHERE Id_hknh = '".$hknh."'";
        $resultLop = $conn->query($findLop);
        if($resultLop->num_rows > 0){
            while($rowLop = $resultLop->fetch_assoc()){
                $findGV = "SELECT * FROM giangvien WHERE MaGV='".$rowLop['MaGV']."'";
                $resultGV = $conn->query($findGV);                
                echo "<tr>";
                echo "<td>".$rowLop['MaLopHP']." </td>";
                echo "<td>".$rowLop['TenLop']." </td>";
                if($resultGV->num_rows > 0){
                    $rowGV = $resultGV->fetch_assoc();
                    echo "<td><a id='".$rowGV['MaGV'].",".$rowGV['HoTen'].",".$rowGV['Gmail']."' onclick='showDetailTea(this.id)'>".$rowGV['HoTen']."</a></td>";
                }else echo "<td></td>";
                
                echo "<td>";
                $findClass = "SELECT Id_hknh FROM lophocphan WHERE MaLopHP='".$rowLop['MaLopHP']."'";
                $resultClass = $conn->query($findClass);
                if($resultClass->num_rows > 0){
                    $rowClass = $resultClass->fetch_assoc();
                    $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$rowClass['Id_hknh']."'";
                    $resultHK = $conn->query($checkHK);
                    $rowHK = $resultHK->fetch_assoc();
                    //
                    echo "<form method='POST' class='form-delete'>";
                    $findSV = "SELECT * FROM sinhvien_hocphan WHERE MaLopHP='".$rowLop['MaLopHP']."'";
                    $resultSV = $conn->query($findSV);
                    if($resultSV->num_rows <= 0 && $rowHK['TrangThai']==1){
                        echo "<button class='btn_class btn_primary' id='".$rowLop['MaLopHP']
                        .",".$rowLop['TenLop'].",".$rowLop['MaGV']."' type='button' onclick='showEditClass(this.id)'>";
                        echo "<i class='fas fa-edit'></i>";
                        echo "</button>";
                        echo "<input type='hidden' value='".$rowLop['MaLopHP']."' name='id-delete'>";
                        echo "<button class='btn_class btn_danger' type='submit' name='deleteClass'>";
                        echo "<i class='fas fa-trash-alt'></i>";
                        echo "</button>";
                        echo " <input type='hidden' value='".$rowLop['MaLopHP']."' name='MaLopHP'>";                   
                    }
                    echo "</form>";
                }
                echo "</td>";
                echo "</tr>";
            }
        }        
    }
    
    function addClass($conn,$maLop,$tenLop,$maGV,$hknh){
        $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id=".$hknh;
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
            $findLop = "SELECT * FROM lophocphan WHERE MaLopHP='".$maLop."'";
            $resultLop = $conn->query($findLop);
            if($resultLop->num_rows <= 0){
                $sql = "INSERT INTO lophocphan VALUES('".$maLop."','".$tenLop."','".$maGV."',".$hknh.")";
                if(mysqli_query($conn, $sql)){
                    echo"
                    <script>
                        Swal.fire(
                            'Đã thêm!',
                            'Bạn đã thêm lớp học phần thành công.',
                            'success'
                        )
                    </script>
                    ";                    
                }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
            }
            else echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Mã lớp học phần đã tồn tại!'
                })
            </script>
            ";
        }
    }
    function editClass($conn,$maLop,$tenLop,$maGV){
        $findLop = "SELECT * FROM lophocphan WHERE MaLopHP='".$maLop."'";
        $resultLop = $conn->query($findLop);
        if($resultLop->num_rows > 0){
            $sql = "UPDATE lophocphan SET TenLop='".$tenLop."', MaGV='".$maGV."' WHERE MaLopHP='".$maLop."'";
            if(mysqli_query($conn, $sql)){
                echo"
                    <script>
                        Swal.fire(
                            'Đã cập nhật!',
                            'Bạn đã cập nhật lớp học phần thành công.',
                            'success'
                        )
                    </script>
                    ";
            }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
        }else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Lớp học phân không tồn tại!'
            })
        </script>
        ";
    }

    function deleteClass($conn,$maLop){
        $findLop = "SELECT * FROM lophocphan WHERE MaLopHP='".$maLop."'";
        $resultLop = $conn->query($findLop);
        if($resultLop->num_rows > 0){
            $sql = "DELETE FROM lophocphan WHERE MaLopHP='".$maLop."'";
            if(mysqli_query($conn, $sql)){
                echo"
                    <script>
                        Swal.fire(
                            'Đã xoá!',
                            'Bạn đã xoá lớp học phần thành công.',
                            'success'
                        )
                    </script>
                    ";
            }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
        }else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Lớp học phân không tồn tại!'
            })
        </script>
        ";
    }

    function multiAddClass($conn,$file,$hknh){
        $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$hknh."'";
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
                            $maLopHP = "";
                            $tenLop = "";
                            if(empty($row[0])||empty($row[1])){
                                $error.=$i." ";
                                $i++;
                                continue;
                            }else{
                                $maLopHP = $row[0];
                                $tenLop = $row[1];
                            }
                            
                            $findLop = "SELECT * FROM lophocphan WHERE MaLopHP='".$maLopHP."'";
                            $resultLop = $conn->query($findLop);
                            if($resultLop->num_rows <= 0){
                                $sql = "INSERT INTO lophocphan(MaLopHP,TenLop,Id_hknh) VALUES('".
                                $maLopHP."','".$tenLop."',".$hknh.")";
                                if(mysqli_query($conn, $sql)){
                                    $success++;
                                }else{
                                    $error.=$i." ";
                                    $i++;
                                    continue;
                                }
            
                            }else{
                                $error.=$i." ";
                                $i++;
                                continue;
                            }
                            $i++;
                        }
                        if(empty($error))
                        echo"
                            <script>
                                Swal.fire(
                                    'Đã thêm!',
                                    'Bạn đã thêm thành công ".$success." lớp học phần.',
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
                                        text: 'Bạn đã thêm thành công ".$success." lớp học phần.',
                                        footer: 'Các hàng bị lỗi: ".$error."'
                                    })
                                </script>
                            ";
                        
                    }
            }
            
        }
    }
?>