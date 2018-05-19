<?php
if(isset($_COOKIE['login'])) {
	setcookie('login', $username, time()-1);
	header("location: index.php");
	exit();
}
else 
	echo "errore";



?>

