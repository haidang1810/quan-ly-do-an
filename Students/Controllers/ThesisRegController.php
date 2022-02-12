<?php
    include("../../Models/ThesisRegModels.php");
    include("../../../public/config.php");
    global $conn;
    if (session_id() === '')
        session_start();

    echo "<div>
    <form method='POST'>";
    echo "<select name='HKNH' class='select_hknh'>";
    if(isset($_POST['search'])){
        if(isset($_POST['HKNH'])) {
            $id = $_POST['HKNH'];
            loadHKNH($conn,$id);
        }   
            
    }
    else if(isset($_SESSION['HKNH'])){
        loadHKNH($conn,$_SESSION['HKNH']);
    }
    else
        loadHKNH($conn);
    echo "</select>";
    echo "<input type='button' name='search' value='Tìm kiếm' class='button_search'>";
    echo "</form>
    </div>";


    

    
?>