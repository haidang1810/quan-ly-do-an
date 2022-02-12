<?php 
    function login($username, $password, $conn) {
        $sql = "SELECT * FROM nguoidung WHERE TaiKhoan='".$username."' AND MatKhau='".$password."' AND TrangThai=1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }
        else {
            return null;
        }
    }
    

?>