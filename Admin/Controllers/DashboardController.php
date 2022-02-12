<?php
    include("../../Models/DashboardModel.php");
    include("../../../public/config.php");
    global $conn;
    echo "<div>
            <div class='boxed box_blue'>
                ";totalStudent($conn); echo "
                <p class='box-title'>Tổng số sinh viên</p>
            </div>
            <div class='boxed box_red'>
                ";totalTeacher($conn);echo "
                <p class='box-title'>Tổng số giảng viên</p>
            </div>
            <div class='boxed box_purple'>
                ";totalClass($conn); echo "
                <p class='box-title'>Tổng số lớp học phần</p>
            </div>
            <div class='boxed box_green'>
                ";totalClassNull($conn); echo "
                <p class='box-title'>Số lớp chưa xếp giảng viên</p>
            </div>
        </div>
        <div>
            <div class='boxed box_blue'>
                ";totalAccStu($conn); echo "
                <p class='box-title'>Tổng số tài khoản sinh viên</p>
            </div>
            <div class='boxed box_red'>
                ";totalAccTea($conn);echo "
                <p class='box-title'>Tổng số tài khoản giảng viên</p>
            </div>
        </div>";        
?>