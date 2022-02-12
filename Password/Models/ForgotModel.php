<?php
    include "../../../public/PHPMailer/src/PHPMailer.php";
    include "../../../public/PHPMailer/src/Exception.php";
    include "../../../public/PHPMailer/src/OAuth.php";
    include "../../../public/PHPMailer/src/POP3.php";
    include "../../../public/PHPMailer/src/SMTP.php";
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    function forgotPass($conn, $username){
        $sql = "SELECT MatKhau FROM nguoidung WHERE TaiKhoan='".$username."'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $mail = new PHPMailer(true);                             
            try {
                $mail->SMTPDebug = 0;                                 
                $mail->isSMTP();         
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true; 
                $mail->Username = 'qldoanvlute@gmail.com'; 
                $mail->Password = 'jrlelczidvxucido';
                $mail->SMTPSecure = 'tls';  
                $mail->Port = 587; 
                $from = 'Hệ thống quản lý đồ án vlute';                        
                $from= "=?utf-8?b?".base64_encode($from)."?=";
                $mail->setFrom('qldoanvlute@gmail.com', $from);
                $mail->addAddress($username, $username);
            
                //Content
                $mail->isHTML(true);                                  
                $title = 'Xác nhận mật khẩu';
                $title= "=?utf-8?b?".base64_encode($title)."?=";
                $mail->Subject = $title;
                $mail->Body    = 'Mật khẩu của bạn là'.$row['MatKhau'];
            
                $mail->send();
                echo "<p class='text_success'>Mật khẩu đã gửi về mail của bạn</p>";
            } catch (Exception $e) {
                echo "<p class='text_error'>Lỗi vui lòng thử lại</p>";
            }
        }else
            echo "<p class='text_error'>Tài khoảng không tồn tại</p>";
        
    }
?>