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
                        <div class="alert alert-success">
                            <strong>Success! </strong> <?php echo $_GET['messaggio']; ?>
                        </div>
                        <?php
                    }

                    if(isset($_GET['msg'])) {
                        ?>

                        <h1 class="card-title text-center">Modifica utente n° <?php echo $_GET['msg']; ?></h1>
                        <?php
                    }
                    else if(isset($_GET['msg1'])) {
                        $id = $_GET['msg1'];
                        $query = "DELETE FROM utenti WHERE id='$id'";

                        $result = $connessione->query($query);

                        header("Location: utenti.php?messaggio=Utente cancellato con successo!");
                    }
                    else {
                    ?>
                        <h1 class="card-title text-center">Lista utenti <a href="insertUtente.php" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-plus"></span></a></h1>

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
                                            <a href="utenti.php?msg=<?php echo $row['id']; ?>">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="utenti.php?msg1=<?php echo $row['id']; ?>">
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
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
