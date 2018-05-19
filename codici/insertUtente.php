<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ristorante";

$connessione = new mysqli($host, $user, $pass, $dbname);

if ($connessione->connect_errno) {
    echo "Errore in connessione al DBMS: " . $connessione->error;
}

if($_POST != null) {
    $username = ($_POST['username']);
    $password = md5($_POST['pass']);
    $result = $connessione->query("SELECT * FROM utenti WHERE username='$username' AND password='$password'");

    if ($result->num_rows != 1) {
        $result1 = $connessione->query("INSERT INTO utenti (username, password) VALUES('$username','$password')");
        header("Location: utenti.php?messaggio=Utente inserito con successo");
    }
    else
        header("Location: insertUtente.php?msg=Username gia' esistente");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <title>Login</title>
        <meta charset="UTF-8 ">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->
        <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="css/util.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <!--===============================================================================================-->
    </head>
</head>
<body>
<?php
include 'menu.php';
?>
<div class="container py-5">
    <?php
        if(isset($_GET['msg'])) {
            ?>
            <div class="alert alert-warning">
                <strong>Warning! </strong> <?php echo $_GET['msg']; ?>
            </div>
            <?php
        }
    ?>
    <div class="card">
        <div class="card-body">
<h1 class="card-title text-center">Inserisci utente</h1>
        <form class="login100-form validate-form" method="post" action="insertUtente.php">
            <div class="wrap-input100 validate-input m-b-26" data-validate="Username richiesto">
                <span class="label-input100">Username</span>
                <input class="input100" type="text" name="username" placeholder="Inserire username">
                <span class="focus-input100"></span>
            </div>

            <div class="wrap-input100 validate-input m-b-18" data-validate = "Password richiesto">
                <span class="label-input100">Password</span>
                <input class="input100" type="password" name="pass" placeholder="Inserire password">
                <span class="focus-input100"></span>
            </div>

            <div class="container-login100-form-btn">
                <button class="login100-form-btn">
                    Inserisci
                </button>
            </div>
        </form>
        </div>
    </div>
</div>


<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/daterangepicker/moment.min.js"></script>
<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="js/main.js"></script>

</body>
</html>
