<?php
    include("../../Models/ClassModel.php");
    include("../../../public/config.php");
    //require("../../../public/PHPExcel/Classes/PHPExcel.php");
    include("../../../public/vendor/autoload.php");
    global $conn;
    if (session_id() === '')
        session_start();
    
    echo "<div>
    <form method='POST'>";
    echo "<select name='HKNH' class='select_hknh'>";
    if(isset($_POST['search'])){
        if(isset($_POST['HKNH'])) {
            $id = $_POST['HKNH'];
            loadHKNH($conn,$id);
        }   
            
    }
    else if(isset($_SESSION['HKNH'])){
        loadHKNH($conn,$_SESSION['HKNH']);
    }
    else
        loadHKNH($conn);
    echo "</select>";
    echo "<input type='submit' name='search' value='Tìm kiếm' class='button_search'>";
    echo "</form>
    </div>";
    
    //table data
    echo "<div class='table'>";
    echo "<table id='tableClass'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Mã lớp</th>";
    echo "<th>Tên lớp</th>";
    echo "<th>Giảng viên</th>";
    echo "<th>Thao tác</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    if(isset($_POST['search']))
        loadLopHP($conn,$_POST['HKNH']);

    if(isset($_SESSION['HKNH']) && !isset($_POST['search']) && !isset($_POST['addClass'])&&!isset($_POST['editClass'])
    &&!isset($_POST['id-delete'])&&!isset($_POST['multiAddClass']))
        loadLopHP($conn,$_SESSION['HKNH']);
        

    if(isset($_POST['addClass'])){
        if(!empty($_POST['MaLopHP']))
            if(!empty($_POST['TenLop']))
                if(!empty($_POST['MaGV'])){
                    if(isset($_SESSION['HKNH'])&& !empty($_SESSION['HKNH'])){
                        $maLop = $_POST['MaLopHP'];
                        $tenLop = $_POST['TenLop'];
                        $tuanBD = $_POST['TuanBD'];
                        $tuanKT = $_POST['TuanKT'];
                        $maGV = $_POST['MaGV'];
                        if($tuanKT-$tuanBD<=17){
                            addClass($conn,$maLop,$tenLop,$maGV,$_SESSION['HKNH']);
                            loadLopHP($conn,$_SESSION['HKNH']);
                        }else echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi...',
                                text: 'Thời gian học quá lớn!'
                            })
                        </script>
                        ";
                    }else echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Chưa chọn học kỳ!'
                        })
                    </script>
                    ";
                }else echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi...',
                        text: 'Chưa chọn giảng viên!'
                    })
                </script>
                ";
            else echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Chưa nhập tên lớp học phần!'
                })
            </script>
            ";
        else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Chưa nhập mã lớp học phần!'
            })
        </script>
        ";
    }

    if(isset($_POST['editClass'])){
        if(!empty($_POST['MaLop']))
            if(!empty($_POST['TenLop']))
                if(!empty($_POST['MaGV'])){
                    $maLop = $_POST['MaLop'];
                    $tenLop = $_POST['TenLop'];
                    $maGV = $_POST['MaGV'];
                    editClass($conn,$maLop,$tenLop,$maGV);
                    loadLopHP($conn,$_SESSION['HKNH']);
                }else echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi...',
                        text: 'Chưa chọn giảng viên!'
                    })
                </script>
                ";
            else echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Chưa nhập tên lớp học phần!'
                })
            </script>
            ";
        else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Chưa nhập mã lớp học phần!'
            })
        </script>
        ";
    }

    if(isset($_POST['id-delete']) && !empty($_POST['id-delete'])){
        $maLop = $_POST['id-delete'];
        deleteClass($conn,$maLop);
        loadLopHP($conn,$_SESSION['HKNH']);
    }

    if(isset($_POST['multiAddClass'])){
        if(isset($_SESSION['HKNH'])&& !empty($_SESSION['HKNH'])){
            $file = $_FILES['file']['tmp_name'];
            if(!empty($file)){
                multiAddClass($conn,$file,$_SESSION['HKNH']);
                loadLopHP($conn,$_SESSION['HKNH']);
            }
            else echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Chưa chọn file!'
                })
            </script>
            ";
        }else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Chưa chọn học kỳ!'
            })
        </script>
        ";        
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    echo "<form method='POST' enctype='multipart/form-data'>";
    echo "<input type='file' name='file'>";
    echo "<button type='submit' name='multiAddClass' class='btn_submit_file'>";
    echo "<i class='fas fa-upload'></i>Thêm từ tệp";
    echo "</button>";
    echo "</form>";
    
?>
