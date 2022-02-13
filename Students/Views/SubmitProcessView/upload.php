<?php
  include '../../../public/config.php';
  global $conn;
  $malhp=$_POST['mahp'];
  $tdn=$_POST['tdn'];
  $msv=$_POST['msv'];
  $mtd=$_POST['mtd'];
  $ht=$_POST['ht']; 

  // Upload directory
  
  if(file_exists($target_dir))
        {
            $target_dir = "../../../public/item/$malhp/$tdn/$msv/";
        }
        else 
        {
            mkdir("../../../public/item/$malhp/$tdn/$msv", 7);
            $target_dir = "../../../public/item/$malhp/$tdn/$msv/";
        }
        // Upload file
        $target_file = $target_dir . basename(["file"]["name"]);
        $tgd="$malhp/$tdn/$msv/";
        
        $msg = "";
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) 
        {
            $dd= $tgd . basename($_FILES["file"]["name"]);
            $msg = "Successfully uploaded";
            $date = getdate();
            $gio=$date["hours"]+6;
            $time = $date['year']."-" .$date['mon']."-" .$date['mday']." " .$gio.":" .$date['minutes'].":" .$date['seconds'];
            $sql = "INSERT INTO nopbaichitiet (Ma, Mssv, File, ThoiGianNop) VALUES ('".$mtd."','".$msv."','".$dd."','".$time."')";
            if ($result = $conn->query($sql)){
                $msg = "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi...',
                                text: 'Lỗi khi lưu vào cơ sở dữ liệu!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload()        
                                }
                            })
                        </script>";
                }
                else
                $msg = "<script>
                        Swal.fire(
                            'Đã thêm!',
                            'Bạn đã upload thành công.',
                            'success'
                        ).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload()        
                            }
                        })
                    </script>";
        }
        else
        { 
        $msg = "<script>
                    Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: data
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload()        
                        }
                    })
                </script>";
        }
        echo $msg;
?>