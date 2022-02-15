<?php
    include("../../Models/ThesisProModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();
    echo "<div>
    <form method='POST'>";
    echo "<select name='HKNH' class=' dsHKNH'>";
    echo "<option value='-1'>Chọn lớp học kỳ năm học</option>";
    loadHKNH($conn);        
    echo "</select>";
    echo "<select name='lopLV' class='  dsLop'>";
    echo "<option value='-1'>Chọn lớp luận văn</option>";
    echo "</select>";
    echo "<button name='search' type='button' class='button_search'>Tìm kiếm</button>";
    echo "<button class='btn_download_class' name='downloadClass'>";
    echo "<i class='fas fa-download'></i> Tải về";
    echo "</button>";
    echo "</form>
    </div>";

    echo "<div class='table'>";
    
    echo "</div>";

    
    if(isset($_GET['process'])){
        $id=$_GET['process'];
        loadDetailProcess($conn,$id);
    }
    
    if(isset($_POST['download'])){
        $source = $_POST['source'];
        $destination = $_POST['destination'];
        Zip($source,$destination,true);       
    }
    if(isset($_POST['downloadProc'])){
        $source = $_POST['source'];
        $destination = $_POST['destination'];
        Zip($source,$destination,true);       
    }
    if(isset($_POST['downloadClass'])){
        $MaHP = $_POST['lopLV'];
        $source = "../../../public/item/".$MaHP."/";
        $destination = $MaHP.".zip";
        Zip($source,$destination,true);       
    }
?>