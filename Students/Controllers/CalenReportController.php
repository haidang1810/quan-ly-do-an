<?php
    include("../../Models/CalenReportModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();

        if(isset($_SESSION['DetailClass'])){
            $maLop = $_SESSION['DetailClass'];
            echo "<h2>Danh sách lịch báo cáo lớp ".$_SESSION['DetailClass']."</h2>";
            echo "<div class='table'>";
            echo "<table id='tableTopic'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Ngày báo cáo</th>";
            echo "<th>Thời gian bắt đầu</th>";
            echo "<th>Số nhóm báo cáo</th>";
            echo "<th>Đăng ký</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            if(!isset($_POST['cancel-calen']) && !isset($_POST['RegCalen']))
            loadData($conn,$maLop);
            if(isset($_POST['cancel-calen'])){
                cancelCalen($conn,$maLop);
                loadData($conn,$maLop);
            }
            if(isset($_POST['RegCalen'])){
                $id = $_POST['RegCalen'];
                RegisCalen($conn,$maLop,$id);
                loadData($conn,$maLop);
            }
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        }else{
            header("location: ../../Views/ClassListView/ClassListView.php");
        }
?>