<?php
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
        $findLop = "SELECT * FROM lopluanvan WHERE Id_hknh=".$hknh;
        $resultLop = $conn->query($findLop);
        if($resultLop->num_rows > 0){
            while($rowLop = $resultLop->fetch_assoc()){
                $findGV = "SELECT * FROM giangvien WHERE MaGV='".$rowLop['MaGV']."'";
                $resultGV = $conn->query($findGV);                
                echo "<tr>";
                echo "<td>".$rowLop['MaLopLV']." </td>";
                echo "<td>".$rowLop['TenLop']." </td>";
                if($resultGV->num_rows > 0){
                    $rowGV = $resultGV->fetch_assoc();
                    echo "<td><a id='".$rowGV['MaGV'].",".$rowGV['HoTen'].",".$rowGV['Gmail']."' onclick='showDetailTea(this.id)'>".$rowGV['HoTen']."</a></td>";
                }else echo "<td></td>";
                
                echo "<td>";
                $findClass = "SELECT Id_hknh FROM lopluanvan WHERE MaLopLV='".$rowLop['MaLopLV']."'";
                $resultClass = $conn->query($findClass);
                if($resultClass->num_rows > 0){
                    $rowClass = $resultClass->fetch_assoc();
                    $checkHK = "SELECT TrangThai FROM hocky_namhoc WHERE Id='".$rowClass['Id_hknh']."'";
                    $resultHK = $conn->query($checkHK);
                    $rowHK = $resultHK->fetch_assoc();
                    //
                    echo "<form method='POST' class='form-delete'>";
                    $findSV = "SELECT * FROM sinhvien_luanvan WHERE MaLopLV='".$rowLop['MaLopLV']."'";
                    $resultSV = $conn->query($findSV);
                    if($resultSV->num_rows <= 0 && $rowHK['TrangThai']==1){
                        echo "<button class='btn_class btn_primary' id='".$rowLop['MaLopLV']
                        .",".$rowLop['TenLop'].",".$rowLop['MaGV']."' type='button' onclick='showEditClass(this.id)'>";
                        echo "<i class='fas fa-edit'></i>";
                        echo "</button>";
                        echo "<input type='hidden' value='".$rowLop['MaLopLV']."' name='id-delete'>";
                        echo "<button class='btn_class btn_danger' value='".$rowLop['MaLopLV']."' type='submit' name='deleteClass'>";
                        echo "<i class='fas fa-trash-alt'></i>";
                        echo "</button>";
                        echo " <input type='hidden' value='".$rowLop['MaLopLV']."' name='MaLopLV'>";                   
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
                    title: 'L???i...',
                    text: 'H???c k??? ???? k???t th??c!'
                })
            </script>
            ";
        }else{
            $findLop = "SELECT * FROM lopluanvan WHERE MaLopLV='".$maLop."'";
            $resultLop = $conn->query($findLop);
            if($resultLop->num_rows <= 0){
                $sql = "INSERT INTO lopluanvan(MaLopLV,TenLop,MaGV,Id_hknh)  VALUES('".$maLop."','".$tenLop."','".$maGV."',".$hknh.")";
                if(mysqli_query($conn, $sql)){
                    echo"
                    <script>
                        Swal.fire(
                            '???? th??m!',
                            'B???n ???? th??m l???p h???c ph???n th??nh c??ng.',
                            'success'
                        )
                    </script>
                    ";
                }else echo"<script type='text/javascript'> alert('L???i ".mysqli_error($conn)."')</script>";
            }
            else echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'L???i...',
                    text: 'M?? l???p h???c ph???n ???? t???n t???i!'
                })
            </script>
            ";
        }
    }
    function editClass($conn,$maLop,$tenLop,$maGV){
        $findLop = "SELECT * FROM lopluanvan WHERE MaLopLV='".$maLop."'";
        $resultLop = $conn->query($findLop);
        if($resultLop->num_rows > 0){
            $sql = "UPDATE lopluanvan SET TenLop='".$tenLop."', MaGV='".$maGV."' WHERE MaLopLV='".$maLop."'";
            if(mysqli_query($conn, $sql)){
                echo"
                    <script>
                        Swal.fire(
                            '???? c???p nh???t!',
                            'B???n ???? c???p nh???t l???p h???c ph???n th??nh c??ng.',
                            'success'
                        )
                    </script>
                    ";
            }else echo"<script type='text/javascript'> alert('L???i ".mysqli_error($conn)."')</script>";
        }else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'L???i...',
                text: 'L???p h???c ph??n kh??ng t???n t???i!'
            })
        </script>
        ";
    }

    function deleteClass($conn,$maLop){
        $findLop = "SELECT * FROM lopluanvan WHERE MaLopLV='".$maLop."'";
        $resultLop = $conn->query($findLop);
        if($resultLop->num_rows > 0){
            $sql = "DELETE FROM lopluanvan WHERE MaLopLV='".$maLop."'";
            if(mysqli_query($conn, $sql)){
                echo"
                    <script>
                        Swal.fire(
                            '???? xo??!',
                            'B???n ???? xo?? l???p h???c ph???n th??nh c??ng.',
                            'success'
                        )
                    </script>
                    ";
            }else echo"<script type='text/javascript'> alert('L???i ".mysqli_error($conn)."')</script>";
        }else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'L???i...',
                text: 'L???p h???c ph??n kh??ng t???n t???i!'
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
                    title: 'L???i...',
                    text: 'H???c k??? ???? k???t th??c!'
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
                        $MaLopLV = "";
                        $tenLop = "";
                        if(empty($row[0])||empty($row[1])){
                            $error.=$i." ";
                            $i++;
                            continue;
                        }else{
                            $MaLopLV = $row[0];
                            $tenLop = $row[1];
                        }
                        
                        $findLop = "SELECT * FROM lopluanvan WHERE MaLopLV='".$MaLopLV."'";
                        $resultLop = $conn->query($findLop);
                        if($resultLop->num_rows <= 0){
                            $sql = "INSERT INTO lopluanvan(MaLopLV,TenLop,Id_hknh) VALUES('".
                            $MaLopLV."','".$tenLop."',".$hknh.")";
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
                                '???? th??m!',
                                'B???n ???? th??m th??nh c??ng ".$success." l???p h???c ph???n.',
                                'success'
                            )
                        </script>
                        ";
                    else
                        echo"
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: '???? th??m!',
                                text: 'B???n ???? th??m th??nh c??ng ".$success." l???p h???c ph???n.',
                                footer: 'C??c h??ng b??? l???i: ".$error."'
                            })
                        </script>
                        ";
                    
                }
            }
        }
    }
?>