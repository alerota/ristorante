<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "ristorante";

$connessione = new mysqli($host, $user, $pass, $dbname);

if ($connessione->connect_errno) {
    echo "Errore in connessione al DBMS: " . $connessione->error;
}
include 'menu.php';
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
        <link rel="stylesheet" type="text/css" href="css/datatable.css"/>
        <script src="js/confirmation.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

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
                        <br><div class="alert alert-success">
                            <strong>Success! </strong> <?php echo $_GET['messaggio']; ?>
                        </div>
                        <?php
                    }
                    if(isset($_GET['alert'])) {
                        ?>
                        <br><div class="alert alert-warning">
                            <strong>Warning! </strong> <?php echo $_GET['alert']; ?>
                        </div>
                        <?php
                    }
                    else if(isset($_GET['msg'])) {
                        $id = $_GET['msg'];
                        $query = "DELETE FROM utenti WHERE id='$id'";

                        $result = $connessione->query($query);

                        if($result)
                            echo "<script> window.location.href= 'utenti.php?messaggio=Utente cancellato con successo!';</script>";
                        else
                            echo "<script> window.location.href= 'utenti.php?alert=Errori nella cancellazione';</script>";
                    }
                    else {
                    ?>
                        <h1 class="card-title text-center">Lista utenti <a href="AggiuntaNuovoUtente.php" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span></a></h1>

                        <br><br>
                        <table id="table">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Username</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $query = "SELECT * FROM utenti";

                            $result = $connessione->query($query);
                            $numrows = $result->num_rows;

                            if ($numrows) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <?php
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";

                                        if($_COOKIE['login'] != $row['username']) {
                                        ?>
                                        <td>
                                            <a href="AggiuntaNuovoUtente.php?msg=<?php echo $row['id']; ?>">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                        </td>
                                        <td>
                                            <a onclick="document.getElementById('idSupporto').value=<?php echo $row['id']; ?>;" class="confirm">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a>
                                        </td>
                                        <?php
                                        }
                                        else{
                                            ?>
                                        <td></td>
                                        <td></td>
                                        <?php
                                        }
                                        ?>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                        <input type="hidden" value="" id="idSupporto"/>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    $(".confirm").confirm({
        content: "",
        title: "Sei sicuro di voler cancellare?",
        buttons: {
            confirm: {
                action: function () {
                    var a = document.getElementById("idSupporto").value;
                    window.location.href = "utenti.php?msg=" + a;
                },
                text: 'Si',
                btnClass: 'btn-danger',
            },
            cancel: {
                action: function () {
                },
                text: 'Annulla',
                btnClass: 'btn-default',
            }
        }
    });
</script>
