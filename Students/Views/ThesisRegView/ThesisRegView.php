<html>
    <head>
        <title>Đăng ký lớp khoá luận</title>
        <link rel="stylesheet" href="style.css">
        <script src="../../../public/jquery-ui/jquery-3.3.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="../../../public/chosen/chosen.min.css">
        <link rel="stylesheet" href="../../../public/datatable/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    </head>
    <body>
        <div class="main">
            <?php
                include("../shared/menu.php");
                include("../shared/nav.php");
            ?>
            <div class="content">
                <h2>Danh sách lớp khoá luận</h2>
                <?php include("../../Controllers/ThesisRegController.php"); ?>
                <div class='table table-class'></div>
            </div>
            <?php
                include("../shared/footer.php");
            ?>
        </div>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="../../../public/chosen/chosen.jquery.js"></script>
        <script src="ThesisRegView.js"></script>
        <script>
            
            $(".select_hknh").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :",
                width: "20%"
            });
        </script>
    </body>
</html>