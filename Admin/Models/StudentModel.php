<?php
    require '../../../public/validator/vendor/autoload.php';
    use SMTPValidateEmail\Validator as SmtpEmailValidator;
    if (session_id() === '')
        session_start();
    function loadStudent($conn){
        $sql = "SELECT * FROM sinhvien";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){            
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$row['Mssv']."</td>";
                echo "<td>".$row['HoTen']."</td>";
                echo "<td>".$row['Gmail']."</td>";
                echo "<td>".$row['NamSinh']."</td>";
                echo "<td>".$row['SDT']."</td>";
                echo "<td>".$row['DiaChi']."</td>";
                echo "<td>".$row['Khoa']."</td>";
                echo "<td>".$row['LOP']."</td>";
                echo "<td>";
                echo "<button class='btn_student btn_primary' id='";
                echo $row['Mssv'].",".$row['HoTen'].",".$row['Gmail'].",".$row['NamSinh'].",".
                $row['SDT'].",".$row['DiaChi'].",".$row['Khoa'].",".$row['LOP'];
                echo "' onclick='showEdit(this.id)' type='button'>";
                echo "<i class='fas fa-edit'></i>";  
                echo "</button>";                
                if(empty($row['TaiKhoan'])){
                    echo "<form method='POST'>";
                    echo "<input type='hidden' value='".$row['Mssv']."' name='mssv'>";
                    echo "<button class='btn_student btn_create' id='' type='submit' name='createAcc'>";
                    echo "Tạo tài khoản</button>";
                    echo "</form>";
                }
                echo "</td>";
                echo "</tr>";
            }            
        }
    }
    function editStudent($conn,$mssv,$hoTen,$gmail,$namSinh,$SDT,$diaChi,$khoa,$lop){
        $findSV = "SELECT * FROM sinhvien WHERE Mssv='".$mssv."'";
        $resultSV = $conn->query($findSV);
        $temp = explode("@", $gmail);
        if($temp[0]!=null){
            echo"<script type='text/javascript'> alert('Gmail sai. Chỉ nhập tên miền. Vd: @st.vlute.edu.vn')</script>";
            return;
        }
        $today = date('Y-m-d');
        $toYear = getdate(strtotime($today));
        $birth = getdate(strtotime($namSinh));
        if($toYear['year']-$birth['year']<18){
            echo"<script type='text/javascript'> alert('Năm sinh sai. Tuổi sinh viên phải lớn hơn bằng 18')</script>";
            return;
        }
        $checkPhone = preg_match( '/^0(\d{9}|9\d{8})$/', $SDT );
        if(!$checkPhone){
            echo"<script type='text/javascript'> alert('Số điện thoại sai định dạng')</script>";
            return;
        }
        if($resultSV->num_rows > 0){
            $sql = "UPDATE sinhvien SET HoTen='".$hoTen."', NamSinh='".$namSinh."',Gmail='".$mssv.$gmail."'".
            ", SDT='".$SDT."', DiaChi='".$diaChi."', Khoa='".$khoa."', LOP='".$lop."' WHERE Mssv='".$mssv."'";
            if(mysqli_query($conn, $sql)){
                echo"<script type='text/javascript'> alert('cập nhật thành công')</script>";
            } else{
                echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
            }
        }else echo"<script type='text/javascript'> alert('Sinh viên không tồn tại')</script>";
    }
    function multiAddstu($conn,$file,$auto=false){
        $objReader = PHPExcel_IOFactory::createReaderForFile($file);
        $objReader->setLoadSheetsOnly("Sheet1");

        $objExcel = $objReader->load($file);
        $sheetData = $objExcel->getActiveSheet()->toArray("null",true,true,true);
        $success=0;
        $error = "";    
        $lastRow =  $objExcel->setActiveSheetIndex()->getHighestRow();           
        if($auto){
            for($i=2;$i<=$lastRow;$i++){
                $mssv = $sheetData[$i]['A'];
                $hoTen = $sheetData[$i]['B'];
                $gmail = $sheetData[$i]['C'];
                $namSinh = $sheetData[$i]['D'];
                $SDT = $sheetData[$i]['E'];
                $diaChi = $sheetData[$i]['F'];
                $khoa = $sheetData[$i]['G'];
                $lop = $sheetData[$i]['H'];
                
                if($mssv=='null'&&$hoTen=='null'&&$gmail=='null'&&$namSinh=='null'
                &&$SDT=='null'&&$diaChi=='null'&&$khoa=='null'&&$lop=='null'){
                    continue;
                }
                if($mssv=='null'||$hoTen=='null'||$gmail=='null'||$namSinh=='null'
                ||$SDT=='null'||$diaChi=='null'||$khoa=='null'||$lop=='null'){
                    $error.=$i." ";
                    continue;
                }
                if(!is_numeric($mssv)){
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
                $temp = explode("@", $gmail);
                if($temp[0]!=$mssv){
                    $error.=$i." ";
                    continue;
                }
                $today = date('Y-m-d');
                $toYear = getdate(strtotime($today));
                $birth = getdate(strtotime($namSinh));
                if($toYear['year']-$birth['year']<18){
                    $error.=$i." ";
                    continue;
                }
                $checkPhone = preg_match( '/^0(\d{9}|9\d{8})$/', $SDT );
                if(!$checkPhone){
                    $error.=$i." ";
                    continue;
                }
                $findSV = "SELECT * FROM sinhvien WHERE Mssv='".$mssv."'";
                $resultSV = $conn->query($findSV);
                if($resultSV->num_rows <= 0){
                    $createAcc = "INSERT INTO nguoidung VALUES('".$gmail."','".$gmail."',1,1)";
                    if(mysqli_query($conn, $createAcc)){
                        $sql="INSERT INTO sinhvien VALUES('".$mssv."','".$hoTen."','".$gmail."','".$namSinh."','".
                        $SDT."','".$diaChi."','".$khoa."','".$lop."','".$gmail."')";
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
                $mssv = $sheetData[$i]['A'];
                $hoTen = $sheetData[$i]['B'];
                $gmail = $sheetData[$i]['C'];
                $namSinh = $sheetData[$i]['D'];
                $SDT = $sheetData[$i]['E'];
                $diaChi = $sheetData[$i]['F'];
                $khoa = $sheetData[$i]['G'];
                $lop = $sheetData[$i]['H'];
                
                if($mssv=='null'&&$hoTen=='null'&&$gmail=='null'&&$namSinh=='null'
                &&$SDT=='null'&&$diaChi=='null'&&$khoa=='null'&&$lop=='null'){
                    continue;
                }
                if($mssv=='null'||$hoTen=='null'||$gmail=='null'||$namSinh=='null'
                ||$SDT=='null'||$diaChi=='null'||$khoa=='null'||$lop=='null'){
                    $error.=$i." ";
                    continue;
                }
                if(!is_numeric($mssv)){
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
                $temp = explode("@", $gmail);
                if($temp[0]!=$mssv)
                {
                    $error.=$i." ";
                    continue;
                }
                $today = date('Y-m-d');
                $toYear = getdate(strtotime($today));
                $birth = getdate(strtotime($namSinh));
                if($toYear['year']-$birth['year']<18){
                    $error.=$i." ";
                    continue;
                }
                $checkPhone = preg_match( '/^0(\d{9}|9\d{8})$/', $SDT );
                if(!$checkPhone){
                    $error.=$i." ";
                    continue;
                }
                $findSV = "SELECT * FROM sinhvien WHERE Mssv='".$mssv."'";
                $resultSV = $conn->query($findSV);
                if($resultSV->num_rows <= 0){
                    
                    $sql="INSERT INTO sinhvien (Mssv,HoTen,Gmail,NamSinh,SDT,DiaChi,Khoa,LOP) 
                    VALUES('".$mssv."','".$hoTen."','".$gmail."','".$namSinh."','".
                    $SDT."','".$diaChi."','".$khoa."','".$lop."')";
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
            ." sinh viên')</script>";
        else
            echo"<script type='text/javascript'> alert('Đã thêm thành công ".$success
            ." sinh viên. \\nCác hàng bị lỗi: ".$error."')</script>";
    }

    function addStu($conn,$mssv,$hoTen,$gmail,$namSinh,$SDT,$diaChi,$khoa,$lop,$auto=false){
        if(!is_numeric($mssv)){
            echo"<script type='text/javascript'> alert('Mã số sinh viên phải là số')</script>";
            return;
        }
        $temp = explode("@", $gmail);
        if($temp[0]!=null){
            echo"<script type='text/javascript'> alert('Gmail sai. Chỉ nhập tên miền. Vd: @st.vlute.edu.vn')</script>";
            return;
        }
        $today = date('Y-m-d');
        $toYear = getdate(strtotime($today));
        $birth = getdate(strtotime($namSinh));
        if($toYear['year']-$birth['year']<18){
            echo"<script type='text/javascript'> alert('Năm sinh sai. Tuổi sinh viên phải lớn hơn bằng 18')</script>";
            return;
        }
        $checkPhone = preg_match( '/^0(\d{9}|9\d{8})$/', $SDT );
        if(!$checkPhone){
            echo"<script type='text/javascript'> alert('Số điện thoại sai định dạng')</script>";
            return;
        }
        $findSV = "SELECT * FROM sinhvien WHERE Mssv='".$mssv."'";
        $resultSV = $conn->query($findSV);
        if($resultSV->num_rows <= 0){
            if($auto){
                $createAcc = "INSERT INTO nguoidung VALUES('".$mssv.$gmail."','".$mssv.$gmail."',1,1)";
                if(mysqli_query($conn, $createAcc)){
                    $sql="INSERT INTO sinhvien VALUES('".$mssv."','".$hoTen."','".$gmail."','".$namSinh."','".
                    $SDT."','".$diaChi."','".$khoa."','".$lop."','".$mssv.$gmail."')";
                    if(mysqli_query($conn, $sql)){
                        echo"<script type='text/javascript'> alert('Thêm sinh viên thành công')</script>";
                    }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
            }else{
                $sql="INSERT INTO sinhvien (Mssv,HoTen,Gmail,NamSinh,SDT,DiaChi,Khoa,LOP) 
                    VALUES('".$mssv."','".$hoTen."','".$mssv.$gmail."','".$namSinh."','".
                    $SDT."','".$diaChi."','".$khoa."','".$lop."')";
                if(mysqli_query($conn, $sql)){
                    echo"<script type='text/javascript'> alert('Thêm sinh viên thành công')</script>";
                }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
            }
        }else echo"<script type='text/javascript'> alert('Sinh viên đã tồn tại')</script>";
        
    }

    function addAccount($conn,$mssv=null){
        $success=0;
        if($mssv!=null){
            $findSV = "SELECT * FROM sinhvien WHERE Mssv='".$mssv."'";
            $resultSV = $conn->query($findSV);
            $rowSV = $resultSV->fetch_assoc();
            $findAcc = "SELECT * FROM nguoidung WHERE TaiKhoan='".$rowSV['Gmail']."'";
            $resultAcc = $conn->query($findAcc);
            if($resultAcc->num_rows <= 0){
                $createAcc = "INSERT INTO nguoidung VALUES('".$rowSV['Gmail']."','".$rowSV['Gmail']."',1,1)";
                if(mysqli_query($conn, $createAcc)){
                    $sql = "UPDATE sinhvien SET TaiKhoan='".$rowSV['Gmail']."' WHERE Mssv='".$mssv."'";
                    if(mysqli_query($conn, $sql))
                        echo"<script type='text/javascript'> alert('Tạo tài khoản thành công')</script>";
                    else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                }
                else{
                    echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                }
            }
            else echo"<script type='text/javascript'> alert('Sinh viên đã có tài khoản')</script>";
        }else{
            $findSV = "SELECT * FROM sinhvien";
            $resultSV = $conn->query($findSV);
            if($resultSV->num_rows > 0){
                while ($rowSV = $resultSV->fetch_assoc()){
                    if($rowSV['TaiKhoan']==null){
                        $createAcc = "INSERT INTO nguoidung VALUES('".$rowSV['Gmail']."','".$rowSV['Gmail']."',1,1)";
                        if(mysqli_query($conn, $createAcc)){
                            $sql = "UPDATE sinhvien SET TaiKhoan='".$rowSV['Gmail']."' WHERE Mssv='".$rowSV['Mssv']."'";
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
        $sql = "SELECT * FROM nguoidung WHERE Loai='1'";
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
