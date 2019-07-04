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
        $this->SetFont('segoeui', '', 14);
        $this->Cell(200, 7, "PROPOSITION D'ASSURANCE AUTOMOBILE", 0, 0, 'C');
        $this->Ln();
        $this->Cell(200, 7, "POLICE: XXXXXXXXXX", 0, 0, 'C');
        $this->Ln(20);
    }

    function footer()
    {
        $this->SetY(-15);
        $this->SetFont('segoeui', '', '8');
        $this->Cell(0, 10, "Page " . $this->PageNo() . "/{nb}", 0, 0, 'C');
    }

    function printSubscriber()
    {
        $this->SetFont('segoeuil', '', 11);
        $this->Cell(0, 7, "IDENTIFICATION DU SOUSCRIPTEUR", 1, 0, 'C');
        $this->Ln();
    }
}

$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A4', 0);
$pdf->printSubscriber();
$pdf->output();
