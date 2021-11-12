#!/opt/lampp/bin/php -q 
<?php

$result = 'Debogage';
require('connect.php');
$agi = new AGI();

$num_exp = $agi->request['agi_callerid'];
$num_dest = $agi->get_variable('Dest', true);
$montant = $agi->get_variable('Montant', true);
$password = $agi->get_variable('Password', true);
$agi->answer();

$query = new Query_bdd();
$solde_exp  = $query->consolde($num_exp);
if (intval($montant)>100){
	if (intval($solde_exp)>=intval($montant)){
		if ($query->isUser($num_dest) == true){
			if ($query->login($num_exp, $password)){
				$query->moins($num_exp, $montant);
				$query->plus($num_dest, $montant);
				$query->transaction($num_exp, $num_dest, $montant);
				$newsolde = $query->consolde($num_exp);

				$result = 'Transaction réussi, votre nouveau solde est de ' .$newsolde. 'Ariar';
			}
			else{
				$result = 'Votre mot de passe est fausse';
			}	
		}
		else{
			$result = "Le Numero de destination n'existe pas";
		}
	}	
	else{
		$result = "Désolé votre solde est insuffisante";
	}
}
else{
	$result = "Erreur, le montant minimal est de 100 Ariar";
}
$agi->set_variable('VAR', $result);
exec("python3 mail.py");
?>
