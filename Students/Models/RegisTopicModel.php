<?php
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
                        echo "<input type='hidden' value='".$rowTopic['MaDeTai']."'>";
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
    }

    function LoadStudent($conn,$maLop){
        $listSV = "SELECT sinhvien.HoTen, sinhvien_hocphan.Mssv 
        FROM sinhvien_hocphan, sinhvien
        WHERE sinhvien_hocphan.Mssv=sinhvien.Mssv And MaLopHP='$maLop'";
        $result = $conn->query($listSV);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $findTopic = "SELECT Mssv FROM dangkydetai WHERE Mssv='".$row['Mssv']."'";
                $resultTopic = $conn->query($findTopic);
                if($resultTopic->num_rows <=0){
                    echo "
                    <label for='".$row['Mssv']."'>".$row['Mssv']." - ".$row['HoTen']."</label>
                    <input type='checkbox' class='enable' id='".$row['Mssv']."' onclick='onChecked(this.id)'><br>
                    ";
                }
            }
            
        }
    }
?>