<?php
    function loadData($conn,$maLop){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $checkSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='".$data."'";
        $resultSV = $conn->query($checkSV);
        if ($resultSV->num_rows > 0){
            $rowSV = $resultSV->fetch_assoc();
            $sql = "SELECT * FROM sinhvien_hocphan, lophocphan
            WHERE sinhvien_hocphan.Mssv='".$rowSV['Mssv']
            ."' and sinhvien_hocphan.MaLopHP='".$maLop."'
            and sinhvien_hocphan.MaLopHP=lophocphan.MaLopHP";
            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $topic = "";
                $process = "";
                $calen = "";
                $poin = "";
                $final = "";
                //tìm đề tài của sv
                $selectTopic = "SELECT MaDeTai FROM detai WHERE MaLopHP='".$row['MaLopHP']."'";
                $resultTopic = $conn->query($selectTopic);
                if ($resultTopic->num_rows > 0){
                    while($rowTopic = $resultTopic->fetch_assoc()){
                        $checkDK = "SELECT detai.TenDeTai FROM dangkydetai, detai
                        WHERE dangkydetai.MaDeTai='".$rowTopic['MaDeTai']."'
                        AND dangkydetai.Mssv='".$row['Mssv']."'";
                        $resultDK = $conn->query($checkDK);
                        if ($resultDK->num_rows > 0){
                            $rowDK = $resultDK->fetch_assoc();
                            $topic = $rowDK['TenDeTai'];
                        }
                    }
                }
                //Tìm tiến độ hiện tại
                $findTD = "SELECT * FROM nopbai WHERE MaLopHP='".$row['MaLopHP']."'";
                $resultTD = $conn->query($findTD);
                if ($resultTD->num_rows > 0){
                    $process .= "<ul class='list-process'>";
                    while($rowTD = $resultTD->fetch_assoc()){
                        $process .= "<li><a href='#' class='link-process'>
                        ".$rowTD['TieuDe']."</a></li><ul class='list-process'><li>".$rowTD['GhiChu']."</li></ul>";
                    }
                    $process .= "</ul>";
                }
                //Tìm lịch báo cáo
                if($row['LichBaoCao']!=null){
                    $findBC = "SELECT NgayBC, ThoiGianBatDau FROM ngaybaocao
                    WHERE Id=".$row['LichBaoCao'];
                    $resultBC = $conn->query($findBC);
                    if ($resultBC->num_rows > 0){
                        $rowBC = $resultBC->fetch_assoc();
                        $date = date("d/m/Y", strtotime($rowBC['NgayBC']));
                        $calen = "".$date.", ".$rowBC['ThoiGianBatDau'];
                    }
                }else $calen = "Chưa có lịch báo cáo";
                
                //tìm điểm
                if($row['DiemSo']==null){
                    $poin = "<ul><li>Chưa có kết quả</li></ul>";
                }else{
                    $poin = "<ul>
                    <li>Điểm số: ".$row['DiemSo']."</li>
                    <li>Điểm chữ: ".$row['DiemChu']."</li>
                    </ul>";
                }
                
                //nộp sản phẩm
                $findSP = "SELECT * FROM nopbai WHERE MaLopHP='".$row['MaLopHP']."'
                and Loai=1";
                $resultSP = $conn->query($findSP);
                if ($resultSP->num_rows > 0){
                    $rowSP = $resultSP->fetch_assoc();
                    $today = strtotime(date("Y-m-d H:i:s"));
                    if($today<strtotime($rowSP['ThoiGianBatDau']))
                        $final = "Chưa đến thời gian nộp";
                    else if($today>strtotime($rowSP['ThoiGianKetThuc']))
                        $final = "Đã hết thời gian nộp";
                    else
                        $final = "Đang trong thời gian nộp";
                }else
                    $final = "Giảng viên chưa tạo thư mục nộp";
                echo "<h3 class='content-title'>".$row['MaLopHP']." - ".$row['TenLop']."</h3>";
                echo "
                <div class='content-body'>
                    <a href='#' class='title-box link-topic'>1. Đăng ký đề tài</a>
                    <ul><li>Đề tài đã đăng ký: $topic</li></ul>
                    <div class='dec-line'></div>
                    <a href='#' class='title-box link-proces'>2. Tiến độ thực hiện</a>
                    $process
                    <div class='dec-line'></div>
                    <a href='#' class='title-box link-final'>3. Nộp sản phẩm</a>
                    <ul><li>Tình trạng: $final</li></ul>
                    <div class='dec-line'></div>
                    <a href='#' class='title-box link-calen'>4. Lịch báo cáo</a>
                    <ul><li>Lịch đã đăng ký: $calen</li></ul>
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
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $today = (date("Y-m-d H:i:s"));
            //đã từng vào lớp đó chưa nếu có cập nhật time mới
            $check = "SELECT Id FROM lichsu_hocphan WHERE Mssv='".$rowSV['Mssv']."' and MaLopHP='$maLop'";
            $resultCheck = $conn->query($check);
            if($resultCheck->num_rows >0){
                $rowCheck = $resultCheck->fetch_assoc();
                $update = "UPDATE lichsu_hocphan SET ThoiGian='$today'
                WHERE Id=".$rowCheck['Id'];
                if(mysqli_query($conn, $update))
                    return true;
            }else{
                $count = "SELECT * FROM lichsu_hocphan WHERE Mssv='".$rowSV['Mssv']."'";
                $resultCount = $conn->query($count);
                //nếu chưa vào lớp đó và đã đủ slot lịch sử thì đổi lần vào củ nhất ngược lại thì thêm lịch sử mới
                if ($resultCount->num_rows == 4){
                    $findLast = "SELECT Id FROM lichsu_hocphan ORDER by ThoiGian desc LIMIT 1";
                    $resultLast = $conn->query($findLast);
                    $rowLast = $resultLast->fetch_assoc();
                    $update = "UPDATE lichsu_hocphan SET MaLopHP='$maLop', ThoiGian='$today'
                    WHERE Id=".$rowLast['Id'];
                    if(mysqli_query($conn, $update))
                        return true;
                }else{
                    $add = "INSERT INTO lichsu_hocphan(Mssv, MaLopHP, ThoiGian) 
                    VALUES('".$rowSV['Mssv']."','$maLop','$today')";
                    if(mysqli_query($conn, $add))
                        return true;
                }
            }
        }
    }
?>