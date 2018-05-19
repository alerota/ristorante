<html>
<head>
    <link href="style/calendar.css" type="text/css" rel="stylesheet" />
    <?php
    if(isset($_GET["date"]))
        echo "<style> 
					#calendar { position: absolute; left: calc(50% - 525px); }
					.header .title { width: calc(100% - 100px); }
				</style>";

    ?>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="style/css/bootstrap.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <style>
        body {
            background-color: white;
        }
        .navbar {
            margin-bottom: 0px !important;
        }
    </style>
</head>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="index.php">Ristorante</a>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <?php
                if(!isset($_COOKIE['login'])) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/">Sale</a>
                    </li>
                    <?php
                }
                    if(isset($_COOKIE['login'])) {
                    ?>
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="prenotazioni.php">Prenotazioni</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="utenti.php">Utenti</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="clienti.php">Clienti/Storico</a>
                        </li>
                    </ul>
                    <?php
                    }
                    ?>
            </ul>
            <?php
                if(isset($_COOKIE['login'])) {
                    ?>
                    <ul class="navbar-nav navbar-right">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Bentornato <?php echo $_COOKIE['login']; ?>, Logout</a>
                        </li>
                    </ul>
                    <?php
                }
                else {
                    ?>
                    <ul class="navbar-nav navbar-right">
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login<span class="sr-only"></span></a>
                        </li>
                    </ul>
                    <?php
                }
            ?>
        </div>
    </div>
    </nav>
