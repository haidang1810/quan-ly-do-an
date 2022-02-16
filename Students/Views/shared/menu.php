<?php
    ob_start();
    include("../../../public/config.php");
    global $conn;
    if(!isset($_COOKIE['cookie_user']) || !isset($_COOKIE['cookie_pass'])){
        if (session_id() === '')
            session_start();
        if(!isset($_SESSION['login']))
            header('location:http://localhost/qldoan/login/Views/LoginView.php');
        $sql="SELECT * FROM nguoidung WHERE TaiKhoan='".$_SESSION['login']."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if($row['Loai']==3)
            header('location: http://localhost/qldoan/Admin/Views/DashboardView/DashboardView.php');  
        else if($row['Loai']==2||$row['Loai']==4)
        header('location: http://localhost/qldoan/Teacher/Views/DashboardView/DashboardView.php');  
    }
    else if(!isset($_SESSION['login'])){
        if (session_id() === '')
            session_start();
        $_SESSION['login'] = $_COOKIE['cookie_user'];
        $sql="SELECT * FROM nguoidung WHERE TaiKhoan='".$_COOKIE['cookie_user']."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if($row['Loai']==3)
            header('location: http://localhost/qldoan/Admin/Views/DashboardView/DashboardView.php'); 
        else if($row['Loai']==2||$row['Loai']==4)
        header('location: http://localhost/qldoan/Teacher/Views/DashboardView/DashboardView.php');
        
    }else{
        $sql="SELECT * FROM nguoidung WHERE TaiKhoan='".$_SESSION['login']."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if($row['Loai']==3)
            header('location: http://localhost/qldoan/Admin/Views/DashboardView/DashboardView.php');  
        else if($row['Loai']==2||$row['Loai']==4)
        header('location: http://localhost/qldoan/Teacher/Views/DashboardView/DashboardView.php');
    }  
    ob_flush(); 
?>  
<html>
    <head>
    <meta charset="UTF-8">        
        <link rel="stylesheet" href="../shared/style.css" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    </head>
    <body>
        <div class="menu">
            <div class="iconWeb">
                <img src="../shared/img/vlute_icon96.png" while="40px" height="40px" >
                <h1 class="showTitle">Quản lý đồ án</h1>
            </div>
            <div class="line"></div>     
            <div>
                <button class="btn item" onclick="goDashboard()">
                <i class="far fa-comment"></i><span class="showTitle">Trang chủ</span>
                </button>
            </div>     
            <div>
                <button class="btn item" onclick="showSubItem('subItem2');">
                    <i class="fas fa-users"></i><span class="showTitle">Đăng ký lớp<i id="angle_subItem2" class="fas fa-angle-right"></i></span>
                </button>
                
                <div id="group_subItem2" class="hidden">
                    <button class="btn subitem" onclick="goRegister()">
                        <i class="fas fa-users"></i><span class="showTitle">Lớp đồ án</span>
                    </button>
                    <button class="btn subitem" onclick="goThesisReg()">
                        <i class="fas fa-graduation-cap"></i><span class="showTitle">Lớp luận văn</span>
                    </button>
                </div>
            </div>
            <div>
                <button class="btn item" onclick="showSubItem('subItem1');">
                    <i class="fas fa-book"></i><span class="showTitle">Quản lý lớp<i id="angle_subItem1" class="fas fa-angle-right"></i></span>
                </button>
                
                <div id="group_subItem1" class="hidden">
                    <button class="btn subitem" onclick="goClassList()">
                        <i class="fas fa-users"></i><span class="showTitle">Lớp đồ án</span>
                    </button>
                    <button class="btn subitem" onclick="goThesisList()">
                        <i class="fas fa-graduation-cap"></i><span class="showTitle">Lớp luận văn</span>
                    </button>
                </div>
            </div>
        </div>
        <script src="../shared/shared.js"></script>
    </body>
</html>