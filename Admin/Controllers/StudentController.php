<?php
    include("../../Models/StudentModel.php");
    include("../../../public/config.php");
    include("../../../public/vendor/autoload.php");
    global $conn;
    if (session_id() === '')
        session_start();
    //tab 1    
    echo "<div class='tab_content'>";
    
    echo "<button class='btn_add' onclick='showAdd()'>
            <i class='fas fa-plus'></i>&nbsp;Thêm
        </button>";
    echo "<form method='POST' class='btn_multiCreateAcc'>";
    echo "<button class='btn_auto_create' type='submit' name='multiCreateAcc'>";
    echo "<i class='fas fa-plus'></i>Tự tạo tài khoản";
    echo "</button>";
    echo "</form>";
    echo "<div class='table'>";
    echo "<table id='tableStudent'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Mssv</th>";
    echo "<th>Họ Tên</th>";
    echo "<th>Gmail</th>";
    echo "<th>Thao tác</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    if(!isset($_POST['editStudent'])&&!isset($_POST['multiAddStu'])&&!isset($_POST['addStudent'])
    &&!isset($_POST['createAcc'])&&!isset($_POST['multiCreateAcc']))
        loadStudent($conn);
    if(isset($_POST['editStudent'])){
        if(!empty($_POST['Mssv']))
            if(!empty($_POST['Hoten']))
                if(!empty($_POST['Gmail'])){
                    $mssv = $_POST['Mssv'];
                    $hoTen = $_POST['Hoten'];
                    $gmail = $_POST['Gmail'];
                    editStudent($conn,$mssv,$hoTen,$gmail);
                    loadStudent($conn);
                }  
                else echo"<script type='text/javascript'> alert('Chưa nhập gmail')</script>";            
            else echo"<script type='text/javascript'> alert('Chưa nhập họ và tên')</script>";
        else echo"<script type='text/javascript'> alert('Lỗi chưa chọn sinh viên vui lòng thử lại')</script>";   
    }
    if(isset($_POST['multiAddStu'])){
        $file = $_FILES['file']['tmp_name'];
        if(!empty($file)){
            if(empty($_POST['autoAcc']))
                multiAddstu($conn,$file,false);
            else
                multiAddstu($conn,$file,true);
            loadStudent($conn);
        }else echo"<script type='text/javascript'> alert('Chưa chọn file')</script>";
    }

    if(isset($_POST['addStudent'])){
        if(!empty($_POST['Mssv']))
            if(!empty($_POST['Hoten']))
                if(!empty($_POST['Gmail'])){
                    $mssv = $_POST['Mssv'];
                    $hoTen = $_POST['Hoten'];
                    $gmail = $_POST['Gmail'];
                    if(isset($_POST['autoAcc']))
                        addStu($conn,$mssv,$hoTen,$gmail,true);
                    else 
                        addStu($conn,$mssv,$hoTen,$gmail,false);
                    loadStudent($conn);
                }
                else echo"<script type='text/javascript'> alert('Chưa nhập gmail')</script>";         
            else echo"<script type='text/javascript'> alert('Chưa nhập họ và tên')</script>";
        else echo"<script type='text/javascript'> alert('Chưa nhập mssv')</script>";
    }

    if(isset($_POST['createAcc'])){
        if(!empty($_POST['mssv'])){
            $mssv = $_POST['mssv'];
            addAccount($conn,$mssv);
            loadStudent($conn);
        }else echo"<script type='text/javascript'> alert('Chưa chọn sinh viên vui lòng chọn lại')</script>";
    }
    if(isset($_POST['multiCreateAcc'])){        
        addAccount($conn);
        loadStudent($conn);
    }


    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "<div class='block_multiAddSt'>";
    echo "<form method='POST' enctype='multipart/form-data'>";
    echo "<input type='file' name='file'>";
    echo "<input type='checkbox' name='autoAcc' id='autoAcc' checked='checked'>";
    echo "<label for='autoAcc'>Tự động tạo tài khoản cho sinh viên</label>";
    echo "<br>";
    echo "<button type='submit' name='multiAddStu'>";
    echo "<i class='fas fa-upload'></i>Thêm từ tệp";
    echo "</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";

    echo "<div class='form_edit_Stu'>
    <form method='POST'>
        <input type='hidden' id='editMssv' name='Mssv'>        
        <div class='form_field'>
            <input type='text' name='Hoten' id='editHoten' class='form_input'>
            <label for='ten' class='form_label'>Họ và tên</label>
        </div>
        <div class='form_field'>
            <input type='text' id='editGmail' name='Gmail' class='form_input'>
            <label for='mail' class='form_label'>Gmail</label>
        </div>
        <input type='submit' name='editStudent' value='Lưu'> 
    </form>
</div> ";

    echo "<div class='form_add_Stu'>
    <form method='POST'>
        <div class='form_field'>
            <input type='text' name='Mssv' class='form_input' >
            <label for='ms' class='form_label'>Mã số sinh viên</label>
        </div>        
        <div class='form_field'>
            <input type='text' name='Hoten' class='form_input'>
            <label for='ten' class='form_label'>Họ và tên</label>
        </div>
        <div class='form_field'>
            <input type='text' name='Gmail' class='form_input' placeholder='Nhập tên miền. Vd: @gmail.com'>
            <label for='mail' class='form_label'>Gmail</label>
        </div>
        <input type='checkbox' name='autoAcc' id='autoAcc_add' checked='checked'>
        <label for='autoAcc_add'>Tự động tạo tài khoản cho sinh viên</label>
        <input type='submit' name='addStudent' value='Lưu'> 
    </form>
</div> ";

    //tab 2
    echo "<div class='tab_content' >";

    echo "<div class='table'>";
    echo "<table id='tableAccount'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Tài khoản</th>";
    echo "<th>Mật khẩu</th>";
    echo "<th>Thao tác</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    if(!isset($_POST['disableAcc'])&&!isset($_POST['enableAcc'])&&!isset($_POST['resetPass']))
        loadAccount($conn);

    if(isset($_POST['disableAcc'])){
        $user = $_POST['disableAcc'];
        disable($conn,$user);
        loadAccount($conn);
    }
    if(isset($_POST['enableAcc'])){
        $user = $_POST['enableAcc'];
        enable($conn,$user);
        loadAccount($conn);
    }
    if(isset($_POST['resetPass'])){
        $user = $_POST['resetPass'];
        resetPass($conn,$user);
        loadAccount($conn);
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "</div>";
?>