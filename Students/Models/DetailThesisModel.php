<?php
    if (session_id() === '')
        session_start();
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    function loadData($conn,$maLop){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $checkSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='".$data."'";
        $resultSV = $conn->query($checkSV);
        if ($resultSV->num_rows > 0){
            $rowSV = $resultSV->fetch_assoc();
            $sql = "SELECT * FROM sinhvien_luanvan, lopluanvan
            WHERE sinhvien_luanvan.Mssv='".$rowSV['Mssv']
            ."' and sinhvien_luanvan.MaLopLV='".$maLop."'
            and sinhvien_luanvan.MaLopLV=lopluanvan.MaLopLV";
            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $topic = "";
                $process = "";
                $calen = "";
                $poin = "";
                $final = "";
                //tìm đề tài của sv
                $selectTopic = "SELECT Ten FROM detailuanvan WHERE MaLopLV='".$row['MaLopLV']."'
                AND Mssv='".$rowSV['Mssv']."'";
                $resultTopic = $conn->query($selectTopic);
                if ($resultTopic->num_rows > 0){
                    $rowTopic = $resultTopic->fetch_assoc();
                    $topic = $rowTopic['Ten'];
                }
                //Tìm tiến độ hiện tại
                $findTD = "SELECT * FROM nopbailuanvan WHERE MaLopLV='".$row['MaLopLV']."' and Loai=0";
                $resultTD = $conn->query($findTD);
                if ($resultTD->num_rows > 0){
                    $process .= "<ul class='list-process'>";
                    while($rowTD = $resultTD->fetch_assoc()){
                        $process .= "<li><a href='#' id='".$rowTD['Id']."' class='list-process link-title-process'>
                        ".$rowTD['TieuDe']."</a></li><ul class='list-process'><li>".$rowTD['GhiChu']."</li></ul>";
                    }
                    $process .= "</ul>";
                }
                //Tìm lịch báo cáo
                $findHD = "SELECT MaHD
                FROM hoidong, sinhvien_luanvan, lopluanvan
                WHERE sinhvien_luanvan.MaLopLV=lopluanvan.MaLopLV
                AND hoidong.ThuKy=lopluanvan.MaGV
                AND sinhvien_luanvan.MaLopLV='$maLop'
                GROUP BY MaHD";
                $resultHD = $conn->query($findHD);
                if ($resultHD->num_rows > 0){
                    while($rowHD=$resultHD->fetch_assoc()){
                        $findCalen = "SELECT * FROM lichbaove WHERE
                        MaHD='".$rowHD['MaHD']."' AND Mssv='".$rowSV['Mssv']."'";
                        $resultCalen = $conn->query($findCalen);
                        if($resultCalen->num_rows > 0){
                            $rowCalen=$resultCalen->fetch_assoc();
                            if($rowCalen['BVLan2']!=null){
                                $calen = "Lần 1: ".$rowCalen['BVLan1'].", lần 2:".$rowCalen['BVLan2'];
                            }else
                                $calen = "Lần 1: ".$rowCalen['BVLan1'];
                        }else
                            $calen = "Chưa có lịch bảo vệ ";
                    }
                }
                //tìm điểm
                if($row['DiemTB']==null){
                    $poin = "<ul><li>Chưa có kết quả</li></ul>";
                }else{
                    $poin = "<ul>
                    <li>Điểm tịch hội đồng: ".$row['DiemCTHD']."</li>
                    <li>Điểm cán bộ hướng dẫn: ".$row['DiemCBHD']."</li>
                    <li>Điểm giảng viên phản biện: ".$row['DiemPB']."</li>
                    <li>Điểm trung bình: ".$row['DiemTB']."</li>
                    <li>Điểm chữ: ".$row['DiemChu']."</li>
                    </ul>";
                }
                
                //nộp sản phẩm
                $findSP = "SELECT * FROM nopbailuanvan WHERE MaLopLV='".$row['MaLopLV']."'
                and Loai=1";
                $resultSP = $conn->query($findSP);
                if ($resultSP->num_rows > 0){
                    $rowSP = $resultSP->fetch_assoc();
                    $today = strtotime(date("Y-m-d H:i:s"));
                    if($today<strtotime($rowSP['ThoiGianBD']))
                        $final = "Chưa đến thời gian nộp";
                    else if($today>strtotime($rowSP['ThoiGianKT']))
                        $final = "Đã hết thời gian nộp";
                    else
                        $final = "Đang trong thời gian nộp";
                }else
                    $final = "Giảng viên chưa tạo thư mục nộp";
                echo "<h3 class='content-title'>".$row['MaLopLV']." - ".$row['TenLop'];
                echo "<div class='dropdown'>
                        <button onclick='hamDropdown()' class='nut_dropdown'><i class='fa fa-cog icon-hide'></i></button>
                        <div class='noidung_dropdown'>
                            <a id='".$row['MaLopLV']."' class='cancel_class'>Huỷ ghi danh</a>
                        </div>
                    </div>";
                echo "</h3>";
                echo "
                <div class='content-body'>
                    <a href='#' class='title-box link-topic'>1. Đề tài thực hiện</a>
                    <ul><li>Đề tài đã đăng ký: $topic</li></ul>
                    <div class='dec-line'></div>
                    <a href='#' class='title-box link-proces'>2. Tiến độ thực hiện</a>
                    $process
                    <div class='dec-line'></div>";
                    if($final!='Giảng viên chưa tạo thư mục nộp'){
                        echo "<a href='#' id='".$rowSP['Id']."' class='title-box link-final link-title-process'>3. Nộp sản phẩm</a>";
                    }else
                        echo "<a href='#' class='title-box link-final'>3. Nộp sản phẩm</a>";
                    echo "<ul><li>Tình trạng: $final</li></ul>
                    <div class='dec-line'></div>
                    <a href='#' class='title-box link-calen'>4. Lịch báo cáo</a>
                    <ul><li>Thời gian bảo vệ: $calen</li></ul>
                    <div class='dec-line'></div>
                    <a href='#' class='title-box link-scores'>5. Kết quả</a>
                    $poin
                </div>
                ";
            }else{
                echo "<h2>Bạn không ghi danh khoá học này</h2>";
            }
        }
    }

    function saveHistory($conn,$maLop){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $checkSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='".$data."'";
        $resultSV = $conn->query($checkSV);
        if ($resultSV->num_rows > 0){
            $rowSV = $resultSV->fetch_assoc();
            
            $today = date("Y-m-d H:i:s");
            //đã từng vào lớp đó chưa nếu có cập nhật time mới
            $check = "SELECT Id FROM lichsu_luanvan WHERE Mssv='".$rowSV['Mssv']."' and MaLopLV='$maLop'";
            $resultCheck = $conn->query($check);
            if($resultCheck->num_rows >0){
                $rowCheck = $resultCheck->fetch_assoc();
                $update = "UPDATE lichsu_luanvan SET ThoiGian='$today'
                WHERE Id=".$rowCheck['Id'];
                if(mysqli_query($conn, $update))
                    return true;
            }else{
                $count = "SELECT * FROM lichsu_luanvan WHERE Mssv='".$rowSV['Mssv']."'";
                $resultCount = $conn->query($count);
                //nếu chưa vào lớp đó và đã đủ slot lịch sử thì đổi lần vào củ nhất ngược lại thì thêm lịch sử mới
                if ($resultCount->num_rows == 4){
                    $findLast = "SELECT Id FROM lichsu_luanvan ORDER by ThoiGian desc LIMIT 1";
                    $resultLast = $conn->query($findLast);
                    $rowLast = $resultLast->fetch_assoc();
                    $update = "UPDATE lichsu_luanvan SET MaLopLV='$maLop', ThoiGian='$today'
                    WHERE Id=".$rowLast['Id'];
                    if(mysqli_query($conn, $update))
                        return true;
                }else{
                    $add = "INSERT INTO lichsu_luanvan(Mssv, MaLopLV, ThoiGian) 
                    VALUES('".$rowSV['Mssv']."','$maLop','$today')";
                    if(mysqli_query($conn, $add))
                        return true;
                }
            }
        }
    }
    if(isset($_POST['id-cancel'])){
        include("../../public/config.php");
        global $conn;
        $maLop=$_POST['id-cancel'];
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $checkSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='".$data."'";
        $resultSV = $conn->query($checkSV);
        $rowSV = $resultSV->fetch_assoc();
        $mssv = $rowSV['Mssv'];
        //check dang ky de tai
        $checkToic="SELECT * FROM detailuanvan
        WHERE MaLopLV='$maLop'
        and Mssv='$mssv'";
        $resultTopic = $conn->query($checkToic);
        // check nop tien do
        $checkPro = "SELECT * FROM nopbailuanvan,nopluanvanct 
        WHERE nopbailuanvan.Id=nopluanvanct.Ma
        And nopluanvanct.Mssv='$mssv'
        AND nopbailuanvan.MaLopLV='$maLop'";
        $resultPro = $conn->query($checkPro);
        //check lich bc
        $checkBC = "SELECT MaHD
                FROM hoidong, sinhvien_luanvan, lopluanvan
                WHERE sinhvien_luanvan.MaLopLV=lopluanvan.MaLopLV
                AND hoidong.ThuKy=lopluanvan.MaGV
                AND sinhvien_luanvan.MaLopLV='$maLop'
                GROUP BY MaHD";
                $resultBC = $conn->query($checkBC);
                if ($resultBC->num_rows > 0){
                    while($rowHD=$resultBC->fetch_assoc()){
                        $findCalen = "SELECT * FROM lichbaove WHERE
                        MaHD='".$rowHD['MaHD']."' AND Mssv='$mssv'";
                        $resultCalen = $conn->query($findCalen);
                        if($resultCalen->num_rows > 0){
                            echo 2;
                            exit;
                        }
                    }
                }
        if($resultTopic->num_rows>0||$resultPro->num_rows>0){
            echo 2;
            exit;
        }
        
        $sql = "DELETE FROM sinhvien_luanvan WHERE MaLopLV='$maLop' AND Mssv='$mssv'";
        if(mysqli_query($conn, $sql)){
            $deleHis = "DELETE FROM lichsu_luanvan WHERE MaLopLV='$maLop' AND Mssv='$mssv'";
            if(mysqli_query($conn, $deleHis))
                echo 1;
        }else{
            echo 3;
        }
    }
    if(isset($_POST['id-title'])){
        unset($_SESSION['id-process']);
        $_SESSION['id-process-thesis'] = $_POST['id-title'];
        echo 1;
    }
?>