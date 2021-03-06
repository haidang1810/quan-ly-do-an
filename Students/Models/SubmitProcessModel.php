<?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();
    function loadData($conn){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $checkSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='".$data."'";
        $resultSV = $conn->query($checkSV);
        $rowSV = $resultSV->fetch_assoc();
        if(isset($_SESSION['id-process'])){
            $id_process = $_SESSION['id-process'];
            $findPro = "SELECT * FROM nopbai WHERE Id=$id_process";
            $resultPro = $conn->query($findPro);
            if($resultPro->num_rows > 0){
                $rowPro = $resultPro->fetch_assoc();
                $findFile = "SELECT Id, File, ThoiGianNop FROM nopbaichitiet 
                WHERE Mssv='".$rowSV['Mssv']."' AND Ma='$id_process'";
                $resultDetail = $conn->query($findFile);
                $timeStart = date("d-m-Y, H:i:s", strtotime($rowPro['ThoiGianBatDau']));
                $timeEnd = date("d-m-Y, H:i:s", strtotime($rowPro['ThoiGianKetThuc']));
                echo "<input type='hidden' value='".$rowPro['ThoiGianKetThuc']."' id='timeEnd'>";
                echo "<h1>".$rowPro['TieuDe']."</h1>";
                echo "<table id='tableTopic'>";
                echo "<tbody>";
                echo "<tr>";
                echo "<td style='width:260px'>Thời gian bắt đầu</td>";
                echo "<td>$timeStart</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td style='width:260px'>Thời gian kết thúc</td>";
                echo "<td>$timeEnd</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td style='width:260px'>Thời gian còn lại</td>";
                echo "<td id='timeRemaining'></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td style='width:260px'>File đã gửi</td>";
                echo "<td>";
                if($resultDetail->num_rows>0){
                    echo "<div class='table-info'>";
                    echo "<table>";
                    while($rowDetail = $resultDetail->fetch_assoc()){
                        $fileName = explode("/",$rowDetail['File']);
                        echo "<tr>";
                        echo "<td>";
                        echo "<a href='../../../public/item/".$rowDetail['File']."'>$fileName[3]</a>";
                        echo "</td>";
                        $timeSubmit = date("d-m-Y, H:i:s", strtotime($rowDetail['ThoiGianNop']));
                        echo "<td>".$timeSubmit."</td>";
                        echo "<td>";
                        echo "<form method='POST' class='form-delete-file'>";
                        echo "<input type='hidden' name='Id_delete' value='".$rowDetail['Id']."'>";
                        echo "<button type='submit' class='btn-delete-file'><i class='fas fa-trash-alt'></button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
                echo "</td>";
                echo "</tr>";
                echo "</tbody>";
                echo "</table>";

                echo "<div class='container'>";
                //echo"<div class='boxed-upload'>";
                $target_dir = "../../../public/item/".$_SESSION['DetailClass']."/".$rowPro['TieuDe']."/".$rowSV['Mssv']."/";
                echo"<form class='dropzone' action='upload.php' id='myDropzone'>";
                echo"<input type='hidden' value='".$_SESSION['DetailClass']."' name = 'mahp'>";
                echo"<input type='hidden' value='".$rowPro['TieuDe']."' name = 'tdn'>";
                echo"<input type='hidden' value='".$rowSV['Mssv']."' name = 'msv'>";
                echo"<input type='hidden' value='$id_process' name = 'mtd'>";
                echo"<input type='hidden' value='$target_dir' name = 'target_dir'>";
                echo"<input type='hidden' value='hocphan' name = 'loaiLop'>";
                echo"<div class='dz-message' data-dz-message>";
                echo"<span>Chọn hoặc kéo thả files tại đây</span></div>";
                echo"</form>";
                //echo"</div> ";
                echo"<button type='button' id='uploadfiles' >Nộp bài</button>";
                echo "</div>";
            }
        }else if(isset($_SESSION['id-process-thesis'])){
            $id_process = $_SESSION['id-process-thesis'];
            $findPro = "SELECT * FROM nopbailuanvan WHERE Id=$id_process";
            $resultPro = $conn->query($findPro);
            if($resultPro->num_rows > 0){
                $rowPro = $resultPro->fetch_assoc();
                $findFile = "SELECT Id, File, ThoiGianNop FROM nopluanvanct 
                WHERE Mssv='".$rowSV['Mssv']."' AND Ma='$id_process'";
                $resultDetail = $conn->query($findFile);
                $timeStart = date("d-m-Y, H:i:s", strtotime($rowPro['ThoiGianBD']));
                $timeEnd = date("d-m-Y, H:i:s", strtotime($rowPro['ThoiGianKT']));
                echo "<input type='hidden' value='".$rowPro['ThoiGianKT']."' id='timeEnd'>";
                echo "<h1>".$rowPro['TieuDe']."</h1>";
                echo "<table id='tableTopic'>";
                echo "<tbody>";
                echo "<tr>";
                echo "<td style='width:260px'>Thời gian bắt đầu</td>";
                echo "<td>$timeStart</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td style='width:260px'>Thời gian kết thúc</td>";
                echo "<td>$timeEnd</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td style='width:260px'>Thời gian còn lại</td>";
                echo "<td id='timeRemaining'></td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td style='width:260px'>File đã gửi</td>";
                echo "<td>";
                if($resultDetail->num_rows>0){
                    echo "<div class='table-info'>";
                    echo "<table>";
                    while($rowDetail = $resultDetail->fetch_assoc()){
                        $fileName = explode("/",$rowDetail['File']);
                        echo "<tr>";
                        echo "<td>";
                        echo "<a href='../../../public/item/".$rowDetail['File']."'>$fileName[3]</a>";
                        echo "</td>";
                        $timeSubmit = date("d-m-Y, H:i:s", strtotime($rowDetail['ThoiGianNop']));
                        echo "<td>".$timeSubmit."</td>";
                        echo "<td>";
                        echo "<form method='POST' class='form-delete-file'>";
                        echo "<input type='hidden' name='Id_delete' value='".$rowDetail['Id']."'>";
                        echo "<button type='submit' class='btn-delete-file'><i class='fas fa-trash-alt'></button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                }
                echo "</td>";
                echo "</tr>";
                echo "</tbody>";
                echo "</table>";

                echo "<div class='container'>";
                //echo"<div class='boxed-upload'>";
                $target_dir = "../../../public/item/".$_SESSION['DetailThesis']."/".$rowPro['TieuDe']."/".$rowSV['Mssv']."/";
                echo"<form class='dropzone' action='upload.php' id='myDropzone'>";
                echo"<input type='hidden' value='".$_SESSION['DetailThesis']."' name = 'mahp'>";
                echo"<input type='hidden' value='".$rowPro['TieuDe']."' name = 'tdn'>";
                echo"<input type='hidden' value='".$rowSV['Mssv']."' name = 'msv'>";
                echo"<input type='hidden' value='$id_process' name = 'mtd'>";
                echo"<input type='hidden' value='$target_dir' name = 'target_dir'>";
                echo"<input type='hidden' value='luanvan' name = 'loaiLop'>";
                echo"<div class='dz-message' data-dz-message>";
                echo"<span>Chọn hoặc kéo thả files tại đây</span></div>";
                echo"</form>";
                //echo"</div> ";
                echo"<button type='button' id='uploadfiles' >Nộp bài</button>";
                echo "</div>";
            }
        }
    }

    function deleteFile($conn,$id){
        if(isset($_SESSION['id-process'])){
            $findFile = "SELECT * FROM nopbaichitiet WHERE Id=$id";
            $resultFile = $conn->query($findFile);
            if($resultFile->num_rows>0){
                $rowFile = $resultFile->fetch_assoc();
                $fileName = explode("/",$rowFile['File']);
                $sql = "DELETE FROM nopbaichitiet WHERE Id=$id";
                if(mysqli_query($conn,$sql)){
                    $path = "../../../public/item/".$rowFile['File'];
                    unlink($path);
                    echo "<script>
                            Swal.fire({
                                'Đã xoá!',
                                'Bạn đã xoá file ".$fileName[3]." thành công.',
                                'success'
                            })
                        </script>";
                }else echo "<script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi...',
                                    text: 'Lỗi sql!'
                                })
                            </script>";
            }else echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi...',
                                text: 'Không tìm thấy file!'
                            })
                        </script>";
        }else if(isset($_SESSION['id-process-thesis'])){
            $findFile = "SELECT * FROM nopluanvanct WHERE Id=$id";
            $resultFile = $conn->query($findFile);
            if($resultFile->num_rows>0){
                $rowFile = $resultFile->fetch_assoc();
                $fileName = explode("/",$rowFile['File']);
                $sql = "DELETE FROM nopluanvanct WHERE Id=$id";
                if(mysqli_query($conn,$sql)){
                    $path = "../../../public/item/".$rowFile['File'];
                    unlink($path);
                    echo "<script>
                            Swal.fire({
                                'Đã xoá!',
                                'Bạn đã xoá file ".$fileName[3]." thành công.',
                                'success'
                            })
                        </script>";
                }else echo "<script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi...',
                                    text: 'Lỗi sql!'
                                })
                            </script>";
            }else echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi...',
                                text: 'Không tìm thấy file!'
                            })
                        </script>";
        }
        
        
    }
?>