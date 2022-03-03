<html>
    <head>
        <title>Chi tiết lớp khoá luận</title>
        <link rel="stylesheet" href="style.css">
        <script src="../../../public/jquery-ui/jquery-3.3.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    </head>
    <body>
        <div class="main">
            <?php
                include("../shared/menu.php");
                include("../shared/nav.php");
            ?>
            <div class="content">
                <?php include("../../Controllers/DetailThesisController.php"); ?>
                <div class='modal hide'>
                    <div class='modal__inner'>
                        <div class='modal__header'>
                            <p>Thông tin đề tài</p>
                            <i class='fas fa-times'></i>
                        </div>
                        <form method='POST' class='modal-form'>
                        <div class='modal__body'>
                            <div class="form_field">
                                <input readonly type="text" id="tenDT" class="form_input">
                                <label for="ten" class="form_label">Tên đề tài</label>
                            </div>
                            <div class="form_field">
                                <textarea readonly id="GhiChu" rows="7" cols="70" class="form_input"></textarea>
                                <label for="ten" class="form_label">Ghi chú</label>
                            </div>                            
                        </div>
                        <div class='modal__footer'>
                            <button class='btn-close'>Đóng</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php
                include("../shared/footer.php");
            ?>
        </div>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="DetailThesisView.js"></script>        
    </body>
</html>