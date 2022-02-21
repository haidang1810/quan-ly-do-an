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
                <h2>Danh sách học kỳ năm học</h2>
                <button class="btn_add" onclick="showAddModal()">
                    <i class="fas fa-plus"></i>&nbsp;Thêm
                </button>
                <?php include("../../Controllers/SemesterController.php"); ?>
                <div class="modal">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Thêm học kỳ - năm học</h2>
                                <div class="close">+</div>
                            </div>
                            <form method="POST">
                                <div class="form_field">
                                    <select name='hoc_ky' class="form_input">
                                        <option value="Học kỳ I">Học kỳ I</option>
                                        <option value="Học kỳ phụ">Học kỳ phụ</option>
                                        <option value="Học kỳ II">Học kỳ II</option>
                                        <option value="Học kỳ hè">Học kỳ hè</option>
                                    </select>
                                    <label for="hk" class="form_label">Học kỳ</label>
                                </div>
                                <div class="form_field">
                                    <input type="number" name="NamBD" id="StartYear" onchange="getYear()" class="form_input"
                                    <?php 
                                        $date = getdate();
                                    echo "min='".$date['year']."' value='".$date['year']."' "; ?>
                                    onkeydown="return false">
                                    <label for="StartYear" class="form_label">Năm học</label>
                                    <span class="dec">-</span>
                                    <input type="number" name="NamKT" id="EndYear" class="form_input input_right" readonly
                                    <?php 
                                        $date = getdate();
                                        $value = $date['year']+1;
                                    echo "min='".$value."' value='".$value."'"; ?>>
                                    
                                </div>
                                <div class="form_field">
                                    <input type="date" name="NgayBD" class="form_input">
                                    <label for="dayBD" class="form_label">Ngày bắt đầu</label>
                                </div>
                                <div class="form_field">
                                    <input type="date" name="NgayKT" class="form_input">
                                    <label for="dayKT" class="form_label">Ngày kết thúc</label>
                                </div>
                                <input type="submit" value="Thêm học kỳ" name="addSemester">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal_edit">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Cập nhật học kỳ năm học</h2>
                                <div class="close close_edit">+</div>
                            </div>
                            <form method="POST">
                                <input type="hidden" id="editId_hknh" name="id_hknh">
                                <div class="form_field">
                                    <select name='hoc_ky' id="editHK" class="form_input">
                                        <option value="Học kỳ I">Học kỳ I</option>
                                        <option value="Học kỳ phụ">Học kỳ phụ</option>
                                        <option value="Học kỳ II">Học kỳ II</option>
                                        <option value="Học kỳ hè">Học kỳ hè</option>
                                    </select>
                                    <label for="hk" class="form_label">Học kỳ</label>
                                </div>
                                <div class="form_field">
                                    <input type="number" name="NamBD" id="editStartYear" onchange="getYearEdit()" class="form_input"
                                    <?php 
                                        $date = getdate();
                                    echo "min='".$date['year']."' value='".$date['year']."' "; ?>
                                    onkeydown="return false">
                                    <label for="StartYear" class="form_label">Năm học</label>
                                    <span class="dec">-</span>
                                    <input type="number" name="NamKT" id="editEndYear" class="form_input input_right" readonly
                                    <?php 
                                        $date = getdate();
                                        $value = $date['year']+1;
                                    echo "min='".$value."' value='".$value."'"; ?>>
                                    
                                </div>
                                <div class="form_field">
                                    <input type="date" name="NgayBD" id="editNgayBD" class="form_input">
                                    <label for="dayBD" class="form_label">Ngày bắt đầu</label>
                                </div>
                                <div class="form_field">
                                    <input type="date" name="NgayKT" id="editNgayKT" class="form_input">
                                    <label for="dayKT" class="form_label">Ngày kết thúc</label>
                                </div>
                                <input type="submit" value="Cập nhật" name="editSemster">
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
                
        </div>
        <?php
            include("../shared/footer.php");
        ?>
        
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="../../../public/chosen/chosen.jquery.js"></script>
        <script src="../../../public/chosen/chosen.jquery.min.js"></script>
        <script src="SemesterView.js"></script>
        <script>
            $('#tableSemster').DataTable({
                "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ]
            });
        </script>
    </body>
</html>