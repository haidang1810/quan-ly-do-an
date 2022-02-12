<?php
    function changPass($conn,$user,$pass,$newPas,$confirm){
        $findUser = "SELECT * FROM nguoidung WHERE TaiKhoan='".trim($user)."'";
        $resultUser = $conn->query($findUser);
        if ($resultUser->num_rows > 0){
            $rowUser = $resultUser->fetch_assoc();
            if($rowUser['MatKhau']==trim($pass)){
                if(trim($newPas)==trim($confirm)){
                    $sql = "UPDATE nguoidung SET MatKhau='".trim($newPas)."' WHERE TaiKhoan='".trim($user)."'";
                    if(mysqli_query($conn, $sql)){
                        echo "<p class='text_success'>Mật khẩu đã được cập nhật</p>";
                    } else{
                        echo "<p class='text_error'>Lỗi ".mysqli_error($conn)." vui long thử lại</p>";
                    }
                }else
                    echo "<p class='text_error'>Xác nhận mật khẩu sai</p>";
            }else echo "<p class='text_error'>Mật khẩu không chính xác</p>";
        }else echo "<p class='text_error'>Tài khoản không tồn tại</p>";
    }
?>