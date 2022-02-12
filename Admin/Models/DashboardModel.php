<?php
    if (session_id() === '')
        session_start();
    function totalStudent($conn){
        $total=0;
        $sql = "SELECT * FROM sinhvien";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $total += $result->num_rows;
        }       
        
        echo "<h1 class='box-number'>".$total."</h1>";
    }
    function totalTeacher($conn){
        $total=0;
        $sql = "SELECT * FROM giangvien";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $total += $result->num_rows;
        }       
        
        echo "<h1 class='box-number'>".$total."</h1>";
    }
    function totalClass($conn){
        $total = 0;
        $sql = "SELECT * FROM lophocphan";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $total += $result->num_rows;
        }
        echo "<h1 class='box-number'>".$total."</h1>";
    }
    function totalClassNull($conn){
        $total = 0;
        $sql = "SELECT * FROM lophocphan WHERE MaGV IS NULL";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $total += $result->num_rows;
        }
        echo "<h1 class='box-number'>".$total."</h1>";
    }
    function totalAccStu($conn){
        $total = 0;
        $sql = "SELECT * FROM nguoidung WHERE Loai=1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $total += $result->num_rows;
        }
        echo "<h1 class='box-number'>".$total."</h1>";
    }
    function totalAccTea($conn){
        $total = 0;
        $sql = "SELECT * FROM nguoidung WHERE Loai=2";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $total += $result->num_rows;
        }
        echo "<h1 class='box-number'>".$total."</h1>";
    }
?>
