<?php
    include("../../Models/RegisTopicModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();
    
    if(isset($_SESSION['DetailClass'])){
        echo "<h2>Danh sách đề tài lớp ".$_SESSION['DetailClass']."</h2>";
        echo "<div class='table'>";
        echo "<table id='tableTopic'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Tên đề tài</th>";
        echo "<th>Ghi chú</th>";
        echo "<th>Số thành viên</th>";
        echo "<th>Đăng ký</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        
        loadTopic($conn,$_SESSION['DetailClass']);

        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }else{
        header("location: ../../Views/ClassListView/ClassListView.php");
    }

?>