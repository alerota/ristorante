<?php
if(!isset($_COOKIE["login"])) {
    echo '<script> window.location.href= "http://localhost/ristorante/index.php";</script>';
    exit();
}
else {
// Connessione al DB
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "ristorante";
    $connessione = mysqli_connect($host, $user, $pass);
    $db_selected = mysqli_select_db($connessione, $dbname);

    if ($_GET != null) {
        $idImportante = $_GET["id"];
        $sql = "select * from gestionefasceorarie where id_fascia = " . $idImportante . ";";

        $result = mysqli_query($connessione, $sql);
        $num_result = mysqli_num_rows($result);

        if ($num_result == 1) {
            $row = mysqli_fetch_array($result);
            $name = $row["nome"];

            $sql = "select * from fasceorarie where id_fascia = " . $idImportante . " order by orario;";

            $result = mysqli_query($connessione, $sql);
            $num_result = mysqli_num_rows($result);

            $orari = array();

            for ($i = 0; $i < 6; $i++)
                $orari[$i] = array();

            for ($i = 0; $i < $num_result; $i++) {
                $row = mysqli_fetch_array($result);
                array_push($orari[$row["fase"]], $row["orario"]);
            }
        } else
            echo "<script>alert('Problemi durante il caricamento della fascia, chiedere assistenza...');</script>";
    }
    ?>

    <div class="col-md-4">
        <?php
        $fasi = array("Colazione", "Brunch", "Pranzo", "Aperitivo", "Cena", "Serata");
        $num = count($fasi);

        for ($i = 0; $i < $num / 3; $i++) {
            echo '<label>' . $fasi[$i] . '</label>
			<div id="Fase' . $i . '" class="row">';

            if (isset($orari[$i]))
                for ($j = 0; $j < sizeof($orari[$i]); $j++)
                    echo '<input type="text" name="orario' . $i . '[]" class="form-control" value="' . $orari[$i][$j] . '" placeholder="Orario"><span class="help-block"></span>';

            echo '<br>
				<button onclick="aggiungiOrario(\'Fase' . $i . '\');" class="btn btn-primary" type="button" >
					Aggiungi riga
				</button>
			</div><hr>';
        }


        ?>
    </div>
    <div class="col-md-4">
        <?php

        for ($i = $num / 3; $i < $num * 2 / 3; $i++) {
            echo '<label>' . $fasi[$i] . '</label>
			<div id="Fase' . $i . '">';

            if (isset($orari[$i]))
                for ($j = 0; $j < sizeof($orari[$i]); $j++)
                    echo '<input type="text" name="orario' . $i . '[]" class="form-control" value="' . $orari[$i][$j] . '" placeholder="Orario"><span class="help-block"></span>';

            echo '<br>
				<button onclick="aggiungiOrario(\'Fase' . $i . '\');" class="btn btn-primary" type="button" >
					Aggiungi riga
				</button>
			</div><hr>';
        }


        ?>
    </div>
    <div class="col-md-4">
        <?php

        for ($i = $num * 2 / 3; $i < $num; $i++) {
            echo '<label>' . $fasi[$i] . '</label>
			<div id="Fase' . $i . '">';

            if (isset($orari[$i]))
                for ($j = 0; $j < sizeof($orari[$i]); $j++)
                    echo '<input type="text" name="orario' . $i . '[]" class="form-control" value="' . $orari[$i][$j] . '" placeholder="Orario"><span class="help-block"></span>';

            echo '<br>
				<button onclick="aggiungiOrario(\'Fase' . $i . '\');" class="btn btn-primary" type="button" >
					Aggiungi riga
				</button>
			</div><hr>';
        }


        ?>
    </div>
    <?php
}
?>