<html>
    <head>
        <link rel="stylesheet" href="../shared/style.css" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    </head>
    <body>
        <div class="nav">
            <button class="btn_justify" onclick="hideMenu()"><i class="fas fa-align-justify"></i></button>
            <p  class='btn_logout'>
                Xin chào: Admin<a href="?logout=1">, Đăng xuất</a>
            </p>
        </div>
    </body>
</html>
<?php
    if(isset($_GET['logout'])){
        session_destroy();
        if(isset($_COOKIE['cookie_user']))
            setcookie('cookie_user','',time()-86400,"/","",0);
        if(isset($_COOKIE['cookie_pass']))
            setcookie('cookie_pass','',time()-86400,"/","",0);
        header("location: ../../../login/Views/LoginView.php");
    }
?>