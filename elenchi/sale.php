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
            <?php
            if(isset($_GET['messaggio'])) {
            ?>
            <div class="alert alert-success">
                <strong>Success! </strong> <?php echo $_GET['messaggio']; ?>
            </div>
            <?php
            }
            if(isset($_GET['alert'])) {
                ?>
                <div class="alert alert-warning">
                    <strong>Warning! </strong> <?php echo $_GET['alert']; ?>
                </div>
                <?php
            }
                ?>
            <h1 class="card-title text-center">Lista sale <a href="../forms/AggiuntaNuovaSala.php" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span></a></h1>
            <br><br>
            <table id="table">
                <thead>
                <tr>
                    <th>Id sala</th>
                    <th>Nome sala</th>
                    <th>Posti prenotabili</th>
                    <th>Edit</th>
                    <th>Canc</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $query = "SELECT * FROM sale";
                $result = $connessione->query($query);
                $numrows = $result->num_rows;

                if ($numrows) {
					$nascondi = false;
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <?php
                            echo "<td>" . $row['id_sala'] . "</td>";
                            echo "<td>" . $row['Nome_sala'] . "</td>";
                            echo "<td>" . $row['Numero_posti_prenotabili'] . "</td>";
                            ?>
                            <td>
                                <a href="../forms/AggiuntaNuovaSala.php?id=<?php echo $row['id_sala'] ?>">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                            </td>
                            <td>
                                <a href="../codici/delete/deleteSala.php?id=<?php echo $row['id_sala']; ?>">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
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
</body>
</html>
