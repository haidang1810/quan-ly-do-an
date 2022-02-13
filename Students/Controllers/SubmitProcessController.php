<?php
    include("../../Models/SubmitProcessModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();

    loadData($conn);

    
    
?>