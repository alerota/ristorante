<html>
	<head>
	</head>
	<body>
		<?php
        session_start();
        include 'menu.php';

        if(isset($_SESSION['user'])) {
            echo "Sono l'admin";
        }
        else {
        include 'calendar.php';
        $calendar = new Calendar();
        echo $calendar->show();

        if(isset($_GET["date"]))
            include 'check.php';
        }
        ?>


	</body>
</html>    
