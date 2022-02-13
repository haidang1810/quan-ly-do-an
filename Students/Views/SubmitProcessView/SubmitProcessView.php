<html>
    <head>
        <title>Danh sách lớp học phần</title>
        <link rel="stylesheet" href="style.css">
        <script src="../../../public/jquery-ui/jquery-3.3.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
        <script src="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
        <link rel="stylesheet" href="../../../public/sweetalert2/node_modules/sweetalert2/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="../../../public/datatable/jquery.dataTables.min.css">
        <link href="../../../public/dropzone/dist/min/dropzone.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    </head>
    <body>
        <div class="main">
            <?php
                include("../shared/menu.php");
                include("../shared/nav.php");
            ?>
            <div class="content">
                <?php include("../../Controllers/SubmitProcessController.php"); ?>
            </div>
            <?php
                include("../shared/footer.php");
            ?>
        </div>
        <script src="../../../public/dropzone/dist/min/dropzone.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
        <script src="SubmitProcessView.js"></script>
        <script>
            var elementDropzone = document.getElementById('myDropzone');
            if(elementDropzone!=null){
                Dropzone.autoDiscover = false;
                var myDropzone = new Dropzone(".dropzone", { 
                    autoProcessQueue: false,
                    parallelUploads: 20 // Number of files process at a time (default 2)
                });
                var elementUpload= document.getElementById('uploadfiles');
                if(elementUpload!=null){
                    $('#uploadfiles').click(function(){
                        myDropzone.processQueue();
                    });
                }
            }
        </script>
    </body>
</html>