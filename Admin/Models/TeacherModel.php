<?php
    require '../../../public/validator/vendor/autoload.php';
    use SMTPValidateEmail\Validator as SmtpEmailValidator;
    if (session_id() === '')
        session_start();
    function loadTeacher($conn){
        $sql = "SELECT * FROM giangvien";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){            
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$row['MaGV']."</td>";
                echo "<td>".$row['HoTen']."</td>";                
                echo "<td>".$row['HocVi']."</td>";                
                echo "<td>".$row['NamSinh']."</td>";
                echo "<td>".$row['SDT']."</td>";
                echo "<td>".$row['Gmail']."</td>";
                echo "<td>";                                
                if(empty($row['TaiKhoan'])){
                    echo "<button class='btn_student btn_primary' id='";
                    echo $row['MaGV'].",".$row['HoTen'].",".$row['HocVi'].",".$row['NamSinh'].",".
                    $row['SDT'].",".$row['Gmail'].",0";
                    echo "' onclick='showEdit(this.id)' type='button'>";
                    echo "<i class='fas fa-edit'></i>";  
                    echo "</button>";
                    echo "<form method='POST'>";
                    echo "<input type='hidden' value='".$row['MaGV']."' name='MaGV'>";
                    echo "<button class='btn_student btn_create' id='' type='submit' name='createAcc'>";
                    echo "Tạo tài khoản</button>";
                    echo "</form>";
                }else{
                    $findAcc = "SELECT * FROM nguoidung WHERE TaiKhoan='".$row['TaiKhoan']."'";
                    $resultAcc = $conn->query($findAcc);
                    $rowAcc = $resultAcc->fetch_assoc();
                    echo "<button class='btn_student btn_primary' id='";
                    echo $row['MaGV'].",".$row['HoTen'].",".$row['HocVi'].",".$row['NamSinh'].",".
                    $row['SDT'].",".$row['Gmail'].",".$rowAcc['Loai'];
                    echo "' onclick='showEdit(this.id)' type='button'>";
                    echo "<i class='fas fa-edit'></i>";  
                    echo "</button>";
                }
                echo "</td>";
                echo "</tr>";
            }            
        }
    }
    function editTeacher($conn,$maGV,$hoTen,$hocVi,$namSinh,$SDT,$gmail,$loai){
        $checkPhone = preg_match( '/^0(\d{9}|9\d{8})$/', $SDT );
        if(!$checkPhone){
            echo"<script type='text/javascript'> alert('Số điện thoại sai định dạng')</script>";
            return;
        }        
        $findGV = "SELECT * FROM giangvien WHERE MaGV='".$maGV."'";
        $resultGV = $conn->query($findGV);
        if($resultGV->num_rows > 0){
            $rowGV = $resultGV->fetch_assoc();
            if($rowGV['Gmail']==$gmail){
                $sql = "UPDATE giangvien SET HoTen='".$hoTen."', HocVi='".$hocVi."', NamSinh='".$namSinh."', SDT='".$SDT."' WHERE MaGV='".$maGV."'";
                if(mysqli_query($conn, $sql)){
                    if($loai!=0){
                        $updateType = "UPDATE nguoidung SET Loai=".$loai." WHERE TaiKhoan='".$rowGV['TaiKhoan']."'";
                        if(mysqli_query($conn, $updateType))
                            echo"<script type='text/javascript'> alert('cập nhật thành công')</script>";
                    }else
                    echo"<script type='text/javascript'> alert('cập nhật thành công')</script>";
                } else{
                    echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                }
            }else{
                $findND = "SELECT * FROM nguoidung WHERE TaiKhoan='".$gmail."'";
                $resultND = $conn->query($findND);
                if($resultND->num_rows <= 0){
                    if($loai!=0){
                        $createAcc = "INSERT INTO nguoidung VALUES('".$gmail."','".$gmail."',".$loai.",1)";
                        if(mysqli_query($conn, $createAcc)){                           
                            $sql = "UPDATE giangvien SET HoTen='".$hoTen."', HocVi='".$hocVi."', NamSinh='".$namSinh."', SDT='".$SDT
                            ."', Gmail='".$gmail."', TaiKhoan='".$gmail."' WHERE MaGV='".$maGV."'";
                            if(mysqli_query($conn, $sql)){
                                $deleteAcc = "DELETE FROM  nguoidung WHERE TaiKhoan='".$rowGV['Gmail']."'";
                                if(mysqli_query($conn, $deleteAcc)){
                                    echo"<script type='text/javascript'> alert('Cập nhật thành công')</script>";
                                }else echo"<script type='text/javascript'> alert('Cập nhật thành công. Xoá tài khoản thất bại mời bạn vô hiệu hoá tài khoản')</script>";                             
                            } else{
                                echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                            }                 
                        }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                    }else echo"<script type='text/javascript'> alert('Chưa chọn phân quyền')</script>";
                    
                }else echo"<script type='text/javascript'> alert('Gmail đã tồn tại')</script>";
            }
            
        }else echo"<script type='text/javascript'> alert('Giảng viên không tồn tại')</script>";
    }
    function multiAddTea($conn,$file,$auto=false){
        $objReader = PHPExcel_IOFactory::createReaderForFile($file);
        $objReader->setLoadSheetsOnly("Sheet1");

        $objExcel = $objReader->load($file);
        $sheetData = $objExcel->getActiveSheet()->toArray("null",true,true,true);
        $success=0;
        $error = "";    
        $lastRow =  $objExcel->setActiveSheetIndex()->getHighestRow();           
        if($auto){
            for($i=2;$i<=$lastRow;$i++){
                $maGV = $sheetData[$i]['A'];
                $hoTen = $sheetData[$i]['B'];
                $hocVi = trim($sheetData[$i]['C']);
                $namSinh = $sheetData[$i]['D'];
                $SDT = $sheetData[$i]['E'];
                $gmail = $sheetData[$i]['F'];
                
                if($maGV=='null'&&$hoTen=='null' &&$hocVi=='null'&&$gmail=='null'&&$namSinh=='null'
                &&$SDT=='null'){
                    continue;
                }
                if($maGV=='null'||$hoTen=='null'||$hocVi=='null'||$gmail=='null'||$namSinh=='null'
                ||$SDT=='null'){
                    $error.=$i." ";
                    continue;
                }

                if($hocVi!="Thạc sĩ" && $hocVi!="Cử nhân" && $hocVi!="Tiến sĩ"){
                    $error.=$i." ";
                    continue;
                }
                //$sender = "dang18101999@gmail.com";
                //$validator = new SmtpEmailValidator($gmail, $sender);
                //$results = $validator->validate();
                //if(!$results){
                    //$error.=$i." ";
                    //continue;
                //}
                $checkPhone = preg_match( '/^0(\d{9}|9\d{8})$/', $SDT );
                if(!$checkPhone){
                    $error.=$i." ";
                    continue;
                }
                $findGV = "SELECT * FROM giangvien WHERE MaGV='".$maGV."'";
                $resultGV = $conn->query($findGV);
                if($resultGV->num_rows <= 0){
                    $createAcc = "INSERT INTO nguoidung VALUES('".$gmail."','".$gmail."',2,1)";
                    if(mysqli_query($conn, $createAcc)){
                        $sql="INSERT INTO giangvien VALUES('".$maGV."','".$hoTen."','".$hocVi."','".$namSinh."','".
                        $SDT."','".$gmail."','".$gmail."')";
                        if(mysqli_query($conn, $sql)){
                            $success++;
                        }else {
                            $error.=$i." ";
                            continue;
                        }
                    }else{
                        $error.=$i." ";
                        continue;
                    }
                }
                else{
                    $error.=$i." ";
                    continue;
                }
                
            }
            
        }else{            
            for($i=2;$i<=$lastRow;$i++){
                $maGV = $sheetData[$i]['A'];
                $hoTen = $sheetData[$i]['B'];
                $hocVi = trim($sheetData[$i]['C']);
                $namSinh = $sheetData[$i]['D'];
                $SDT = $sheetData[$i]['E'];
                $gmail = $sheetData[$i]['F'];
                
                if($maGV=='null'&&$hoTen=='null' &&$hocVi=='null'&&$gmail=='null'&&$namSinh=='null'
                &&$SDT=='null'){
                    continue;
                }
                if($maGV=='null'||$hoTen=='null'||$hocVi=='null'||$gmail=='null'||$namSinh=='null'
                ||$SDT=='null'){
                    $error.=$i." ";
                    continue;
                }
                if($hocVi!="Thạc sĩ" && $hocVi!="Cử nhân" && $hocVi!="Tiến sĩ"){
                    $error.=$i." ";
                    continue;
                }
                //$sender = "dang18101999@gmail.com";
                //$validator = new SmtpEmailValidator($gmail, $sender);
                //$results = $validator->validate();
                //if(!$results){
                    //$error.=$i." ";
                    //continue;
                //}
                $checkPhone = preg_match( '/^0(\d{9}|9\d{8})$/', $SDT );
                if(!$checkPhone){
                    $error.=$i." ";
                    continue;
                }
                $findGV = "SELECT * FROM giangvien WHERE MaGV='".$maGV."'";
                $resultGV = $conn->query($findGV);
                if($resultGV->num_rows <= 0){
                    
                    $sql="INSERT INTO giangvien (MaGV,HoTen,HocVi,NamSinh,SDT,Gmail) 
                    VALUES('".$maGV."','".$hoTen."','".$hocVi."','".$namSinh."','".
                    $SDT."','".$gmail."')";
                    if(mysqli_query($conn, $sql)){
                        $success++;
                    }else {
                        $error.=$i." ";
                        continue;
                    }
                }
                else{
                    $error.=$i." ";
                    continue;
                }
                
            }
        }
        if(empty($error))
            echo"<script type='text/javascript'> alert('Đã thêm thành công ".$success
            ." giảng viên')</script>";
        else
            echo"<script type='text/javascript'> alert('Đã thêm thành công ".$success
            ." giảng viên. \\nCác hàng bị lỗi: ".$error."')</script>";
    }

    function addTeacher($conn,$maGV,$hoTen,$hocVi,$namSinh,$SDT,$gmail,$auto=false){
        
        $checkPhone = preg_match( '/^0(\d{9}|9\d{8})$/', $SDT );
        if(!$checkPhone){
            echo"<script type='text/javascript'> alert('Số điện thoại sai định dạng')</script>";
            return;
        }
        $findGV = "SELECT * FROM giangvien WHERE MaGV='".$maGV."'";
        $resultGV = $conn->query($findGV);
        if($resultGV->num_rows <= 0){
            if($auto){
                $createAcc = "INSERT INTO nguoidung VALUES('".$gmail."','".$gmail."',2,1)";
                if(mysqli_query($conn, $createAcc)){
                    $sql="INSERT INTO giangvien VALUES('".$maGV."','".$hoTen."','".$hocVi."','".$namSinh."','".
                    $SDT."','".$gmail."','".$gmail."')";
                    if(mysqli_query($conn, $sql)){
                        echo"<script type='text/javascript'> alert('Thêm giảng viên thành công')</script>";
                    }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
            }else{
                $sql="INSERT INTO giangvien (MaGV,HoTen,HocVi,NamSinh,SDT,Gmail) 
                    VALUES('".$maGV."','".$hoTen."','".$hocVi."','".$namSinh."','".
                    $SDT."','".$gmail."')";
                if(mysqli_query($conn, $sql)){
                    echo"<script type='text/javascript'> alert('Thêm giảng viên thành công')</script>";
                }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
            }
        }else echo"<script type='text/javascript'> alert('Giảng viên đã tồn tại')</script>";
        
    }

    function addAccount($conn,$maGV=null){
        $success=0;
        if($maGV!=null){
            $findGV = "SELECT * FROM giangvien WHERE MaGV='".$maGV."'";
            $resultGV = $conn->query($findGV);
            $rowGV = $resultGV->fetch_assoc();
            $findAcc = "SELECT * FROM nguoidung WHERE TaiKhoan='".$rowGV['Gmail']."'";
            $resultAcc = $conn->query($findAcc);
            if($resultAcc->num_rows <= 0){
                $createAcc = "INSERT INTO nguoidung VALUES('".$rowGV['Gmail']."','".$rowGV['Gmail']."',2,1)";
                if(mysqli_query($conn, $createAcc)){
                    $sql = "UPDATE giangvien SET TaiKhoan='".$rowGV['Gmail']."' WHERE MaGV='".$maGV."'";
                    if(mysqli_query($conn, $sql))
                        echo"<script type='text/javascript'> alert('Tạo tài khoản thành công')</script>";
                    else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                }
                else{
                    echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                }
            }else echo"<script type='text/javascript'> alert('Giảng viên đã có tài khoản')</script>";
            
        }else{
            $findGV = "SELECT * FROM giangvien";
            $resultGV = $conn->query($findGV);
            if($resultGV->num_rows > 0){
                while ($rowGV = $resultGV->fetch_assoc()){
                    if($rowGV['TaiKhoan']==null){
                        $createAcc = "INSERT INTO nguoidung VALUES('".$rowGV['Gmail']."','".$rowGV['Gmail']."',2,1)";
                        if(mysqli_query($conn, $createAcc)){
                            $sql = "UPDATE giangvien SET TaiKhoan='".$rowGV['Gmail']."' WHERE MaGV='".$rowGV['MaGV']."'";
                            if(mysqli_query($conn, $sql))
                                $success++;
                        }
                    }
                }
            }
            echo"<script type='text/javascript'> alert('Đã tạo thành công ".$success." tài khoản')</script>";
        }
    }
    function loadAccount($conn){
        $sql = "SELECT * FROM nguoidung WHERE Loai='2'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $currentAcc = "";
                if(isset($_SESSION['login']))
                    $currentAcc = $_SESSION['login'];
                else if(isset($_COOKIE['cookie_user']) && isset($_COOKIE['cookie_pass']))
                    $currentAcc = $_COOKIE['cookie_user'];
                $findUser = "SELECT * FROM nguoidung WHERE TaiKhoan='".$currentAcc."'";
                $resultUser = $conn->query($findUser);
                $rowUser = $resultUser->fetch_assoc();
                
                echo "<tr>";
                echo "<td>".$row['TaiKhoan']."</td>";
                echo "<td><input type='password' class='form_pass' id='".$row['TaiKhoan']."' value='".$row['MatKhau']."'></td>";
                echo "<td>";                
                if($row['TrangThai']==1){    
                    echo "<form method='POST' onsubmit='if(ConfirmDisable() == false) return false;'>";                
                    echo "<button class='btn_student btn_danger' value='".$row['TaiKhoan']."' name='disableAcc' type='submit'>";
                    echo "<i class='fas fa-user-slash'></i></button>";
                    echo "<button class='btn_student btn_primary' id='".$row['TaiKhoan'].",".$rowUser['MatKhau']."' type='button' onclick='showModalPass(this.id)'>";
                    echo "<i class='fas fa-eye'></i></button>";
                    echo "</form>";
                }else{
                    echo "<form method='POST' onsubmit='if(ConfirmEnable() == false) return false;'>";
                    echo "<button class='btn_student btn_check' value='".$row['TaiKhoan']."' name='enableAcc' type='submit'>";
                    echo "<i class='fas fa-user-check'></i></button>";
                    echo "<button class='btn_student btn_primary' id='".$row['TaiKhoan'].",".$rowUser['MatKhau']."' type='button' onclick='showModalPass(this.id)'>";
                    echo "<i class='fas fa-eye'></i></button>";
                    echo "</form>";
                }                
                echo "</td>";                    
                echo "</tr>";   
            }
        }
    }
    function disable($conn,$user){
        $findUser = "SELECT * FROM nguoidung WHERE TaiKhoan='".$user."'";
        $resultUser = $conn->query($findUser);
        if($resultUser->num_rows > 0){
            $sql = "UPDATE nguoidung SET TrangThai='0' WHERE TaiKhoan='".$user."'";
            if(mysqli_query($conn, $sql))
                echo"<script type='text/javascript'> alert('Đã vô hiệu hoá tài khoản')</script>";
            else 
                echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
        }else echo"<script type='text/javascript'> alert('Tài khoản không tồn tại')</script>";
    }
    function enable($conn,$user){
        $findUser = "SELECT * FROM nguoidung WHERE TaiKhoan='".$user."'";
        $resultUser = $conn->query($findUser);
        if($resultUser->num_rows > 0){
            $sql = "UPDATE nguoidung SET TrangThai='1' WHERE TaiKhoan='".$user."'";
            if(mysqli_query($conn, $sql))
                echo"<script type='text/javascript'> alert('Kích hoạt tài khoản thành công')</script>";
            else 
                echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
        }else echo"<script type='text/javascript'> alert('Tài khoản không tồn tại')</script>";
    }
?>
