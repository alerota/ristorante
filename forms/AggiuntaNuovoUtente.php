<?php
if(!isset($_COOKIE["login"])) {
    echo '<script> window.location.href= "http://prenotazioni.ristorante-almolo13.com/index.php";</script>';
    exit();
}
else {
    ?>

    <?php
// Connessione al DB

    $host = "localhost";
    $user = "ristoran_pren";
    $pass = "szc[yPA-hIhB";
    $dbname = "ristoran_prenotazioni";
    $connessione = mysqli_connect($host, $user, $pass);
    $db_selected = mysqli_select_db($connessione, $dbname);


    if ($_GET != null) {
        $idImportante = $_GET["msg"];
        $sql = "select * from utenti where id = " . $idImportante . ";";

        $result = mysqli_query($connessione, $sql);

        $num_result = mysqli_num_rows($result);

        if ($num_result == 1) {
            $row = mysqli_fetch_array($result);
            $password = $row["password"];
            $user = $row["username"];
        } else
            echo "<script>alert('Problemi durante il caricamento, chiedere assistenza...');</script>";


    }
    include '../menu.php';
    ?>
    <html>
    <body id="body">
    <div class="container py-5">
        <div class="card">

            <?php
            if (isset($_GET['alert'])) {
                ?>
                <br>
                <div class="alert alert-warning">
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
                            <h1 class="card-title text-center"><?php if ($_GET != null) echo "Modifica utente n°" . $idImportante; else echo "Inserimento utente"; ?></h1>
                            <hr>
                            <form class="form-horizontal" id="utente" method="post"
                                  action="<?php if ($_GET != null) echo "../codici/update/updateUtente.php?id=" . $idImportante; else echo "../codici/insert/insertUtente.php"; ?>">
                                <div class="col-lg-10 col-lg-offset-0">
                                    <div class="form-group">
                                        <label for="firstName" class="col-sm-3 control-label">Username</label>
                                        <div class="col-sm-9">

                                            <input type="text" name="username" placeholder="Username"
                                                   class="form-control" <?php if ($_GET != null) echo "value='" . $user . "'"; ?>>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-sm-3 control-label">Password</label>
                                        <div class="col-sm-9">
                                            <input type="password" name="password" placeholder="Password"
                                                   class="form-control" <?php if ($_GET != null) echo "value='" . $password . "'"; ?>>
                                        </div>
                                    </div>
                                    <hr>
                                    <button onclick="document.getElementById('utente').submit();"
                                            class="btn btn-primary center-block" type="button" style="width: 50%; ">
                                        <?php if ($_GET != null) echo "Aggiorna"; else echo "Aggiungi"; ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
    <?php
}
?>