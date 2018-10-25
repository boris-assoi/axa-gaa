<?php 
	/*
	Tableaux des requêtes par type d'utilisateur
	*/

	//Administrateur
	$m_admin = array(
		"users" => "SELECT *, type_user_lib AS userType FROM user, type_user WHERE user_type = type_user_id ORDER BY user_nom DESC",
		"list_batch" => "SELECT *, DATE_FORMAT(batch_date_recp, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM batch, type_attestation WHERE batch.batch_type = type_attestation.type_attestation_id ORDER BY batch_date_recp ASC",
		"list_attestation" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id ORDER BY attestation_num ASC",
		"list_annulation" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_statut = 'annulé' ORDER BY attestation_num ASC",
		"attib_to" => "SELECT *, ug_nom AS c_nom FROM unit_gestion ORDER BY ug_nom ASC",
		"dispoAuto" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='en stock' AND attestation_type = 1",
		"dispoBrune" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='en stock' AND attestation_type = 2",
		"dispoVerte" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='en stock' AND attestation_type = 3",
		"validCert" => "SELECT attestation_num FROM attestation WHERE attestation_num = ? AND attestation_statut = 'en stock' AND attestation_admin = ? AND attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?)",
		"attrib" => "UPDATE attestation SET attestation_statut='unité de gestion', attestation_ug=(SELECT ug_id FROM unit_gestion WHERE ug_nom = :to) WHERE attestation_statut='en stock' AND attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = :type) AND attestation_num > :f AND attestation_num < :t ORDER BY attestation_num LIMIT :dernier",
		"list_clients" => "SELECT * FROM client ORDER BY client_nom ASC",
		"cancel_batch" => "DELETE FROM batch WHERE batch_id = ?",
		"cancel_cert" => "UPDATE attestation SET attestation_statut = 'annulé', attestation_annul_date = ?, attestation_annul = 1 WHERE attestation_num = ?",
		"status" => "SELECT *, DATE_FORMAT(pol_date_deb, '%d/%m/%Y') AS dateDf, DATE_FORMAT(pol_date_fin, '%d/%m/%Y') AS dateDt FROM attestation, vehicule, client, police, police_item, vente WHERE attestation_vente = vente_id AND vente_vehicule = vehicule_id AND vehicule_police = police_num AND police_item_police = police_num AND pol_client = client_id AND attestation_num = ?",
	);
	
	//Responsable commercial
	$m_r_commercial = array(
		"list_attestation" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) ORDER BY attestation_num ASC",
		"list_annulation" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) AND attestation_statut = 'annulé' ORDER BY attestation_num ASC",
		"attib_to" => "SELECT *, pos_nom AS c_nom FROM pos WHERE pos_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) ORDER BY pos_nom ASC",
		"dispoAuto" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='unité de gestion' AND attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) AND attestation_type = 1",
		"dispoBrune" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='unité de gestion' AND attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) AND attestation_type = 2",
		"dispoVerte" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='unité de gestion' AND attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) AND attestation_type = 3",
		"validCert" => "SELECT attestation_num FROM attestation WHERE attestation_num = ? and attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) AND attestation_statut = 'unité de gestion' AND attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?)",
		"attrib" => "UPDATE attestation SET attestation_statut='point de vente', attestation_pos=(SELECT pos_id FROM pos WHERE pos_nom = :to) WHERE attestation_statut='unité de gestion' AND attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = :type) AND attestation_num > :f AND attestation_num < :t ORDER BY attestation_num LIMIT :dernier",
		"cancel_cert" => "UPDATE attestation SET attestation_statut = 'annulé', attestation_annul_date = ?, attestation_annul = 1 WHERE attestation_num = ?",
		"status" => "SELECT *, DATE_FORMAT(pol_date_deb, '%d/%m/%Y') AS dateDf, DATE_FORMAT(pol_date_fin, '%d/%m/%Y') AS dateDt FROM attestation, vehicule, client, police, vente WHERE attestation_vente = vente_id AND vente_vehicule = vehicule_id AND vehicule_police = police_num AND pol_client = client_id AND attestation_num = ?",
	);
	
	//Superviseurs
	$m_superviseur = array(
		"list_attestation" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) ORDER BY attestation_num ASC",
		"list_annulation" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) AND attestation_statut = 'annulé' ORDER BY attestation_num ASC",
		"attib_to" => "SELECT CONCAT(user.user_prenom, ' ' , user.user_nom, ' - ', user.user_mat) AS c_nom, comm_id, comm_pos FROM user, commercial WHERE user_id = comm_id AND comm_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) ORDER BY user_nom ASC",
		"dispoAuto" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='point de vente' AND attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) AND attestation_type = 1",
		"dispoBrune" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='point de vente' AND attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) AND attestation_type = 2",
		"dispoVerte" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='point de vente' AND attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) AND attestation_type = 3",
		"validCert" => "SELECT attestation_num FROM attestation WHERE attestation_num = ? and attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) AND attestation_statut = 'point de vente' AND attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?)",
		"attrib" => "UPDATE attestation SET attestation_statut='commercial', attestation_comm=(SELECT user_id FROM user WHERE user_mat = :to) WHERE attestation_statut='point de vente' AND attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = :type) AND attestation_num > :f AND attestation_num < :t ORDER BY attestation_num LIMIT :dernier",
		"cancel_cert" => "UPDATE attestation SET attestation_statut = 'annulé', attestation_annul_date = ?, attestation_annul = 1 WHERE attestation_num = ?",
		"status" => "SELECT attestation_ug, attestation_pos, attestation_comm, attestation_deliver_date, attestation_vente, attestation_statut FROM attestation WHERE attestation_num = ?",
	);
	
	//Commercial
	$m_commercial = array(
		"dispoAuto" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='commercial' AND attestation_comm = ? AND attestation_type = 1",
		"dispoBrune" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='commercial' AND attestation_comm = ? AND attestation_type = 2",
		"dispoVerte" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='commercial' AND attestation_comm = ? AND attestation_type = 3",
		"list_attestation" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_comm = ? ORDER BY attestation_num ASC",
		"list_annulation" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_comm = ? AND attestation_statut = 'annulé' ORDER BY attestation_num ASC",
		"cert_to_deliver" => "SELECT attestation_num, type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation.attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?) AND attestation_statut = 'commercial' AND attestation_comm = ? ORDER BY attestation_num ASC LIMIT 1",
		"cb_to_deliver" => "SELECT attestation_num, type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation.attestation_type = 2 AND attestation_statut = 'commercial' AND attestation_comm = ? ORDER BY attestation_num ASC LIMIT 1",
		"list_clients" => "SELECT * FROM client WHERE client_comm = ?",

		//Nouvelle vente
		"cert_new_vehicule" => "INSERT INTO vehicule(vehicule_mat, vehicule_chassis, vehicule_marque, vehicule_genre, vehicule_cat, vehicule_police) values(?,?,?,?,(SELECT cat_vehicule_id FROM categorie_vehicule WHERE cat_vehicule_id = ?),?)",
		"cert_new_police" => "INSERT INTO police(police_num, pol_client) values(?,(SELECT client_id FROM client WHERE client_comm = ? ORDER BY client_id DESC LIMIT 1))",

		"cert_new_police_item" => "INSERT INTO police_item (pol_date_deb, pol_date_fin, police_item_police, police_item_vente) values(?,?,?,(SELECT vente_id FROM vente WHERE vente_commmercial = ? ORDER BY vente_id DESC LIMIT 1))",

		"cert_new_vente" => "INSERT INTO vente(vente_montant, vente_vehicule, vente_commercial, vente_type_vente, vente_type_attestation) values(?,(SELECT vehicule_id FROM vehicule ORDER BY vehicule_id DESC LIMIT 1),?,?,(SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?))",
		"cert_sell" => "UPDATE attestation SET attestation_statut = 'vendu', attestation_vente = ?, attestation_deliver_date = ? WHERE attestation_num = ?",
		"cert_new_client" => "INSERT INTO client (client_nom, client_profession, client_adresse, client_contact, client_comm, client_type) VALUES (?,?,?,?,?,(SELECT type_client_id FROM type_client WHERE type_client_lib = ?))",

		"cancel_cert" => "UPDATE attestation SET attestation_statut = 'annulé', attestation_annul_date = ?, attestation_annul = 1 WHERE attestation_num = ?",
		"status" => "SELECT *, DATE_FORMAT(pol_date_deb, '%d/%m/%Y') AS dateDf, DATE_FORMAT(pol_date_fin, '%d/%m/%Y') AS dateDt FROM attestation, vehicule, client, police, vente WHERE attestation_vente = vente_id AND vente_vehicule = vehicule_id AND vehicule_police = police_num AND pol_client = client_id AND attestation_num = ?",

		//Informations de vente
		"sales" => "SELECT police_num, pol_date_deb, pol_date_fin, client_nom, vehicule_marque, vehicule_mat, vente_montant, vente_id, type_attestation_lib FROM vente, police, police_item, client, vehicule, type_attestation WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id AND police_item.police_item_police = police.police_num AND vehicule.vehicule_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_commercial = ?",
		"sale_details" => "SELECT vente_id, vente_montant, vente_type_attestation, vehicule_id, vehicule_genre, vehicule_marque, vehicule_mat, vehicule_chassis, vehicule_cat, police_item_id, police_num, pol_date_deb, pol_date_fin, client_id, client_nom, client_type, client_profession, client_adresse, client_contact FROM vente, police, client, vehicule, type_attestation, police_item WHERE police.pol_client = client.client_id AND vehicule.vehicule_police = police.police_num AND police_item.police_item_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_commercial = ? AND vente.vente_id = ?",

		//Modification de la vente
		"cert_update_client" => "UPDATE client SET client_nom = ?, client_profession = ?, client_adresse = ?, client_contact = ?, client_type = (SELECT type_client_id FROM type_client WHERE type_client_lib = ?) WHERE client_id= ?",
		"cert_update_police" => "UPDATE police SET police_num = ? WHERE police_num = ?",
		"cert_update_police_item" => "UPDATE police_item SET pol_date_deb = ?, pol_date_fin = ? WHERE police_item_id = ?",
		"cert_update_vehicule" => "UPDATE vehicule SET vehicule_mat = ?, vehicule_chassis = ?, vehicule_marque = ?, vehicule_genre = ?, vehicule_cat = ? WHERE vehicule_id = ?",
		"cert_update_vente" => "UPDATE vente SET vente_montant = ?, vente_type_attestation = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?) WHERE vente_id = ?",

		//Requete pour le renouvellement
		"renew_police_item" => "INSERT INTO police_item (pol_date_deb, pol_date_fin, police_item_police, police_item_vente) values(?,?,?,(SELECT vente_id FROM vente WHERE vente_commercial = ? ORDER BY vente_id DESC LIMIT 1))",
		"renew_vente" => "INSERT INTO vente(vente_montant, vente_vehicule, vente_commercial, vente_type_vente, vente_type_attestation) values(?,?,?,?,?)",
	);

	//Choix du tableau de modèle pour les requêtes
	$type = $_SESSION['type'];
	$models = array();
	switch ($type) {
		case 'admin':
			$models = $m_admin;
			break;

		case 'r_commercial':
			$models = $m_r_commercial;
			break;

		case 'superviseur':
			$models = $m_superviseur;
			break;

		case 'commercial':
			$models = $m_commercial;
			break;
		
		default:
			# code...
			break;
	}
?>