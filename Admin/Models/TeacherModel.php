<?php
    //use SMTPValidateEmail\Validator as SmtpEmailValidator;
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
                echo "<td>".$row['Gmail']."</td>";
                echo "<td>";                                
                if(empty($row['TaiKhoan'])){
                    echo "<button class='btn_student btn_primary' id='";
                    echo $row['MaGV'].",".$row['HoTen'].",".$row['HocVi'].",".$row['Gmail'].",0";
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
                    echo $row['MaGV'].",".$row['HoTen'].",".$row['HocVi'].",".$row['Gmail'].",".$rowAcc['Loai'];
                    echo "' onclick='showEdit(this.id)' type='button'>";
                    echo "<i class='fas fa-edit'></i>";  
                    echo "</button>";
                }
                echo "</td>";
                echo "</tr>";
            }            
        }
    }
    function editTeacher($conn,$maGV,$hoTen,$hocVi,$gmail,$loai){     
        $findGV = "SELECT * FROM giangvien WHERE MaGV='".$maGV."'";
        $resultGV = $conn->query($findGV);
        if($resultGV->num_rows > 0){
            $rowGV = $resultGV->fetch_assoc();
            if($rowGV['Gmail']==$gmail){
                $sql = "UPDATE giangvien SET HoTen='".$hoTen."', HocVi='".$hocVi."' WHERE MaGV='".$maGV."'";
                if(mysqli_query($conn, $sql)){
                    if($loai!=0){
                        $updateType = "UPDATE nguoidung SET Loai=".$loai." WHERE TaiKhoan='".$rowGV['TaiKhoan']."'";
                        if(mysqli_query($conn, $updateType))
                            echo "<script>
                            Swal.fire(
                                'Đã lưu!',
                                'Bạn đã cập nhật giảng viên thành công.',
                                'success'
                            )</script>";
                    }else
                    echo "<script>
                    Swal.fire(
                        'Đã lưu!',
                        'Bạn đã cập nhật giảng viên thành công.',
                        'success'
                    )</script>";                
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
                            $sql = "UPDATE giangvien SET HoTen='".$hoTen."', HocVi='".$hocVi."', Gmail='".$gmail."', TaiKhoan='".$gmail."' WHERE MaGV='".$maGV."'";
                            if(mysqli_query($conn, $sql)){
                                $deleteAcc = "DELETE FROM  nguoidung WHERE TaiKhoan='".$rowGV['Gmail']."'";
                                if(mysqli_query($conn, $deleteAcc)){
                                    echo "<script>
                                    Swal.fire(
                                        'Đã lưu!',
                                        'Bạn đã cập nhật giảng viên thành công.',
                                        'success'
                                    )</script>"; 
                                }else echo "<script>
                                Swal.fire(
                                    'Đã lưu!',
                                    'Cập nhật thành công. Xoá tài khoản thất bại mời bạn vô hiệu hoá tài khoản.',
                                    'success'
                                )</script>"; 
                            } else{
                                echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                            }                 
                        }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                    }else echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi...',
                        text: 'Chưa chọn phân quyền!'
                    })</script>";                    
                }else echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Gmail đã tồn tại!'
                })</script>";
            }
            
        }else echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Giảng viên không tồn tại!'
        })</script>";
    }
    function multiAddTea($conn,$file,$auto=false){
        if($_FILES["file"]["name"] != ''){
            $allowed_extension = array('xls', 'csv', 'xlsx');
            $file_array = explode(".", $_FILES["file"]["name"]);
            $file_extension = end($file_array);

            if(in_array($file_extension, $allowed_extension)){
                $file_name = time() . '.' . $file_extension;
                move_uploaded_file($file, $file_name);
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
                        
                    $maGV = "";
                    $hoTen = "";
                    $hocVi = "";
                    $gmail = "";
                    if(empty($row[0])||empty($row[1])||empty($row[2])||empty($row[3])){
                        $error.=$i." ";
                        $i++;
                        continue;
                    }else{
                        $maGV = $row[0];
                        $hoTen = $row[1];
                        $hocVi = $row[2];
                        $gmail = $row[3];
                    } 
                    
                    if($hocVi!="Thạc sĩ" && $hocVi!="Cử nhân" && $hocVi!="Tiến sĩ" && $hocVi!="Cao học"){
                        $error.=$i." ";
                        $i++;
                        continue;
                    }
                    if($auto){
                        $findGV = "SELECT * FROM giangvien WHERE MaGV='".$maGV."'";
                        $resultGV = $conn->query($findGV);
                        if($resultGV->num_rows <= 0){
                            $createAcc = "INSERT INTO nguoidung VALUES('".$gmail."','".$gmail."',2,1)";
                            if(mysqli_query($conn, $createAcc)){
                                $sql="INSERT INTO giangvien VALUES('".$maGV."','".$hoTen."','".$hocVi."','".$gmail."','".$gmail."')";
                                if(mysqli_query($conn, $sql)){
                                    $success++;
                                }else {
                                    $error.=$i." ";
                                    $i++;
                                    continue;
                                }
                            }else{
                                $error.=$i." ";
                                $i++;
                                continue;
                            }
                        }
                    }else{
                        $findGV = "SELECT * FROM giangvien WHERE MaGV='".$maGV."'";
                        $resultGV = $conn->query($findGV);
                        if($resultGV->num_rows <= 0){
                            
                            $sql="INSERT INTO giangvien (MaGV,HoTen,HocVi,Gmail) 
                            VALUES('".$maGV."','".$hoTen."','".$hocVi."','".$gmail."')";
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
                    $i++;
                }
                if(empty($error))
                    echo"
                    <script>
                        Swal.fire(
                            'Đã lưu!',
                            'Bạn đã thêm thành công ".$success." giảng viên.',
                            'success'
                        )
                    </script>";
                else
                echo"
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Đã thêm!',
                            text: 'Bạn đã thêm thành công ".$success." giảng viên.',
                            footer: 'Các hàng bị lỗi: ".$error."'
                        })
                    </script>";
            }
        }
        
    }

    function addTeacher($conn,$maGV,$hoTen,$hocVi,$gmail,$auto=false){
        
        $findGV = "SELECT * FROM giangvien WHERE MaGV='".$maGV."'";
        $resultGV = $conn->query($findGV);
        if($resultGV->num_rows <= 0){
            if($auto){
                $createAcc = "INSERT INTO nguoidung VALUES('".$gmail."','".$gmail."',2,1)";
                if(mysqli_query($conn, $createAcc)){
                    $sql="INSERT INTO giangvien VALUES('".$maGV."','".$hoTen."','".$hocVi."','".$gmail."','".$gmail."')";
                    if(mysqli_query($conn, $sql)){
                        echo"
                        <script>
                            Swal.fire(
                                'Đã lưu!',
                                'Thêm giảng viên thành công.',
                                'success'
                            )
                        </script>";
                    }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
            }else{
                $sql="INSERT INTO giangvien (MaGV,HoTen,HocVi,NamSinh,SDT,Gmail) 
                    VALUES('".$maGV."','".$hoTen."','".$hocVi."','".$gmail."')";
                if(mysqli_query($conn, $sql)){
                    echo"
                        <script>
                            Swal.fire(
                                'Đã lưu!',
                                'Thêm giảng viên thành công.',
                                'success'
                            )
                        </script>";
                }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
            }
        }else echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Giảng viên đã tồn tại!'
        })</script>";
        
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
                    echo"
                    <script>
                        Swal.fire(
                            'Đã lưu!',
                            'Tạo tài khoản thành công.',
                            'success'
                        )
                    </script>";
                    else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                }
                else{
                    echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                }
            }else echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Giảng viên đã có tài khoản!'
            })</script>";
            
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
            echo"
            <script>
                Swal.fire(
                    'Đã lưu!',
                    'Đã tạo thành công ".$success." tài khoản.',
                    'success'
                )
            </script>";
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
                    echo "<form method='POST' class='form-disable'>";    
                    echo "<input type='hidden' name='disableAcc' value='".$row['TaiKhoan']."'>";          
                    echo "<button class='btn_student btn_danger'  type='submit'>";
                    echo "<i class='fas fa-user-slash'></i></button>";
                    echo "</form>";
                }else{
                    echo "<form method='POST' class='form-enable'>";
                    echo "<input type='hidden' name='enableAcc' value='".$row['TaiKhoan']."'>";
                    echo "<button class='btn_student btn_check'  type='submit'>";
                    echo "<i class='fas fa-user-check'></i></button>";
                    echo "</form>";
                }    
                echo "<form method='POST' class='reset-pass'>";
                echo "<input type='hidden' name='resetPass' value='".$row['TaiKhoan']."'>";
                echo "<button class='btn_student btn_primary' type='submit' >";
                echo "<i class='fas fa-undo'></i></button>";      
                echo "</form>";                
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
            echo"
            <script>
                Swal.fire(
                    'Đã lưu!',
                    'Đã vô hiệu hoá tài khoản.',
                    'success'
                )</script>";
            else 
                echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
        }else echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Tài khoản không tồn tại!'
        })</script>";
    }
    function enable($conn,$user){
        $findUser = "SELECT * FROM nguoidung WHERE TaiKhoan='".$user."'";
        $resultUser = $conn->query($findUser);
        if($resultUser->num_rows > 0){
            $sql = "UPDATE nguoidung SET TrangThai='1' WHERE TaiKhoan='".$user."'";
            if(mysqli_query($conn, $sql))
            echo"
            <script>
                Swal.fire(
                    'Đã lưu!',
                    'Kích hoạt tài khoản thành công.',
                    'success'
                )</script>";
            else 
                echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
        }else echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Tài khoản không tồn tại!'
        })</script>";
    }
    function resetPass($conn,$user){
        $findUser = "SELECT * FROM nguoidung WHERE TaiKhoan='".$user."'";
        $resultUser = $conn->query($findUser);
        if($resultUser->num_rows > 0){
            $sql = "UPDATE nguoidung SET MatKhau='123' WHERE TaiKhoan='".$user."'";
            if(mysqli_query($conn, $sql))
            echo"
            <script>
                Swal.fire(
                    'Đã lưu!',
                    'Kích hoạt khôi phục mật khẩu về mặc định.',
                    'success'
                )</script>";
            else 
                echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
        }else echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Tài khoản không tồn tại!'
        })</script>";
    }
?>
