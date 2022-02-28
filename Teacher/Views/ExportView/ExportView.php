<?php
    include("../../Controllers/ExportController.php");
    require '../../../public/mpdf/vendor/autoload.php';
    if(isset($_POST['export'])){
        $maLop = $_POST['MaLop'];
        $findLop = "SELECT * FROM sinhvien_hocphan WHERE MaLopHP='".$maLop."'";
        $resultLop = $conn->query($findLop);
        if($resultLop->num_rows > 0){
            $findNameClass = "SELECT * FROM lophocphan WHERE MaLopHP='".$maLop."'";
            $resultNameClass = $conn->query($findNameClass);
            $rowNameClass = $resultNameClass-> fetch_assoc();
            $data= "
            <html>
                <head>
                    <link rel='stylesheet' href='style.css'>
                </head>
                <body>
                    <div class='block'>
                        <div class='block-top'>
                            <div class='block-logo'>
                                <img src='../shared/img/vlute_icon96.png'>
                            </div>
                            <div class='block-title'>
                                <h3>PHIẾU ĐIỂM ĐỒ ÁN</h3>
                            </div>
                            <div class='block-right'></div>
                        </div>
                        <div class='block-info'>
                            <p class='text'>Tên lớp học phần: <strong>".$rowNameClass['TenLop']."</strong></p>
                            <p class='text'>Mã lớp học phần: ".$maLop."</p>           
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>TT</th>
                                    <th>MÃ SV</th>
                                    <th>HỌ VÀ TÊN</th>
                                    <th>Điểm học phần</th>
                                    <th>Thang điểm chữ</th>
                                    <th>Ký tên</th>
                                    <th>Ghi chú</th>
                                </tr>
                                <tbody>";
                                $count = 1;
            while($rowLop = $resultLop-> fetch_assoc()){
                $findSV = "SELECT * FROM sinhvien WHERE Mssv='".$rowLop['Mssv']."'";
                $resultSV = $conn->query($findSV);              
                
                $rowSV = $resultSV-> fetch_assoc();
                $data .= "<tr>
                <td>".$count."</td>
                <td>".$rowSV['Mssv']."</td>
                <td>".$rowSV['HoTen']."</td>
                <td>".$rowLop['DiemSo']."</td>
                <td>".$rowLop['DiemChu']."</td>
                <td></td>
                <td></td>
                </tr>";
                $count++;
            }
            $data .="</tbody>
                            </thead>
                        </table>
                        <p class='date'>Vĩnh long, ngày &emsp;&emsp; tháng &emsp;&emsp; năm</p>
                        <p><strong>Trưởng khoa&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; 
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Giáo viên giảng dạy</strong></p>
                    </div>
                    
                </body>
            </html>";
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->WriteHTML($data);
            $mpdf->Output();
        }else{
            $findNameClass = "SELECT * FROM lopluanvan WHERE MaLopLV='".$maLop."'";
            $resultNameClass = $conn->query($findNameClass);
            $rowNameClass = $resultNameClass-> fetch_assoc();
            $data= "
            <html>
                <head>
                    <link rel='stylesheet' href='style.css'>
                </head>
                <body>
                    <div class='block'>
                        <div class='block-top'>
                            <div class='block-logo'>
                                <img src='../shared/img/vlute_icon96.png'>
                            </div>
                            <div class='block-title'>
                                <h3>PHIẾU ĐIỂM ĐỒ ÁN</h3>
                            </div>
                            <div class='block-right'></div>
                        </div>
                        <div class='block-info'>
                            <p class='text'>Tên lớp học phần: <strong>".$rowNameClass['TenLop']."</strong></p>
                            <p class='text'>Mã lớp học phần: ".$maLop."</p>           
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>TT</th>
                                    <th>MÃ SV</th>
                                    <th>HỌ VÀ TÊN</th>
                                    <th>Điểm CTHD</th>
                                    <th>Điểm CBHD</th>
                                    <th>Điểm GVPB</th>
                                    <th>Điểm trung bình</th>
                                    <th>Ký tên</th>
                                    <th>Ghi chú</th>
                                </tr>
                                <tbody>";
                                $count = 1;
            $findLop = "SELECT * FROM sinhvien_luanvan WHERE MaLopLV='".$maLop."'";
            $resultLop = $conn->query($findLop);
            if($resultLop->num_rows > 0){
                while($rowLop = $resultLop-> fetch_assoc()){
                    $findSV = "SELECT * FROM sinhvien WHERE Mssv='".$rowLop['Mssv']."'";
                    $resultSV = $conn->query($findSV);              
                    
                    $rowSV = $resultSV-> fetch_assoc();
                    $data .= "<tr>
                    <td>".$count."</td>
                    <td>".$rowSV['Mssv']."</td>
                    <td>".$rowSV['HoTen']."</td>
                    <td>".$rowLop['DiemCTHD']."</td>
                    <td>".$rowLop['DiemCBHD']."</td>
                    <td>".$rowLop['DiemPB']."</td>
                    <td>".$rowLop['DiemTB']."</td>
                    <td></td>
                    <td></td>
                    </tr>";
                    $count++;
                }
                $data .="</tbody>
                                </thead>
                            </table>
                            <p class='date'>Vĩnh long, ngày &emsp;&emsp; tháng &emsp;&emsp; năm</p>
                            <p><strong>Trưởng khoa&emsp;&emsp;&emsp;&emsp;&emsp;&emsp; 
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
                            &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Giáo viên giảng dạy</strong></p>
                        </div>
                        
                    </body>
                </html>";
                $mpdf = new \Mpdf\Mpdf();
                $mpdf->WriteHTML($data);
                $mpdf->Output();
            }
            
        }
        
        
    }
    
?>
