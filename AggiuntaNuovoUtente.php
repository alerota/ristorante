<html>
<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ristorante";

$connessione = new mysqli($host, $user, $pass, $dbname);

if ($connessione->connect_errno) {
    echo "Errore in connessione al DBMS: " . $connessione->error;
}

if(isset($_POST['submit'])) {
    $user = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM utenti WHERE username='$user'";
    $result = $connessione->query($query);
    if($result->num_rows == 1)
        header("Location: AggiuntaNuovoUtente.php?alert=Username gia' esistente");
    else {
        $query2 = "INSERT INTO utenti(username, password) VALUES ('$username', '$password')";
        $result = $connessione->query($query);
        if($result != null)
            header("Location: utenti.php?messaggio=Utente inserito con successo!");
        else
            header("Location: utenti.php?alert=Errore nell'inserimento!");
    }
}
else {
include 'menu.php';
?>
<body id="body">
<div class="container py-5">
    <div class="card">
        <?php
        if(isset($_GET['alert'])) {
            ?>
            <div class="alert alert-warning">
                <strong>Warning! </strong> <?php echo $_GET['alert']; ?>
            </div>
            <?php
        }
        ?>
        <div class="card-body">
            <h1 class="card-title text-center">Inserisci nuovo utente</h1>
            <div class="container">
                <form class="form-horizontal" role="form" id="form" action="" method="post">
                    <div class="col-lg-10 col-lg-offset-0">
                        <div class="form-group">
                            <label for="firstName" class="col-sm-3 control-label">Username</label>
                            <div class="col-sm-9">
                                <input type="text" name="username" placeholder="Username"
                                       class="form-control" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" placeholder="Password"
                                       class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-9 col-sm-offset-3">
                                <input type="submit" value="Inserisci">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php
}