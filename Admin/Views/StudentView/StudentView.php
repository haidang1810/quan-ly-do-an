<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="../../../public/datatable/jquery.dataTables.min.css">
        
    </head>
    <body>
        <div class="main">
            <?php
                include("../shared/menu.php");
                include("../shared/nav.php");
            ?>
            <div class="content">
            <h2>Quản lý sinh viên</h2>
            <ul class="tab" id="tab">
                <li><a href="#" class="tab_link" onclick="openTab(event,0)">Sinh viên</a></li>
                <li><a href="#" class="tab_link" onclick="openTab(event,1)">Tài khoản</a></li>
            </ul>
            <?php include("../../Controllers/StudentController.php"); ?>   
            <div class="modal">
                <div class="modal_overlay"></div>
                    <div class="modal_body">
                        <div class="modal_inner">
                            <div class="modal_title">
                                <h3>Xác nhận mật khẩu</h3>
                                <div class="close">+</div>
                            </div>
                            <input type="hidden" id="currentPass">
                            <input type="hidden" id="rowShow">                            
                            <input type="password"  id="pass" placeholder="Nhập mật khẩu của bạn">
                            <button onclick="showPass()">Xác nhận</button>
                        </div>
                    </div>
                </div> 
                
            </div>
            <?php
                include("../shared/footer.php");
            ?>
        </div>
        <script src="StudentView.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script>
        $('#tableStudent').DataTable({
            "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ]
        });
        </script>
        <script>
        $('#tableAccount').DataTable({
            "lengthMenu": [ 5, 10, 15, 20, 25, 30, 40, 50 ]
        });        
        </script>
    </body>
</html>