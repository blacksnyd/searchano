<?php
if(isset($_POST['submit'])){
	if(empty($_POST['player'])){
		$_SESSION['error'] = 'Veuillez entrer un ID. 🐺';
	}else {
		if(getInfo($_POST['player']) == null){
			$_SESSION['error'] = 'Impossible de trouver le joueur ou ID erroné. 🐺';
		}else {
			$re = getInfo($_POST['player']);
			//echo '<pre>';
			//var_dump($re);
			//echo '</pre>';
		}
	}
}
?>