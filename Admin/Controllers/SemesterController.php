<?php
    include("../../Models/SemesterModel.php");
    include("../../../public/config.php");
    require("../../../public/PHPExcel/Classes/PHPExcel.php");
    global $conn;
    if (session_id() === '')
        session_start();

    
    //table data
    echo "<div class='table'>";
    echo "<table id='tableSemster'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Học kỳ năm học</th>";
    echo "<th>Thời gian bắt đầu</th>";
    echo "<th>Thời gian kết thúc</th>";
    echo "<th>Trạng thái</th>";
    echo "<th>Thao tác</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    if(!isset($_POST['addSemester']) && !isset($_POST['id_status'])
    && !isset($_POST['editSemster']))
        loadHKNH($conn);
    if(isset($_POST['addSemester'])){
        if(isset($_POST['hoc_ky']) && !empty($_POST['hoc_ky']))
            if(isset($_POST['NamBD']) && !empty($_POST['NamBD']))
                if(isset($_POST['NamKT']) && !empty($_POST['NamKT']))
                    if(isset($_POST['NgayBD']) && !empty($_POST['NgayBD']))
                        if(isset($_POST['NgayKT']) && !empty($_POST['NgayKT'])){
                            $start = $_POST['NgayBD'];
                            $end = $_POST['NgayKT'];
                            if($start<$end){
                                $name = $_POST['hoc_ky']." , ".$_POST['NamBD']." - ".$_POST['NamKT'];
                                AddSemester($conn,$name,$start,$end);
                                
                            }else echo "
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Lỗi...',
                                        text: 'Thời gian bắt đầu phải nhỏ hơn thời kết thúc!'
                                    })
                                </script>
                                ";
                        }else echo "
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi...',
                                    text: 'Chưa nhập thời gian kết thúc!'
                                })
                            </script>
                            ";
                    else echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Chưa nhập thời gian bắt đầu!'
                        })
                    </script>
                    ";
                
        loadHKNH($conn);
    }

    if(isset($_POST['id_status']) && !empty($_POST['id_status'])){
        $id = $_POST['id_status'];
        ChangeStatus($conn,$id);
        loadHKNH($conn);
    }
    
    if(isset($_POST['editSemster'])){
        if(isset($_POST['id_hknh']) && !empty($_POST['id_hknh']))
            if(isset($_POST['hoc_ky']) && !empty($_POST['hoc_ky']))
                if(isset($_POST['NamBD']) && !empty($_POST['NamBD']))
                    if(isset($_POST['NamKT']) && !empty($_POST['NamKT']))
                        if(isset($_POST['NgayBD']) && !empty($_POST['NgayBD']))
                            if(isset($_POST['NgayKT']) && !empty($_POST['NgayKT'])){
                                $start = $_POST['NgayBD'];
                                $end = $_POST['NgayKT'];
                                if($start<$end){
                                    $bd = explode("-",$start);
                                    $kt = explode("-",$end);
                                    if($bd[2]>=$_POST['NamBD']&&$bd[2]<=$_POST['NamBD']
                                    &&$kt[2]>=$_POST['NamBD']&&$kt[2]<=$_POST['NamBD']){
                                        $id = $_POST['id_hknh'];
                                        $name = $_POST['hoc_ky']." , ".$_POST['NamBD']." - ".$_POST['NamKT'];
                                        UpdateSemester($conn,$id,$name,$start,$end);
                                    }else echo "
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Lỗi...',
                                            text: 'Thời gian không nằm trong niên khoá!'
                                        })
                                    </script>
                                    ";
                                    
                                }else echo "
                                    <script>
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Lỗi...',
                                            text: 'Thời gian bắt đầu phải nhỏ hơn thời kết thúc!'
                                        })
                                    </script>
                                    ";
                            }else echo "
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Lỗi...',
                                        text: 'Chưa nhập thời gian kết thúc!'
                                    })
                                </script>
                                ";
                        else echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi...',
                                text: 'Chưa nhập thời gian bắt đầu!'
                            })
                        </script>
                        ";
                    
        loadHKNH($conn);
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    
?>
