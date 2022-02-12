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
    echo "<input type='submit' name='search' value='Tìm kiếm' class='topic_button_search'>";
    echo "</form>
    </div>";
    if(isset($_SESSION['LHP']))
        echo "<h3>Danh sách đề tài lớp ".$_SESSION['LHP']."</h3>";
    echo "<div class='table'>";
    echo "<table id='tableTopic'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th style='max-width:200px'>Tên đề tài</th>";
    echo "<th>Ghi chú</th>";
    echo "<th style='min-width:50px'>Số thành viên</th>";
    echo "<th style='min-width:90px'>Thao tác</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    if(isset($_SESSION['LHP'])&&!isset($_POST['search'])&&!isset($_POST['addTopic'])
    &&!isset($_POST['editTopic'])&&!isset($_POST['MaDT-delete'])&&!isset($_POST['multiAdd']))
        loadTopic($_SESSION['LHP'],$conn);
    //load khi ấn tìm
    if(isset($_POST['search'])){
        if(isset($_POST['lopHP'])&&$_POST['lopHP']!=-1){
            $MaHP = $_POST['lopHP'];
            loadTopic($MaHP,$conn);
        }
    }
    //load khi xoa
    if(isset($_POST['MaDT-delete'])){
        $Ma = $_POST['MaDT-delete'];
        deleTopic($Ma,$conn);
        $LHP = $_SESSION['LHP'];
        loadTopic($LHP,$conn);
    }
    //load khi them
    if(isset($_POST['addTopic'])){
        if(isset($_POST['TenDeTai']))
            $Ten = $_POST['TenDeTai'];
        if(isset($_POST['SoThanVien']))
            $SoThanhVien = $_POST['SoThanVien'];
        if(isset($_POST['LopHP']))
            $HP = $_POST['LopHP'];         
            if(trim($Ten)!="")
                if(trim($SoThanhVien)!="")
                    if(trim($HP)){
                        if(isset($_POST['GhiChu']))
                            $GhiChu = $_POST['GhiChu'];
                        addTopic($Ten, $SoThanhVien, $GhiChu, $HP, $conn);
                        loadTopic($LHP,$conn);
                    }
                    else echo"<script type='text/javascript'> alert('Chưa chọn lớp học phần')</script>";
                else echo"<script type='text/javascript'> alert('Chưa nhập số thành viên')</script>";
            else echo"<script type='text/javascript'> alert('Chưa nhập tên đề tài')</script>";       
    }
    //load khi cap nhat
    if(isset($_POST['editTopic'])){
        if(isset($_POST['MaDeTai']))
            $MaDeTai = $_POST['MaDeTai'];
        if(isset($_POST['TenDeTai']))    
            $TenDeTai = $_POST['TenDeTai'];
        if(isset($_POST['SoThanVien']))    
            $SoThanhVien = $_POST['SoThanVien'];
        if(trim($MaDeTai)!="")
            if(trim($TenDeTai)!="")
                if(trim($SoThanhVien)!=""){
                    if(isset($_POST['GhiChu'])){
                        $GhiChu = $_POST['GhiChu'];
                        editTopic($MaDeTai,$TenDeTai, $GhiChu, $SoThanhVien,$conn);
                        loadTopic($LHP,$conn);
                    }
                        
                }
    }
    if(isset($_POST['multiAdd'])){
        $class = $_POST['LopHP'];
        $file = $_FILES['file']['tmp_name'];
        if(!empty($file)){
            multiAdd($conn,$file,$class);
            loadTopic($LHP,$conn);
        }else echo"<script type='text/javascript'> alert('Chưa chọn file')</script>";
    }


    echo "</tbody>";
    echo "</table>";
    echo "</div>";

?>