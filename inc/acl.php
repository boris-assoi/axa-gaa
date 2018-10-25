<?php 
	/*
	Matrice des droits d'accès
	*/

	//commande
	$acl_manage_store  = array('admin');

	//Attestation
	$acl_manage_certs = array('admin','r_commercial','superviseur','commercial');

	//Attribution d'attestation
	$acl_attrib_cert = array('admin','r_commercial','superviseur');

	//Gestion des ventes
	$acl_sales = array('commercial');

	//Annulation des attestations
	$acl_cert_annul = array('admin','r_commercial','superviseur','commercial');

	//Impression des attestations
	$acl_cert_deliverer = array('commercial');

	//Utilisateur
	$acl_manage_users = array('admin');

	//Centre
	$acl_manage_centers = array('admin');

	//Rapports
	$acl_reports = array('admin','r_commercial','superviseur','commercial');

	//Settings
	$acl_manage_settings = array('admin','r_commercial','superviseur','commercial');
?>