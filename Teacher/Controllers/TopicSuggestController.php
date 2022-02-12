<?php
    include("../../Models/TopicSuggestModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();

    echo "<div>
    <form method='POST'>";
    echo "<select name='HKNH' class='dsHKNH'>";
    echo "<option value='-1'>Chọn lớp học kỳ năm học</option>";
    loadHKNH($conn);        
    echo "</select>";
    echo "<select name='lopHP' class='dsLop'>";
    echo "<option value='-1'>Chọn lớp HP</option>";
    echo "</select>";
    echo "<input type='submit' name='search' value='Tìm kiếm' class='topic_button_search'>";
    echo "</form>
    </div>";
    echo "<div class='table'>";
    echo "<table id='tableTopic'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>id</th>";
    echo "<th style='min-width:100px'>Tên đề tài</th>";
    echo "<th>Ghi chú</th>";
    echo "<th>Sinh viên đề xuất</th>";
    echo "<th>Số thành viên</th>";
    echo "<th>Duyệt</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    if(isset($_POST['search'])){
        if(isset($_POST['lopHP'])){
            $MaLop = $_POST['lopHP'];
            loadTopicSuggest($conn,$MaLop);
        }
        
    }
    if(isset($_SESSION['LHP'])&&!isset($_POST['search'])&&!isset($_POST['MaDX-suggest'])
    &&!isset($_POST['MaDX-refuse']))
        loadTopicSuggest($conn,$_SESSION['LHP']);

    
    if(isset($_POST['MaDX-suggest']) && !empty($_POST['MaDX-suggest']))
        if(isset($_POST['TenDT']) &&!empty($_POST['TenDT']))
            if(isset($_POST['MaLop']) &&!empty($_POST['MaLop'])){
                $Ma=$_POST['MaDX-suggest'];
                $MaLop=$_POST['MaLop'];
                $Ten = $_POST['TenDT'];
                $GhiChu = $_POST['GhiChu'];
                suggestTopic($conn,$Ma,$Ten,$GhiChu,$MaLop);
                loadTopicSuggest($conn,$MaLop);
            }
    

    if(isset($_POST['MaDX-refuse'])){
        if(!empty($_POST['MaDX-refuse'])){
            $ma = $_POST['MaDX-refuse'];
            refuse($conn,$ma);
            loadTopicSuggest($conn,$_SESSION['LHP']);
        }
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";


?>