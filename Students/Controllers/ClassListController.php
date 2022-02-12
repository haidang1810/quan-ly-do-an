<?php
    include("../../Models/ClassListModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();
?>