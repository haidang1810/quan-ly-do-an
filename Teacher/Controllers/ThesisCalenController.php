<?php
    include("../../Models/ThesisCalenModel.php");
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
    echo "<select name='lopLV' class='dsLop'>";
    echo "<option value='-1'>Chọn lớp HP</option>";
    echo "</select>";
    echo "<input type='submit' name='search' value='Tìm kiếm' class='button_search'>";
    echo "</form>
    </div>";

    echo "<div class='table'>";
    echo "<table id='tableCalen'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Mssv</th>";
    echo "<th>Hội đồng</th>";
    echo "<th>Bảo vệ lần 1</th>";
    echo "<th>Bảo vệ lần 2</th>";
    echo "<th>Thao tác</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    if(isset($_POST['search'])){
        if(isset($_POST['lopLV'])){
            $MaLop = $_POST['lopLV'];
            loadCalen($conn,$MaLop);
        }
        
    }
    if(isset($_SESSION['LLV'])&&!isset($_POST['SaveCalen'])&&!isset($_POST['search'])){
        loadCalen($conn,$_SESSION['LLV']);        
    }


    if(isset($_POST['SaveCalen'])){
        if(isset($_POST['MaLich']) && !empty($_POST['MaLich'])){
            if(isset($_POST['HoiDong']) && !empty($_POST['HoiDong']))
                if(isset($_POST['Lan1']) && !empty($_POST['Lan1']))
                    if(isset($_POST['Lan2'])){
                        $maLich = $_POST['MaLich'];
                        $maHD = $_POST['HoiDong'];
                        $BVLan1 = $_POST['Lan1'];
                        $BVLan2 = $_POST['Lan2'];
                        editProcess($conn,$maLich,$maHD,$BVLan1,$BVLan2);
                    }else echo"<script type='text/javascript'> alert('Lỗi')</script>";
                else echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi...',
                        text: 'Chưa nhập thời gian bảo vệ lần 1!'
                    })
                </script>
                ";
            else echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Chưa chọn hội đồng bảo vệ!'
                })
            </script>
            ";
        }else {
            if(isset($_POST['HoiDong']) && !empty($_POST['HoiDong']))
                if(isset($_POST['Mssv']) && !empty($_POST['Mssv']))
                    if(isset($_POST['Lan1']) && !empty($_POST['Lan1'])){
                        $maHD = $_POST['HoiDong'];
                        $mssv = $_POST['Mssv'];
                        $BVLan1 = $_POST['Lan1'];
                        addProcess($conn,$maHD,$mssv,$BVLan1);
                    }else echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Chưa nhập thời gian bảo vệ lần 1!'
                        })
                    </script>
                    ";
        }
        loadCalen($conn,$_SESSION['LLV']);
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
?>