<?php
if(!isset($_COOKIE["login"])) {
    echo '<script> window.location.href= "http://localhost/ristorante/index.php";</script>';
    exit();
}
else {
    ?>
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "ristorante";

    $connessione = new mysqli($host, $user, $pass, $dbname);

    if ($connessione->connect_errno) {
    echo "Errore in connessione al DBMS: " . $connessione->error;
    }
    include '../menu.php';
    ?>
    <html>
    <head>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#table').DataTable();
            });
        </script>
        <?php
        if (!isset($_GET['msg'])) {
            echo '<style type="text/css">
		#warning-message { display: none; }
		@media only screen and (orientation:portrait){
			#wrapper { display:none; }
			#warning-message { display:block; }
		}
		@media only screen and (orientation:landscape){
			#warning-message { display:none; }
		}
		</style>';
        } else
            echo '<style> #warning-message { display:none; } </style>';
        ?>
    </head>

    <body id="body">
    <div class="container">
        <div class="row">
            <div class="col-md-3"><br></div>
            <div class="col-md-6">
                <h1 class="text-center">Lista storico clienti</h1>
                <br><br>
                <table id="table">
                    <thead>
                    <tr>
                        <th>Nome Cliente</th>
                        <th>Numero di telefono</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = "SELECT * FROM storico";

                    $result = $connessione->query($query);
                    $numrows = $result->num_rows;

                    if ($numrows) {
                        $nascondi = false;
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <?php
                                echo "<td>" . $row['nome_cliente'] . "</td>";
                                echo "<td>" . $row['tel_cliente'] . "</td>";
                                ?>
                            </tr>
                            <?php
                        }
                    } else
                        $nascondi = true;
                    ?>
                    </tbody>
                </table>
                <?php
                if ($nascondi) {
                    echo "<script> document.getElementById('table').style.display = 'none'; </script>";
                    echo "<p style='text-align: center;'>Non sono presenti records.</p>";
                }
                ?>
            </div>
            <div class="col-md-3"><br></div>
        </div>
    </div>
    <div id="warning-message">
        <br>
        <div class="alert alert-warning">
            <h3><strong>Attenzione!</strong> Questa pagina è visualizzabile solo se orienti il cellulare in orizzontale
            </h3>
        </div>
    </div>
    </body>
    </html>
    <?php
}
?>