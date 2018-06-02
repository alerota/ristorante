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
			$('#table0').DataTable();
			if ( $( "#table1" ).length )
				$('#table1').DataTable();
			if ( $( "#table2" ).length )
				$('#table2').DataTable();
        });
    </script>
	<?php
	if(!isset($_GET['msg']))
	{
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
	}
	else
		echo '<style> #warning-message { display:none; } </style>';
	?>
</head>

<body id="body">
    <div class="container">
        <div class="row">
            <div class="col-md-12" id="wrapper">
                <?php
                if(isset($_GET['messaggio'])) {
                    ?>
                    <div class="alert alert-warning">
                        <strong>Attenzione! </strong> <?php echo $_GET['messaggio']; ?>
                    </div>
                    <?php
                }

                if(isset($_GET['msg'])) {
                    ?>
                    <h1 class="text-center">Prenotazione n° <?php echo $_GET['msg']; ?></h1>

                    <?php
                    $id = $_GET['msg'];
                    $query2 = "SELECT * FROM prenotazioni WHERE id_prenotazione='$id'";
                    $result2 = $connessione->query($query2);
                    $numrows2 = $result2->num_rows;

                    if($numrows2) {
                        while ($row2 = $result2->fetch_assoc()) {
                        ?>
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
													echo "<input type='text' class='form-control' placeholder='" . $row3['id_sala'] ." - ". $row3['Nome_sala'] . "' disabled>";
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
											echo "<textarea class='form-control' rows='10' disabled>" .$row2['note_prenotazione'] ."</textarea>";
										?>
									</div>
									<div class='col-md-2'><br></div>
								</div>
								<div class="text-center">
									<button onclick="window.location.href='../forms/ModificaPrenotazione.php?msg=<?php echo $_GET['msg'] ?>&t=n';" class="btn btn-primary" type="button">
										<h4>Modifica</h4>
									</button>
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
					
					if(!$result)
						echo "<script> window.location.href= 'prenotazioni.php?messaggio=Cliente rimasto nella lista clienti!';</script>";
					else
						echo "<script> window.location.href= 'prenotazioni.php';</script>";
                }
                else {
					
					$query = array();
					$titoli = ["Prenotazioni aperte", "Arrivati", "Scaduti", "Prenotazioni chiuse"];
					$parametri = [[1, 1, 1], [0, 1, 1], [1, 0, 1], [1, 1, 0]];
					if(isset($_GET['date'])) {
                        $data = date("Y-m-d", strtotime($_GET['date']));
						// Prenotazioni aperte (persone non ancora arrivate o scadute)
                        $query[0] = "SELECT * FROM prenotazioni WHERE (giorno='$data' and chiusura = 0 and arrivo = 0 and scadenza = 0) ORDER BY `giorno`, `orario`;";
                        // Arrivati
						$query[1] = "SELECT * FROM prenotazioni WHERE giorno='$data' and arrivo = 1 and chiusura = 0 ORDER BY `giorno`, `orario`;";
                        // Scaduti
						$query[2] = "SELECT * FROM prenotazioni WHERE giorno='$data' and scadenza = 1 and chiusura = 0 ORDER BY `giorno`, `orario`;";
						// Prenotazioni chiuse
						$query[3] = "SELECT * FROM prenotazioni WHERE giorno='$data' and chiusura = 1 ORDER BY `giorno`, `orario`;";
                    }
					else if(isset($_GET["strt"]) && isset($_GET["nd"]))
					{
						$a1 = $_GET["strt"];
						$a2 = $_GET["nd"];
						$query[0] = "SELECT * FROM prenotazioni WHERE giorno >= '" . $a1 . "' and giorno <= '" . $a2 . "' ORDER BY `giorno`, `orario`;";
					}
                    else
                        $query[0] = "SELECT * FROM prenotazioni WHERE chiusura = 0 ORDER BY `giorno`, `orario`;";
					
					for($i=0; $i < sizeof($query); $i++)
					{
						$sql = $query[$i];
						$result = $connessione->query($sql);
						echo '<hr><h1 class="text-center">' . $titoli[$i] . '</h1><br>';
						if($result && ($result->num_rows) > 0)
						{
							$numrows = $result->num_rows;
							$nascondi = false;
							echo '
								<table id="table' . $i . '">
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
										<th>Arrive</th>
										<th>Delay</th>
										<th>Close</th>
										<th>Canc</th>
									</tr>
									</thead>
									<tbody>';
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
										<a href="prenotazioni.php?msg=<?php echo $row['id_prenotazione']; ?>">
											<span class="glyphicon glyphicon-eye-open"></span>
										</a>
									</td>
									<td>
										<a href="../forms/ModificaPrenotazione.php?msg=<?php echo $row['id_prenotazione']; ?>&t=n">
											<span class="glyphicon glyphicon-pencil"></span>
										</a>
									</td>
									<td>
										<a href="../codici/aggiornaPrenotazione.php?id=<?php echo $row['id_prenotazione'] . "&a=a&p=" . $parametri[$i][0]; ?>">
											<span class="glyphicon glyphicon-ok"></span>
										</a>
									</td>
									<td>
										<a href="../codici/aggiornaPrenotazione.php?id=<?php echo $row['id_prenotazione'] . "&a=s&p=" . $parametri[$i][1]; ?>">
											<span class="glyphicon glyphicon-remove"></span>
										</a>
									</td>
									<td>
										<a href="../codici/aggiornaPrenotazione.php?id=<?php echo $row['id_prenotazione'] . "&a=c&p=" . $parametri[$i][2]; ?>">
											<span class="glyphicon glyphicon-ban-circle"></span>
										</a>
									</td>
									<td>
										<a onclick="document.getElementById('idSupporto').value=<?php echo $row['id_prenotazione']; ?>;" class="confirm">
											<span class="glyphicon glyphicon-trash"></span>
										</a>
									</td>
								</tr>
								<?php
							}
							echo '</tbody>
								</table>';
						}
						else
							$nascondi = true;
					
						if($nascondi)
							echo "<p style='text-align: center;'>Non sono presenti records.</p>";
					}
				}
				?>
                <input type="hidden" value="" id="idSupporto"/>
            </div>
			<div id="warning-message">
				<br>
				<div class="alert alert-warning">
					<h3><strong>Attenzione!</strong> Questa pagina è visualizzabile solo se orienti il cellulare in orizzontale</h3>
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
                    window.location.href = "prenotazioni.php?msg1=" + a;
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
