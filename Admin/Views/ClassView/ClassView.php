<html>
    <head>
        <title>Quản lý lớp</title>
        <link rel="stylesheet" href="style.css">
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
        <link rel="stylesheet" href="../../../public/datatable/jquery.dataTables.min.css">
        <link rel="stylesheet" href="../../../public/chosen/chosen.min.css">
    </head>
    <body>
        <div class="main">
            <?php
                include("../shared/menu.php");
                include("../shared/nav.php");
            ?>
            <div class="content">
                <h2>Danh sách lớp học phần</h2>
                <button class="btn_add" onclick="showAddClass()">
                    <i class="fas fa-plus"></i>&nbsp;Thêm
                </button>
                <?php include("../../Controllers/ClassController.php"); ?>
                <div class="modal">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Thêm lớp học phần</h2>
                                <div class="close">+</div>
                            </div>
                            <form method="POST">
                                <div class="form_field">
                                    <input type="text" name="MaLopHP" class="form_input">
                                    <label for="lhp" class="form_label">Mã lớp học phần</label>
                                </div>
                                <div class="form_field">
                                    <input type="text" name="TenLop" class="form_input">
                                    <label for="ht" class="form_label">Tên lớp</label>
                                </div>
                                <div class="form_select">
                                    <select name="MaGV" class='select_AddClass'>
                                        <?php                                            
                                            $findGV = "SELECT * FROM giangvien";
                                            $resultGV = $conn->query($findGV);
                                            if ($resultGV->num_rows > 0) {
                                                while($rowGV = $resultGV->fetch_assoc()){
                                                    echo "<option value='".$rowGV['MaGV']."'>".$rowGV['MaGV'].": ".$rowGV['HoTen']."</option>";                                            
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <input type="submit" value="Thêm lớp" name="addClass">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal_edit">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Cập nhật lớp học phần</h2>
                                <div class="close close_edit">+</div>
                            </div>
                            <form method="POST">
                                <input type="hidden" id="editMaLop" name="MaLop">
                                <div class="form_field">
                                    <input type="text" name="TenLop" id="editTen" class="form_input">
                                    <label for="ht" class="form_label">Tên lớp</label>
                                </div>
                                <div class="form_select">
                                    <select name="MaGV" id="editGV" class='select_AddClass'>
                                        <?php                                            
                                            $findGV = "SELECT * FROM giangvien";
                                            $resultGV = $conn->query($findGV);
                                            if ($resultGV->num_rows > 0) {
                                                while($rowGV = $resultGV->fetch_assoc()){
                                                    echo "<option value='".$rowGV['MaGV']."'>".$rowGV['MaGV'].": ".$rowGV['HoTen']."</option>";                                            
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <input type="submit" value="Cập nhật" name="editClass">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal_GV">
                    <div class="modal_overlay"></div>
                    <div class="modal_body modal_GV_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Thông tin chi tiết giảng viên viên</h2>
                                <div class="close close_GV">+</div>
                            </div>
                            <ul>
                                <li id="MaGV"></li>
                                <li id="HoTen"></li>
                                <li id="Gmail"></li>
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
        <script src="ClassView.js"></script>
        <script>
        $('#tableClass').DataTable({
            "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ]
        });
        </script>
        <script>
            $(".select_AddClass").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :",
                width: "70%"
            });
            $(".select_hknh").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :",
                width: "20%"
            });
        </script>
    </body>
</html>