<?php
    include("../../Models/ThesisCalenModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();
    if(isset($_SESSION['login'])){
        $data = $_SESSION['login'];
        $findGV = "SELECT Loai FROM nguoidung WHERE TaiKhoan='$data'";
        $resultGV = $conn->query($findGV);
        if($resultGV->num_rows>0){
            $rowGV = $resultGV->fetch_assoc();
            if($rowGV['Loai']==2){
                header("location: ../../Views/DashboardView/DashboardView.php");
            }
        }
        
    }
    
    echo "<div>
    <form method='POST'>";
    echo "<select name='HKNH' class='dsHKNH'>";
    echo "<option value='-1'>Chọn lớp học kỳ năm học</option>";
    loadHKNH($conn);        
    echo "</select>";
    echo "<select name='lopLV' class='dsLop'>";
    echo "<option value='-1'>Chọn lớp HP</option>";
    echo "</select>";
    echo "<button name='search' type='button' class='button_search'>Tìm kiếm</button>";
    echo "</form>
    </div>";

    echo "<div class='table'>";

    
    echo "</div>";
?>