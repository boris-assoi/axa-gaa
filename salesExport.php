<?php
try
{
    session_start();

    include_once "inc/acl.php";

    /*
    if (!in_array($_SESSION['type'], $acl_mod_com)) {
        header("location: accesDenied.php");
    }
    */
    
    include_once "inc/connection.php";
    include_once "inc/models.php";

    //Inclusion de la classe PHPExcel
    require_once "assets/Classes/PHPExcel.php";

    //Création de l'objet PHPExcel
    $excel = new PHPExcel();

    
    // Edition des propriétés du document
    $excel->getProperties()->setCreator("LG2A")
                                ->setLastModifiedBy("LG2A")
                                ->setTitle("Rapport des attestations - LG2A")
                                ->setSubject("Rapport des attestations - LG2A")
                                ->setDescription("Rapport des attestations, généré par LG2A - Logiciel de Gestion des Attestations Automobiles");

    //Sélectionner la céllule active
    $excel->setActiveSheetIndex(0);

    $start = (isset($_GET['start'])) ? $_GET['start'] : 'null';
    $fin = (isset($_GET['fin'])) ? $_GET['fin'] : 'null';

    if ((empty($_GET['start']) && empty($_GET['fin'])) || (isset($_GET['start']) && isset($_GET['fin']))) {
        $req = $bdd->prepare($models['sales_report']);
        $req -> execute(array($_SESSION['userID']));
    } else {
        $req = $bdd->prepare($models['sales_report_filtered']);
        $req -> execute(array($_SESSION['userID'], $start, $fin));
    }

    //Réalisation des entêtes du tableau
    $excel->getActiveSheet()
        ->setCellValue('A1','ETAT DES ATTESTATIONS') //Titre
        ->setCellValue('A2','Edité par')
        ->setCellValue('B2',$_SESSION['userPrenom'].' '.$_SESSION['userNom'])
        ->setCellValue('A4', 'N° D\'ATTESTATION')
        ->setCellValue('B4', 'STATUT')
        ->setCellValue('C4', 'TYPE D\'ATTESTATION')
        ->setCellValue('D4', 'UNITE DE GESTION')
        ->setCellValue('E4', 'POINT DE VENTE')
        ->setCellValue('F4', 'NUMERO DE POLICE')
        ->setCellValue('G4', 'DATE D\'EFFET')
        ->setCellValue('H4', 'DATE D\'ECHEANCE')
        ->setCellValue('I4', 'CLIENT')
        ->setCellValue('J4', 'PRIME')
        ->setCellValue('K4', 'DATE D\'EDITION')
        ->setCellValue('L4', 'PRODUCTEUR');
    
    //Mise en forme du titre
    $excel->getActiveSheet()->getStyle('A1')->applyFromArray(
        array(
            'font' => array(
                'size' => 24
            )
        )
    );

    //Mise en forme des entêtes du tableau
    $excel->getActiveSheet()->getStyle('A4:L4')->applyFromArray(
        array(
            'font' => array(
                'bold' => true
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        )
    );

    //Variable de numéro de céllule du début des données
    $row = 5;

    while ($ok = $req->fetch()) {
        $excel->getActiveSheet()
            ->setCellValue('A'.$row, $ok['attestation'])
            ->setCellValue('B'.$row, $ok['statut'])
            ->setCellValue('C'.$row, $ok['type'])
            ->setCellValue('D'.$row, $ok['ug'])
            ->setCellValue('E'.$row, $ok['pos'])
            ->setCellValue('F'.$row, $ok['police'])
            ->setCellValue('G'.$row, $ok['startDate'])
            ->setCellValue('H'.$row, $ok['endDate'])
            ->setCellValue('I'.$row, $ok['client'])
            ->setCellValue('J'.$row, $ok['prime'])
            ->setCellValue('K'.$row, $ok['saleDate'])
            ->setCellValue('L'.$row, $ok['commercial']);

        //Incrémentation de la variale de numéro de céllule pour les différentes lignes des données
        $row++;
    } 
    //Ajuster la largeur des cellules
    $excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
    $excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    $excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    $excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    $excel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    $excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
    $excel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    $excel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
    $excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);

    //Ajouter des bordures aux données du tableau

    /* $excel->getActiveSheet()->getStyle('A5:L'.($row - 1))->applyFromArray(
        array(
            'borders' => array(
                'ouline' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ),
                'vertical' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        )
    ); */

    //Renommage de la feuille
    $excel->getActiveSheet()->setTitle('Etat des attestations');
    
    //Redirection vers le navigateur pour le téléchargement plutôt que l'enregistrement direct dans le système de fichiers
    //Le fichier sera au format EXCEL XLSX
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="LG2A -'.date('d-m-Y h-i').'.xlsx"');
    header('Cache-Control: max-age=0');

    //Ecriture du résulat dans le fichier
    $file = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');

    //Faire la sortie en PHP au lieu du nom du fichier
    $file->save('php://output');
}
catch (Exception $e)
{
    die('Erreur:'.$e->getMessage());
}
?> 