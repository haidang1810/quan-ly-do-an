<?php
    function loadHKNH($conn,$MaHKNH=null) {
        $sql = "SELECT * FROM hocky_namhoc";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($MaHKNH==null)
                    echo "<option value='".$row['Id']."'>".$row['HocKy_NamHoc']."</option>";
                else if($MaHKNH==$row['Id']){
                    echo "<option value='".$row['Id']."'selected='selected'>".$row['HocKy_NamHoc']."</option>";                       
                    }
                    else
                        echo "<option value='".$row['Id']."'>".$row['HocKy_NamHoc']."</option>";
            }
        }
    }
    function loadLopHP($conn,$hknh) {
        if (session_id() === '')
            session_start();
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $_SESSION['HKNH'] = $hknh;
        $findND = "SELECT MaGV FROM giangvien WHERE TaiKhoan='".$data."'";
        $resultND = $conn->query($findND);
        if ($resultND->num_rows > 0) {
            $rowND = $resultND->fetch_assoc();
            $findLop = "SELECT * FROM lophocphan WHERE MaGV='".$rowND['MaGV']."' AND Id_hknh='".$hknh."'";
            $resultLop = $conn->query($findLop);
            if($resultLop->num_rows > 0){
                while($rowLop = $resultLop->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>".$rowLop['MaLopHP']." </td>";
                    echo "<td>".$rowLop['TenLop']." </td>";
                    echo "<td>";
                    echo "<ul>";
                    echo "<li><b>Tuần bắt đầu:</b> ".$rowLop['TuanBD']."</li>";
                    echo "<li><b>Tuần kết thúc:</b> ".$rowLop['TuanKT']."</li>";
                    echo "</ul>";
                    echo "</td>";
                    echo "<td>";
                    echo "<form method='POST'>";
                    echo "<button class='btn_class btn_detail' type='submit' name='showStudentList'>";
                    echo "<i class='fas fa-info-circle'></i>";
                    echo "</button>";
                    echo " <input type='hidden' value='".$rowLop['MaLopHP']."' name='MaLopHP'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
            }
        }
    }
    
?>