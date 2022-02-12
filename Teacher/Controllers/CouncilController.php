<?php
    include("../../Models/CouncilModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();
    
    echo "<div class='table'>";
    echo "<table id='tableCouncil'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Mã hội đồng</th>";
    echo "<th>Chủ tịch hội đồng</th>";
    echo "<th>Thư ký</th>";
    echo "<th>Giảng viên phản biện</th>";
    echo "<th>Thao tác</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    if(!isset($_POST['addCouncil']) && !isset($_POST['deleteCouncil']) && !isset($_POST['editCouncil']))
        loadCouncil($conn);
    
    //load khi xoa
    if(isset($_POST['deleteCouncil'])){
        $Ma = $_POST['deleteCouncil'];
        deleCouncil($Ma,$conn);
        loadCouncil($conn);
    }
    
    if(isset($_POST['addCouncil'])){
        if(isset($_POST['MaHD']) && !empty($_POST['MaHD']))
            if(isset($_POST['CTHD']) && !empty($_POST['CTHD']))
                if(isset($_POST['CBHD']) && !empty($_POST['CBHD']))
                    if(isset($_POST['GVPB']) && !empty($_POST['GVPB'])){
                        $maHD = $_POST['MaHD'];
                        $CTHD = $_POST['CTHD'];
                        $CBHD = $_POST['CBHD'];
                        $GVPB = $_POST['GVPB'];
                        if($CTHD != $CBHD && $CTHD != $GVPB && $CBHD != $GVPB)
                            addCouncil($conn, $maHD, $CTHD, $CBHD, $GVPB);   
                        else echo"<script type='text/javascript'> alert('Các chức vụ không được trùng')</script>";                     
                    }else echo"<script type='text/javascript'> alert('Chưa chọn giảng viên phản biên')</script>";
                else echo"<script type='text/javascript'> alert('Chưa chọn cán bộ hướng dẫn')</script>";
            else echo"<script type='text/javascript'> alert('Chưa chọn chủ tịch hội đồng')</script>";
        else echo"<script type='text/javascript'> alert('Chưa nhập mã hội đồng')</script>";
        loadCouncil($conn);
    }
    //load khi cap nhat
    if(isset($_POST['editCouncil'])){
        if(isset($_POST['MaHD']) && !empty($_POST['MaHD']))
            if(isset($_POST['CTHD']) && !empty($_POST['CTHD']))
                if(isset($_POST['CBHD']) && !empty($_POST['CBHD']))
                    if(isset($_POST['GVPB']) && !empty($_POST['GVPB'])){
                        $MaHD = $_POST['MaHD'];
                        $CTHD = $_POST['CTHD'];
                        $CBHD = $_POST['CBHD'];
                        $GVPB = $_POST['GVPB'];
                        if($CTHD != $CBHD && $CTHD != $GVPB && $CBHD != $GVPB)
                            editCouncil($MaHD, $CTHD, $CBHD, $GVPB, $conn);   
                        else echo"<script type='text/javascript'> alert('Các chức vụ không được trùng')</script>";                   
                    }else echo"<script type='text/javascript'> alert('Chưa chọn giảng viên phản biên')</script>";
                else echo"<script type='text/javascript'> alert('Chưa chọn cán bộ hướng dẫn')</script>";
            else echo"<script type='text/javascript'> alert('Chưa chọn chủ tịch hội đồng')</script>";
        else echo"<script type='text/javascript'> alert('Chưa nhập mã hội đồng')</script>";
        loadCouncil($conn);
    }
    if(isset($_POST['multiAdd'])){
        $class = $_POST['LopHP'];
        $file = $_FILES['file']['tmp_name'];
        if(!empty($file))
            multiAdd($conn,$file,$class);
        else echo"<script type='text/javascript'> alert('Chưa chọn file')</script>";
    }


    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    
?>