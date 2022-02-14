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
        $findDK = "SELECT Mssv, dangkydetai.MaDeTai 
        FROM detai, dangkydetai 
        WHERE detai.MaDeTai=dangkydetai.MaDeTai 
        AND Mssv='".$rowSV['Mssv']."' AND detai.MaLopHP='$maLop'";
        $resultDK = $conn->query($findDK);
        $findOffer = "SELECT * FROM detaidexuat WHERE Mssv='".$rowSV['Mssv']."'
        AND MaLopHP='$maLop'";
        $resultOffer = $conn->query($findOffer);
        if($resultOffer->num_rows <= 0){
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
                $findTopic = "SELECT Mssv FROM dangkydetai WHERE Mssv='".$row['Mssv']."'";
                $resultTopic = $conn->query($findTopic);
                if($resultTopic->num_rows <=0 && $row['Mssv']!=$rowSV['Mssv']){
                    echo "
                    <label for='".$row['Mssv']."'>".$row['Mssv']." - ".$row['HoTen']."</label>
                    <input type='checkbox' class='enable' id='".$row['Mssv']."' onclick='onChecked(this.id)'><br>
                    ";
                }
            }
            
        }
    }

    function cancelTopic($conn,$id){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='$data'";
        $resultSV = $conn->query($findSV);
        $rowSV = $resultSV->fetch_assoc();

        $sql = "DELETE FROM dangkydetai WHERE MaDeTai='$id' AND Mssv='".$rowSV['Mssv']."'";
        if(mysqli_query($conn,$sql)){
            echo"
                <script>
                    Swal.fire(
                        'Đã huỷ!',
                        'Bạn đã huỷ đăng ký đề tài thành công.',
                        'success'
                    )
                    setTimeout(() => {
                        window.location.href = window.location.href; 
                    }, 2000);
                </script>
                ";
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
                    Swal.fire(
                        'Đẫ thêm!',
                        'Bạn đã đề xuất đề tài thành công.',
                        'success'
                    )
                    setTimeout(() => {
                        window.location.href = window.location.href; 
                    }, 2000);
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
            $rowOffer = $resultOffer->fetch_assoc();
            return $rowOffer['Ten'];
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