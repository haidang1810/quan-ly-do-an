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
                <h2 id='titleTopic'>Quản lý đề tài </h2>
                <button class="btn_add" onclick="showAddTopic()">
                    <i class="fas fa-plus"></i>&nbsp;Thêm
                </button>
                <?php include("../../Controllers/TopicController.php"); ?>
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
                                    <input type="number" class="SoThanVien" placeholder="Số thành viên">
                                    <textarea class="GhiChu" rows="7" cols="70" placeholder="Ghi Chú"></textarea>
                                    <button type='button' class="btn-add-topic">Thêm đề tài</button>
                                </form>
                            </div>
                            <div class="tab_content">
                                <form method="POST" enctype="multipart/form-data">
                                    <input type="file" name="file">
                                    <select name="LopHP" class='select_AddTopic'>
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
                                                $findLop = "SELECT * FROM lophocphan WHERE MaGV='".$rowND['MaGV']."'";
                                                $resultLop = $conn->query($findLop);
                                                if($resultLop->num_rows > 0){
                                                    while($rowLop = $resultLop->fetch_assoc()){
                                                        echo "<option value='".$rowLop['MaLopHP']."'>".$rowLop['MaLopHP']." ".$rowLop['TenLop']."</option>";                                            
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
                            <form name="edit" method="POST">
                                <input type="text" id="nameEdit" name="TenDeTai" placeholder="Tên đề tài">
                                <input type="number" id="AmountEdit" name="SoThanVien" placeholder="Số thành viên" readonly>  
                                <input type="hidden" id="idEdit" name="MaDeTai">     
                                <textarea name="GhiChu" id ="noteEdit" rows="9" cols="70" placeholder="Ghi Chú"></textarea>                        
                                <button type='button' class="btn-edit-topic">Cập nhật đề tài</button>
                            </form>
                        </div>
                    </div>
                </div>                
            </div>
            <?php
                include("../shared/footer.php");
            ?>
        </div>    
        <script src="TopicView.js"></script>    
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>        
        <script src="../../../public/chosen/chosen.jquery.js"></script>
        <script src="../../../public/chosen/chosen.jquery.min.js"></script>
        <script>
        $(".topic_select").chosen({
            allow_single_deselect: true,
            no_results_text: "Không tìm thấy kết quả :"
        });
        $(".select_class").chosen({
            allow_single_deselect: true,
            no_results_text: "Không tìm thấy kết quả :",
            width: "20%"
        });
        $(".select_AddTopic").chosen({
            allow_single_deselect: true,
            no_results_text: "Không tìm thấy kết quả :",
            width: "70%"
        });
        </script>
        
    </body>
</html>