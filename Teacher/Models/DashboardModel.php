<?php
    if (session_id() === '')
        session_start();
    function totalStudent($conn){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findND = "SELECT MaGV FROM giangvien WHERE TaiKhoan='".$data."'";
        $resultND = $conn->query($findND);
        $total=0;
        if ($resultND->num_rows > 0) {            
            $rowND = $resultND->fetch_assoc();
            $findLop = "SELECT * FROM lophocphan WHERE MaGV='".$rowND['MaGV']."'";
            $resultLop = $conn->query($findLop);
            if($resultLop->num_rows > 0){                
                while($rowLop = $resultLop->fetch_assoc()){
                    $sql = "SELECT * FROM sinhvien_hocphan WHERE MaLopHP='".$rowLop['MaLopHP']."'";
                    $result = $conn->query($sql);
                    $total += $result->num_rows;
                }
            }           
        }
        echo "<h1 class='box-number'>".$total."</h1>";
    }
    function totalClass($conn){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findND = "SELECT MaGV FROM giangvien WHERE TaiKhoan='".$data."'";
        $resultND = $conn->query($findND);
        $total = 0;
        if ($resultND->num_rows > 0){
            $rowND = $resultND->fetch_assoc();
            $sql = "SELECT * FROM lophocphan WHERE MaGV='".$rowND['MaGV']."'";
            $result = $conn->query($sql);
            $total = $result->num_rows;
        }
        echo "<h1 class='box-number'>".$total."</h1>";
    }

    function totalTopic($conn){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findND = "SELECT MaGV FROM giangvien WHERE TaiKhoan='".$data."'";
        $resultND = $conn->query($findND);
        $total=0;
        if ($resultND->num_rows > 0) {            
            $rowND = $resultND->fetch_assoc();
            $findLop = "SELECT * FROM lophocphan WHERE MaGV='".$rowND['MaGV']."'";
            $resultLop = $conn->query($findLop);
            if($resultLop->num_rows > 0){                
                while($rowLop = $resultLop->fetch_assoc()){
                    $sql = "SELECT * FROM detai WHERE MaLopHP='".$rowLop['MaLopHP']."'";
                    $result = $conn->query($sql);
                    $total += $result->num_rows;
                }
            }           
        }
        echo "<h1 class='box-number'>".$total."</h1>";
    }
    function suggestApproved($conn){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findND = "SELECT MaGV FROM giangvien WHERE TaiKhoan='".$data."'";
        $resultND = $conn->query($findND);
        $total=0;
        if ($resultND->num_rows > 0) {            
            $rowND = $resultND->fetch_assoc();
            $findLop = "SELECT * FROM lophocphan WHERE MaGV='".$rowND['MaGV']."'";
            $resultLop = $conn->query($findLop);
            if($resultLop->num_rows > 0){                
                while($rowLop = $resultLop->fetch_assoc()){
                    $sql = "SELECT * FROM detaidexuat WHERE MaLopHP='".$rowLop['MaLopHP']."' AND (TrangThai=1 OR TrangThai=2)";
                    $result = $conn->query($sql);
                    $total += $result->num_rows;
                }
            }           
        }
        echo "<h1 class='box-number'>".$total."</h1>";
    }

    function suggest($conn){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findND = "SELECT MaGV FROM giangvien WHERE TaiKhoan='".$data."'";
        $resultND = $conn->query($findND);
        $total=0;
        if ($resultND->num_rows > 0) {            
            $rowND = $resultND->fetch_assoc();
            $findLop = "SELECT * FROM lophocphan WHERE MaGV='".$rowND['MaGV']."'";
            $resultLop = $conn->query($findLop);
            if($resultLop->num_rows > 0){                
                while($rowLop = $resultLop->fetch_assoc()){
                    $sql = "SELECT * FROM detaidexuat WHERE MaLopHP='".$rowLop['MaLopHP']."' AND TrangThai=0";
                    $result = $conn->query($sql);
                    $total += $result->num_rows;
                }
            }           
        }
        echo "<h1 class='box-number'>".$total."</h1>";
    }

    function classNonTopic($conn){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findND = "SELECT MaGV FROM giangvien WHERE TaiKhoan='".$data."'";
        $resultND = $conn->query($findND);
        $total=0;
        if ($resultND->num_rows > 0) {            
            $rowND = $resultND->fetch_assoc();
            $findLop = "SELECT * FROM lophocphan WHERE MaGV='".$rowND['MaGV']."'";
            $resultLop = $conn->query($findLop);
            if($resultLop->num_rows > 0){                
                while($rowLop = $resultLop->fetch_assoc()){
                    $sql = "SELECT * FROM detai WHERE MaLopHP='".$rowLop['MaLopHP']."'";
                    $result = $conn->query($sql);
                    if($result->num_rows <= 0)
                        $total += 1;
                }
            }           
        }
        echo "<h1 class='box-number'>".$total."</h1>";
    }

    function classNonCalen($conn){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findND = "SELECT MaGV FROM giangvien WHERE TaiKhoan='".$data."'";
        $resultND = $conn->query($findND);
        $total=0;
        if ($resultND->num_rows > 0) {            
            $rowND = $resultND->fetch_assoc();
            $findLop = "SELECT * FROM lophocphan WHERE MaGV='".$rowND['MaGV']."'";
            $resultLop = $conn->query($findLop);
            if($resultLop->num_rows > 0){                
                while($rowLop = $resultLop->fetch_assoc()){
                    $sql = "SELECT * FROM ngaybaocao WHERE MaLopHP='".$rowLop['MaLopHP']."'";
                    $result = $conn->query($sql);
                    if($result->num_rows <= 0)
                        $total += 1;
                }
            }           
        }
        echo "<h1 class='box-number'>".$total."</h1>";
    }
?>