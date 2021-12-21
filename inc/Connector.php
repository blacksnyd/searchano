<?php
try {
	$bdd = new PDO('mysql:host='.PDO_HOST.':'.PDO_PORT.';dbname='.PDO_NAME, PDO_USER, PDO_PASS);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$bdd->exec("SET CHARACTER SET utf8");
}catch(Exception $e) {
	die($e->getMessage());
}