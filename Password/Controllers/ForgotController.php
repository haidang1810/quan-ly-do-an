<?php
    include("../../Models/ForgotModel.php");
    include("../../../public/config.php");
    global $conn;

    if(isset($_POST['Forgot'])){
        if(isset($_POST['username']) && !empty($_POST['username'])){
            $username = $_POST['username'];
            forgotPass($conn, $username);
        }
    }
?>