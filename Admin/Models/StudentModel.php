<?php
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
                echo "<td>";
                echo "<button class='btn_student btn_primary' id='";
                echo $row['Mssv'].",".$row['HoTen'].",".$row['Gmail'];
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
    function editStudent($conn,$mssv,$hoTen,$gmail){
        $findSV = "SELECT * FROM sinhvien WHERE Mssv='".$mssv."'";
        $resultSV = $conn->query($findSV);
        $temp = explode("@", $gmail);
        if($temp[0]!=null){
            echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Gmail sai. Chỉ nhập tên miền. Vd: @st.vlute.edu.vn!'
            })</script>";
            return;
        }
        
        if($resultSV->num_rows > 0){
            $sql = "UPDATE sinhvien SET HoTen='".$hoTen."', Gmail='".$mssv.$gmail."' WHERE Mssv='".$mssv."'";
            if(mysqli_query($conn, $sql)){
                echo "<script>
                Swal.fire(
                    'Đã lưu!',
                    'Bạn đã cập nhật thành công.',
                    'success'
                )</script>";
            } else{
                echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
            }
        }else echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Sinh viên không tồn tại!'
        })</script>";
    }
    function multiAddstu($conn,$file,$auto=false){
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
                        
                    $mssv = "";
                    $hoTen = "";
                    $gmail = "";
                    
                    if(empty($row[0])||empty($row[1])||empty($row[2])){
                        $error.=$i." ";
                        $i++;
                        continue;
                    }else{
                        $mssv = $row[0];
                        $hoTen = $row[1];
                        $gmail = $row[2];
                    } 
                    if(!is_numeric($mssv)){
                        $error.=$i." ";
                        $i++;
                        continue;
                    }
                    $temp = explode("@", $gmail);
                    if($temp[0]!=$mssv){
                        $error.=$i." ";
                        $i++;
                        continue;
                    }
                    if($auto){
                        $findSV = "SELECT * FROM sinhvien WHERE Mssv='".$mssv."'";
                        $resultSV = $conn->query($findSV);
                        if($resultSV->num_rows <= 0){
                            $createAcc = "INSERT INTO nguoidung VALUES('".$gmail."','".$gmail."',1,1)";
                            if(mysqli_query($conn, $createAcc)){
                                $sql="INSERT INTO sinhvien VALUES('".$mssv."','".$hoTen."','".$gmail."','".$gmail."')";
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
                        else{
                            $error.=$i." ";
                            $i++;
                            continue;
                        }
                    }else{
                        $findSV = "SELECT * FROM sinhvien WHERE Mssv='".$mssv."'";
                        $resultSV = $conn->query($findSV);
                        if($resultSV->num_rows <= 0){
                            $sql="INSERT INTO sinhvien (Mssv,HoTen,Gmail) 
                            VALUES('".$mssv."','".$hoTen."','".$gmail."')";
                            if(mysqli_query($conn, $sql)){
                                $success++;
                            }else {
                                $error.=$i." ";
                                $i++;
                                continue;
                            }
                        }
                        else{
                            $error.=$i." ";
                            $i++;
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
                            'Bạn đã thêm thành công ".$success." sinh viên.',
                            'success'
                        )
                    </script>";
                else
                echo"
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Đã thêm!',
                            text: 'Bạn đã thêm thành công ".$success." sinh viên.',
                            footer: 'Các hàng bị lỗi: ".$error."'
                        })
                    </script>";
            }
        }
    }

    function addStu($conn,$mssv,$hoTen,$gmail,$auto=false){
        if(!is_numeric($mssv)){
            echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Mã số sinh viên phải là số!'
        })</script>";
            return;
        }
        $temp = explode("@", $gmail);
        if($temp[0]!=null){
            echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Gmail sai. Chỉ nhập tên miền. Vd: @st.vlute.edu.vn!'
        })</script>";
            return;
        }
        
        $findSV = "SELECT * FROM sinhvien WHERE Mssv='".$mssv."'";
        $resultSV = $conn->query($findSV);
        if($resultSV->num_rows <= 0){
            if($auto){
                $createAcc = "INSERT INTO nguoidung VALUES('".$mssv.$gmail."','".$mssv.$gmail."',1,1)";
                if(mysqli_query($conn, $createAcc)){
                    $sql="INSERT INTO sinhvien VALUES('".$mssv."','".$hoTen."','".$gmail."','".$mssv.$gmail."')";
                    if(mysqli_query($conn, $sql)){
                        echo"
                        <script>
                            Swal.fire(
                                'Đã lưu!',
                                'Thêm sinh viên thành công.',
                                'success'
                            )
                        </script>";
                    }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
                }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
            }else{
                $sql="INSERT INTO sinhvien (Mssv,HoTen,Gmail) 
                    VALUES('".$mssv."','".$hoTen."','".$mssv.$gmail."')";
                if(mysqli_query($conn, $sql)){
                    echo"
                        <script>
                            Swal.fire(
                                'Đã lưu!',
                                'Thêm sinh viên thành công.',
                                'success'
                            )
                        </script>";
                }else echo"<script type='text/javascript'> alert('Lỗi ".mysqli_error($conn)."')</script>";
            }
        }else echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Sinh viên đã tồn tại!'
        })</script>";
        
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
            }
            else echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Sinh viên đã có tài khoản!'
            })</script>";
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
        $sql = "SELECT * FROM nguoidung WHERE Loai='1'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
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