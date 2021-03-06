<?php

if(!isset($_COOKIE["login"])) {
    echo '<script> window.location.href= "http://prenotazioni.ristorante-almolo13.com/index.php";</script>';
    exit();
}
else {

    $host = "localhost";
    $user = "ristoran_pren";
    $pass = "szc[yPA-hIhB";
    $dbname = "ristoran_prenotazioni";

    $connessione = new mysqli($host, $user, $pass, $dbname);

    if ($connessione->connect_errno) {
        echo "Errore in connessione al DBMS: " . $connessione->error;
    }
    require_once '../menu.php';
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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <hr>
                <?php
                if (isset($_GET['messaggio'])) {
                    ?>
                    <div class="alert alert-warning">
                        <strong>Attenzione! </strong> <?php echo $_GET['messaggio']; ?>
                    </div>
                    <?php
                }

                if (isset($_GET['msg'])) {
                    ?>
                    <h1 class="text-center">Prenotazione da revisionare n° <?php echo $_GET['msg']; ?></h1>

                    <?php
                    $id = $_GET['msg'];
                    $query2 = "SELECT * FROM prenotazionidarevisionare WHERE id_prenotazione='$id'";
                    $result2 = $connessione->query($query2);
                    $numrows2 = $result2->num_rows;

                    if ($numrows2) {
                        while ($row2 = $result2->fetch_assoc()) {
                            ?>
                            <div class="container">
                                <form>
                                    <div class="form-row row">
                                        <div class='col-md-2'><br></div>
                                        <div class="form-group col-md-4">
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
                                        <div class='col-md-2'><br></div>
                                    </div>
                                    <div class="form-row row">
                                        <div class='col-md-2'><br></div>
                                        <div class="form-group col-md-2">
                                            <label for="disabledTextInput">Numero persone</label>
                                            <?php
                                            echo "<input type='text' class='form-control' placeholder='" . $row2['num_partecipanti'] . "' disabled>";
                                            ?>
                                        </div>
                                        <div class="form-group col-md-2">
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
                                                    echo "<input type='text' class='form-control' placeholder='" . $row3['id_sala'] . " - " . $row3['Nome_sala'] . "' disabled>";
                                            }
                                            ?>
                                        </div>
                                        <div class='col-md-2'><br></div>
                                    </div>
                                    <div class="form-row row">
                                        <div class='col-md-2'><br></div>
                                        <div class="form-group col-md-8">
                                            <label for="comment">Note</label>
                                            <?php
                                            echo "<textarea class='form-control' rows='10' disabled>" . $row2['note_prenotazione'] . "</textarea>";
                                            ?>
                                        </div>
                                        <div class='col-md-2'><br></div>
                                    </div>
                                    <div class="text-center">
                                        <button onclick="window.location.href='../forms/ModificaPrenotazione.php?msg=<?php echo $_GET['msg'] ?>&t=r';"
                                                class="btn btn-primary" type="button">
                                            <h4>Modifica</h4>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <?php
                        }
                    }
                } else if (isset($_GET['msg1'])) {
                    $id = $_GET['msg1'];
                    $query = "DELETE FROM prenotazionidarevisionare WHERE id_prenotazione='$id'";

                    $result = $connessione->query($query);

                    if ($result)
                        echo "<script> window.location.href= 'revisionare.php';</script>";
                    else
                        echo "<script> window.location.href= 'revisionare.php?messaggio=Errore nella cancellazione della prenotazione da revisionare!';</script>";
                } else {
                    ?>
                    <h1 class="text-center">Lista prenotazioni da revisionare</h1>
                    <br>
                    <table id="table">
                        <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Telefono</th>
                            <th>Persone</th>
                            <th>Giorno</th>
                            <th>Orario</th>
                            <th>Sala</th>
                            <th>View</th>
                            <th>Edit</th>
                            <th>Canc</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php

                        if (isset($_GET['date'])) {
                            $data = $_GET['date'];
                            $query = "SELECT * FROM prenotazionidarevisionare WHERE giorno='$data'";
                        } else
                            $query = "SELECT * FROM prenotazionidarevisionare";

                        $result = $connessione->query($query);
                        $numrows = $result->num_rows;

                        if ($numrows) {
                            $nascondi = false;
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
                                    } else
                                        echo "<td>x</td>";
                                    ?>
                                    <td>
                                        <a href="revisionare.php?msg=<?php echo $row['id_prenotazione'] ?>">
                                            <span class="glyphicon glyphicon-eye-open"></span>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="../forms/ModificaPrenotazione.php?msg=<?php echo $row['id_prenotazione'] ?>&t=r">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                    </td>
                                    <td>
                                        <a onclick="document.getElementById('idSupporto').value=<?php echo $row['id_prenotazione']; ?>;"
                                           class="confirm">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </a>
                                    </td>
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
                        window.location.href = "revisionare.php?msg1=" + a;
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
    <?php
}
?>