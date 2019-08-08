<?php
require "../assets/fpdf/fpdf.php";

//Récupération du JSON et sérialisation en tableau
//$data = $_POST['results'];

//Création de la classe pdf étendue de FPDF
class myPDF extends FPDF
{
    function header()
    {
        $this->Image('../images/print-logo.png', 10, 6, 50);
        $this->AddFont('segoeui');
        $this->AddFont('segoeuil');
        $this->AddFont('segoeuib');
        $this->AddFont('segoeuii');
        $this->AddFont('segoeuiz');
        $this->SetFont('segoeuib', '', 12);
        $this->Cell(200, 7, "PROPOSITION D'ASSURANCE AUTOMOBILE", 0, 0, 'C');
        $this->Ln();
        $this->Cell(200, 7, "POLICE: XXXXXXXXXX", 0, 0, 'C');
        $this->Ln(20);
    }

    function footer()
    {
        $this->SetY(-15);
        $this->SetFont('segoeui', '', 8);
        $this->Cell(0, 10, "Page " . $this->PageNo() . "/{nb}", 0, 0, 'C');
    }

    function headerBloc($title)
    {
        $this->SetFont('segoeuib', '', 9);
        $this->Cell(0, 7, $title, 1, 0, 'C');
        $this->Ln();
    }

    function printInfo($label, $info)
    {
        $this->SetFont('segoeui', '', 6);
        $this->Cell(40, 4, "$label :", 0, 0, 'L');
        $this->SetFont('segoeuib', '', 6);
        $this->Cell(150, 4, "$info", 0, 0, 'L');
        $this->Ln();
    }

    function infoSubscriber()
    {
        $this->printInfo("Nom et prenom(s)", "Boris Assoi");
        $this->printInfo("Classe d' anciennete", "Classe 2");
        $this->printInfo("Statut socio-professionnel", "A");
        $this->printInfo("Telephone", "09090909");
        $this->printInfo("Adresse", "Yopougon, Abidjan");
    }

    function infoVehicle()
    {
        $this->printInfo(
            "Usage du vehicule",
            "VEHICULES A CARROSSERIE DE TOURISME APPARTENANT A DES PERSONNES PHYSIQUES, UTILISES TANT POUR LES BESOINS PROFESSIONNELS QUE PRIVES ET QUI SONT AMENAGES POUR LE TRANPORT DES PERSONNES"
        );
        $this->printInfo("Immatriculation", "3892IJ01");
        $this->printInfo("Energie", "Diesel");
        $this->printInfo("Puissance fiscale", "20");
        $this->printInfo("Numero de chassis", "38349238432JN");
        $this->printInfo("Date de mise en circulation", "2014-07-24");
        $this->printInfo("Marque", "MAZDA");
        $this->printInfo("Valeur neuve", "22000000");
        $this->printInfo("Valeur venale", "8106450");
    }

    function infoPolice()
    {
        $this->printInfo("Type de vente", "Affaire nouvelle");
        $this->printInfo("Formule", "TIERCE COMPLETE");
        $this->printInfo("Echeance", "du 25-07-2019 au 21-07-2020");
        $this->printInfo("Résumé de la formule", "Formule de tierce complete");
    }
}

$pdf = new myPDF();
$pdf->SetCreator('LG2A');
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4', 0);
$pdf->headerBloc("IDENTIFICATION DU SOUCRIPTEUR");
$pdf->infoSubscriber();
$pdf->headerBloc('IDENTIFICATION DU VEHICULE');
$pdf->infoVehicle();
$pdf->headerBloc("DATE D'EFFET ET CHOIX DE FORMULE");
$pdf->infoPolice();
$pdf->output();
