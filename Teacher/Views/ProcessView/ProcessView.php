<html>
    <head>
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
                <h2>Tiến độ đồ án</h2>
                <button class="btn_add" onclick="showAddProcess()">
                    <i class="fas fa-plus"></i>&nbsp;Thêm
                </button>
                <?php include("../../Controllers/ProcessController.php"); ?>
                <div class="modal">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Thêm tiến độ</h2>
                                <div class="close">+</div>
                            </div>
                            <form method="POST">
                                <input type="text" class="TieuDe" placeholder="Tiêu đề">
                                <textarea class="GhiChu" id="addNote" rows="7" cols="70" placeholder="Ghi Chú"></textarea>
                                
                                <div class="form_field">
                                    <input type="datetime-local" class="form_input ThoiGianBD">
                                    <label for="BD" class="form_label">Thời gian bắt đầu</label>
                                </div>
                                <div class="form_field">
                                    <input type="datetime-local"  class="form_input ThoiGianKT">
                                    <label for="KT" class="form_label">Thời gian kết thúc</label>
                                </div>
                                <div>
                                    <input type="checkbox" class="SanPham" id="cbSP">
                                    <label for="cbSP" class="label-checkbox">Nộp sản phầm cuối kỳ</label>
                                </div>
                                
                                <button type='button' class="btn-add-process">Thêm đề tài</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal_edit">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Cập nhật tiến độ</h2>
                                <div class="close close_edit">+</div>
                            </div>
                            <form method="POST">
                                <input type="hidden" class="Id" id="editID">
                                <input type="text" class="TieuDe" id="editTitle" placeholder="Tiêu đề">
                                <textarea class="GhiChu" id="editNote" rows="7" cols="70" placeholder="Ghi Chú"></textarea>
                                
                                <div class="form_field">
                                    <input type="datetime-local" id="editBD" class="form_input ThoiGianBD">
                                    <label for="BD" class="form_label">Thời gian bắt đầu</label>
                                </div>
                                <div class="form_field">
                                    <input type="datetime-local" id="editKT" class="form_input ThoiGianKT">
                                    <label for="KT" class="form_label">Thời gian kết thúc</label>
                                </div>  
                                <button type='button' class="btn-edit-process">Cập nhật tiến độ</button>                              
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
        <script src="ProcessView.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="../../../public/chosen/chosen.jquery.js"></script>
        <script src="../../../public/chosen/chosen.jquery.min.js"></script>
        
        <script>
            $('#tableDetail').DataTable({
                "lengthMenu": [ 5, 10, 15, 20]
            });
        </script>
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
            $(".select_AddProcess").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :",
                width: "70%"
            });
        </script>
    </body>
</html>