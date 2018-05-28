<?php

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
    </head>

    <body id="body">
    <div class="container py-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title text-center">Lista storico clienti</h1>
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
                        }
						else
							$nascondi = true;
                        ?>
                        </tbody>
                    </table>
					<?php
					if($nascondi)
					{
						echo "<script> document.getElementById('table').style.display = 'none'; </script>";
						echo "<p style='text-align: center;'>Non sono presenti records.</p>";
					}
					?>
                </div>
            </div>
        </div>
    </body>
</html>