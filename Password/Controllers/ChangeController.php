<?php
    include("../../Models/ChangeModel.php");
    include("../../../public/config.php");
    global $conn;

    if(isset($_POST['Change'])){
        if(isset($_POST['user']) && !empty($_POST['user']))
            if(isset($_POST['Pass']) && !empty($_POST['Pass']))
                if(isset($_POST['newPass']) && !empty($_POST['newPass']))
                    if(isset($_POST['Confirm']) && !empty($_POST['Confirm'])){
                        $user = $_POST['user'];
                        $pass = $_POST['Pass'];
                        $newPas = $_POST['newPass'];
                        $confirm = $_POST['Confirm'];
                        changPass($conn,$user,$pass,$newPas,$confirm);
                    }
    }
?>