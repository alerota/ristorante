<?php
if(isset($_COOKIE['login'])) {
	setcookie('login', null, time()-1);
	echo '<script> window.location.href= "http://prenotazioni.ristorante-almolo13.com/index.php";</script>';
	exit();
}
else 
	echo "errore";
?>

