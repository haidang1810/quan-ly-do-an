<?php
  include '../../../public/config.php';
  global $conn;
  $malhp=$_POST['mahp'];
  $tdn=$_POST['tdn'];
  $msv=$_POST['msv'];
  $mtd=$_POST['mtd'];
  $target_dir = $_POST['target_dir'];
  $loaiLop = $_POST['loaiLop'];
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
    //Upload file
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $tgd="$malhp/$tdn/$msv/";
    
    $msg = "";
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) 
    {
        $dd= $tgd . basename($_FILES["file"]["name"]);
        $date = getdate();
        $gio=$date["hours"]+6;
        $time = $date['year']."-" .$date['mon']."-" .$date['mday']." " .$gio.":" .$date['minutes'].":" .$date['seconds'];
        if($loaiLop=='hocphan'){
            $sql = "INSERT INTO nopbaichitiet (Ma, Mssv, File, ThoiGianNop) VALUES ('".$mtd."','".$msv."','".$dd."','".$time."')";
            if (mysqli_query($conn, $sql)){
                $msg = "<script>
                        Swal.fire({
                            title: 'Đã lưu!',
                            text: 'Bạn đã upload thành công.',
                            icon: 'success',
                            didClose: ()=>{
                                window.location.href = window.location.href;
                            }
                        })
                    </script>";
            }else
                $msg = "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi...',
                                text: 'Lỗi khi lưu vào cơ sở dữ liệu!',
                                didClose: ()=>{
                                    window.location.href = window.location.href;
                                }
                            })
                        </script>";
        }else{
            $sql = "INSERT INTO nopluanvanct (Ma, Mssv, File, ThoiGianNop) VALUES ('".$mtd."','".$msv."','".$dd."','".$time."')";
            if (mysqli_query($conn, $sql)){
                $msg = "<script>
                Swal.fire({
                    title: 'Đã lưu!',
                    text: 'Bạn đã upload thành công.',
                    icon: 'success',
                    didClose: ()=>{
                        window.location.href = window.location.href;
                    }
                })
            </script>";
            }else
            $msg = "<script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Lỗi khi lưu vào cơ sở dữ liệu!',
                didClose: ()=>{
                    window.location.href = window.location.href;
                }
            })
        </script>";
        }
        
    }
    else
    { 
        $msg = "<script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi...',
                text: 'Lỗi khi upload file!',
                didClose: ()=>{
                    window.location.href = window.location.href;
                }
            })
        </script>"; 
    }
    echo $msg;
?>