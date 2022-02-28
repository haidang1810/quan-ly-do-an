<?php
    if (session_id() === '')
        session_start();
    function loadData($conn,$maLop){
        $findCalen = "SELECT * FROM ngaybaocao WHERE MaLopHP='$maLop'";
        $resultCalen = $conn->query($findCalen);
        if($resultCalen->num_rows>0){
            while($rowCalen = $resultCalen->fetch_assoc()){
                $id = $rowCalen['Id'];
                $remining = "SELECT sinhvien_hocphan.Mssv, dangkydetai.MaDeTai 
                FROM sinhvien_hocphan, dangkydetai 
                WHERE sinhvien_hocphan.LichBaoCao=$id 
                AND dangkydetai.Mssv=sinhvien_hocphan.Mssv GROUP BY sinhvien_hocphan.Mssv";
                $resultRemi = $conn->query($remining);
                $date = date("d-m-Y",strtotime($rowCalen['NgayBC']));
                $time = $rowCalen['ThoiGianBatDau'];
                $amount = $rowCalen['SoNhomBC'];
                $lost = $resultRemi->num_rows;
                echo "<tr>";
                echo "<td>$date</td>";
                echo "<td>$time</td>";
                echo "<td>$lost/$amount</td>";
                echo "<td>";
                $checkHK = "SELECT hocky_namhoc.TrangThai FROM lophocphan, hocky_namhoc
                WHERE lophocphan.Id_hknh=hocky_namhoc.Id AND lophocphan.MaLopHP='$maLop'";
                $resultHK = $conn->query($checkHK);
                $rowHK = $resultHK->fetch_assoc();
                if($rowHK['TrangThai']==1){
                    if(isset($_SESSION['login'])){
                        $data = $_SESSION['login'];
                    }
                    $findSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='$data'";
                    $resultSV = $conn->query($findSV);
                    $rowSV = $resultSV->fetch_assoc();
                    $mssv = $rowSV['Mssv'];
                    $checkDK = "SELECT * FROM sinhvien_hocphan WHERE Mssv='$mssv'
                    AND MaLopHP='$maLop'";
                    $resultDK = $conn->query($checkDK);
                    $rowDK = $resultDK->fetch_assoc();
                    if($rowDK['LichBaoCao']){
                        if($rowDK['LichBaoCao']==$id){
                            echo "<form method='POST' class='form-cancel'>";
                            echo "<input type='hidden' name='cancel-calen' value='$maLop'>";
                            echo "<button class='btn_Calen btn_danger' name='cancel-calen' type='submit'>
                            <i class='fas fa-trash-alt'></i>
                            </button>";
                            echo "</form>";
                        }
                        
                    }else if($lost<$amount){
                        echo "<form method='POST'>";
                        echo "<button type='submit' name='RegCalen' class='btn_Calen btn_primary' value='$id' >";
                        echo "<i class='fas fa-edit'></i>";
                        echo "</button>";
                        echo "</form>";
                    }
                }
                echo "</td>";
                echo "</tr>";
            }
        }
    }
    function cancelCalen($conn,$maLop){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='$data'";
        $resultSV = $conn->query($findSV);
        $rowSV = $resultSV->fetch_assoc();
        $mssv = $rowSV['Mssv'];
        $findGroup = "SELECT sinhvien_hocphan.Mssv, dangkydetai.MaDeTai 
        FROM sinhvien_hocphan, dangkydetai 
        WHERE sinhvien_hocphan.Mssv = dangkydetai.Mssv 
        AND sinhvien_hocphan.MaLopHP = '$maLop' 
        AND dangkydetai.MaDeTai= (
            SELECT dangkydetai.MaDeTai 
            FROM detai, dangkydetai 
            WHERE dangkydetai.MaDeTai=detai.MaDeTai 
            AND detai.MaLopHP='$maLop'
            AND dangkydetai.Mssv='$mssv' ) 
        GROUP BY sinhvien_hocphan.Mssv";
        $resultGroup = $conn->query($findGroup);
        if($resultGroup->num_rows>0){
            $err=0;
            while($rowGroup = $resultGroup->fetch_assoc()){
                $sql = "UPDATE sinhvien_hocphan SET LichBaoCao=NULL 
                WHERE Mssv='".$rowGroup['Mssv']."' AND MaLopHP='$maLop'";
                if(!mysqli_query($conn,$sql))
                    $err=1;
            }
            if($err==0){
                echo"
                <script>
                    Swal.fire(
                        'Đã huỷ!',
                        'Bạn đã huỷ lịch báo cáo thành công.',
                        'success'
                    )
                </script>";
            }else{
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Lỗi khi huỷ lịch!'
                        })
                    </script>";
            }
        }
    }
    function RegisCalen($conn,$maLop,$id){
        if(isset($_SESSION['login'])){
            $data = $_SESSION['login'];
        }
        $findSV = "SELECT Mssv FROM sinhvien WHERE TaiKhoan='$data'";
        $resultSV = $conn->query($findSV);
        $rowSV = $resultSV->fetch_assoc();
        $mssv = $rowSV['Mssv'];
        $findGroup = "SELECT sinhvien_hocphan.Mssv, dangkydetai.MaDeTai 
        FROM sinhvien_hocphan, dangkydetai 
        WHERE sinhvien_hocphan.Mssv = dangkydetai.Mssv 
        AND sinhvien_hocphan.MaLopHP = '$maLop' 
        AND dangkydetai.MaDeTai= (
            SELECT dangkydetai.MaDeTai 
            FROM detai, dangkydetai 
            WHERE dangkydetai.MaDeTai=detai.MaDeTai 
            AND detai.MaLopHP='$maLop'
            AND dangkydetai.Mssv='$mssv' ) 
        GROUP BY sinhvien_hocphan.Mssv";
        $resultGroup = $conn->query($findGroup);
        if($resultGroup->num_rows>0){
            $err=0;
            while($rowGroup = $resultGroup->fetch_assoc()){
                $sql = "UPDATE sinhvien_hocphan SET LichBaoCao=$id 
                WHERE Mssv='".$rowGroup['Mssv']."' AND MaLopHP='$maLop'";
                if(!mysqli_query($conn,$sql))
                    $err=1;
            }
            if($err==0){
                echo"
                <script>
                    Swal.fire(
                        'Đã cập nhật!',
                        'Bạn đã đăng ký lịch báo cáo thành công.',
                        'success'
                    )
                </script>";
            }else{
                echo "
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi...',
                            text: 'Lỗi khi đăng ký!'
                        })
                    </script>";
            }
        }else{
            echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Sinh viên chưa có đề tài!'
                })
            </script>";
        }
    }
?>