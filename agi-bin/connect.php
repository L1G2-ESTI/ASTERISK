#!/opt/lampp/bin/php -q

<?php

require('phpagi/phpagi.php');

class connect_bdd{
          protected function dbconnect(){
    		$bdd = new PDO('mysql:host=localhost;dbname=Dama','root','') or die ('Not connected');
        	return $bdd;
          }
}

class Query_bdd extends connect_bdd{
	public function transaction($idexp, $iddest, $montant){
        	$bdd = $this->dbconnect();
		$res = $bdd->prepare("INSERT INTO Transactions(Daty, Num_Exp, Num_Dest, Somme) values( NOW(), ?, ?, ?)");
		$res->execute(array($idexp, $iddest, $montant));
        }
	
	public function isUser($num){
        	$bdd = $this->dbconnect();
		$res = $bdd->prepare("SELECT 1 FROM Utilisateurs WHERE Numero = ? ");
		$res->execute(array($num));
		if ($res->rowCount()==1){
			return true ;
		}
		return false;
        }


	public function moins($idexp, $montant){
                $bdd = $this->dbconnect();
		$res = $bdd->prepare("UPDATE Utilisateurs SET Solde = (Solde - ?)  WHERE Numero = ?");
		$res->execute(array($montant, $idexp));
        }

	public function plus($iddest, $montant){
                $bdd = $this->dbconnect();
		$res = $bdd->prepare("UPDATE Utilisateurs SET Solde = (Solde + ?) WHERE Numero = ?");
		$res->execute(array($montant, $iddest));
	}

	public function login($num, $pass){
		$bdd = $this->dbconnect();
		$res = $bdd->prepare("SELECT 1 FROM Utilisateurs WHERE Numero=? AND Password=?");
		$res->execute(array($num, $pass));
		if ($res->rowCount() == 1){
			return true;	
		}
		return false;
	}
}
?>
