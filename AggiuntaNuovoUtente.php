<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ristorante";

$connessione = mysqli_connect($host, $user, $pass);
$db_selected = mysqli_select_db($connessione, $dbname);

if ($connessione->connect_errno) {
    echo "Errore in connessione al DBMS: " . $connessione->error;
}

if($_POST != null) {
    $user = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM utenti WHERE username='$user'";
    $result = $connessione->query($query);
	
    if($result->num_rows == 1)
        echo "<script> window.location.href= 'AggiuntaNuovoUtente.php?alert=Username gia' esistente';</script>";
    else {
<<<<<<< HEAD
        $query2 = "INSERT INTO utenti(username, password) VALUES ('". $username ."', '" . $password ."')";
        $result = $connessione->query($query);
        if($result != null)
            header("Location: utenti.php?messaggio=Utente inserito con successo!");
=======
        $query2 = "INSERT INTO utenti(username, password) VALUES ('$user', '$password')";
        $result = $connessione->query($query2);
        if($result)
			echo "<script> window.location.href= 'utenti.php?messaggio=Utente inserito con successo!';</script>";
>>>>>>> 5cd3488194591105dea1f53e84bc62cdad06cf40
        else
			echo "<script> window.location.href= 'utenti.php?alert=Errore nell'inserimento!';</script>";
    }
}

include 'menu.php';
?>
<html>
<body id="body">
<<<<<<< HEAD
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
=======
<div class="container py-5">
    <div class="card">
		
        <?php
        if(isset($_GET['alert'])) {
            ?>
            <br><div class="alert alert-warning">
                <strong>Warning! </strong> <?php echo $_GET['alert']; ?>
            </div>
            <?php
        }
        ?>
        <div class="card-body">
            <div class="container">
				<div class="row">
					<div class="col-md-3"><br></div>
					<div class="col-md-6">
						<h1 class="card-title text-center">Inserisci nuovo utente</h1>
						<hr>
						<form class="form-horizontal" role="form" id="formAddUtente" method="post">
							<div class="col-lg-10 col-lg-offset-0">
								<div class="form-group">
									<label for="firstName" class="col-sm-3 control-label">Username</label>
									<div class="col-sm-9">
										<input type="text" name="username" placeholder="Username" class="form-control" autofocus>
									</div>
								</div>
								<div class="form-group">
									<label for="password" class="col-sm-3 control-label">Password</label>
									<div class="col-sm-9">
										<input type="password" name="password" placeholder="Password" class="form-control">
									</div>
								</div>
								<hr>
								<button onclick="document.getElementById('formAddUtente').submit();" class="btn btn-primary center-block" type="button" style="width: 50%; ">
								<?php if(isset($idImportante)) echo "Aggiorna"; else echo "Aggiungi"; ?>
								</button>
							</div>
						</form>
					</div>
				</div>
            </div>
>>>>>>> 5cd3488194591105dea1f53e84bc62cdad06cf40
        </div>
    </div>
</body>
</html>
