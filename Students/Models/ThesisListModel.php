<?php
    if (session_id() === '')
        session_start();
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    if(isset($_POST['mssv'])){
        include("../../public/config.php");
        global $conn;
        $mssv = $_POST['mssv'];
        $sql = "SELECT sinhvien_luanvan.MaLopLV,
        lopluanvan.TenLop,NgayBD,NgayKT,Id_hknh,HoTen
        FROM sinhvien_luanvan, lopluanvan, giangvien, hocky_namhoc 
        WHERE sinhvien_luanvan.MaLopLV=lopluanvan.MaLopLV 
        and lopluanvan.MaGV=giangvien.MaGV 
        and lopluanvan.Id_hknh=hocky_namhoc.Id
        and sinhvien_luanvan.Mssv='$mssv'";
        $result = $conn->query($sql);
        $res = "";
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $dateStart = strtotime($row['NgayBD']);
                $dateEnd = strtotime($row['NgayKT']);
                $dateDiff = abs(($dateEnd-$dateStart)/(60*60*24));
                $today = strtotime(date("Y-m-d"));
                $currentDateDiff = abs(($today-$dateStart)/(60*60*24));
                $percent = ceil(($currentDateDiff/$dateDiff)*100);
                if($today<=$dateStart)
                    $percent=0;
                if($percent>=100)
                    $percent=100;
                $res .= "
                <div class='course'>
                    <a href='#' class='link-course'>".$row['MaLopLV']." - ".$row['TenLop']."</a>
                    <input type='hidden' value='".$row['MaLopLV']."' class='MaHP'>
                    <p class='info'>Giảng viên: ".$row['HoTen']."</p>
                    <div class='complete'>
                        <progress id='course-complete' value='$percent' max='100'></progress>
                        <p class='info' id ='value-complete'>$percent% Complete</p>
                    </div>
                </div>
                ";
            }
        }
        echo $res;
    }

    if(isset($_POST['sv'])&&isset($_POST['key'])){
        include("../../public/config.php");
        global $conn;
        $mssv = $_POST['sv'];
        $key = $_POST['key'];
        $sql = "SELECT sinhvien_luanvan.MaLopLV,
        lopluanvan.TenLop,NgayBD,NgayKT,Id_hknh,HoTen
        FROM sinhvien_luanvan, lopluanvan, giangvien, hocky_namhoc 
        WHERE sinhvien_luanvan.MaLopLV=lopluanvan.MaLopLV 
        and lopluanvan.MaGV=giangvien.MaGV 
        and lopluanvan.Id_hknh=hocky_namhoc.Id
        and sinhvien_luanvan.Mssv='$mssv'
        and lopluanvan.TenLop LIKE '%$key%'";
        $result = $conn->query($sql);
        $res = "";
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $dateStart = strtotime($row['NgayBD']);
                $dateEnd = strtotime($row['NgayKT']);
                $dateDiff = abs(($dateEnd-$dateStart)/(60*60*24));
                $today = strtotime(date("Y-m-d"));
                $currentDateDiff = abs(($today-$dateStart)/(60*60*24));
                $percent = ceil(($currentDateDiff/$dateDiff)*100);
                if($today<=$dateStart)
                    $percent=0;
                if($percent>=100)
                    $percent=100;
                $res .= "
                <div class='course'>
                    <a href='#' class='link-course'>".$row['MaLopLV']." - ".$row['TenLop']."</a>
                    <input type='hidden' value='".$row['MaLopLV']."' class='MaHP'>
                    <p class='info'>Giảng viên: ".$row['HoTen']."</p>
                    <div class='complete'>
                        <progress id='course-complete' value='$percent' max='100'></progress>
                        <p class='info' id ='value-complete'>$percent% Complete</p>
                    </div>
                </div>
                ";
            }
        }else{
            $sql = "SELECT sinhvien_luanvan.MaLopLV,
            lopluanvan.TenLop,NgayBD,NgayKT,Id_hknh,HoTen
            FROM sinhvien_luanvan, lopluanvan, giangvien, hocky_namhoc 
            WHERE sinhvien_luanvan.MaLopLV=lopluanvan.MaLopLV 
            and lopluanvan.MaGV=giangvien.MaGV 
            and lopluanvan.Id_hknh=hocky_namhoc.Id
            and sinhvien_luanvan.Mssv='$mssv'
            and sinhvien_luanvan.MaLopLV LIKE '%$key%'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $dateStart = strtotime($row['NgayBD']);
                    $dateEnd = strtotime($row['NgayKT']);
                    $dateDiff = abs(($dateEnd-$dateStart)/(60*60*24));
                    $today = strtotime(date("Y-m-d"));
                    $currentDateDiff = abs(($today-$dateStart)/(60*60*24));
                    $percent = ceil(($currentDateDiff/$dateDiff)*100);
                    if($today<=$dateStart)
                        $percent=0;
                    if($percent>=100)
                        $percent=100;
                    $res .= "
                    <div class='course'>
                        <a href='#' class='link-course'>".$row['MaLopLV']." - ".$row['TenLop']."</a>
                        <input type='hidden' value='".$row['MaLopLV']."' class='MaHP'>
                        <p class='info'>Giảng viên: ".$row['HoTen']."</p>
                        <div class='complete'>
                            <progress id='course-complete' value='$percent' max='100'></progress>
                            <p class='info' id ='value-complete'>$percent% Complete</p>
                        </div>
                    </div>
                    ";
                }
            }else{
                $sql = "SELECT sinhvien_luanvan.MaLopLV,
                lopluanvan.TenLop,NgayBD,NgayKT,Id_hknh,HoTen
                FROM sinhvien_luanvan, lopluanvan, giangvien, hocky_namhoc 
                WHERE sinhvien_luanvan.MaLopLV=lopluanvan.MaLopLV 
                and lopluanvan.MaGV=giangvien.MaGV 
                and lopluanvan.Id_hknh=hocky_namhoc.Id
                and sinhvien_luanvan.Mssv='$mssv'
                and HoTen LIKE '%$key%'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $dateStart = strtotime($row['NgayBD']);
                        $dateEnd = strtotime($row['NgayKT']);
                        $dateDiff = abs(($dateEnd-$dateStart)/(60*60*24));
                        $today = strtotime(date("Y-m-d"));
                        $currentDateDiff = abs(($today-$dateStart)/(60*60*24));
                        $percent = ceil(($currentDateDiff/$dateDiff)*100);
                        if($today<=$dateStart)
                            $percent=0;
                        if($percent>=100)
                            $percent=100;
                        $res .= "
                        <div class='course'>
                            <a href='#' class='link-course'>".$row['MaLopLV']." - ".$row['TenLop']."</a>
                            <input type='hidden' value='".$row['MaLopLV']."' class='MaHP'>
                            <p class='info'>Giảng viên: ".$row['HoTen']."</p>
                            <div class='complete'>
                                <progress id='course-complete' value='$percent' max='100'></progress>
                                <p class='info' id ='value-complete'>$percent% Complete</p>
                            </div>
                        </div>
                        ";
                    }
                }
            }
        }
        echo $res;
    }

    if(isset($_POST['history'])){
        include("../../public/config.php");
        global $conn;
        $mssv = $_POST['history'];
        $sql = "SELECT lichsu_luanvan.MaLopLV,
        lopluanvan.TenLop,NgayBD,NgayKT,Id_hknh,HoTen
        FROM lichsu_luanvan, lopluanvan, giangvien, hocky_namhoc 
        WHERE lichsu_luanvan.MaLopLV=lopluanvan.MaLopLV 
        and lopluanvan.MaGV=giangvien.MaGV 
        and lopluanvan.Id_hknh=hocky_namhoc.Id
        and lichsu_luanvan.Mssv='$mssv' ORDER BY ThoiGian DESC";
        $result = $conn->query($sql);
        $res = "";
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $dateStart = strtotime($row['NgayBD']);
                $dateEnd = strtotime($row['NgayKT']);
                $dateDiff = abs(($dateEnd-$dateStart)/(60*60*24));
                $today = strtotime(date("Y-m-d"));
                $currentDateDiff = abs(($today-$dateStart)/(60*60*24));
                $percent = ceil(($currentDateDiff/$dateDiff)*100);
                if($today<=$dateStart)
                    $percent=0;
                if($percent>=100)
                    $percent=100;
                $res .= "
                <div class='course'>
                    <a href='#' class='link-course'>".$row['MaLopLV']." - ".$row['TenLop']."</a>
                    <input type='hidden' value='".$row['MaLopLV']."' class='MaHP'>
                    <p class='info'>Giảng viên: ".$row['HoTen']."</p>
                    <div class='complete'>
                        <progress id='course-complete' value='$percent' max='100'></progress>
                        <p class='info' id ='value-complete'>$percent% Complete</p>
                    </div>
                </div>
                ";
            }
        }
        echo $res;
    }

    if(isset($_POST['MaHP'])){
        unset($_SESSION['DetailClass']);
        $_SESSION['DetailThesis'] = $_POST['MaHP'];
        echo 1;
    }

    
?>