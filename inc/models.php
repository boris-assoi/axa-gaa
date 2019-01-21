<?php 
	/*
	Tableaux des requêtes par type d'utilisateur
	*/

	//Administrateur
	$m_admin = array(
		"users" => "SELECT *, type_user_lib AS userType FROM user, type_user WHERE user_type = type_user_id ORDER BY user_nom DESC",
		
		"list_batch" => "SELECT *, DATE_FORMAT(batch_date_recp, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM batch, type_attestation WHERE batch.batch_type = type_attestation.type_attestation_id ORDER BY batch_date_recp ASC",

		"list_attestation" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id ORDER BY attestation_num ASC LIMIT 10",

		"list_attestation_filtered" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_num = ? ORDER BY attestation_num ASC",

		"list_annulation" => "SELECT *, DATE_FORMAT(attestation_annul_date, '%d/%m/%Y à %H:%i') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_statut = 'annulé' ORDER BY attestation_num ASC",

		"attib_to" => "SELECT *, ug_nom AS c_nom FROM unit_gestion ORDER BY ug_nom ASC",

		"dispoAuto" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='en stock' AND attestation_type = 1",
		"dispoBrune" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='en stock' AND attestation_type = 2",
		"dispoVerte" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='en stock' AND attestation_type = 3",

		"validCert" => "SELECT attestation_num FROM attestation WHERE attestation_num = ? AND attestation_statut = 'en stock' AND attestation_admin = ? AND attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?)",

		"attrib" => "UPDATE attestation SET attestation_statut='unité de gestion', attestation_ug=(SELECT ug_id FROM unit_gestion WHERE ug_nom = :to) WHERE attestation_statut='en stock' AND attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = :type) AND attestation_num > :f AND attestation_num < :t ORDER BY attestation_num LIMIT :dernier",

		"list_clients" => "SELECT * FROM client ORDER BY client_nom ASC",

		"cancel_batch" => "DELETE FROM batch WHERE batch_id = ?",

		"cancel_cert" => "UPDATE attestation SET attestation_statut = 'annulé', attestation_annul_desc = ?, attestation_annul = 1 WHERE attestation_num = ?",

		"status" => "SELECT attestation_ug, attestation_pos, attestation_comm, DATE_FORMAT(attestation_deliver_date, '%d/%m/%Y à %H:%i') AS attestation_deliver_date, attestation_vente, attestation_statut FROM attestation WHERE attestation_num = ?",

		"status_sale" => "SELECT vente_id, vente_montant, DATE_FORMAT(vente_date, '%d/%m/%Y à %H:%i') AS vente_date, police_num, pol_date_deb, pol_date_fin, client_id, client_nom FROM vente, police, client, vehicule, type_attestation, police_item WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente.vente_id  AND vehicule.vehicule_police = police.police_num AND police_item.police_item_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_commercial = ? AND vente.vente_id = ?",

		//-- VENTE --

		//Informations de vente
		"sales" => "SELECT police_num, DATE_FORMAT(pol_date_deb, '%d/%m/%Y') AS pol_date_deb, DATE_FORMAT(pol_date_fin, '%d/%m/%Y') AS pol_date_fin, client_nom, vehicule_marque, vehicule_mat, vente_montant, vente_id, DATE_FORMAT(vente_date, '%d/%m/%Y') AS vente_date, vente_commercial, type_attestation_lib, type_vente_lib, police_item_id FROM vente, police, police_item, client, vehicule, type_attestation, type_vente, pos WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id AND police_item.police_item_police = police.police_num AND vehicule.vehicule_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_type_vente = type_vente.type_vente_id ORDER BY vente_date DESC",

		"sales_by_seller" => "SELECT police_num, DATE_FORMAT(pol_date_deb, '%d/%m/%Y') AS pol_date_deb, DATE_FORMAT(pol_date_fin, '%d/%m/%Y') AS pol_date_fin, client_nom, vehicule_marque, vehicule_mat, vente_montant, vente_id, DATE_FORMAT(vente_date, '%d/%m/%Y') AS vente_date, vente_commercial, type_attestation_lib, type_vente_lib, police_item_id FROM vente, police, police_item, client, vehicule, type_attestation, type_vente, attestation WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id AND police_item.police_item_police = police.police_num AND vehicule.vehicule_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_type_vente = type_vente.type_vente_id AND attestation.attestation_admin = ? ORDER BY vente_date DESC",

		"sale_details" => "SELECT vente_id, vente_montant, vente_type_attestation, vehicule_id, vehicule_genre, vehicule_marque, vehicule_mat, vehicule_chassis, vehicule_cat, police_item_id, police_num, pol_date_deb, pol_date_fin, client_id, client_nom, client_type, client_profession, client_adresse, client_contact FROM vente, police, client, vehicule, type_attestation, police_item WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id  AND vehicule.vehicule_police = police.police_num AND police_item.police_item_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_commercial = ? AND vente.vente_id = ?",

		"sale_details_for_pos_operation" => "SELECT vente_id, vente_montant, vente_type_attestation, vehicule_id, vehicule_genre, vehicule_marque, vehicule_mat, vehicule_chassis, vehicule_cat, police_item_id, police_num, pol_date_deb, pol_date_fin, client_id, client_nom, client_type, client_profession, client_adresse, client_contact FROM vente, police, client, vehicule, type_attestation, police_item, pos WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id  AND vehicule.vehicule_police = police.police_num AND police_item.police_item_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND pos.pos_id = (SELECT comm_pos FROM commercial WHERE comm_id = ?) AND vente.vente_id = ?",

		"seller" => "SELECT user_prenom, user_nom, user_mat FROM user WHERE user_id = ?",

		//Rapports
		"sales_report" => "
		SELECT attestation_num AS attestation, 
			attestation_statut AS statut, 
			type_attestation_lib AS type, 
			ug_nom AS ug, 
			pos_nom AS pos, 
			police_num AS police, 
			DATE_FORMAT(pol_date_deb, '%d/%m/%Y') AS startDate, 
			DATE_FORMAT(pol_date_fin, '%d/%m/%Y') AS endDate, 
			client_nom AS client, 
			vente_montant AS prime, 
			DATE_FORMAT(vente_date, '%d/%m/%Y') AS saleDate, 
			CONCAT(user_mat,'-',user_prenom,' ',user_nom) AS commercial 
		FROM attestation, type_attestation, unit_gestion, pos, police, police_item, CLIENT, vente, vehicule, user 
		WHERE police.pol_client = client.client_id  
			AND police_item.police_item_vente = vente_id 
			AND attestation.attestation_vente = vente.vente_id 
			AND attestation.attestation_ug = unit_gestion.ug_id 
			AND attestation.attestation_pos = pos.pos_id 
			AND police_item.police_item_police = police.police_num 
			AND vehicule.vehicule_police = police.police_num 
			AND vente.vente_vehicule = vehicule.vehicule_id 
			AND attestation.attestation_type = type_attestation.type_attestation_id 
			AND vente.vente_commercial = user.user_id 
		ORDER BY vente.vente_date DESC
		",

		"sales_report_filtered" => "
		SELECT attestation_num as attestation, 
			attestation_statut AS statut,  
			type_attestation_lib as type, 
			ug_nom AS UG, 
			pos_nom AS POS, 
			police_num as police, 
			DATE_FORMAT(pol_date_deb, '%d/%m/%Y') AS startDate, 
			DATE_FORMAT(pol_date_fin, '%d/%m/%Y') AS endDate, 
			client_nom as client, 
			vente_montant as prime,
			DATE_FORMAT(vente_date, '%d/%m/%Y') AS saleDate, 
			CONCAT(user_mat,'-',user_prenom,' ',user_nom) AS commercial 
		FROM attestation, type_attestation, unit_gestion, pos, police, police_item, client, vente, vehicule 
		WHERE police.pol_client = client.client_id 
			AND police_item.police_item_vente = vente_id 
			AND attestation.attestation_vente = vente.vente_id 
			AND attestation.attestation_ug = unit_gestion.ug_id 
			AND attestation.attestation_pos = pos.pos_id 
			AND police_item.police_item_police = police.police_num 
			AND vehicule.vehicule_police = police.police_num 
			AND vente.vente_vehicule = vehicule.vehicule_id 
			AND attestation.attestation_type = type_attestation.type_attestation_id 
			AND attestation_admin = ? 
			AND vente.vente_date >= ? 
			AND vente.vente_date < ? 
		ORDER BY vente.vente_date DESC
		",

		//Commercial vendeur pour les rapports		
		"seller" => "SELECT user_prenom, user_nom, user_mat FROM user WHERE user_id = ?",

		//-- MOT DE PASSE
		"pass_check" => "SELECT user_password FROM user WHERE user_id = ?",

		//Mise à jour du mot de passe
		"pass_update" => "UPDATE user SET user_password = ? WHERE user_id = ?",
	);
	
	//Responsable commercial
	$m_r_commercial = array(
		"list_attestation" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) ORDER BY attestation_num ASC LIMIT 10",

		"list_attestation_filtered" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?)AND attestation_num = ? ORDER BY attestation_num ASC",

		"list_annulation" => "SELECT *, DATE_FORMAT(attestation_annul_date, '%d/%m/%Y à %H:%i') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) AND attestation_statut = 'annulé' ORDER BY attestation_num ASC",

		"attib_to" => "SELECT *, pos_nom AS c_nom FROM pos WHERE pos_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) ORDER BY pos_nom ASC",

		"dispoAuto" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='unité de gestion' AND attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) AND attestation_type = 1",
		"dispoBrune" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='unité de gestion' AND attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) AND attestation_type = 2",
		"dispoVerte" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='unité de gestion' AND attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) AND attestation_type = 3",

		"validCert" => "SELECT attestation_num FROM attestation WHERE attestation_num = ? and attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) AND attestation_statut = 'unité de gestion' AND attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?)",

		"attrib" => "UPDATE attestation SET attestation_statut='point de vente', attestation_pos=(SELECT pos_id FROM pos WHERE pos_nom = :to) WHERE attestation_statut='unité de gestion' AND attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = :type) AND attestation_num > :f AND attestation_num < :t ORDER BY attestation_num LIMIT :dernier",

		"cancel_cert" => "UPDATE attestation SET attestation_statut = 'annulé', attestation_annul_desc = ?, attestation_annul = 1 WHERE attestation_num = ?",

		"status" => "SELECT attestation_ug, attestation_pos, attestation_comm, DATE_FORMAT(attestation_deliver_date, '%d/%m/%Y à %H:%i') AS attestation_deliver_date, attestation_vente, attestation_statut FROM attestation WHERE attestation_num = ? AND attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?)",

		"status_sale" => "SELECT vente_id, vente_montant, DATE_FORMAT(vente_date, '%d/%m/%Y à %H:%i') AS vente_date, police_num, pol_date_deb, pol_date_fin, client_id, client_nom FROM vente, police, client, vehicule, type_attestation, police_item WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente.vente_id  AND vehicule.vehicule_police = police.police_num AND police_item.police_item_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_commercial = ? AND vente.vente_id = ?",

		//Rapports
		"sales_report" => "
		SELECT attestation_num AS attestation, 
			attestation_statut AS statut, 
			type_attestation_lib AS type, 
			ug_nom AS ug, 
			pos_nom AS pos, 
			police_num AS police, 
			DATE_FORMAT(pol_date_deb, '%d/%m/%Y') AS startDate, 
			DATE_FORMAT(pol_date_fin, '%d/%m/%Y') AS endDate, 
			client_nom AS client, 
			vente_montant AS prime, 
			DATE_FORMAT(vente_date, '%d/%m/%Y') AS saleDate, 
			CONCAT(user_mat,'-',user_prenom,' ',user_nom) AS commercial 
		FROM attestation, type_attestation, unit_gestion, pos, police, police_item, client, vente, vehicule, user
		WHERE police.pol_client = client.client_id 
			AND police_item.police_item_vente = vente_id 
			AND attestation.attestation_vente = vente.vente_id 
			AND attestation.attestation_ug = unit_gestion.ug_id 
			AND attestation.attestation_pos = pos.pos_id 
			AND police_item.police_item_police = police.police_num 
			AND vehicule.vehicule_police = police.police_num 
			AND vente.vente_vehicule = vehicule.vehicule_id 
			AND attestation.attestation_type = type_attestation.type_attestation_id 
			AND attestation.attestation_ug = (
				SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?
				) 
		ORDER BY vente.vente_date DESC
		",

		"sales_report_filtered" => "SELECT attestation_num as attestation, type_attestation_lib as type, ug_nom AS UG, pos_nom AS POS, police_num as police, pol_date_deb as debut, pol_date_fin as fin, client_nom as client, vente_montant as prime, vente_commercial FROM attestation, type_attestation, unit_gestion, pos, police, police_item, client, vente, vehicule WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id AND attestation.attestation_vente = vente.vente_id AND attestation.attestation_ug = unit_gestion.ug_id AND attestation.attestation_pos = pos.pos_id AND police_item.police_item_police = police.police_num AND vehicule.vehicule_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND attestation.attestation_type = type_attestation.type_attestation_id AND attestation.attestation_ug = (SELECT ug_id FROM unit_gestion WHERE ug_r_comm = ?) AND vente.vente_date >= ? AND vente.vente_date < ? ORDER BY vente.vente_date DESC",

		//Commercial vendeur pour les rapports		
		"seller" => "SELECT user_prenom, user_nom, user_mat FROM user WHERE user_id = ?",

		//-- MOT DE PASSE
		"pass_check" => "SELECT user_password FROM user WHERE user_id = ?",

		//Mise à jour du mot de passe
		"pass_update" => "UPDATE user SET user_password = ? WHERE user_id = ?",
	);
	
	//Superviseurs
	$m_superviseur = array(
		"list_attestation" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) ORDER BY attestation_num ASC LIMIT 10",

		"list_attestation_filtered" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) AND attestation_num = ? ORDER BY attestation_num ASC",

		"list_annulation" => "SELECT *, DATE_FORMAT(attestation_annul_date, '%d/%m/%Y à %H:%i') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) AND attestation_statut = 'annulé' ORDER BY attestation_num ASC",

		"attib_to" => "SELECT CONCAT(user.user_prenom, ' ' , user.user_nom, ' - ', user.user_mat) AS c_nom, comm_id, comm_pos FROM user, commercial WHERE user_id = comm_id AND comm_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) ORDER BY user_nom ASC",

		"dispoAuto" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='point de vente' AND attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) AND attestation_type = 1",
		"dispoBrune" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='point de vente' AND attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) AND attestation_type = 2",
		"dispoVerte" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='point de vente' AND attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) AND attestation_type = 3",

		"validCert" => "SELECT attestation_num FROM attestation WHERE attestation_num = ? and attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) AND attestation_statut = 'point de vente' AND attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?)",

		"attrib" => "UPDATE attestation SET attestation_statut='producteur', attestation_comm=(SELECT user_id FROM user WHERE user_mat = :to) WHERE attestation_statut='point de vente' AND attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = :type) AND attestation_num > :f AND attestation_num < :t ORDER BY attestation_num LIMIT :dernier",

		"cancel_cert" => "UPDATE attestation SET attestation_statut = 'annulé', attestation_annul_desc = ?, attestation_annul = 1 WHERE attestation_num = ?",

		"status" => "SELECT attestation_ug, attestation_pos, attestation_comm, DATE_FORMAT(attestation_deliver_date, '%d/%m/%Y à %H:%i') AS attestation_deliver_date, attestation_vente, attestation_statut FROM attestation WHERE attestation_num = ? AND attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?)",

		"status_sale" => "SELECT vente_id, vente_montant, DATE_FORMAT(vente_date, '%d/%m/%Y à %H:%i') AS vente_date, police_num, pol_date_deb, pol_date_fin, client_id, client_nom FROM vente, police, client, vehicule, type_attestation, police_item WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente.vente_id  AND vehicule.vehicule_police = police.police_num AND police_item.police_item_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_commercial = ? AND vente.vente_id = ?",

		//Rapports
		"sales_report" => "SELECT attestation_num as attestation, type_attestation_lib as type, ug_nom AS UG, pos_nom AS POS, police_num as police, pol_date_deb as debut, pol_date_fin as fin, client_nom as client, vente_montant as prime, vente_commercial FROM attestation, type_attestation, unit_gestion, pos, police, police_item, client, vente, vehicule WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id AND attestation.attestation_vente = vente.vente_id AND attestation.attestation_ug = unit_gestion.ug_id AND attestation.attestation_pos = pos.pos_id AND police_item.police_item_police = police.police_num AND vehicule.vehicule_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND attestation.attestation_type = type_attestation.type_attestation_id AND attestation.attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) ORDER BY vente.vente_date DESC",

		"sales_report_filtered" => "SELECT attestation_num as attestation, type_attestation_lib as type, ug_nom AS UG, pos_nom AS POS, police_num as police, pol_date_deb as debut, pol_date_fin as fin, client_nom as client, vente_montant as prime, vente_commercial FROM attestation, type_attestation, unit_gestion, pos, police, police_item, client, vente, vehicule WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id AND attestation.attestation_vente = vente.vente_id AND attestation.attestation_ug = unit_gestion.ug_id AND attestation.attestation_pos = pos.pos_id AND police_item.police_item_police = police.police_num AND vehicule.vehicule_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND attestation.attestation_type = type_attestation.type_attestation_id AND attestation.attestation_pos = (SELECT pos_id FROM pos WHERE pos_superviseur = ?) AND vente.vente_date >= ? AND vente.vente_date < ? ORDER BY vente.vente_date DESC",

		//Commercial vendeur pour les rapports		
		"seller" => "SELECT user_prenom, user_nom, user_mat FROM user WHERE user_id = ?",

		//-- MOT DE PASSE
		"pass_check" => "SELECT user_password FROM user WHERE user_id = ?",

		//Mise à jour du mot de passe
		"pass_update" => "UPDATE user SET user_password = ? WHERE user_id = ?",
	);
	
	//Commercial
	$m_commercial = array(
		"dispoAuto" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='producteur' AND attestation_comm = ? AND attestation_type = 1",
		"dispoBrune" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='producteur' AND attestation_comm = ? AND attestation_type = 2",
		"dispoVerte" => "SELECT COUNT(*) AS nbre FROM attestation WHERE attestation_statut='producteur' AND attestation_comm = ? AND attestation_type = 3",

		"list_attestation" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_comm = ? ORDER BY attestation_num ASC LIMIT 10",

		"list_attestation_filtered" => "SELECT *, DATE_FORMAT(attestation_date, '%d/%m/%Y') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_comm = ? AND attestation_num = ? ORDER BY attestation_num ASC",

		"list_annulation" => "SELECT *, DATE_FORMAT(attestation_annul_date, '%d/%m/%Y à %H:%i') AS dateFr, type_attestation.type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation_comm = ? AND attestation_statut = 'annulé' ORDER BY attestation_num ASC",

		"cert_to_deliver" => "SELECT attestation_num, type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation.attestation_type = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?) AND attestation_statut = 'producteur' AND attestation_comm = ? ORDER BY attestation_num ASC LIMIT 1",

		"cb_to_deliver" => "SELECT attestation_num, type_attestation_lib FROM attestation, type_attestation WHERE attestation.attestation_type = type_attestation.type_attestation_id AND attestation.attestation_type = 2 AND attestation_statut = 'producteur' AND attestation_comm = ? ORDER BY attestation_num ASC LIMIT 1",

		"list_clients" => "SELECT * FROM client WHERE client_comm = ?",

		//Nouvelle vente
		"cert_new_vehicule" => "INSERT INTO vehicule(vehicule_mat, vehicule_chassis, vehicule_marque, vehicule_genre, vehicule_cat, vehicule_police) values(?,?,?,?,(SELECT cat_vehicule_id FROM categorie_vehicule WHERE cat_vehicule_id = ?),?)",

		"cert_new_police" => "INSERT INTO police(police_num, pol_client) values(?,(SELECT client_id FROM client WHERE client_comm = ? ORDER BY client_id DESC LIMIT 1))",

		"cert_new_police_item" => "INSERT INTO police_item (pol_date_deb, pol_date_fin, police_item_police, police_item_vente) values(?,?,?,(SELECT vente_id FROM vente WHERE vente_commercial = ? ORDER BY vente_id DESC LIMIT 1))",

		"cert_new_vente" => "INSERT INTO vente(vente_montant, vente_vehicule, vente_commercial, vente_type_vente, vente_type_attestation) values(?,(SELECT vehicule_id FROM vehicule WHERE vehicule_police = ? ORDER BY vehicule_id DESC LIMIT 1),?,?,(SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?))",

		"cert_sell" => "UPDATE attestation SET attestation_statut = 'vendu', attestation_vente = ?, attestation_deliver_date = ? WHERE attestation_num = ?",

		"cert_new_client" => "INSERT INTO client (client_nom, client_profession, client_adresse, client_contact, client_comm, client_type) VALUES (?,?,?,?,?,(SELECT type_client_id FROM type_client WHERE type_client_lib = ?))",

		"cancel_cert" => "UPDATE attestation SET attestation_statut = 'annulé', attestation_annul_desc = ?, attestation_annul = 1 WHERE attestation_num = ?",

		"status" => "SELECT attestation_ug, attestation_pos, attestation_comm, DATE_FORMAT(attestation_deliver_date, '%d/%m/%Y à %H:%i') AS attestation_deliver_date, attestation_vente, attestation_statut FROM attestation WHERE attestation_num = ? AND attestation_comm = ?",

		"status_sale" => "SELECT vente_id, vente_montant, DATE_FORMAT(vente_date, '%d/%m/%Y à %H:%i') AS vente_date, police_num, pol_date_deb, pol_date_fin, client_id, client_nom FROM vente, police, client, vehicule, type_attestation, police_item WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente.vente_id  AND vehicule.vehicule_police = police.police_num AND police_item.police_item_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_commercial = ? AND vente.vente_id = ?",

		//Informations de vente
		"sales" => "SELECT police_num, DATE_FORMAT(pol_date_deb, '%d/%m/%Y') AS pol_date_deb, DATE_FORMAT(pol_date_fin, '%d/%m/%Y') AS pol_date_fin, client_nom, vehicule_marque, vehicule_mat, vente_montant, vente_id, DATE_FORMAT(vente_date, '%d/%m/%Y') AS vente_date, vente_commercial, type_attestation_lib, type_vente_lib, police_item_id FROM vente, police, police_item, client, vehicule, type_attestation, type_vente, pos WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id AND police_item.police_item_police = police.police_num AND vehicule.vehicule_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_type_vente = type_vente.type_vente_id AND pos_id = (SELECT comm_pos FROM commercial WHERE comm_id = ?) AND vente_date > (CURDATE()+' 00:00:00') ORDER BY vente_date DESC LIMIT 5",

		"sales_filtered" => "SELECT police_num, DATE_FORMAT(pol_date_deb, '%d/%m/%Y') AS pol_date_deb, DATE_FORMAT(pol_date_fin, '%d/%m/%Y') AS pol_date_fin, client_nom, vehicule_marque, vehicule_mat, vente_montant, vente_id, DATE_FORMAT(vente_date, '%d/%m/%Y') AS vente_date, vente_commercial, type_attestation_lib, type_vente_lib, police_item_id FROM vente, police, police_item, client, vehicule, type_attestation, type_vente, pos WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id AND police_item.police_item_police = police.police_num AND vehicule.vehicule_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_type_vente = type_vente.type_vente_id AND pos_id = (SELECT comm_pos FROM commercial WHERE comm_id = :user) AND (police_num = :find OR client_nom = :find OR vehicule_mat = :find) ORDER BY vente_date DESC",

		"sales_by_seller" => "SELECT police_num, DATE_FORMAT(pol_date_deb, '%d/%m/%Y') AS pol_date_deb, DATE_FORMAT(pol_date_fin, '%d/%m/%Y') AS pol_date_fin, client_nom, vehicule_marque, vehicule_mat, vente_montant, vente_id, DATE_FORMAT(vente_date, '%d/%m/%Y') AS vente_date, vente_commercial, type_attestation_lib, type_vente_lib, police_item_id FROM vente, police, police_item, client, vehicule, type_attestation, type_vente WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id AND police_item.police_item_police = police.police_num AND vehicule.vehicule_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_type_vente = type_vente.type_vente_id AND vente.vente_commercial = ? AND vente_date > (CURDATE()+' 00:00:00') ORDER BY vente_date DESC LIMIT 5",

		"sales_by_seller_filtered" => "SELECT police_num, DATE_FORMAT(pol_date_deb, '%d/%m/%Y') AS pol_date_deb, DATE_FORMAT(pol_date_fin, '%d/%m/%Y') AS pol_date_fin, client_nom, vehicule_marque, vehicule_mat, vente_montant, vente_id, DATE_FORMAT(vente_date, '%d/%m/%Y') AS vente_date, vente_commercial, type_attestation_lib, type_vente_lib, police_item_id FROM vente, police, police_item, client, vehicule, type_attestation, type_vente WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id AND police_item.police_item_police = police.police_num AND vehicule.vehicule_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_type_vente = type_vente.type_vente_id AND vente.vente_commercial = :user AND (police_num = :find OR client_nom = :find OR vehicule_mat = :find) ORDER BY vente_date DESC",

		"sale_details" => "SELECT vente_id, vente_montant, vente_type_attestation, vehicule_id, vehicule_genre, vehicule_marque, vehicule_mat, vehicule_chassis, vehicule_cat, police_item_id, police_num, pol_date_deb, pol_date_fin, client_id, client_nom, client_type, client_profession, client_adresse, client_contact FROM vente, police, client, vehicule, type_attestation, police_item WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id  AND vehicule.vehicule_police = police.police_num AND police_item.police_item_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND vente.vente_commercial = ? AND vente.vente_id = ?",

		"sale_details_for_pos_operation" => "SELECT vente_id, vente_montant, vente_type_attestation, vehicule_id, vehicule_genre, vehicule_marque, vehicule_mat, vehicule_chassis, vehicule_cat, police_item_id, police_num, pol_date_deb, pol_date_fin, client_id, client_nom, client_type, client_profession, client_adresse, client_contact FROM vente, police, client, vehicule, type_attestation, police_item, pos WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id  AND vehicule.vehicule_police = police.police_num AND police_item.police_item_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND vente.vente_type_attestation = type_attestation.type_attestation_id AND pos.pos_id = (SELECT comm_pos FROM commercial WHERE comm_id = ?) AND vente.vente_id = ?",

		"seller" => "SELECT user_prenom, user_nom, user_mat, vente_commercial FROM user, vente WHERE user_id = ? AND user_id = vente_commercial",

		//Modification de la vente
		"cert_update_client" => "UPDATE client SET client_nom = ?, client_profession = ?, client_adresse = ?, client_contact = ?, client_type = (SELECT type_client_id FROM type_client WHERE type_client_lib = ?) WHERE client_id= ?",

		"cert_update_police" => "UPDATE police SET police_num = ? WHERE police_num = ?",

		"cert_update_police_item" => "UPDATE police_item SET pol_date_deb = ?, pol_date_fin = ? WHERE police_item_id = ?",

		"cert_update_vehicule" => "UPDATE vehicule SET vehicule_mat = ?, vehicule_chassis = ?, vehicule_marque = ?, vehicule_genre = ?, vehicule_cat = ? WHERE vehicule_id = ?",

		"cert_update_vente" => "UPDATE vente SET vente_montant = ?, vente_type_attestation = (SELECT type_attestation_id FROM type_attestation WHERE type_attestation_lib = ?) WHERE vente_id = ?",

		//Requete pour le renouvellement
		"renew_police_item" => "INSERT INTO police_item (pol_date_deb, pol_date_fin, police_item_police, police_item_vente) values(?,?,?,(SELECT vente_id FROM vente WHERE vente_commercial = ? ORDER BY vente_id DESC LIMIT 1))",

		"renew_vente" => "INSERT INTO vente(vente_montant, vente_vehicule, vente_commercial, vente_type_vente, vente_type_attestation) values(?,?,?,?,?)",

		//Requete pour la flotte
		"cert_new_fleet_vente" => "INSERT INTO vente(vente_montant, vente_vehicule, vente_commercial, vente_type_vente, vente_type_attestation) values(?,(SELECT vehicule_id FROM vehicule WHERE vehicule_police = ? ORDER BY vehicule_id DESC LIMIT 1),?,?,?)",

		//Résiliation
		"check_fleet_police" => "SELECT COUNT(*) AS nbre FROM vehicule WHERE vehicule_police = ?",

		"cancel_sale" => "DELETE FROM vehicule WHERE vehicule_id = ?",

		"cancel_sale_for_fleet" => "DELETE FROM vehicule WHERE vehicule_id = ?",

		"cert_to_cancel_sale" => "SELECT attestation_num FROM attestation WHERE attestation_vente = ? AND attestation_comm = ?",

		//Rapports
		"sales_report" => "SELECT attestation_num as attestation, type_attestation_lib as type, ug_nom AS UG, pos_nom AS POS, police_num as police, pol_date_deb as debut, pol_date_fin as fin, client_nom as client, vente_montant as prime, vente_commercial FROM attestation, type_attestation, unit_gestion, pos, police, police_item, client, vente, vehicule WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id AND attestation.attestation_vente = vente.vente_id AND attestation.attestation_ug = unit_gestion.ug_id AND attestation.attestation_pos = pos.pos_id AND police_item.police_item_police = police.police_num AND vehicule.vehicule_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND attestation.attestation_type = type_attestation.type_attestation_id AND vente.vente_commercial = ? ORDER BY vente.vente_date DESC LIMIT 20",

		"sales_report_filtered" => "SELECT attestation_num as attestation, type_attestation_lib as type, ug_nom AS UG, pos_nom AS POS, police_num as police, pol_date_deb as debut, pol_date_fin as fin, client_nom as client, vente_montant as prime, vente_commercial FROM attestation, type_attestation, unit_gestion, pos, police, police_item, client, vente, vehicule WHERE police.pol_client = client.client_id AND police_item.police_item_vente = vente_id AND attestation.attestation_vente = vente.vente_id AND attestation.attestation_ug = unit_gestion.ug_id AND attestation.attestation_pos = pos.pos_id AND police_item.police_item_police = police.police_num AND vehicule.vehicule_police = police.police_num AND vente.vente_vehicule = vehicule.vehicule_id AND attestation.attestation_type = type_attestation.type_attestation_id AND vente.vente_commercial = ? AND vente.vente_date >= ? AND vente.vente_date < ? ORDER BY vente.vente_date DESC",

		//-- MOT DE PASSE
		"pass_check" => "SELECT user_password FROM user WHERE user_id = ?",

		//Mise à jour du mot de passe
		"pass_update" => "UPDATE user SET user_password = ? WHERE user_id = ?",

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