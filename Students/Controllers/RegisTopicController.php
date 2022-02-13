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
        
        if(!isset($_POST['Id-cancel']))
            loadTopic($conn,$_SESSION['DetailClass']);
        if(isset($_POST['Id-cancel'])){
            $maDT = $_POST['Id-cancel'];
            cancelTopic($conn,$maDT);
            loadTopic($conn,$_SESSION['DetailClass']);
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";

        //modal
        echo "
        <div class='modal hide'>
                <div class='modal__inner'>
                    <div class='modal__header'>
                        <p>Đăng ký đề tài</p>
                        <i class='fas fa-times'></i>
                    </div>
                    <div class='modal__body'>
                        <h2>Chọn thành viên</h2>
                        <form method='POST' class='modal__form'>
                            <input type='hidden' name='MaDT' value='' id='Id_DT'>
                            ";
                            LoadStudent($conn,$_SESSION['DetailClass']);
                            
                        echo "</form>
                    </div>
                    <div class='modal__footer'>
                        <button class='modal__button__submit'>Đăng ký</button>
                    </div>
                </div>
            </div>
        ";
    }else{
        header("location: ../../Views/ClassListView/ClassListView.php");
    }

?>