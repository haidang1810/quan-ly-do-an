<?php
    
    include("../../Models/ThesisClassModel.php");
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
    echo "<input type='submit' name='search' value='Tìm kiếm' class='button_search'>";
    echo "</form>
    </div>";
    
    //table data
    echo "<div class='table'>";
    echo "<table id='tableClass'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Mã lớp</th>";
    echo "<th>Tên lớp</th>";
    echo "<th>Thao tác</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    if (session_id() === '')
        session_start();
    if(isset($_POST['search'])&&!isset($_POST['showStudentList'])&&isset($_POST['HKNH'])){
        $hknh = $_POST['HKNH'];
        loadLopLV($conn,$hknh);
    }else if(isset($_SESSION['HKNH'])&&!isset($_POST['showStudentList'])){
        loadLopLV($conn,$_SESSION['HKNH']);
    }

    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    if(isset($_POST['showStudentList'])){
        if(!empty($_POST['MaLopLV'])){
            $_SESSION['ShowStudentThesis']=$_POST['MaLopLV'];
            unset($_SESSION['ShowStudent']);
            header("location: ../../Views/StudentListView/StudentListView.php");
        }
    }
    
    
?>
