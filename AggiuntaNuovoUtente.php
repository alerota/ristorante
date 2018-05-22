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
        $query2 = "INSERT INTO utenti(username, password) VALUES ('". $username ."', '" . $password ."')";
        $result = $connessione->query($query);
        if($result != null)
            header("Location: utenti.php?messaggio=Utente inserito con successo!");
        else
            header("Location: utenti.php?alert=Errore nell'inserimento!");
    }
}

include 'menu.php';
?>
<html>
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
            <h1 class="card-title text-center">Inserisci nuovo utente</h1>
            <form action="AggiuntaNuovoUtente.php" method="POST" class="form-horizontal">
                <div class="col-lg-10 col-lg-offset-0">
                    <div class="form-group">
                        <label for="username" class="col-sm-3 control-label">Username</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-9 col-sm-offset-3">
                            <input id="submit" name="submit" type="submit" value="Inserisci" class="btn btn-primary" >
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
