<?php
    include("../../Models/SubmitProcessModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();

    if(!isset($_POST['Id_delete']))
        loadData($conn);

        
    if(isset($_POST['Id_delete'])){
        $id = $_POST['Id_delete'];
        deleteFile($conn,$id);
        loadData($conn);
    }
    
    
?>