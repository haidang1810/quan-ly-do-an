<?php
    if (session_id() === '')
        session_start();
    function loadHKNH($conn) {
        $sql = "SELECT * FROM hocky_namhoc";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<option value='".$row['Id']."'>".$row['HocKy_NamHoc']."</option>";
            }
        }
    }
    if(isset($_POST['search'])){
        include("../../public/config.php");
        global $conn;
        $MaLop = $_POST['search'];
        $findMa = "SELECT * FROM detaidexuat WHERE MaLopHP='".$MaLop."' AND TrangThai=0 GROUP BY Ma";
        $resultMa = $conn->query($findMa);
        if ($resultMa->num_rows > 0){
            echo "<table id='tableTopic'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th style='min-width:100px'>Tên đề tài</th>";
            echo "<th>Ghi chú</th>";
            echo "<th>Sinh viên đề xuất</th>";
            echo "<th>Số thành viên</th>";
            echo "<th>Duyệt</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            while($rowMa = $resultMa->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$rowMa['Ten']."</td>";
                echo "<td>".$rowMa['GhiChu']."</td>";
                echo "<td>".$rowMa['Mssv']."</td>";
                echo "<td>".$rowMa['SoTV']."</td>";
                
                echo "<td>";
                echo "<form method='POST' class='form-suggest'>";
                echo "<input type='hidden' value='".$rowMa['Ma']."' class='MaDX-suggest'>";
                echo "<input type='hidden' value='".$rowMa['Ten']."' class='TenDT'>";
                echo "<input type='hidden' value='".$rowMa['GhiChu']."' class='GhiChu'>";
                echo "<input type='hidden' value='".$MaLop."' class='MaLop'>";
                echo "<button class='btn_topic btn_suggest' type='button'><i class='far fa-check-square'></i></button>";
                echo "</form>";
                echo "<form method='POST' class='form-refuse'>";
                echo "<button class='btn_topic btn_refuse' id='".$rowMa['Ma']."' type='button'><i class='fas fa-times'></i></button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
    }
    if(isset($_POST['suggest'])){
        include("../../public/config.php");
        global $conn;
        $Ma = $_POST['maDT'];
        $Ten = $_POST['tenDT'];
        $GhiChu = $_POST['ghiChu'];
        $MaLop = $_POST['maLop'];
        $date = new DateTime();
        $date->setTimeZone(new DateTimeZone("Asia/Ho_Chi_Minh"));
        $get_datetime = $date->format('Y.m.d H:i:s');    

        $findSug = "SELECT * FROM detaidexuat WHERE Ma='".$Ma."'";
        $resultSug = $conn->query($findSug);
        if($resultSug->num_rows > 0){
            while($rowSug = $resultSug->fetch_assoc()){
                $STV = $rowSug['SoTV'];
                $AddTopic = "INSERT INTO detai(TenDeTai,GhiChu,SoThanhVien,MaLopHP)
                VALUES('".$Ten."','".$GhiChu."',".$STV.",'".$MaLop."')";
                if(mysqli_query($conn, $AddTopic)){
                    $findTopic = "SELECT MaDeTai FROM detai WHERE TenDeTai='".$Ten."' 
                    AND GhiChu='".$GhiChu."' AND SoThanhVien='".$STV."' AND MaLopHP='".$MaLop."'";
                    $resultTopic = $conn->query($findTopic);
                    if($resultTopic->num_rows > 0){
                        $rowTopic = $resultTopic->fetch_assoc();
                        $status = "UPDATE detaidexuat SET TrangThai=1 WHERE Ma='".$Ma."' AND Mssv='".$rowSug['Mssv']."'";
                        if(mysqli_query($conn, $status)){
                            $register = "INSERT INTO dangkydetai Value('".$rowTopic['MaDeTai']."','".$rowSug['Mssv']."','".$get_datetime."')";
                            if(mysqli_query($conn, $register))
                                echo 1;
                        }else echo mysqli_error($conn);
                    }
                }else echo mysqli_error($conn);
            }
        }
    }

    if(isset($_POST['refuse'])){
        include("../../public/config.php");
        global $conn;
        $ma = $_POST['id_refuse'];
        $findSug = "SELECT * FROM detaidexuat WHERE Ma=".$ma;
        $resultSug = $conn->query($findSug);
        if($resultSug->num_rows > 0){
            $status = "UPDATE detaidexuat SET TrangThai=2 WHERE Ma='".$ma."'";
            if(mysqli_query($conn, $status))
                echo 1;
            else
                mysqli_error($conn);
        }
    }
    if(isset($_POST['id'])){
        include("../../public/config.php");
        global $conn;
        $hknh = $_POST['id'];
        if (session_id() === '')
        session_start();
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findND = "SELECT MaGV FROM giangvien WHERE TaiKhoan='".$data."'";
        $resultND = $conn->query($findND);
        if ($resultND->num_rows > 0) {
            $rowND = $resultND->fetch_assoc();
            $findLop = "SELECT * FROM lophocphan WHERE MaGV='".$rowND['MaGV']."' AND Id_hknh='".$hknh."'";
            $resultLop = $conn->query($findLop);
            if($resultLop->num_rows > 0){
                while($rowLop = $resultLop->fetch_assoc()){
                    echo "<option value='".$rowLop['MaLopHP']."'>".$rowLop['MaLopHP']." ".$rowLop['TenLop']."</option>";
                }
            }
        }
    }
?>