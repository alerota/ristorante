<?php
if(isset($_COOKIE['login'])) {
	setcookie('login', $username, time()-1);
	echo '<script> window.location.href= "http://localhost/ristorante/index.php";</script>';
	exit();
}
else 
	echo "errore";
?>

