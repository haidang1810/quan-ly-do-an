<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <form method="POST" enctype='multipart/form-data'>
        <input type="file" name="file">
        <input type="submit" value="submit" name='submit'>
    </form>
</body>
</html>
<?php
    include("../../public/config.php");
    global $conn;
    include("../../public/vendor/autoload.php");
    if(isset($_POST['submit'])){
        if($_FILES["file"]["name"] != ''){
            $allowed_extension = array('xls', 'csv', 'xlsx');
            $file_array = explode(".", $_FILES["file"]["name"]);
            $file_extension = end($file_array);

            if(in_array($file_extension, $allowed_extension)){
                $file_name = time() . '.' . $file_extension;
                move_uploaded_file($_FILES['file']['tmp_name'], $file_name);
                $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

                $spreadsheet = $reader->load($file_name);

                unlink($file_name);

                $data = $spreadsheet->getActiveSheet()->toArray();
                $error = "";
                $success = 0;
                $i=1;
                foreach($data as $row){
                    if($i==1){
                        $i++;
                        continue;
                    }
                    
                    $mssv = $row[0];
                    $sql = "INSERT INTO sinhvien_hocphan(Mssv, MaLopHP) VALUES('$mssv','204_1TH1509_03')";
                    if(mysqli_query($conn, $sql)){
                        $success++;
                    }else{
                        $error.=" $i";
                    }
                    $i++;
                }
                echo "Đã thêm thành công $success row";
                echo " Hàng lỗi:$error";
            }
        }
    }
?>