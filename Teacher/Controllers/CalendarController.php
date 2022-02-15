<?php
    include("../../Models/CalendarModel.php");
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
    echo "<button name='search' type='button' class='button_search'>Tìm kiếm</button>";
    echo "</form>
    </div>";

    echo "<div class='table'>";
    

    
    echo "</div>";
?>