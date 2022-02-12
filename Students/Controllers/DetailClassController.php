<?php
    include("../../Models/DetailClassModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();
    if(isset($_SESSION['DetailClass'])){
        loadData($conn,$_SESSION['DetailClass']);
        saveHistory($conn,$_SESSION['DetailClass']);
    }else{
        header("location: ../../Views/ClassListView/ClassListView.php");
    }
?>