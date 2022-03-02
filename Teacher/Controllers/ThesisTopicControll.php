<?php
    include("../../Models/ThesisTopicModel.php");
    include("../../../public/config.php");
    //require("../../../public/PHPExcel/Classes/PHPExcel.php");
    include("../../../public/vendor/autoload.php");
    global $conn;
    if (session_id() === '')
        session_start();

        
            
    echo "<div>
    <form method='POST'>";       
    echo "<select name='HKNH' class='topic_select dsHKNH'>";
    echo "<option value='-1'>Chọn lớp học kỳ năm học</option>";
    loadHKNH($conn);        
    echo "</select>";
    echo "<select name='lopLV' class=' topic_select dsLop'>";
    echo "<option value='-1'>Chọn lớp khoá luận</option>";
    echo "</select>";
    echo "<button name='search' type='button' class='topic_button_search'>Tìm kiếm</button>";    echo "</form>
    </div>";
    echo "<div class='table'>";
    
    
    
    if(isset($_POST['multiAdd'])){
        if(isset($_POST['LopLV'])){
            $lopLV = $_POST['LopLV'];
            $file = $_FILES['file']['tmp_name'];
            if(!empty($file)){
                multiAdd($conn,$file,$lopLV);
            }else echo "
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi...',
                    text: 'Chưa chọn file!'
                })
            </script>
            ";
        }        
    }


    

    
    echo "</div>";
?>