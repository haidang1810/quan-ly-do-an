<?php
    include("../../Models/TeacherModel.php");
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
    echo "<table id='tableTeacher'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Mã giảng viên</th>";
    echo "<th>Họ Tên</th>";    
    echo "<th>Học vị</th>";    
    echo "<th>Năm sinh</th>";
    echo "<th>Số điện thoại</th>";
    echo "<th>Gmail</th>";
    echo "<th>Thao tác</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    if(!isset($_POST['editTeacher'])&&!isset($_POST['multiAddTea'])&&!isset($_POST['addTeacher'])
    &&!isset($_POST['createAcc'])&&!isset($_POST['multiCreateAcc']))
        loadTeacher($conn);
    if(isset($_POST['editTeacher'])){
        if(!empty($_POST['MaGV']))
            if(!empty($_POST['Hoten']))
                if(!empty($_POST['Gmail']))
                    if(!empty($_POST['NamSinh']))
                        if(!empty($_POST['SDT']))
                            if(!empty($_POST['Loai'])){
                            $maGV = $_POST['MaGV'];
                            $hoTen = $_POST['Hoten'];
                            $hocVi = $_POST['HocVi'];
                            $gmail = $_POST['Gmail'];
                            $namSinh = $_POST['NamSinh'];
                            $SDT = $_POST['SDT'];
                            $loai = $_POST['Loai'];
                            editTeacher($conn,$maGV,$hoTen,$hocVi,$namSinh,$SDT,$gmail,$loai);
                            
                            }else echo"<script type='text/javascript'> alert('Chưa Chọn phân quyền')</script>";
                        else echo"<script type='text/javascript'> alert('Chưa nhập số điện thoại')</script>";
                    else echo"<script type='text/javascript'> alert('Chưa nhập năm sinh')</script>";    
                else echo"<script type='text/javascript'> alert('Chưa nhập gmail')</script>";            
            else echo"<script type='text/javascript'> alert('Chưa nhập họ và tên')</script>";
        else echo"<script type='text/javascript'> alert('Lỗi chưa chọn sinh viên vui lòng thử lại')</script>";   
        loadTeacher($conn);
    }
    if(isset($_POST['multiAddTea'])){
        $file = $_FILES['file']['tmp_name'];
        if(!empty($file)){
            if(empty($_POST['autoAcc']))
                multiAddTea($conn,$file,false);
            else
                multiAddTea($conn,$file,true);
            loadTeacher($conn);
        }else echo"<script type='text/javascript'> alert('Chưa chọn file')</script>";
    }

    if(isset($_POST['addTeacher'])){
        if(!empty($_POST['MaGV']))
            if(!empty($_POST['Hoten']))
                if(!empty($_POST['Gmail']))
                    if(!empty($_POST['NamSinh']))
                        if(!empty($_POST['SDT'])){
                            $maGV = $_POST['MaGV'];
                            $hoTen = $_POST['Hoten'];
                            $hocVi = $_POST['HocVi'];
                            $gmail = $_POST['Gmail'];
                            $namSinh = $_POST['NamSinh'];
                            $SDT = $_POST['SDT'];
                            if(isset($_POST['autoAcc']))
                                addTeacher($conn,$maGV,$hoTen,$hocVi,$namSinh,$SDT,$gmail,true);
                            else 
                                addTeacher($conn,$maGV,$hoTen,$hocVi,$namSinh,$SDT,$gmail,false);
                            loadTeacher($conn);
                        }
                        else echo"<script type='text/javascript'> alert('Chưa nhập số điện thoại')</script>";
                    else echo"<script type='text/javascript'> alert('Chưa nhập năm sinh')</script>"; 
                else echo"<script type='text/javascript'> alert('Chưa nhập gmail')</script>";         
            else echo"<script type='text/javascript'> alert('Chưa nhập họ và tên')</script>";
        else echo"<script type='text/javascript'> alert('Chưa nhập mã giảng viên')</script>";
    }

    if(isset($_POST['createAcc'])){
        if(!empty($_POST['MaGV'])){
            $maGV = $_POST['MaGV'];
            addAccount($conn,$maGV);
            loadTeacher($conn);
        }else echo"<script type='text/javascript'> alert('Chưa chọn sinh viên vui lòng chọn lại')</script>";
    }
    if(isset($_POST['multiCreateAcc'])){        
        addAccount($conn);
        loadTeacher($conn);
    }


    echo "</tbody>";
    echo "</table>";
    echo "</div>";
    echo "<div class='block_multiAddSt'>";
    echo "<form method='POST' enctype='multipart/form-data'>";
    echo "<input type='file' name='file'>";
    echo "<input type='checkbox' name='autoAcc' id='autoAcc' checked='checked'>";
    echo "<label for='autoAcc'>Tự động tạo tài khoản cho giảng viên</label>";
    echo "<br>";
    echo "<button type='submit' name='multiAddTea'>";
    echo "<i class='fas fa-upload'></i>Thêm từ tệp";
    echo "</button>";
    echo "</form>";
    echo "</div>";
    echo "</div>";

    echo "<div class='form_edit_tea'>
    <form method='POST'>
        <input type='hidden' id='editMaGV' name='MaGV'>        
        <div class='form_field'>
            <input type='text' name='Hoten' id='editHoten' class='form_input'>
            <label for='ten' class='form_label'>Họ và tên</label>
        </div>
        <select class='select_teacher' id='editHocVi' name='HocVi'>
            <option value='Cử nhân'>Cử nhân</option>
            <option value='Thạc sĩ'>Thạc sĩ</option>
            <option value='Tiến sĩ'>Tiến sĩ</option>
        </select>
        <select class='select_teacher select_type' id='editLoai' name='Loai'>
            <option value='0'>Chọn phân quyền</option>
            <option value='2'>Giảng viên</option>
            <option value='4'>Trưởng khoa</option>
        </select>
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
        <input type='submit' name='editTeacher' value='Lưu'> 
    </form>
</div> ";

    echo "<div class='form_add_tea'>
    <form method='POST'>
        <div class='form_field'>
            <input type='text' name='MaGV' class='form_input' >
            <label for='ms' class='form_label'>Mã giảng viên</label>
        </div>        
        <div class='form_field'>
            <input type='text' name='Hoten' class='form_input'>
            <label for='ten' class='form_label'>Họ và tên</label>
        </div>      
        <select class='select_teacher' name='HocVi'>
            <option value='Cử nhân'>Cử nhân</option>
            <option value='Thạc sĩ'>Thạc sĩ</option>
            <option value='Tiến sĩ'>Tiến sĩ</option>
        </select>
        <div class='form_field'>
            <input type='date' name='NamSinh' class='form_input'>
            <label for='ns' class='form_label'>Năm sinh</label>
        </div>
        <div class='form_field'>
            <input type='number' name='SDT' class='form_input'>
            <label for='sdt' class='form_label'>Số điện thoại</label>
        </div>
        <div class='form_field'>
            <input type='text' name='Gmail' class='form_input'>
            <label for='mail' class='form_label'>Gmail</label>
        </div>
        </br>
        <input type='checkbox' name='autoAcc' id='autoAcc_add' checked='checked'>
        <label for='autoAcc_add'>Tự động tạo tài khoản cho giảng viên</label>
        <input type='submit' name='addTeacher' value='Lưu'> 
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