<?php
    include("../../Models/ProcessModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();
    echo "<div>
    <for method='POST'>";
    echo "<select name='HKNH' class='select_process dsHKNH'>";
    echo "<option value='-1'>Chọn lớp học kỳ năm học</option>";
    loadHKNH($conn);        
    echo "</select>";
    echo "<select name='lopHP' class=' select_process dsLop'>";
    echo "<option value='-1'>Chọn lớp HP</option>";
    echo "</select>";
    echo "<button name='search' type='button' class='button_search'>Tìm kiếm</button>";
    echo "<button class='btn_download_class' name='downloadClass'>";
    echo "<i class='fas fa-download'></i> Tải về";
    echo "</button>";
    echo "</form>
    </div>";

    echo "<div class='table'>";
    


    if(isset($_SESSION['LHP'])&&!isset($_POST['search'])
    &&!isset($_POST['addProcess'])&&!isset($_POST['id-delete'])&&!isset($_POST['editProcess']))
        loadProcess($conn,$_SESSION['LHP']);

    if(isset($_POST['addProcess']))
        if(isset($_POST['TieuDe']))
            if(isset($_POST['ThoiGianBD']))
                if(isset($_POST['ThoiGianKT'])){
                    $title = $_POST['TieuDe'];
                    if(!empty($title)){
                        $note = $_POST['GhiChu'];
                        $timeStart = $_POST['ThoiGianBD'];
                        if(!empty($timeStart)){
                            $timeEnd = $_POST['ThoiGianKT'];
                            if(!empty($timeEnd)){
                                $class = $_POST['LopHP'];
                                if($timeStart<$timeEnd){
                                    if(isset($_POST['SanPham']))
                                        addProcess($conn,$title,$note,$timeStart,$timeEnd,$class,1);
                                    else
                                        addProcess($conn,$title,$note,$timeStart,$timeEnd,$class,0);
                                }else echo "
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Lỗi...',
                                        text: 'Thời gian bắt đầu phải nhỏ hơn thòi gian kết thúc!'
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
                        }else echo "
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi...',
                                text: 'Chưa nhập thời gian bắt đầu!'
                            })
                        </script>
                        ";                        
                    }else echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Chưa nhập tiêu đề!'
                        })
                    </script>
                    ";
                }           
    

    if(isset($_POST['id-delete'])){
        $id = $_POST['id-delete'];
        deleProcess($conn,$id);
    }

    if(isset($_POST['editProcess'])){
        if(!empty($_POST['TieuDe'])){
            if(!empty($_POST['ThoiGianBD'])){
                if(!empty($_POST['ThoiGianKT'])){
                    if(!empty($_POST['Id'])){
                        $id=$_POST['Id'];
                        $title=$_POST['TieuDe'];
                        $note=$_POST['GhiChu'];
                        $timeStart=$_POST['ThoiGianBD'];
                        $timeEnd=$_POST['ThoiGianKT'];
                        editProcess($conn,$id,$title,$note,$timeStart,$timeEnd);
                    }else echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'không tìm thấy tiến độ!'
                        })
                    </script>
                    ";                    
                }else echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi...',
                        text: 'Thời gian kết thúc không thể trống!'
                    })
                </script>
                ";
            }else echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Thời gian bắt đầu không thể trống!'
                })
            </script>
            ";
        }else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Tiêu đề không thể trống!'
            })
        </script>
        ";
    }

    
    echo "</div>";

    
    if(isset($_GET['process'])){
        $id=$_GET['process'];
        loadDetailProcess($conn,$id);
    }
    
    if(isset($_POST['download'])){
        $source = $_POST['source'];
        $destination = $_POST['destination'];
        Zip($source,$destination,true);       
    }
    if(isset($_POST['downloadProc'])){
        $source = $_POST['source'];
        $destination = $_POST['destination'];
        Zip($source,$destination,true);       
    }
    if(isset($_POST['downloadClass'])){
        $MaHP = $_POST['lopHP'];
        $source = "../../../public/item/".$MaHP."/";
        $destination = $MaHP.".zip";
        Zip($source,$destination,true);       
    }
?>