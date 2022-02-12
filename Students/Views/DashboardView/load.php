<?php
    
    $servername = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "qldoan";
    // Create connection
    $conn = new mysqli($servername, $user, $pass, $dbname);
    // Check connection
    if ($conn->connect_error) 
    {
        die("Lỗi kết nối: " . $conn->connect_error);
    }

    //$sql = "SELECT * FROM nopbai";
    session_start();
    $taiKhoan = $_SESSION['login'];
    $sqlsv = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='".$taiKhoan."'";
        $resultsv = $conn->query($sqlsv);
        $rowsv = $resultsv->fetch_assoc();
        $msv=$rowsv['Mssv'];

    $sql = "SELECT * FROM `nopbai`, sinhvien_hocphan WHERE sinhvien_hocphan.MaLopHP = nopbai.MaLopHP and sinhvien_hocphan.Mssv='".$msv."'";
    $result = $conn->query($sql);

    while($row = $result-> fetch_assoc()){
        $dateKT = date('Y-n-d H:i:s',strtotime($row["ThoiGianKetThuc"]));
        $gt=$row["Id"];
        $tieuDe =$row["MaLopHP"]."\n".$row["TieuDe"]."\n".$row['GhiChu']."\nHạn chót: ".date('H:i:s',strtotime($row["ThoiGianKetThuc"]));
        $data[] = array(
            'id'   => $row["Id"],
            'title'   => $tieuDe,
            'start'   => $dateKT,
            'end'   => $dateKT,
            'textColor' => "#ffffff",
            'allDay' => 'true'
            );
    }
    echo json_encode($data);

?>