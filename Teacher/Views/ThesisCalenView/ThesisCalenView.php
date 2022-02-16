<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
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
                <h2>Xếp lịch bảo vệ</h2>
                <?php include("../../Controllers/ThesisCalenController.php"); ?>
                <div class="modal">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Xếp lịch bảo vệ</h2>
                                <div class="close">+</div>
                            </div>
                            <form method="POST">
                                <div class="form_select">
                                    <input type="hidden" id="editMaLich" name="MaLich">
                                    <input type="hidden" id="editMssv" name="Mssv">
                                    <select name="HoiDong" id="editMaHD" class='calen_select_Add'>
                                        
                                    </select>
                                </div>
                                <div class="form_field">
                                    <input type="datetime-local" id="editLan1" name="Lan1" class="form_input">
                                    <label for="L1" class="form_label">Bảo vệ lần 1</label>
                                </div>
                                <div class="form_field">
                                    <input type="datetime-local" id="editLan2" name="Lan2" class="form_input">
                                    <label for="L2" class="form_label">Bảo vệ lần 2</label>
                                </div>
                                <button type='button' class="btn-save-calen">Cập nhật</button>                              
                            </form>
                        </div>
                    </div>
                </div>                
                <div class="modal modal_SV">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Thông tin chi tiết sinh viên</h2>
                                <div class="close close_SV">+</div>
                            </div>
                            <ul>
                                <li id="Mssv"></li>
                                <li id="HoTen"></li>
                                <li id="NgaySinh"></li>
                                <li id="SDT"></li>
                                <li id="DiaChi"></li>
                                <li id="Khoa"></li>
                                <li id="Lop"></li>
                            </ul>                            
                        </div>
                    </div>
                </div>
            </div>
            <?php
                include("../shared/footer.php");
            ?>
        </div>
        <script src="ThesisCalenView.js"></script>
        
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="../../../public/chosen/chosen.jquery.js"></script>
        <script src="../../../public/chosen/chosen.jquery.min.js"></script>     
        <script>
            $(".dsHKNH").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :",
                width: "20%"
            });
            $(".dsLop").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :",
                width: "20%"
            });
            
        </script>
    </body>
</html>