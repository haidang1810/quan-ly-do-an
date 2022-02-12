<?php
    include("../../Models/ThesisTopicModel.php");
    include("../../../public/config.php");
    require("../../../public/PHPExcel/Classes/PHPExcel.php");
    global $conn;
    if (session_id() === '')
        session_start();

        
            
    echo "<div>
    <form method='POST'>";       
    echo "<select name='HKNH' class='topic_select dsHKNH'>";
    echo "<option value='-1'>Chọn lớp học kỳ năm học</option>";
    loadHKNH($conn);        
    echo "</select>";
    echo "<select name='lopLV' class=' topic_select dsLop'>";
    echo "<option value='-1'>Chọn lớp luận văn</option>";
    echo "</select>";
    echo "<input type='submit' name='search' value='Tìm kiếm' class='topic_button_search'>";
    echo "</form>
    </div>";
    echo "<div class='table'>";
    echo "<table id='tableTopic'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th style='min-width:100px'>Tên đề tài</th>";
    echo "<th>Ghi chú</th>";
    echo "<th>Sinh viên thực hiện</th>";
    echo "<th>Thao tác</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    if(isset($_POST['search'])){
        if(isset($_POST['lopLV'])&&$_POST['lopLV']!=-1){
            $MaLop = $_POST['lopLV'];
            loadTopic($conn,$MaLop);
        }
        
    }
    if(isset($_SESSION['LLV'])&&!isset($_POST['search'])&&!isset($_POST['addTopic'])
    &&!isset($_POST['multiAdd'])&&!isset($_POST['input-delete'])&&!isset($_POST['editTopic']))
        loadTopic($conn,$_SESSION['LLV']);

    if(isset($_POST['addTopic']))
        if(isset($_POST['TenDeTai'])&&!empty($_POST['TenDeTai']))            
            if(isset($_POST['LopLV']))
                if(isset($_POST['Mssv'])){
                    if(isset($_POST['GhiChu'])){
                        $maLop = $_POST['LopLV'];
                        $ten = $_POST['TenDeTai'];
                        $ghiChu = $_POST['GhiChu'];
                        $mssv = $_POST['Mssv'];
                        addToppic($conn,$maLop,$ten,$ghiChu,$mssv);
                        loadTopic($conn,$maLop);
                    }                        
                }else echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Chưa chọn mã số sinh viên!'
                        })
                    </script>
                    ";
            else echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi...',
                        text: 'Chưa chọn lớp luận văn!'
                    })
                </script>
                ";
        else echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Chưa nhập tên đề tài!'
                })
            </script>
            ";

    if(isset($_POST['multiAdd'])){
        if(isset($_POST['LopLV'])){
            $lopLV = $_POST['LopLV'];
            $file = $_FILES['file']['tmp_name'];
            if(!empty($file)){
                multiAdd($conn,$file,$lopLV);
                loadTopic($conn,$lopLV);
            }else echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Chưa chọn file!'
                })
            </script>
            ";
        }        
    }

    if(isset($_POST['input-delete'])){
        $Ma = $_POST['input-delete'];
        deleTopic($Ma,$conn);
        if(isset($_SESSION['LLV']))
            loadTopic($conn,$_SESSION['LLV']);
    }

    if(isset($_POST['editTopic'])){
        if(isset($_POST['MaDT']))
            if(isset($_POST['TenDeTai']) && !empty($_POST['TenDeTai']))
                if(isset($_POST['Mssv'])){
                    if(isset($_POST['GhiChu'])){
                        $maDT = $_POST['MaDT'];
                        $ten = $_POST['TenDeTai'];
                        $ghiChu = $_POST['GhiChu'];
                        $mssv = $_POST['Mssv'];
                        editTopic($maDT,$ten, $ghiChu, $mssv,$conn);
                        loadTopic($conn,$_SESSION['LLV']);
                    }
                }else echo "
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi...',
                        text: 'Chưa chọn mã số sinh viên!'
                    })
                </script>
                ";
            else echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Chưa nhập tên đề tài!'
                })
            </script>
            ";
        else echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Đề tài không tồn tại!'
            })
        </script>
        ";
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";
?>