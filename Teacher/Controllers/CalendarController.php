<?php
    include("../../Models/CalendarModel.php");
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
    echo "<select name='lopHP' class='dsLop'>";
    echo "<option value='-1'>Chọn lớp HP</option>";
    echo "</select>";
    echo "<input type='submit' name='search' value='Tìm kiếm' class='topic_button_search'>";
    echo "</form>
    </div>";

    echo "<div class='table'>";
    echo "<table id='tableCalen'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Ngày báo cáo</th>";
    echo "<th>Thời gian bắt đầu</th>";
    echo "<th>Số nhóm báo cáo</th>";
    echo "<th>Đề tài đã đăng ký</th>";
    echo "<th>Thao tác</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    if(isset($_POST['search'])){
        $MaHP = $_POST['lopHP'];
        loadCalendar($conn,$MaHP);
    }

    if(isset($_SESSION['LHP'])&&!isset($_POST['search'])&&!isset($_POST['addCalen'])
    &&!isset($_POST['id-delete'])&&!isset($_POST['editCalen'])){
        $MaHP = $_SESSION['LHP'];
        loadCalendar($conn,$MaHP);
    }


    if(isset($_POST['addCalen'])){
        if(!empty($_POST['NgayBC']))
            if(!empty($_POST['ThoiGianBD']))
                if(!empty($_POST['SoNhomBC']))
                    if(!empty($_POST['LopHP'])){
                        $dateReport = $_POST['NgayBC'];
                        $timeStart = $_POST['ThoiGianBD'];
                        $Amount = $_POST['SoNhomBC'];
                        $class = $_POST['LopHP'];
                        addCalen($conn,$dateReport,$timeStart,$Amount,$class);
                        loadCalendar($conn,$class);
                    }else echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Chưa chọn lớp!'
                        })
                    </script>
                    ";
                else echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi...',
                        text: 'Chưa nhập số nhóm báo cáo!'
                    })
                </script>
                ";
            else echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Chưa chọn thời gian bắt đầu!'
                })
            </script>
            ";
        else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Chưa chọn ngày báo cáo!'
            })
        </script>
        ";
    }

    if(isset($_POST['id-delete'])&& !empty($_POST['id-delete'])){
        $id = $_POST['id-delete'];
        deleCalen($conn, $id);
        $MaHP = $_SESSION['LHP'];
        loadCalendar($conn,$MaHP);
    }

    if(isset($_POST['editCalen'])&&!empty($_POST['id-edit'])){
        if(!empty($_POST['NgayBC']))
            if(!empty($_POST['ThoiGianBD']))
                if(!empty($_POST['SoNhomBC'])){
                    $id = $_POST['id-edit'];
                    $date = $_POST['NgayBC'];
                    $time = $_POST['ThoiGianBD'];
                    $amount = $_POST['SoNhomBC'];
                    editCalen($conn,$id,$date,$time,$amount);
                    $MaHP = $_SESSION['LHP'];
                    loadCalendar($conn,$MaHP);
                }else echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi...',
                        text: 'Chưa nhập số nhóm báo cáo!'
                    })
                </script>
                ";
            else echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Chưa chọn thời gian báo cáo!'
                })
            </script>
            ";
        else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Chưa chọn ngày báo cáo!'
            })
        </script>
        ";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
?>