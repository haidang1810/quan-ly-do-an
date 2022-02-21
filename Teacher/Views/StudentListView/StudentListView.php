<html>
    <head>
        <title>Quản lý lớp</title>
        <link rel="stylesheet" href="style.css">
        <script src="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.css">
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
                <?php include("../../Controllers/StudentListController.php"); ?>                
                <div class="modal modal_editLV">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Cập nhật điểm</h2>
                                <div class="close close_editLV">+</div>
                            </div>
                            <form name="edit" method="POST">
                                <div class="form_field">
                                    <input type="number" id="editDiemCTHD" step="0.1" name="DiemCTHD" class="form_input"
                                    onchange="avgPoint()" min='0' max='10' step="0.01">
                                    <label for="editDiemCTHD" class="form_label">Điểm CTHD</label>
                                </div>
                                <div class="form_field">
                                    <input type="number" id="editDiemCBHD" step="0.1" onchange="avgPoint()" name="DiemCBHD" class="form_input" maxlength="2">
                                    <label for="editDiemCBHD" class="form_label">Điểm CBHD</label>
                                </div>  
                                <div class="form_field">
                                    <input type="number" id="editDiemGVPB" step="0.1" onchange="avgPoint()" name="DiemGVPB" class="form_input" maxlength="2">
                                    <label for="editDiemGVPB" class="form_label">Điểm GVPB</label>
                                </div> 
                                <div class="form_field">
                                    <input type="number" id="editDiemTB" name="DiemTB" step="0.1" class="form_input" disabled maxlength="2">
                                    <label for="editDiemTB" class="form_label">Điểm TB</label>
                                </div>     
                                <div class="form_field">
                                    <input type="text" id="editDiemChuLV" name="DiemChuLV" readonly class="form_input" maxlength="2">
                                    <label for="editDiemChuLV" class="form_label">Điểm chữ</label>
                                </div>     
                                <input type="hidden" id="editClassLV" name="MaLopLV">                  
                                <input type="hidden" id="editCodeLV" name="MssvLV">                  
                                <input type="submit" value="Cập nhật điểm" name="editScoreLV">
                            </form>
                        </div>
                    </div>
                </div>  
                <div class="modal modal_edit">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Cập nhật điểm</h2>
                                <div class="close close_edit">+</div>
                            </div>
                            <form name="edit" method="POST">
                                <div class="form_field">
                                    <input type="number" id="editDiemSo" name="DiemSo" class="form_input"
                                    onchange="subPoint(this.value)" min='0' max='10' step="0.1">
                                    <label for="editDiemSo" class="form_label">Điểm số</label>
                                </div>
                                <div class="form_field">
                                    <input type="text" id="editDiemChu" name="DiemChu" class="form_input" readonly maxlength="2">
                                    <label for="editDiemChu" class="form_label">Điểm chữ</label>
                                </div>    
                                <input type="hidden" id="editClass" name="MaLop">                  
                                <input type="hidden" id="editCode" name="Mssv">                  
                                <input type="submit" value="Cập nhật điểm" name="editScore">
                            </form>
                        </div>
                    </div>
                </div>  
            </div>
            <?php
                include("../shared/footer.php");
            ?>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="StudentListView.js"></script>
        <script>
        $('#table_student').DataTable({
            "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ]
        });
        $('#tableTopic').DataTable({
            "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ]
        });
        </script>        
    </body>
</html>