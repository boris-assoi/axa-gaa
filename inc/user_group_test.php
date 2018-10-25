<?php  
	public static function getListclientProspects(){
		include('connexion.php');
		$personne=$_SESSION['login'];

		$reqDocument = $db ->prepare('SELECT client_prospect.* , utilisateur.* FROM client_prospect
		 INNER JOIN utilisateur ON client_prospect.utilisateur=utilisateur.id_utilisateur 
		 LEFT JOIN utilisateur chef ON utilisateur.chefId=chef.id_utilisateur 
		 WHERE utilisateur.id_utilisateur =:a OR utilisateur.chefId =:b');
	   		$reqDocument->bindValue(':a', $personne);
	   		$reqDocument->bindValue(':b', $personne);
	      $reqDocument->execute();

	       $results = Array();
		while ($ligne=$reqDocument->fetch()){

				$clientProspects = clientProspects::readRowCL($ligne);
			if($ligne !== false)
				$results[] = $clientProspects;

				}

		return $results;
	}
 ?>