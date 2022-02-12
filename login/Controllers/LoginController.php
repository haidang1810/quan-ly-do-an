<?php
    include("../../public/config.php");
    global $conn;
    if(isset($_POST['login'])){
        if(isset($_POST['username']) && isset($_POST['password'])) {
            include("../Models/LoginModel.php");
            $username = $_POST['username'];
            $password = $_POST['password'];

            $row = login($username, $password,$conn);
            if(!empty($row))  {
                if (session_id() === '')
                    session_start();
                $_SESSION['login'] = $row['TaiKhoan'];
                if(!empty($_POST['remember'])) {
                    setcookie('cookie_user',$username,time()+86400,"/");
                    setcookie('cookie_pass',$password,time()+86400,"/");
                } else {
                    if(isset($_COOKIE['cookie_user']))
                        setcookie('cookie_user','',time()-86400,"/","",0);
                    if(isset($_COOKIE['cookie_pass']))
                        setcookie('cookie_pass','',time()-86400,"/","",0);
                }
                if($row["Loai"]==2 || $row["Loai"]==4)
                    header('location: http://localhost/qldoan/Teacher/Views/DashboardView/DashboardView.php');  
                else if($row["Loai"]==3)    
                    header('location: http://localhost/qldoan/admin/Views/DashboardView/DashboardView.php');  
                else if($row["Loai"]==1)    
                    header('location: http://localhost/qldoan/Students/Views/DashboardView/DashboardView.php');
            }
            else
                echo '<p>Sai tên đăng nhập hoặc mật khẩu</p>';
        }
            
    }
    if(isset($_COOKIE['cookie_user']) && isset($_COOKIE['cookie_pass'])){
        $sql = "SELECT * FROM nguoidung WHERE TaiKhoan='".$_COOKIE['cookie_user']
        ."' AND MatKhau='".$_COOKIE['cookie_pass']."' AND TrangThai=1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row["Loai"]==2 || $row["Loai"]==4)
                header('location: http://localhost/qldoan/Teacher/Views/DashboardView/DashboardView.php');  
            else if($row["Loai"]==3)    
                header('location: http://localhost/qldoan/admin/Views/DashboardView/DashboardView.php');  
            else if($row["Loai"]==1)    
                header('location: http://localhost/qldoan/Students/Views/DashboardView/DashboardView.php');
        }
    }
    
?>