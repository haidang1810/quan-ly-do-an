<?php
    include("../../Models/ProcessModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();
    echo "<div>
    <for method='POST'>";
    echo "<select name='HKNH' class='select_process dsHKNH'>";
    echo "<option value='-1'>Chọn lớp học kỳ năm học</option>";
    loadHKNH($conn);        
    echo "</select>";
    echo "<select name='lopHP' class=' select_process dsLop'>";
    echo "<option value='-1'>Chọn lớp HP</option>";
    echo "</select>";
    echo "<button name='search' type='button' class='button_search'>Tìm kiếm</button>";
    echo "<button class='btn_download_class' name='downloadClass'>";
    echo "<i class='fas fa-download'></i> Tải về";
    echo "</button>";
    echo "</form>
    </div>";

    echo "<div class='table'>";
    
    echo "</div>";

    
    echo "<div class='table-detail'>";

    echo "</div>";
    
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
        $MaHP = $_POST['lopHP'];
        $source = "../../../public/item/".$MaHP."/";
        $destination = $MaHP.".zip";
        Zip($source,$destination,true);       
    }
?>