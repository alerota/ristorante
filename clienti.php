<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ristorante";

$connessione = new mysqli($host, $user, $pass, $dbname);

if ($connessione->connect_errno) {
    echo "Errore in connessione al DBMS: " . $connessione->error;
}

?>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="css/datatable.css"/>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#table').DataTable();
        });
    </script>
</head>

<body id="body">
<?php
include 'menu.php';
?>
<div class="container py-5">
    <div class="card">
        <div class="card-body">
                <h1 class="card-title text-center">Lista clienti</h1>
                <br><br>
                <table id="table">
                    <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Telefono</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = "SELECT * FROM storico";

                    $result = $connessione->query($query);
                    $numrows = $result->num_rows;

                    if ($numrows) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <?php
                                    echo "<td>" . $row['cliente'] . "</td>";
                                    echo "<td>" . $row['tel'] . "</td>";
                                ?>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
        </div>
    </div>
</body>
</html>