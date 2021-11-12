#!/opt/lampp/bin/php -q 

<?php
	$bdd = new PDO('mysql:host=localhost;dbname=Dama', 'root', '');
	require('phpagi/phpagi.php');
	$agi = new AGI();

	$numero = $agi->request['agi_callerid'];
	$consulte = $bdd->query("SELECT Solde FROM Utilisateurs WHERE Numero = '$numero' ");
	$resp = $consulte->fetchall();
	$solde = $resp[0][0];

	$agi->answer();
	$agi->set_variable('VOLA', 'Votre solde est de:'.$solde.'Ariar');
?>
