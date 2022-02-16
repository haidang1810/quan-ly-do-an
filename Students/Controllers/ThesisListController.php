<?php
    include("../../Models/ThesisListModel.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();
?>