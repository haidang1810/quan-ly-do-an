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
                <h2>Danh sách đề tài khoá luận</h2>
                <button class="btn_add" onclick="showAddTopic()">
                    <i class="fas fa-plus"></i>&nbsp;Thêm
                </button>
                <?php include("../../Controllers/ThesisTopicControll.php"); ?>    
                <div class="modal">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <ul class="tab" id="tab">
                                <li><a href="#" class="tab_link" onclick="openTab(event,0)">Thêm</a></li>
                                <li><a href="#" class="tab_link" onclick="openTab(event,1)">Thêm nhiều</a></li>
                            </ul>
                            <div class="close">+</div>
                            <div class="tab_content">                                
                                <form method="POST">
                                    <input type="text" class="TenDeTai" placeholder="Tên đề tài">
                                    <textarea class="GhiChu" rows="7" cols="70" placeholder="Ghi Chú"></textarea>
                                    <div class="block_select_SV">
                                    <select name="Mssv" class='select_AddTopic selectAdd_Mssv'>
                                        <option value='-1'>Chọn sinh viên</option>
                                        <?php
                                            $findSV = "SELECT * FROM sinhvien";
                                            $resultSV = $conn->query($findSV);
                                            if($resultSV->num_rows > 0){
                                                while($rowSV = $resultSV->fetch_assoc()){
                                                    echo "<option value='".$rowSV['Mssv']."'>".$rowSV['Mssv']." ".$rowSV['HoTen']."</option>";                                            
                                                }
                                            }
                                        ?>
                                    </select>
                                    </div>
                                    <button type='button' class="btn-add-topic">Thêm đề tài</button>
                                </form>
                            </div>
                            <div class="tab_content">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="file" name="file">    </br>   
                                    <select name="LopLV" class='select_AddTopic selectAdd_Lop'>
                                        <?php
                                            if (session_id() === '')
                                                session_start();
                                            if(isset($_SESSION['login'])){
                                                $data = $_SESSION['login'];
                                            }
                                            $findND = "SELECT MaGV FROM giangvien WHERE TaiKhoan='".$data."'";
                                            $resultND = $conn->query($findND);
                                            if ($resultND->num_rows > 0) {
                                                $rowND = $resultND->fetch_assoc();
                                                $findLop = "SELECT * FROM lopluanvan WHERE MaGV='".$rowND['MaGV']."'";
                                                $resultLop = $conn->query($findLop);
                                                if($resultLop->num_rows > 0){
                                                    while($rowLop = $resultLop->fetch_assoc()){
                                                        echo "<option value='".$rowLop['MaLopLV']."'>".$rowLop['MaLopLV']." ".$rowLop['TenLop']."</option>";                                            
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>                             
                                    <input type="submit" value="Thêm đề tài" name="multiAdd">
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="modal modal_edit">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Cập nhật đề tài</h2>
                                <div class="close close_edit">+</div>
                            </div>
                            <form method="POST">
                                <input type="hidden" id="editMaDT" name="MaDT">
                                <input type="text" id="editTen" name="TenDeTai" placeholder="Tên đề tài">
                                <textarea name="GhiChu" id="editGhiChu" rows="7" cols="70" placeholder="Ghi Chú"></textarea>
                                <button type='button' class="btn-edit-topic">Cập nhật</button>
                            </form>
                        </div>
                    </div>
                </div>            
                <div class="modal modal_detail">
                    <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h2>Thông tin chi tiết sinh viên</h2>
                                <div class="close close_detail">+</div>
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
        <script src="ThesisTopicView.js"></script>        
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
            $(".selectAdd_Lop").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :",
                width: "70%",
            });
            $(".selectAdd_Mssv").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :",
                width: "70%"
            });
        </script>
    </body>
</html>