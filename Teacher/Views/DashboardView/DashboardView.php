<html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="main">
            <?php
                include("../shared/menu.php");
                include("../shared/nav.php");
            ?>
            <div class="content">
            <h2>Thống kê</h2>
                <?php include("../../Controllers/DashboardController.php"); ?>          
                
                
            </div>
            <?php
                include("../shared/footer.php");
            ?>
        </div>
        
    </body>
</html>