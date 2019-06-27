<?php
$data = $_POST['results'];

//Insertion du template
ob_start();
require_once('template_nc.php');
$template = ob_get_clean();

//Insertion de la librairie Dompdf
require_once('../assets/dompdf/autoload.inc.php');
use Dompdf\Dompdf;

//Instance de Dompdf
$dompdf = new Dompdf();
$dompdf->load_html($template);

//Ajustement de la page
$dompdf->setPaper('A4', 'portrait');

//Génération du rendu pdf
$dompdf->render();

//Sortie dans le navigateur
$dompdf->stream('NC-' . date('l, d-n-y'));

//Sortie dans un fichier
file_put_contents('../assets/NC-' . date('l, d-n-y') . '.pdf', $dompdf->output());

return $template;

header("location: index.php");
