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
                <?php
                if(isset($_GET['messaggio'])) {
                    ?>
                    <div class="alert alert-warning">
                        <strong>Warning! </strong> <?php echo $_GET['messaggio']; ?>
                    </div>
                    <?php
                }

                if(isset($_GET['msg'])) {
                    ?>
                    <h1 class="card-title text-center">Prenotazione n° <?php echo $_GET['msg']; ?></h1>

                    <?php
                    $id = $_GET['msg'];
                    $query2 = "SELECT * FROM prenotazioni WHERE id_prenotazione='$id'";
                    $result2 = $connessione->query($query2);
                    $numrows2 = $result2->num_rows;

                    if($numrows2) {
                        while ($row2 = $result2->fetch_assoc()) {
                        ?>
                            <form>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="disabledTextInput">Cliente</label>
                                        <?php
                                        echo "<input type='text' class='form-control' placeholder='" . $row2['cliente'] . "' disabled>";
                                        ?>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="disabledTextInput">Telefono</label>
                                        <?php
                                        echo "<input type='text' class='form-control' placeholder='" . $row2['tel'] . "' disabled>";
                                        ?>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-2">
                                        <label for="disabledTextInput">Numero persone</label>
                                        <?php
                                        echo "<input type='text' class='form-control' placeholder='" . $row2['num_partecipanti'] . "' disabled>";
                                        ?>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="disabledTextInput">Giorno</label>
                                        <?php
                                        echo "<input type='text' class='form-control' placeholder='" . $row2['giorno'] . "' disabled>";
                                        ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="disabledTextInput">Ora</label>
                                        <?php
                                        echo "<input type='text' class='form-control' placeholder='" . $row2['orario'] . "' disabled>";
                                        ?>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label for="disabledTextInput">Sala</label>

                                        <?php
                                        $idsala = $row2['id_sala'];
                                        $query3 = "SELECT * FROM sale WHERE id_sala='$idsala'";
                                        $result3 = $connessione->query($query3);
                                        $numrows3 = $result3->num_rows;

                                        if ($numrows3) {
                                            while ($row3 = $result3->fetch_assoc())
                                                    echo "<input type='text' class='form-control' placeholder='" . $row3['id_sala'] ." - ". $row3['Nome_sala'] . "' disabled>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-10">
                                        <label for="comment">Note</label>
                                        <?php
                                            echo "<textarea class='form-control' rows='5' disabled>" .$row2['note_prenotazione'] ."</textarea>";
                                        ?>
                                    </div>
                                </div>
                            </form>
                        <?php
                        }
                    }
                }
                else if(isset($_GET['msg1'])) {
                    $id = $_GET['msg1'];
                    $query = "DELETE FROM prenotazioni WHERE id_prenotazione='$id'";

                    $result = $connessione->query($query);

                    header("Location: prenotazioni.php?messaggio=Cliente rimasto nella lista dei clienti");
                }
                else {
                ?>
                <h1 class="card-title text-center">Lista prenotazioni</h1>
                <br><br>
                <table id="table">
                    <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Telefono</th>
                        <th>Persone</th>
                        <th>Giorno</th>
                        <th>Orario</th>
                        <th>Sala</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    if(isset($_GET['date'])) {
                        $data = $_GET['date'];
                        $query = "SELECT * FROM prenotazioni WHERE giorno='$data'";
                    }
                    else
                        $query = "SELECT * FROM prenotazioni";

                    $result = $connessione->query($query);
                    $numrows = $result->num_rows;

                    if ($numrows) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <tr>
                                <?php
                                echo "<td>" . $row['cliente'] . "</td>";
                                echo "<td>" . $row['tel'] . "</td>";
                                echo "<td>" . $row['num_partecipanti'] . "</td>";
                                $date = new DateTime($row['giorno']);
                                echo "<td>" . $date->format('d-m-Y') . "</td>";
                                echo "<td>" . $row['orario'] . "</td>";

                                $query1 = "SELECT * FROM sale WHERE id_sala=" . $row['id_sala'];
                                $result1 = $connessione->query($query1);
                                $numrows1 = $result1->num_rows;
                                if ($numrows1) {
                                    while ($row1 = $result1->fetch_assoc())
                                        echo "<td>" . $row1['Nome_sala'] . "</td>";
                                }
                                ?>
                                <td>
                                    <a href="prenotazioni.php?msg=<?php echo $row['id_prenotazione'] ?>">
                                        <span class="glyphicon glyphicon-expand"></span>
                                    </a>
                                </td>
                                <td>
                                    <a href="prenotazioni.php?msg1=<?php echo $row['id_prenotazione']; ?>">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <?php
                }
                ?>
            </div>
        </div>
    </body>
</html>
