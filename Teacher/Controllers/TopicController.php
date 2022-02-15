<?php
    include("../../Models/TopicModel.php");
    include("../../../public/config.php");
    require("../../../public/PHPExcel/Classes/PHPExcel.php");
    global $conn;
    if (session_id() === '')
        session_start();
    if(isset($_SESSION['LHP'])){
        $LHP = $_SESSION['LHP'];
    }
            
    echo "<div>
    <form method='POST' id='formTopic'>";
    echo "<select name='HKNH' class='topic_select dsHKNH'>";
    echo "<option value='-1'>Chọn lớp học kỳ năm học</option>";
    loadHKNH($conn);        
    echo "</select>";
    echo "<select name='lopHP' class=' select_class dsLop'>";
    echo "<option value='-1'>Chọn lớp HP</option>";
    echo "</select>";
    echo "<button name='search' type='button' class='topic_button_search'>Tìm kiếm</button>";
    echo "</form>
    </div>";
    echo "<div class='table'>";
    


    if(isset($_POST['multiAdd'])){
        $class = $_POST['LopHP'];
        $file = $_FILES['file']['tmp_name'];
        if(!empty($file)){
            multiAdd($conn,$file,$class);
        }else echo"<script type='text/javascript'> alert('Chưa chọn file')</script>";
    }

    echo "</div>";

?>