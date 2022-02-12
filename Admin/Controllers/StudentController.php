<?php
    include("../../Models/StudentModel.php");
    include("../../../public/config.php");
    require("../../../public/PHPExcel/Classes/PHPExcel.php");
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
    echo "<th>Năm sinh</th>";
    echo "<th>Số điện thoại</th>";
    echo "<th>Địa chỉ</th>";
    echo "<th>Khoá</th>";
    echo "<th>Lớp</th>";
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
                if(!empty($_POST['Gmail']))
                    if(!empty($_POST['NamSinh']))
                        if(!empty($_POST['SDT']))
                            if(!empty($_POST['DiaChi']))
                                if(!empty($_POST['Khoa']))
                                    if(!empty($_POST['Lop'])){
                                        $mssv = $_POST['Mssv'];
                                        $hoTen = $_POST['Hoten'];
                                        $gmail = $_POST['Gmail'];
                                        $namSinh = $_POST['NamSinh'];
                                        $SDT = $_POST['SDT'];
                                        $diaChi = $_POST['DiaChi'];
                                        $khoa = $_POST['Khoa'];
                                        $lop = $_POST['Lop'];
                                        editStudent($conn,$mssv,$hoTen,$gmail,$namSinh,$SDT,$diaChi,$khoa,$lop);
                                        loadStudent($conn);
                                    }else echo"<script type='text/javascript'> alert('Chưa nhập lớp')</script>";
                                else echo"<script type='text/javascript'> alert('Chưa nhập khoá')</script>";
                            else echo"<script type='text/javascript'> alert('Chưa nhập địa chỉ')</script>";
                        else echo"<script type='text/javascript'> alert('Chưa nhập số điện thoại')</script>";
                    else echo"<script type='text/javascript'> alert('Chưa nhập năm sinh')</script>";    
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
                if(!empty($_POST['Gmail']))
                    if(!empty($_POST['NamSinh']))
                        if(!empty($_POST['SDT']))
                            if(!empty($_POST['DiaChi']))
                                if(!empty($_POST['Khoa']))
                                    if(!empty($_POST['Lop'])){
                                        $mssv = $_POST['Mssv'];
                                        $hoTen = $_POST['Hoten'];
                                        $gmail = $_POST['Gmail'];
                                        $namSinh = $_POST['NamSinh'];
                                        $SDT = $_POST['SDT'];
                                        $diaChi = $_POST['DiaChi'];
                                        $khoa = $_POST['Khoa'];
                                        $lop = $_POST['Lop'];
                                        if(isset($_POST['autoAcc']))
                                            addStu($conn,$mssv,$hoTen,$gmail,$namSinh,$SDT,$diaChi,$khoa,$lop,true);
                                        else 
                                            addStu($conn,$mssv,$hoTen,$gmail,$namSinh,$SDT,$diaChi,$khoa,$lop,false);
                                        loadStudent($conn);
                                    }else echo"<script type='text/javascript'> alert('Chưa nhập lớp')</script>";
                                else echo"<script type='text/javascript'> alert('Chưa nhập khoá')</script>";
                            else echo"<script type='text/javascript'> alert('Chưa nhập địa chỉ')</script>";
                        else echo"<script type='text/javascript'> alert('Chưa nhập số điện thoại')</script>";
                    else echo"<script type='text/javascript'> alert('Chưa nhập năm sinh')</script>"; 
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
        <div class='form_field'>
            <input type='date' name='NamSinh' id='editNamSinh' class='form_input'>
            <label for='ns' class='form_label'>Năm sinh</label>
        </div>
        <div class='form_field'>
            <input type='number' name='SDT' id='editSDT' class='form_input'>
            <label for='sdt' class='form_label'>Số điện thoại</label>
        </div>
        <div class='form_field'>
            <input type='text' name='DiaChi' id='editDiaChi' class='form_input'>
            <label for='diaChi' class='form_label'>Địa chỉ</label>
        </div>
        <div class='form_field'>
            <input type='text' name='Khoa' id='editKhoa' class='form_input'>
            <label for='khoa' class='form_label'>Khoá</label>
        </div>
        <div class='form_field'>
            <input type='text' name='Lop' id='editLop' class='form_input'>
            <label for='Ms' class='form_label'>Lớp</label>
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
        <div class='form_field'>
            <input type='date' name='NamSinh' class='form_input'>
            <label for='ns' class='form_label'>Năm sinh</label>
        </div>
        <div class='form_field'>
            <input type='number' name='SDT' class='form_input'>
            <label for='sdt' class='form_label'>Số điện thoại</label>
        </div>
        <div class='form_field'>
            <input type='text' name='DiaChi' class='form_input'>
            <label for='diaChi' class='form_label'>Địa chỉ</label>
        </div>
        <div class='form_field'>
            <input type='text' name='Khoa' class='form_input'>
            <label for='khoa' class='form_label'>Khoá</label>
        </div>
        <div class='form_field'>
            <input type='text' name='Lop' class='form_input'>
            <label for='Ms' class='form_label'>Lớp</label>
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

    if(!isset($_POST['disableAcc'])&&!isset($_POST['enableAcc']))
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

    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    echo "</div>";

?>