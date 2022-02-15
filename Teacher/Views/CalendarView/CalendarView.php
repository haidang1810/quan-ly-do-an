<html>
    <head>
        <title>Quản lý lớp</title>
        <link rel="stylesheet" href="style.css">
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="../../../public/chosen/chosen.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link rel="stylesheet" href="../../../public/datatable/jquery.dataTables.min.css">
    </head>
    <body>
        <div class="main">
            <?php
                include("../shared/menu.php");
                include("../shared/nav.php");
            ?>
            <div class="content">
                <h2>Xếp lịch báo cáo</h2>
                <button class="btn_add" onclick="showAddCalen()">
                    <i class="fas fa-plus"></i>&nbsp;Thêm
                </button>
                <?php include("../../Controllers/CalendarController.php"); ?>     
                <div class="modal">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Thêm lịch báo cáo</h2>
                                <div class="close">+</div>
                            </div>
                            <form name="edit" method="POST">
                                <div class="form_field">
                                    <input type="date"  class="form_input NgayBC">
                                    <label for="dayBC" class="form_label">Ngày báo cáo</label>
                                </div>
                                <div class="form_field">
                                    <input type="time"  class="form_input ThoiGianBD">  
                                    <label for="timeBC" class="form_label">Thời gian bắt đầu</label>
                                </div>
                                <div class="form_field">
                                    <input type="number"  min="0" class="form_input SoNhomBC">
                                    <label for="timeBC" class="form_label">Số nhóm báo cáo</label>
                                </div>                      
                                <button type='button' class="btn-add-calen">Thêm lịch</button>
                            </form>
                        </div>
                    </div>
                </div> 
                <div class="modal modal_edit">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Cập nhật lịch báo cáo</h2>
                                <div class="close close_edit">+</div>
                            </div>
                            <form name="edit" method="POST">
                                <div class="form_field">
                                    <input type="date" id="editDate" name="NgayBC" class="form_input">
                                    <label for="dayBC" class="form_label">Ngày báo cáo</label>
                                </div>
                                <div class="form_field">
                                    <input type="time" id="editTimeStart" name="ThoiGianBD" class="form_input">  
                                    <label for="timeBC" class="form_label">Thời gian bắt đầu</label>
                                </div>
                                <div class="form_field">
                                    <input type="number" id="editAmount" name="SoNhomBC" min="0" class="form_input">
                                    <label for="timeBC" class="form_label">Số nhóm báo cáo</label>
                                </div>
                                <input type="hidden" id='editHidden' name="id-edit">
                                <button type='button' class="btn-edit-calen">Cập nhật lịch</button>                              
                            </form>
                        </div>
                    </div>
                </div> 
                <div class="modal modal_view">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Thông tin chi tiết sinh viên</h2>
                                <div class="close close2">+</div>
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
            </div>
            <?php
                include("../shared/footer.php");
            ?>
        </div>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="../../../public/chosen/chosen.jquery.js"></script>
        <script src="../../../public/chosen/chosen.jquery.min.js"></script>
        <script src="CalendarView.js"></script>
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