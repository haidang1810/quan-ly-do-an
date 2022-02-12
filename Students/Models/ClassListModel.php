<?php
    if (session_id() === '')
        session_start();
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    if(isset($_POST['mssv'])){
        include("../../public/config.php");
        global $conn;
        $mssv = $_POST['mssv'];
        $sql = "SELECT sinhvien_hocphan.MaLopHP,
        lophocphan.TenLop,NgayBD,NgayKT,Id_hknh,HoTen
        FROM sinhvien_hocphan, lophocphan, giangvien, hocky_namhoc 
        WHERE sinhvien_hocphan.MaLopHP=lophocphan.MaLopHP 
        and lophocphan.MaGV=giangvien.MaGV 
        and lophocphan.Id_hknh=hocky_namhoc.Id
        and sinhvien_hocphan.Mssv='$mssv'";
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
                    <a href='#' class='link-course'>".$row['MaLopHP']." - ".$row['TenLop']."</a>
                    <input type='hidden' value='".$row['MaLopHP']."' class='MaHP'>
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
        $sql = "SELECT sinhvien_hocphan.MaLopHP,
        lophocphan.TenLop,NgayBD,NgayKT,Id_hknh,HoTen
        FROM sinhvien_hocphan, lophocphan, giangvien, hocky_namhoc 
        WHERE sinhvien_hocphan.MaLopHP=lophocphan.MaLopHP 
        and lophocphan.MaGV=giangvien.MaGV 
        and lophocphan.Id_hknh=hocky_namhoc.Id
        and sinhvien_hocphan.Mssv='$mssv'
        and lophocphan.TenLop LIKE '%$key%'";
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
                    <a href='#' class='link-course'>".$row['MaLopHP']." - ".$row['TenLop']."</a>
                    <input type='hidden' value='".$row['MaLopHP']."' class='MaHP'>
                    <p class='info'>Giảng viên: ".$row['HoTen']."</p>
                    <div class='complete'>
                        <progress id='course-complete' value='$percent' max='100'></progress>
                        <p class='info' id ='value-complete'>$percent% Complete</p>
                    </div>
                </div>
                ";
            }
        }else{
            $sql = "SELECT sinhvien_hocphan.MaLopHP,
            lophocphan.TenLop,NgayBD,NgayKT,Id_hknh,HoTen
            FROM sinhvien_hocphan, lophocphan, giangvien, hocky_namhoc 
            WHERE sinhvien_hocphan.MaLopHP=lophocphan.MaLopHP 
            and lophocphan.MaGV=giangvien.MaGV 
            and lophocphan.Id_hknh=hocky_namhoc.Id
            and sinhvien_hocphan.Mssv='$mssv'
            and sinhvien_hocphan.MaLopHP LIKE '%$key%'";
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
                        <a href='#' class='link-course'>".$row['MaLopHP']." - ".$row['TenLop']."</a>
                        <input type='hidden' value='".$row['MaLopHP']."' class='MaHP'>
                        <p class='info'>Giảng viên: ".$row['HoTen']."</p>
                        <div class='complete'>
                            <progress id='course-complete' value='$percent' max='100'></progress>
                            <p class='info' id ='value-complete'>$percent% Complete</p>
                        </div>
                    </div>
                    ";
                }
            }else{
                $sql = "SELECT sinhvien_hocphan.MaLopHP,
                lophocphan.TenLop,NgayBD,NgayKT,Id_hknh,HoTen
                FROM sinhvien_hocphan, lophocphan, giangvien, hocky_namhoc 
                WHERE sinhvien_hocphan.MaLopHP=lophocphan.MaLopHP 
                and lophocphan.MaGV=giangvien.MaGV 
                and lophocphan.Id_hknh=hocky_namhoc.Id
                and sinhvien_hocphan.Mssv='$mssv'
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
                            <a href='#' class='link-course'>".$row['MaLopHP']." - ".$row['TenLop']."</a>
                            <input type='hidden' value='".$row['MaLopHP']."' class='MaHP'>
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
        $sql = "SELECT lichsu_hocphan.MaLopHP,
        lophocphan.TenLop,NgayBD,NgayKT,Id_hknh,HoTen
        FROM lichsu_hocphan, lophocphan, giangvien, hocky_namhoc 
        WHERE lichsu_hocphan.MaLopHP=lophocphan.MaLopHP 
        and lophocphan.MaGV=giangvien.MaGV 
        and lophocphan.Id_hknh=hocky_namhoc.Id
        and lichsu_hocphan.Mssv='$mssv' ORDER BY ThoiGian DESC";
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
                    <a href='#' class='link-course'>".$row['MaLopHP']." - ".$row['TenLop']."</a>
                    <input type='hidden' value='".$row['MaLopHP']."' class='MaHP'>
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
        $_SESSION['DetailClass'] = $_POST['MaHP'];
        echo 1;
    }

    
?>