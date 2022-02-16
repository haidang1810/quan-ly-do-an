<?php
    function loadCouncil($conn){
        $findHD = "SELECT * FROM hoidong";
        $resultHD = $conn->query($findHD);
        if($resultHD->num_rows > 0){
            while($rowHD = $resultHD-> fetch_assoc()){
                echo "<tr>";
                echo "<td>".$rowHD['MaHD']."</td>";

                $findCTHD = "SELECT * FROM giangvien WHERE MaGV='".$rowHD['ChuTich']."'";
                $resultCTHD = $conn->query($findCTHD);
                $rowCTHD = $resultCTHD-> fetch_assoc();
                echo "<td>".$rowCTHD['HoTen']."</td>";

                $findTK = "SELECT * FROM giangvien WHERE MaGV='".$rowHD['ThuKy']."'";
                $resultTK = $conn->query($findTK);
                $rowTK = $resultTK-> fetch_assoc();
                echo "<td>".$rowTK['HoTen']."</td>";

                $findPB = "SELECT * FROM giangvien WHERE MaGV='".$rowHD['PhanBien']."'";
                $resultPB = $conn->query($findPB);
                $rowPB = $resultPB-> fetch_assoc();
                echo "<td>".$rowPB['HoTen']."</td>";

                echo "<td>";
                echo "<form method='POST'class='form-delete'>";
                echo "<input type='hidden' name='deleteCouncil' value='".$rowHD['MaHD']."'>";
                echo "<button class='btn_topic btn_primary' id='".$rowHD['MaHD'].",".$rowHD['ChuTich'].",".$rowHD['ThuKy'].",".$rowHD['PhanBien']."' type='button' onclick='showEditCouncil(this.id)'><i class='fas fa-edit'></i></button>";  
                echo "<button class='btn_topic btn_danger'  type='submit'><i class='fas fa-trash-alt'></i></button>";
                echo "</form>";
                echo "</td>";

                echo "</tr>";
            }
        }
    }

    function addCouncil($conn, $maHD, $CTHD, $CBHD, $GVPB){
        $findHD = "SELECT * FROM hoidong WHERE MaHD='".$maHD."'";
        $resultHD = $conn->query($findHD);
        if ($resultHD->num_rows <= 0){
            $sql = "INSERT INTO hoidong 
            VALUES('".$maHD."','".$CTHD."','".$CBHD."','".$GVPB."')";
            if(mysqli_query($conn, $sql)){ 
                echo"
            <script>
                Swal.fire(
                    'Đã thêm!',
                    'Thêm hội đồng thành công.',
                    'success'
                )</script>";
            } else{
                echo"<script type='text/javascript'> alert('".mysqli_error($conn)."')</script>";
            }
        }else echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Hội đồng đã tồn tại!'
        })</script>";
        
        
    }
    function deleCouncil($MaHD,$conn){
        $findHD = "SELECT * FROM hoidong WHERE MaHD='".$MaHD."'";
        $resultHD = $conn->query($findHD);
        if ($resultHD->num_rows > 0){
            $sql = "DELETE FROM hoidong WHERE MaHD='".$MaHD."'";
            if(mysqli_query($conn, $sql)){  
                echo"
            <script>
                Swal.fire(
                    'Đã xoá!',
                    'Xoá hội đồng thành công.',
                    'success'
                )</script>";
            } else{
                echo"<script type='text/javascript'> alert('".mysqli_error($conn)."')</script>";
            }
        }
        else
        echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Lỗi...',
            text: 'Hội đồng đã tồn tại!'
        })</script>";
    }
    function editCouncil($MaHD, $CTHD, $CBHD, $GVPB, $conn){
        $findHD = "SELECT * FROM hoidong WHERE MaHD='".$MaHD."'";
        $resultHD= $conn->query($findHD);
        if($resultHD->num_rows > 0){
            $sql = "UPDATE hoidong SET ChuTich='".$CTHD."', ThuKY='".$CBHD."', PhanBien='".$GVPB."' WHERE MaHD='".$MaHD."'";
            if(mysqli_query($conn, $sql))
                
            echo"
            <script>
                Swal.fire(
                    'Đã lưu!',
                    'Cập nhật hội đồng thành công.',
                    'success'
                )</script>";
            else
                echo"<script type='text/javascript'> alert('".mysqli_error($conn)."')</script>";
        }      
    }

    function multiAdd($conn,$file,$class){
        $objReader = PHPExcel_IOFactory::createReaderForFile($file);
        $objReader->setLoadSheetsOnly("Sheet1");

        $objExcel = $objReader->load($file);
        $sheetData = $objExcel->getActiveSheet()->toArray("null",true,true,true);
        $success=0;
        $error = "";
        for($i=2;$i<=count($sheetData);$i++){
            $name = $sheetData[$i]['A'];
            $amount = $sheetData[$i]['B'];
            $note = $sheetData[$i]['C'];
            if(empty($name)||empty($amount)){
                $error.=$i." ";
                continue;
            }
                
            $findDT = "SELECT * FROM detai";
            $resultDT = $conn->query($findDT);
            $count = $resultDT->num_rows;
            if($count<9)
                $Ma="DT00".(string)($count+1);
            else if($count>=9 && $count<99)
                $Ma="DT0".(string)($count+1);
            else
                $Ma = "DT".(string)($count+1);        
            
            $sql = "INSERT INTO detai 
            VALUES('".$Ma."','".$name."','".$note."',".$amount.",'".$class."')";
            if(mysqli_query($conn, $sql)){
                $success++;
            }else
            {
                $error.=$i." ";
            }
        }
        if(empty($error))
        echo"
        <script>
            Swal.fire(
                'Đã lưu!',
                'Bạn đã thêm thành công ".$success." đê tài.',
                'success'
            )
        </script>";
    else
    echo"
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Đã thêm!',
                text: 'Bạn đã thêm thành công ".$success." đê tài.',
                footer: 'Các hàng bị lỗi: ".$error."'
            })
        </script>";
    }
?>