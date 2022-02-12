<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
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
                <h2>Danh sách hội đồng</h2>
                <button class="btn_add" onclick="showAddCouncil()">
                    <i class="fas fa-plus"></i>&nbsp;Thêm
                </button></br>
                <?php include("../../Controllers/CouncilController.php"); ?>
                <div class="modal">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Thêm hội đồng</h2>
                                <div class="close">+</div>
                            </div>
                            <form method="POST">
                                <input type="text" name="MaHD" placeholder="Nhập mã hội đồng">
                                <div class="block_select">
                                    <select name="CTHD" class='select_Council select_add_CTHD'>
                                        <option value="">Chọn chủ tịch hội đồng</option>
                                        <?php
                                            $findGV = "SELECT * FROM giangvien WHERE HocVi='Thạc sĩ'";
                                            $resulGV = $conn->query($findGV);
                                            if ($resulGV->num_rows > 0) {
                                                while($rowGV = $resulGV->fetch_assoc()){
                                                    echo "<option value='".$rowGV['MaGV']."'>".$rowGV['MaGV']." ".$rowGV['HoTen']."</option>";                                            
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="block_select">
                                    <select name="CBHD" class='select_Council select_add_CBHD'>
                                        <option value="">Chọn cán bộ hướng dẫn</option>
                                        <?php
                                            $findGV = "SELECT * FROM giangvien WHERE HocVi='Thạc sĩ'";
                                            $resulGV = $conn->query($findGV);
                                            if ($resulGV->num_rows > 0) {
                                                while($rowGV = $resulGV->fetch_assoc()){
                                                    echo "<option value='".$rowGV['MaGV']."'>".$rowGV['MaGV']." ".$rowGV['HoTen']."</option>";                                            
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="block_select">
                                    <select name="GVPB" class='select_Council select_add_GVPB'>
                                        <option value="">Chọn giảng viên phản biện</option>
                                        <?php
                                            $findGV = "SELECT * FROM giangvien WHERE HocVi='Thạc sĩ'";
                                            $resulGV = $conn->query($findGV);
                                            if ($resulGV->num_rows > 0) {
                                                while($rowGV = $resulGV->fetch_assoc()){
                                                    echo "<option value='".$rowGV['MaGV']."'>".$rowGV['MaGV']." ".$rowGV['HoTen']."</option>";                                            
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <input type="submit" value="Thêm hội đồng" name="addCouncil">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal modal_edit">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Cập nhật hội đồng</h2>
                                <div class="close close_edit">+</div>
                            </div>
                            <form method="POST">
                                <input type="hidden" id="editMaHD" name="MaHD">
                                <div class="block_select block_select_top">
                                    <select name="CTHD" id="editCTHD" class='select_Council select_edit_CTHD'>
                                        <option value="">Chọn chủ tịch hội đồng</option>
                                        <?php
                                            $findGV = "SELECT * FROM giangvien WHERE HocVi='Thạc sĩ'";
                                            $resulGV = $conn->query($findGV);
                                            if ($resulGV->num_rows > 0) {
                                                while($rowGV = $resulGV->fetch_assoc()){
                                                    echo "<option value='".$rowGV['MaGV']."'>".$rowGV['MaGV']." ".$rowGV['HoTen']."</option>";                                            
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="block_select">
                                    <select name="CBHD" id="editCBHD" class='select_Council select_edit_CBHD'>
                                        <option value="">Chọn cán bộ hướng dẫn</option>
                                        <?php
                                            $findGV = "SELECT * FROM giangvien WHERE HocVi='Thạc sĩ'";
                                            $resulGV = $conn->query($findGV);
                                            if ($resulGV->num_rows > 0) {
                                                while($rowGV = $resulGV->fetch_assoc()){
                                                    echo "<option value='".$rowGV['MaGV']."'>".$rowGV['MaGV']." ".$rowGV['HoTen']."</option>";                                            
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="block_select">
                                    <select name="GVPB" id="editGVPB" class='select_Council select_edit_GVPB'>
                                        <option value="">Chọn giảng viên phản biện</option>
                                        <?php
                                            $findGV = "SELECT * FROM giangvien WHERE HocVi='Thạc sĩ'";
                                            $resulGV = $conn->query($findGV);
                                            if ($resulGV->num_rows > 0) {
                                                while($rowGV = $resulGV->fetch_assoc()){
                                                    echo "<option value='".$rowGV['MaGV']."'>".$rowGV['MaGV']." ".$rowGV['HoTen']."</option>";                                            
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <input type="submit" value="cập nhật" name="editCouncil">
                            </form>
                        </div>
                    </div>
                </div>                
            </div>
            <?php
                include("../shared/footer.php");
            ?>
        </div>    
        <script src="CouncilView.js"></script>            
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="../../../public/chosen/chosen.jquery.js"></script>
        <script src="../../../public/chosen/chosen.jquery.min.js"></script>
        <script>
            $('#tableCouncil').DataTable({
                "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ],            
            });
            $(".select_add_CTHD").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :"
                
            });
            $(".select_add_CBHD").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :"
            });
            $(".select_add_GVPB").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :"
            });
            $(".select_edit_CTHD").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :"
            });
            $(".select_edit_CBHD").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :"
            });
            $(".select_edit_GVPB").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :"
            });
        </script>       
    </body>
</html>