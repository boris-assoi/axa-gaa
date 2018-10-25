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

    // Original PHP code by Chirp Internet: www.chirp.com.au
    // Please acknowledge use of this code by including this header.
    function cleanData(&$str) {
        if($str == 't') $str = 'TRUE';
        if($str == 'f') $str = 'FALSE';
        if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
            $str = "'$str";
        }
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
    }

    // filename for download
    $filename = "LG2A" . date('Ymd h:i') . ".xls";

    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Type: application/vnd.ms-excel");

    $flag = false;

    $start = (isset($_GET['start'])) ? $_GET['start'] : 'null';
    $fin = (isset($_GET['fin'])) ? $_GET['fin'] : 'null';

    if ((empty($_GET['start']) && empty($_GET['fin'])) || (isset($_GET['start']) && isset($_GET['fin']))) {
        $req = $bdd->prepare($models['sales_report']);
        $req -> execute(array($_SESSION['userID']));
    } else {
        $req = $bdd->prepare($models['sales_report_filtered']);
        $req -> execute(array($_SESSION['userID'], $start, $fin));
    }

    while($ok = $req->fetch()) {
        if(!$flag) {
            // display field/column names as first row
            echo implode("\t", array_keys($ok)) . "\r\n";
            $flag = true;
        }
        array_walk($ok, __NAMESPACE__ . '\cleanData');
        echo implode("\t", array_values($ok)) . "\r\n";
    }
    exit;
}
catch (Exception $e)
{
    die('Erreur:'.$e->getMessage());
}
?> 