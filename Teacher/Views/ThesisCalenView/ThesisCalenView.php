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
                                        <?php
                                            $MaLop = $_SESSION['LLV'];
                                            $findLop = "SELECT * FROM lopluanvan WHERE MaLopLV='".$MaLop."'";
                                            $resultLop = $conn->query($findLop);
                                            $rowLop = $resultLop->fetch_assoc();

                                            $findHD = "SELECT * FROM hoidong WHERE ThuKy='".$rowLop['MaGV']."'";
                                            $resultHD = $conn->query($findHD);
                                            if($resultHD->num_rows > 0){
                                                while($rowHD = $resultHD->fetch_assoc()){
                                                    $findCTHD = "SELECT * FROM giangvien WHERE MaGV='".$rowHD['ChuTich']."'";
                                                    $resultCTHD = $conn->query($findCTHD);
                                                    $rowCTHD = $resultCTHD-> fetch_assoc();
                                                    echo "<li>Chủ tịch: ".$rowCTHD['HoTen']."</li>";
                                    
                                                    $findTK = "SELECT * FROM giangvien WHERE MaGV='".$rowHD['ThuKy']."'";
                                                    $resultTK = $conn->query($findTK);
                                                    $rowTK = $resultTK-> fetch_assoc();
                                                    echo "<li>Thư ký: ".$rowTK['HoTen']."</li>";
                                    
                                                    $findPB = "SELECT * FROM giangvien WHERE MaGV='".$rowHD['PhanBien']."'";
                                                    $resultPB = $conn->query($findPB);
                                                    $rowPB = $resultPB-> fetch_assoc();
                                                    echo "<option value='".$rowHD['MaHD']."' title='Chủ tịch: ".$rowCTHD['HoTen']
                                                    ."\n Thư ký: ".$rowTK['HoTen']."\n Phản biện: ".$rowPB['HoTen']."'>".$rowHD['MaHD']."</option>";                                            
                                                }
                                            }
                                        ?>
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
                                <input type="submit" value="Lưu" name="SaveCalen">
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
            $('#tableCalen').DataTable({
                "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ]
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
            $(".calen_select_Add").chosen({
                allow_single_deselect: true,
                no_results_text: "Không tìm thấy kết quả :",
                width: "70%"
            });
        </script>
    </body>
</html>