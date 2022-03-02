<?php
    include("../../Models/StudentListModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();

    if(isset($_SESSION['ShowStudent'])){
        $MaLop = $_SESSION['ShowStudent'];
        $findClass = "SELECT TenLop FROM lophocphan WHERE MaLopHP='".$MaLop."'";
        $resultClass = $conn->query($findClass);
        $rowClass = $resultClass->fetch_assoc();
        echo "<h3 class='title-class'>".$MaLop." - ".$rowClass['TenLop']."</h3>";
        echo "<div class='table'>";
        echo "<h2>Danh sách sinh viên</h2>";
        echo "<form method='POST' action='../ExportView/ExportView.php'>";
        echo "<input type='hidden' name='MaLop' value='".$MaLop."'>";
        echo "<button class='btn_export' type='submit' name='export'>
        <i class='fas fa-file-download'></i>&nbsp;In phiếu điểm</button>";     
        echo "</form>";       
        echo "<table id='table_student'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Mã sinh viên</th>";
        echo "<th>Họ và tên</th>";
        echo "<th>Điểm số</th>";
        echo "<th>Điểm chữ</th>";
        echo "<th>Cập nhật điểm</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        if(isset($_POST['editScore'])&&!empty($_POST['MaLop'])&&!empty($_POST['Mssv'])){
            if(!empty($_POST['DiemSo']))
                if(!empty($_POST['DiemChu'])){
                    $student=$_POST['Mssv'];
                    $class=$_POST['MaLop'];
                    $score=$_POST['DiemSo'];
                    $point=$_POST['DiemChu'];
                    editScore($conn,$student,$class,$score,$point);
                    
                }else echo"
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Chưa nhập điểm chữ!'
                        })
                    </script>
                    ";
            else echo"
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Chưa nhập điểm số!'
                        })
                    </script>
                ";
            showStudentList($conn,$MaLop);
        }else showStudentList($conn,$MaLop);
        echo "</tbody>";
        echo "</table>";
        echo "</div>";

        echo "<div class='table'>";
        echo "<h2>Danh sách đăng ký đề tài</h2>";
        echo "<table id='tableTopic'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Tên đề tài</th>";
        echo "<th>Số thành viên</th>";
        echo "<th>sinh viên đăng ký</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";  
        registerTopic($conn,$MaLop);
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }else if(isset($_SESSION['ShowStudentThesis'])){
        $MaLop = $_SESSION['ShowStudentThesis'];
        $findClass = "SELECT TenLop FROM lopluanvan WHERE MaLopLV='".$MaLop."'";
        $resultClass = $conn->query($findClass);
        $rowClass = $resultClass->fetch_assoc();
        echo "<h3 class='title-class'>".$MaLop." - ".$rowClass['TenLop']."</h3>";
        echo "<div class='table'>";
        echo "<h2>Danh sách sinh viên</h2>";
        echo "<form method='POST' action='../ExportView/ExportView.php'>";
        echo "<input type='hidden' name='MaLop' value='".$MaLop."'>";
        echo "<button class='btn_export' type='submit' name='export'>
        <i class='fas fa-file-download'></i>&nbsp;In phiếu điểm</button>";     
        echo "</form>";       
        echo "<table id='table_student'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Mã sinh viên</th>";
        echo "<th>Họ và tên</th>";
        echo "<th>Điểm chủ tịch hội đồng</th>";
        echo "<th>Điểm cán bộ hướng dẫn</th>";
        echo "<th>Điểm giảng viên PB</th>";
        echo "<th>Điểm trung bình</th>";
        echo "<th>Điểm chữ</th>";
        echo "<th>Cập nhật điểm</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        if(isset($_POST['editScoreLV'])&&!empty($_POST['MaLopLV'])&&!empty($_POST['MssvLV'])){
            if(!empty($_POST['DiemCTHD']))
                if(!empty($_POST['DiemCBHD']))
                    if(!empty($_POST['DiemGVPB']))
                        if(isset($_POST['DiemChuLV'])){
                            $diemCTHD=$_POST['DiemCTHD'];
                            $diemCBHD=$_POST['DiemCBHD'];
                            $diemPB=$_POST['DiemGVPB'];
                            $diemTB=($diemCTHD+$diemCBHD+$diemPB)/3;
                            $diemChu = $_POST['DiemChuLV'];
                            $mssv=$_POST['MssvLV'];
                            $maLop=$_POST['MaLopLV'];
                            editScoreLV($conn,$diemCTHD,$diemCBHD,$diemPB,$diemTB,$diemChu,$mssv,$maLop);
                        }else echo"
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi...',
                                    text: 'Chưa nhập điểm chữ!'
                                })
                            </script>
                        ";
                    else echo"
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi...',
                                    text: 'Chưa nhập điểm GVPB!'
                                })
                            </script>
                    ";
                else echo"
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi...',
                                text: 'Chưa nhập điểm CBHD!'
                            })
                        </script>
                ";
            else echo"
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Chưa nhập điểm CTHD!'
                        })
                    </script>
            ";
            showStudentListThesis($conn,$MaLop);
        }else showStudentListThesis($conn,$MaLop);
        echo "</tbody>";
        echo "</table>";
        echo "</div>";  
        
        echo "<div class='table'>";
        echo "<h2>Danh sách đăng ký đề tài</h2>";
        echo "<table id='tableTopic'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Tên đề tài</th>";
        echo "<th>Ghi chú</th>";
        echo "<th>sinh viên đăng ký</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";  
        registerTopic($conn,$MaLop);
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }else header("location: ../DashboardView/DashboardView.php");
    
    
?>