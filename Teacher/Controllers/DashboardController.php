<?php
    include("../../Models/DashboardModel.php");
    include("../../../public/config.php");
    global $conn;
    echo "<div>
            <div class='boxed'>
                ";totalStudent($conn); echo "
                <p class='box-title'>Tổng số sinh viên</p>
            </div>
            <div class='boxed'>
                ";totalClass($conn);echo "
                <p class='box-title'>Tổng số lớp học phần</p>
            </div>
            <div class='boxed'>
                ";totalTopic($conn); echo "
                <p class='box-title'>Tổng số đề tài</p>
            </div>
            <div class='boxed'>
                ";suggestApproved($conn); echo "
                <p class='box-title'>Đề tài đề xuất đã duyệt</p>
            </div>
        </div>
        <div>
            <div class='boxed'>
                ";suggest($conn); echo "
                <p class='box-title'>Đề tài đề xuất chưa duyệt</p>
            </div>
            <div class='boxed'>
                ";classNonTopic($conn); echo "
                <p class='box-title'>Số lớp chưa có đề tài</p>
            </div>
            <div class='boxed'>
                ";classNonCalen($conn); echo "
                <p class='box-title'>Số lớp chưa có lịch báo cáo</p>
            </div>
        </div>";
?>