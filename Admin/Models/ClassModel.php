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
                echo "<td>";
                echo "<ul>";
                echo "<li><b>Tuần bắt đầu:</b> ".$rowLop['TuanBD']."</li>";
                echo "<li><b>Tuần kết thúc:</b> ".$rowLop['TuanKT']."</li>";
                echo "</ul>";
                echo "</td>";
                if($resultGV->num_rows > 0){
                    $rowGV = $resultGV->fetch_assoc();
                    echo "<td><a id='".$rowGV['MaGV'].",".$rowGV['HoTen'].",".$rowGV['NamSinh']
                .",".$rowGV['SDT'].",".$rowGV['Gmail']."' onclick='showDetailTea(this.id)'>".$rowGV['HoTen']."</a></td>";
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
                        .",".$rowLop['TenLop'].",".$rowLop['TuanBD'].",".$rowLop['TuanKT']
                        .",".$rowLop['MaGV']."' type='button' onclick='showEditClass(this.id)'>";
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
    
    function addClass($conn,$maLop,$tenLop,$tuanBD,$tuanKT,$maGV,$hknh){
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
                $sql = "INSERT INTO lophocphan VALUES('".$maLop."','".$tenLop."','".$tuanBD
                ."','".$tuanKT."','".$maGV."',".$hknh.")";
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
    function editClass($conn,$maLop,$tenLop,$tuanBD,$tuanKT,$maGV){
        $findLop = "SELECT * FROM lophocphan WHERE MaLopHP='".$maLop."'";
        $resultLop = $conn->query($findLop);
        if($resultLop->num_rows > 0){
            $sql = "UPDATE lophocphan SET TenLop='".$tenLop."', TuanBD=".$tuanBD
            .", TuanKT=".$tuanKT.", MaGV='".$maGV."' WHERE MaLopHP='".$maLop."'";
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
            $objReader = PHPExcel_IOFactory::createReaderForFile($file);
            $objReader->setLoadSheetsOnly("Sheet1");

            $objExcel = $objReader->load($file);
            $sheetData = $objExcel->getActiveSheet()->toArray("null",true,true,true);
            $success=0;
            $error = "";    
            $lastRow =  $objExcel->setActiveSheetIndex()->getHighestRow();
            for($i=2;$i<=$lastRow;$i++){
                $maLopHP = $sheetData[$i]['A'];
                $tenLop = $sheetData[$i]['B'];
                $tuanBD = $sheetData[$i]['C'];
                $tuanKT = $sheetData[$i]['D'];
                if(!is_numeric($tuanBD)||!is_numeric($tuanKT)){
                    $error.=$i." ";
                    continue;
                }
                if((int)$tuanKT-(int)$tuanBD>17){
                    $error.=$i." ";
                    continue;
                }
                if($maLopHP=='null'||$tenLop=='null'||$tuanBD=='null'||$tuanKT=='null'){
                    $error.=$i." ";
                    continue;
                }
                if($maLopHP=='null'&&$tenLop=='null'&&$tuanBD=='null'&&$tuanKT=='null'){
                    continue;
                }
                $findLop = "SELECT * FROM lophocphan WHERE MaLopHP='".$maLopHP."'";
                $resultLop = $conn->query($findLop);
                if($resultLop->num_rows <= 0){
                    $sql = "INSERT INTO lophocphan(MaLopHP,TenLop,TuanBD,TuanKT,Id_hknh) VALUES('".
                    $maLopHP."','".$tenLop."',".$tuanBD.",".$tuanKT.",".$hknh.")";
                    if(mysqli_query($conn, $sql)){
                        $success++;
                    }else{
                        $error.=$i." ";
                        continue;
                    }

                }else{
                    $error.=$i." ";
                    continue;
                }
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
?>