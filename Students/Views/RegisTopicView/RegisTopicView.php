<html>
    <head>
        <title>Danh sách lớp học phần</title>
        <link rel="stylesheet" href="style.css">
        <script src="../../../public/jquery-ui/jquery-3.3.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.css">
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
                <?php include("../../Controllers/RegisTopicController.php"); ?>
                <div class='modal hide modal-offers'>
                    <div class='modal__inner modal-offers-inner'>
                        <div class='modal__header modal-offers-header'>
                            <p>Đề xuất đề tài</p>
                            <i class='fas fa-times'></i>
                        </div>
                        <form method='POST' class='modal-offers-form'>
                        <div class='modal__body'>
                            <h2>Nhập thông tin đề tài</h2>
                            
                                <div class="form_field">
                                    <input type="text" name="tenDT" class="form_input">
                                    <label for="ten" class="form_label">Tên đề tài</label>
                                </div>
                                <div class="form_field">
                                    <textarea name="GhiChu" rows="7" cols="70" class="form_input"></textarea>
                                    <label for="ten" class="form_label">Ghi chú</label>
                                </div>
                                
                                <div class="form_field">
                                    <input type="number" name="STV" class="form_input" min='1'>
                                    <label for="sl" class="form_label">Số thành viên</label>
                                </div>
                            
                        </div>
                        <div class='modal__footer modal-offers-footer'>
                            <input type="submit" name='offers-topic' value="Đề xuất">
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
        <script src="RegisTopicView.js"></script>  
        <script>
            $('#tableTopic').DataTable({
            "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ],
            });
        </script>      
    </body>
</html>