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
    if(isset($_POST['id'])&&isset($_POST['mssv'])) {
        include("../../public/config.php");
        global $conn;
        $hknh = $_POST['id'];
        $mssv = $_POST['mssv'];
        if (session_id() === '')
            session_start();
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $_SESSION['HKNH'] = $hknh;
        $findLop = "SELECT * FROM lopluanvan WHERE Id_hknh=".$hknh;
        $resultLop = $conn->query($findLop);
        if($resultLop->num_rows > 0){
        echo "<table id='tableClass'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Mã lớp</th>";
        echo "<th>Tên lớp</th>";
        echo "<th>Giảng viên</th>";
        echo "<th>Đăng ký</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
            while($rowLop = $resultLop->fetch_assoc()){
                echo "<tr>";
                echo "<td>".$rowLop['MaLopLV']." </td>";
                echo "<td>".$rowLop['TenLop']." </td>";
                echo "<td>";
                $findGV = "SELECT * FROM giangvien WHERE MaGV='".$rowLop['MaGV']."'";
                $resultGV = $conn->query($findGV);
                if ($resultGV->num_rows > 0) {
                    $rowGV = $resultGV->fetch_assoc();
                    echo $rowGV['HoTen'];
                }
                echo "</td>";
                echo "<td>";
                //
                $checkHKNH =  "SELECT TrangThai FROM hocky_namhoc WHERE id=$hknh";
                $resultHKNH = $conn->query($checkHKNH);
                //
                $check = "SELECT * FROM sinhvien_luanvan WHERE Mssv='$mssv' AND MaLopLV='".$rowLop['MaLopLV']."'";
                $resultCheck = $conn->query($check);
                
                if($resultCheck->num_rows <= 0 && $resultHKNH->num_rows > 0){
                    $rowHKNH = $resultHKNH->fetch_assoc();
                    if($rowHKNH['TrangThai']==1){
                        echo "<form method='POST' class='form-register'>";
                        echo "<button class='btn_register btn_primary' type='submit'>";
                        echo "<i class='fas fa-edit'></i>";
                        echo "</button>";
                        echo " <input type='hidden' value='".$rowLop['MaLopLV']."' name='MaLopLV' class='MaLopLV'>";
                        echo "</form>";
                    }
                }
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        }
    }

    if(isset($_POST['maLopLV'])&&isset($_POST['mssv'])){
        include("../../public/config.php");
        global $conn;
        $maLop = $_POST['maLopLV'];
        $mssv = $_POST['mssv'];
        $sql = "INSERT INTO sinhvien_luanvan(Mssv,MaLopLV) VALUES('$mssv','$maLop')";
        if(mysqli_query($conn, $sql))
            echo 1;
        else echo -1;
    }
?>