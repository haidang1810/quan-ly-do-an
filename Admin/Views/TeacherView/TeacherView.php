<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="../../../public/datatable/jquery.dataTables.min.css">
        
    </head>
    <body>
        <div class="main">
            <?php
                include("../shared/menu.php");
                include("../shared/nav.php");
            ?>
            <div class="content">
                <h2>Quản lý giảng viên</h2>
                <ul class="tab" id="tab">
                    <li><a href="#" class="tab_link" onclick="openTab(event,0)">Giảng viên</a></li>
                    <li><a href="#" class="tab_link" onclick="openTab(event,1)">Tài khoản</a></li>
                </ul>
                <?php include("../../Controllers/TeacherController.php"); ?>   
                
            </div>
            <?php
                include("../shared/footer.php");
            ?>
        </div>
        <script src="TeacherView.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script>
        $('#tableTeacher').DataTable({
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