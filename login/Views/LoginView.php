<html>

<head>
    <title>Đăng nhập hệ thống</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="container_top">
            <h1>Quản lý đồ án</h1>
            <h4>Hệ thống quản lý đồ án khoa CNTT trường Đại học Sư phạm Kỹ thuật Vĩnh Long</h4>
        </div>
        <div class="container_bottom">
            <div class="form_top">
                <div class="form_top_left">
                    <h2>Đăng nhập hệ thống</h2>
                    <p>Người dùng cần đăng nhập để sử dụng các chức năng dành riêng cho cán bộ, giảng viên, sinh viên.</p>
                </div>
                <div class="form_top_right">
                    <img src="./img/vlute_icon96.png" alt="">
                </div>
            </div>
            <div class="form_bottom">
                <form method="POST">
                    <input type="text" name="username" placeholder="Tên đăng nhập" class="login_input login_text" value="<?php 
                            if(isset($_COOKIE['cookie_user'])) echo $_COOKIE['cookie_user'];?>">
                    <input type="password" name="password" id="" placeholder="Mật khẩu" class="login_input login_text" value="<?php 
                            if(isset($_COOKIE['cookie_pass'])) echo $_COOKIE['cookie_pass'];?>">
                    <input type="checkbox" name="remember" id = "savePass" <?php if(isset($_COOKIE['cookie_user'])&&isset($_COOKIE['cookie_pass'])) echo "checked='checked'" ?>>
                    <label for="savePass" class="login_lable">Ghi nhớ đăng nhập</label>
                    <input type="submit" name="login" value="Đăng nhập" class="login_input login_button">
                    <div class="error_pass">
                        <?php include("../Controllers/LoginController.php"); ?>
                    </div> 
                </form>
                <div class="forgot_pass">
                    <a href="../../Password/View/ForgotView/ForgotView.php" class="link_forgot">Quên mật khẩu?</a>
                    <a href="../../Password/View/ChangeView/ChangeView.php" class="link_change">Đổi mật khẩu</a>
                </div>
                
                        
            </div>
        </div>
    </div>
</body>

</html>

