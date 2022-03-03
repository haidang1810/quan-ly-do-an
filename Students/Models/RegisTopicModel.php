<?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    if (session_id() === '')
        session_start();
    function loadTopic($conn,$maLop){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='$data'";
        $resultSV = $conn->query($findSV);
        $rowSV = $resultSV->fetch_assoc();
        $checkHK = "SELECT hocky_namhoc.TrangThai FROM lophocphan, hocky_namhoc
        WHERE lophocphan.Id_hknh=hocky_namhoc.Id AND lophocphan.MaLopHP='$maLop'";
        $resultHK = $conn->query($checkHK);
        $rowHK = $resultHK->fetch_assoc();
        
        $findDK = "SELECT Mssv, dangkydetai.MaDeTai 
        FROM detai, dangkydetai 
        WHERE detai.MaDeTai=dangkydetai.MaDeTai 
        AND Mssv='".$rowSV['Mssv']."' AND detai.MaLopHP='$maLop'";
        $resultDK = $conn->query($findDK);
        $findOffer = "SELECT * FROM detaidexuat WHERE Mssv='".$rowSV['Mssv']."'
        AND MaLopHP='$maLop' AND TrangThai <> 1";
        $resultOffer = $conn->query($findOffer);
        if($resultOffer->num_rows <= 0 && $rowHK['TrangThai']!=0){
            if($resultDK->num_rows > 0){
                $rowDK = $resultDK->fetch_assoc();
                $topic = "SELECT * FROM detai WHERE MaLopHP='$maLop'";
                $resultTopic = $conn->query($topic);
                if($resultTopic->num_rows > 0){
                    while($rowTopic = $resultTopic->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$rowTopic['TenDeTai']."</td>";
                        echo "<td>".$rowTopic['GhiChu']."</td>";
                        $count = "SELECT * FROM dangkydetai WHERE MaDeTai='".$rowTopic['MaDeTai']."'";
                        $resultCount = $conn->query($count);
                        $remaining = $rowTopic['SoThanhVien']-($resultCount->num_rows);
                        echo "<td>".$resultCount->num_rows."/".$rowTopic['SoThanhVien']."</td>";
                        echo "<td>";
                        if($rowTopic['MaDeTai']==$rowDK['MaDeTai']){
                            echo "<form method='POST' class='form-cancel'>";
                            echo "<input type='hidden' name='Id-cancel' value='".$rowTopic['MaDeTai']."'>";
                            echo "<button class='btn_register btn_danger'  type='submit'>
                            <i class='fas fa-trash-alt'></i>
                            </button>";
                            echo "</form>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                }
            
            }else{
                $rowDK = $resultDK->fetch_assoc();
                $topic = "SELECT * FROM detai WHERE MaLopHP='$maLop'";
                $resultTopic = $conn->query($topic);
                if($resultTopic->num_rows > 0){
                    while($rowTopic = $resultTopic->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>".$rowTopic['TenDeTai']."</td>";
                        echo "<td>".$rowTopic['GhiChu']."</td>";
                        $count = "SELECT * FROM dangkydetai WHERE MaDeTai='".$rowTopic['MaDeTai']."'";
                        $resultCount = $conn->query($count);
                        $remaining = $rowTopic['SoThanhVien']-($resultCount->num_rows);
                        echo "<td>".$resultCount->num_rows."/".$rowTopic['SoThanhVien']."</td>";
                        echo "<td>";
                        echo "<button class='btn_register btn_primary open-modal-btn' id='".$rowTopic['MaDeTai'].",$remaining' onclick='openModal(this.id)' >";
                        echo "<i class='fas fa-edit'></i>";
                        echo "</button>";
                        echo "</td>";
                        echo "</tr>";
                    }
                }
            }
        }else{
            $rowDK = $resultDK->fetch_assoc();
            $topic = "SELECT * FROM detai WHERE MaLopHP='$maLop'";
            $resultTopic = $conn->query($topic);
            if($resultTopic->num_rows > 0){
                while($rowTopic = $resultTopic->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$rowTopic['TenDeTai']."</td>";
                    echo "<td>".$rowTopic['GhiChu']."</td>";
                    $count = "SELECT * FROM dangkydetai WHERE MaDeTai='".$rowTopic['MaDeTai']."'";
                    $resultCount = $conn->query($count);
                    $remaining = $rowTopic['SoThanhVien']-($resultCount->num_rows);
                    echo "<td>".$resultCount->num_rows."/".$rowTopic['SoThanhVien']."</td>";
                    echo "<td>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
        }
    }

    function LoadStudent($conn,$maLop){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='$data'";
        $resultSV = $conn->query($findSV);
        $rowSV = $resultSV->fetch_assoc();
        $listSV = "SELECT sinhvien.HoTen, sinhvien_hocphan.Mssv 
        FROM sinhvien_hocphan, sinhvien
        WHERE sinhvien_hocphan.Mssv=sinhvien.Mssv And MaLopHP='$maLop'";
        $result = $conn->query($listSV);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $flat = true;
                $selectTopic = "SELECT MaDeTai FROM detai WHERE MaLopHP='$maLop'";
                $resultTopic = $conn->query($selectTopic);
                if ($resultTopic->num_rows > 0){
                    while($rowTopic = $resultTopic->fetch_assoc()){
                        $checkDK = "SELECT detai.TenDeTai FROM dangkydetai, detai
                        WHERE dangkydetai.MaDeTai='".$rowTopic['MaDeTai']."'
                        AND dangkydetai.Mssv='".$row['Mssv']."'
                        AND detai.MaDeTai=dangkydetai.MaDeTai";
                        $resultDK = $conn->query($checkDK);
                        if ($resultDK->num_rows <= 0 && $row['Mssv']!=$rowSV['Mssv']){
                            continue;
                        }else $flat = false;
                    }
                }
                if($flat)
                    echo "
                    <label for='".$row['Mssv']."'>".$row['Mssv']." - ".$row['HoTen']."</label>
                    <input type='checkbox' class='enable' id='".$row['Mssv']."' onclick='onChecked(this.id)'><br>
                    ";
            }
        }
    }

    function cancelTopic($conn,$id,$maLop){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='$data'";
        $resultSV = $conn->query($findSV);
        $rowSV = $resultSV->fetch_assoc();
        //check tien do
        $checkPro = "SELECT * FROM nopbai,nopbaichitiet 
        WHERE nopbai.Id=nopbaichitiet.Ma
        And nopbaichitiet.Mssv='$data'
        AND nopbai.MaLopHP='$maLop'";
        $resultPro = $conn->query($checkPro);
        //check lich bc
        $checkBC = "SELECT NgayBC FROM NgayBaoCao WHERE MaLopHP='$maLop'";
        $resultBC = $conn->query($checkBC);
        if($resultPro->num_rows>0||$resultBC->num_rows>0){
            echo"
            <script>
                Swal.fire({
                    title: 'Lỗi!',
                    text: 'Học kỳ đã bắt đầu không thể huỷ.',
                    icon: 'error'
                })
            </script>
            ";
            exit;
        }else{
            $sql = "DELETE FROM dangkydetai WHERE MaDeTai='$id' AND Mssv='".$rowSV['Mssv']."'";
            if(mysqli_query($conn,$sql)){
                echo"
                    <script>
                        Swal.fire({
                            title: 'Đã huỷ!',
                            text: 'Bạn đã huỷ đăng ký đề tài thành công.',
                            icon: 'success',
                            didClose: ()=>{
                                window.location.href = window.location.href;
                            }
                        })
                    </script>
                    ";
            }
        }
    }
    if(isset($_POST['listSV']) && isset($_POST['MaDT'])){
        include("../../public/config.php");
        global $conn;
        $listSV = explode(",",$_POST['listSV']);
        $today = date("Y-m-d H:i:s");
        $id_topic = $_POST['MaDT'];
        $error = [];
        foreach($listSV as $mssv){
            $sql = "INSERT INTO dangkydetai
            VALUES($id_topic,'$mssv','$today')";
            if(!mysqli_query($conn,$sql))
                array_push($error,mysqli_error($conn));
        }
        if(count($error)>0){
            echo "Không thể đăng ký cho các sinh viên: ".implode($error);
        }else echo 1;
        
    }

    function offer_topic($conn,$class,$name,$note,$amount){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='$data'";
        $resultSV = $conn->query($findSV);
        $rowSV = $resultSV->fetch_assoc();
        $mssv = $rowSV['Mssv'];
        $sql = "INSERT INTO detaidexuat(MaLopHP,Ten,GhiChu,SoTV,Mssv,TrangThai) 
        VALUES('$class','$name','$note','$amount', '$mssv', 0)";
        if(mysqli_query($conn,$sql)){
            echo"
                <script>
                    Swal.fire({
                        title: 'Đã lưu!',
                        text: 'Bạn đã đề xuất đề tài thành công.',
                        icon: 'success',
                        didClose: ()=>{
                            window.location.href = window.location.href;
                        }
                    })
                </script>
                ";
        }
    }
    function checkOffer($conn,$maLop){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='$data'";
        $resultSV = $conn->query($findSV);
        $rowSV = $resultSV->fetch_assoc();
        $findOffer = "SELECT * FROM detaidexuat WHERE Mssv='".$rowSV['Mssv']."'
        AND MaLopHP='$maLop'";
        $resultOffer = $conn->query($findOffer);
        if($resultOffer->num_rows > 0){
            $data = [];
            while($rowOffer = $resultOffer->fetch_assoc()){
                $data[] = $rowOffer;
            }
            return $data;
        }else {
            $findDK = "SELECT Mssv, dangkydetai.MaDeTai
            FROM detai, dangkydetai 
            WHERE detai.MaDeTai=dangkydetai.MaDeTai 
            AND Mssv='".$rowSV['Mssv']."' AND detai.MaLopHP='$maLop'";
            $resultDK = $conn->query($findDK);
            if($resultDK->num_rows > 0)
                return "exit";
            else return "null";
        }
    }
?>