<html>

<head>
    <title>Đổi mật khẩu</title>
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
                    <h2>Đổi mật khẩu</h2>
                    <p>Hướng dẫn cấp mật khẩu mới cho tài khoản:</br>
                    1. Nhập tài khoản và mật khẩu của bạn
                    </br>
                    2. Nhập mật khẩu mới vào ô mật khẩu mới và xác nhận mật khẩu mới.
                    </br>
                    3. Ấn nút cập nhật.</p>
                </div>
                <div class="form_top_right">
                    <img src="../img/vlute_icon96.png" alt="">
                </div>
            </div>
            <div class="form_bottom">
                <form method="POST">
                    <input type="text" name="user" placeholder="Nhập tài khoản" class="login_input login_text">
                    <input type="password" name="Pass" placeholder="Nhập mật khẩu" class="login_input login_text">
                    <input type="password" name="newPass" placeholder="Nhập mật khẩu mới" class="login_input login_text" minlength="6">
                    <input type="password" name="Confirm" placeholder="Xác nhận mật khẩu mới" class="login_input login_text" minlength="6">
                    <input type="submit" name="Change" value="Cập nhật" class="login_input login_button">
                    <?php include("../../Controllers/ChangeController.php"); ?>
                </form>
            </div>
        </div>
    </div>
</body>

</html>

