<?php
    ob_start();
    include("../../../public/config.php");
    global $conn;
    if(!isset($_COOKIE['cookie_user']) || !isset($_COOKIE['cookie_pass'])){
        if (session_id() === '')
            session_start();
        if(!isset($_SESSION['login']))
            header('location: ../.././../login/Views/LoginView.php');
        $sql="SELECT * FROM nguoidung WHERE TaiKhoan='".$_SESSION['login']."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if($row['Loai']==3)
            header('location: ../../../Admin/Views/DashboardView/DashboardView.php');  
        else if($row['Loai']==1)
            header('location: ../../../Students/Views/DashboardView/DashboardView.php');  
    }
    else if(!isset($_SESSION['login'])){
        if (session_id() === '')
            session_start();
        $_SESSION['login'] = $_COOKIE['cookie_user'];
        $sql="SELECT * FROM nguoidung WHERE TaiKhoan='".$_COOKIE['cookie_user']."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if($row['Loai']==3)
            header('location: ../../../Admin/Views/DashboardView/DashboardView.php'); 
        else if($row['Loai']==1)
            header('location: ../../../Students/Views/DashboardView/DashboardView.php'); 
        
    }else{
        $sql="SELECT * FROM nguoidung WHERE TaiKhoan='".$_SESSION['login']."'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if($row['Loai']==3)
            header('location: ../../../Admin/Views/DashboardView/DashboardView.php');  
        else if($row['Loai']==1)
            header('location: ../../../Students/Views/DashboardView/DashboardView.php');  
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
                <h1 class="showTitle">Qu???n l?? ????? ??n</h1>
            </div>
            <div class="line"></div>
            <div>
                <button class="btn item" onclick="goDashboard()">
                    <i class="fas fa-home"></i><span class="showTitle">Trang ch???</span>
                </button>
            </div>            
            <div>
                <button class="btn item" onclick="showSubItem('subItem2');">
                    <i class="fas fa-users"></i><span class="showTitle">Qu???n l?? l???p<i id="angle_subItem2" class="fas fa-angle-right"></i></span>
                </button>
                
                <div id="group_subItem2" class="hidden">
                    <button class="btn subitem" onclick="goClass()">
                        <i class="fas fa-users"></i><span class="showTitle">L???p ????? ??n</span>
                    </button>
                    <button class="btn subitem" onclick="goThesisClass()">
                        <i class="fas fa-graduation-cap"></i><span class="showTitle">L???p kho?? lu???n</span>
                    </button>
                </div>
            </div>
            <div>
                <button class="btn item" onclick="showSubItem('subItem1');">
                    <i class="fas fa-book"></i><span class="showTitle">????? t??i ????? ??n<i id="angle_subItem1" class="fas fa-angle-right"></i></span>
                </button>
                
                <div id="group_subItem1" class="hidden">
                    <button class="btn subitem" onclick="goTopic()">
                        <i class="fas fa-list"></i><span class="showTitle">Danh s??ch ????? t??i</span>
                    </button>
                    <button class="btn subitem" onclick="goTopicSugg()">
                        <i class="far fa-comment"></i><span class="showTitle">????? t??i ????? xu???t</span>
                    </button>
                </div>
            </div>
            <div>
                <button class="btn item" onclick="goThesisTopic()">
                <i class="far fa-comment"></i><span class="showTitle">????? t??i kho?? lu???n</span>
                </button>
            </div>
            <div>
                <button class="btn item" onclick="showSubItem('subItem3');">
                    <i class="fas fa-file-word"></i><span class="showTitle">Qu???n l?? ti???n ?????<i id="angle_subItem3" class="fas fa-angle-right"></i></span>
                </button>                
                <div id="group_subItem3" class="hidden">
                    <button class="btn subitem" onclick="goProcess()">
                        <i class="fas fa-users"></i><span class="showTitle">L???p ????? ??n</span>
                    </button>
                    <button class="btn subitem" onclick="goThesisPro()">
                        <i class="fas fa-graduation-cap"></i><span class="showTitle">L???p kho?? lu???n</span>
                    </button>
                </div>
            </div>
            <div>
                <button class="btn item" onclick="goCalen()">
                <i class="fas fa-calendar-alt"></i><span class="showTitle">X???p l???ch b??o c??o</span>
                </button>
            </div>
            <?php
                $sql="SELECT * FROM nguoidung WHERE TaiKhoan='".$_SESSION['login']."'";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                if($row['Loai']==4){
                    echo "<div>
                            <button class='btn item' id='subItem4' onclick='showSubItem(this.id);'>
                                <i class='fas fa-file-word'></i><span class='showTitle'>B???o v??? kho?? lu???n<i id='angle_subItem4' class='fas fa-angle-right'></i></span>
                            </button>                
                            <div id='group_subItem4' class='hidden'>
                                <button class='btn subitem' onclick='goCouncil()'>
                                    <i class='fas fa-users'></i><span class='showTitle'>H???i ?????ng b???o v???</span>
                                </button>
                                <button class='btn subitem' onclick='goThesisCalen()'>
                                    <i class='fas fa-calendar-alt'></i><span class='showTitle'>L???ch b???o v???</span>
                                </button>
                            </div>
                        </div>";
                }
            ?>
        </div>
        <script src="../shared/shared.js"></script>
    </body>
</html>