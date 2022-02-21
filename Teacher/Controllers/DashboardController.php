<?php
    include("../../Models/DashboardModel.php");
    include("../../../public/config.php");
    global $conn;
    echo "<div>
            <div class='boxed box_blue'>
                ";totalStudent($conn); echo "
                <p class='box-title'>Tổng số sinh viên</p>
            </div>
            <div class='boxed box_blue'>
                ";totalClass($conn);echo "
                <p class='box-title'>Tổng số lớp học phần</p>
            </div>
            <div class='boxed box_blue'>
                ";totalTopic($conn); echo "
                <p class='box-title'>Tổng số đề tài</p>
            </div>
            <div class='boxed box_blue'>
                ";suggestApproved($conn); echo "
                <p class='box-title'>Đề tài đề xuất đã duyệt</p>
            </div>
        </div>
        <div>
            <div class='boxed box_red'>
                ";suggest($conn); echo "
                <p class='box-title'>Đề tài đề xuất chưa duyệt</p>
            </div>
            <div class='boxed box_red'>
                ";classNonTopic($conn); echo "
                <p class='box-title'>Số lớp chưa có đề tài</p>
            </div>
            <div class='boxed box_red'>
                ";classNonCalen($conn); echo "
                <p class='box-title'>Số lớp chưa có lịch báo cáo</p>
            </div>
        </div>";
?>