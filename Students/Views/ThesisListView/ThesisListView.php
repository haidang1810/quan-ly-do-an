<html>
    <head>
        <title>Danh sách lớp học phần</title>
        <link rel="stylesheet" href="style.css">
        <script src="../../../public/jquery-ui/jquery-3.3.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    </head>
    <body>
        <div class="main">
            <?php
                include("../shared/menu.php");
                include("../shared/nav.php");
            ?>
            <div class="content">
                <div class="tabs">
                    <h2>Danh sách lớp đã đăng ký</h2>
                    <input id="tab1" type="radio" name="tabs" checked>
                    <label for="tab1" class="tab1">Gần đây</label>
                    <input id="tab2" type="radio" name="tabs">
                    <label for="tab2" class="tab2">Tất cả</label>
                    <div class="search-box" id="search-box">
                        <input type="text" placeholder="Tìm kiếm..." class="input-search" id="input-search"/>
                        <button type="button" class="btn-search">
                            <i class="fas fa-search"></i>
                        </button> 
                    </div>
                    <section class="content-tab">
                        <?php include("../../Controllers/ThesisListController.php"); ?>
                    </section>
                </div>
            </div>
            <?php
                include("../shared/footer.php");
            ?>
        </div>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="ThesisListView.js"></script>        
    </body>
</html>