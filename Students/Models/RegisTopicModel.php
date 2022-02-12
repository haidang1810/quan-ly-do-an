<?php
    function loadTopic($conn,$maLop){
        $topic = "SELECT * FROM detai WHERE MaLopHP='$maLop'";
        $resultTopic = $conn->query($topic);
        if($resultTopic->num_rows > 0){
            while($rowTopic = $resultTopic->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$rowTopic['TenDeTai']."</td>";
                echo "<td>".$rowTopic['GhiChu']."</td>";
                $count = "SELECT * FROM dangkydetai WHERE MaDeTai='".$rowTopic['MaDeTai']."'";
                $resultCount = $conn->query($count);
                echo "<td>".$resultCount->num_rows."/".$rowTopic['SoThanhVien']."</td>";
                echo "<td></td>";
                echo "</tr>";
            }
        }
    }
?>