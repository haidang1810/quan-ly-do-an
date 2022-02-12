<html>

<head>
    <title>Quên mật khẩu</title>
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
                    <h2>Tìm làm mật khẩu</h2>
                    <p>Hướng dẫn cấp mật khẩu mới cho tài khoản:</br>
                    1. Nhập tên đăng nhập vào ô bên dưới. Sau đó nhấn nút lấy lại mật khẩu
                    </br>
                    2. Hệ thống sẽ gởi thư vào địa chỉ email vlute của chủ tài khoản.
                    </br>
                    3. Kiểm tra email để biết mật khẩu của bạn.</p>
                </div>
                <div class="form_top_right">
                    <img src="../img/vlute_icon96.png" alt="">
                </div>
            </div>
            <div class="form_bottom">
                <form method="POST">
                    <input type="text" name="username" placeholder="Nhập tên đăng nhập" class="login_input login_text">
                    <input type="submit" name="Forgot" value="Lấy lại mật khẩu" class="login_input login_button">
                    <?php include("../../Controllers/ForgotController.php"); ?>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

