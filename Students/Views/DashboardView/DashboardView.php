<html>
    <head>
        <link rel="stylesheet" href="style.css">
        <title>Trang chủ</title>
        <script src="../../../public/jquery-ui/jquery-3.3.1.min.js"></script>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css' />
    </head>
    <body>
        <div class="main">
            <?php
                include("../shared/menu.php");
                include("../shared/nav.php");
            ?>
            <div class="content">
            <h2>Lịch</h2>
                <?php include("../../Controllers/DashboardController.php"); 
                    echo"<div class='container'>";
                    echo"<div id='calendar'>";
                    echo"</div>";
                    echo"</div>";
                ?>          
                
                
            </div>
            <?php
                include("../shared/footer.php");
            ?>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
        <script></script>
        <script>
            var element = document.getElementById('calendar');
            if(element!=null){
                $(document).ready(function() {
                    var calendar = $('#calendar').fullCalendar({
                        header: {
                            left: 'prev, today',
                            center: 'title',
                            right: 'next'
                        },
                        timeZone: 'local',
                        events: 'load.php',
                        height: 500
                    });
                });  
            }
        </script>
    </body>
</html>