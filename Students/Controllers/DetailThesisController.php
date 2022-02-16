<?php
    include("../../Models/DetailThesisModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();
    if(isset($_SESSION['DetailThesis'])){
        loadData($conn,$_SESSION['DetailThesis']);
        saveHistory($conn,$_SESSION['DetailThesis']);
    }else{
        header("location: ../../Views/ThesisListView/ThesisListView.php");
    }
?>