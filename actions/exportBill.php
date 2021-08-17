<?php
require_once('../utils/database.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

require('../lib/fpdf.php');
require_once('../lib/PHPMailer/src/PHPMailer.php');
require_once('../lib/PHPMailer/src/Exception.php');

$bdd = getDatabaseConnection();
$q = 'SELECT * FROM activities WHERE start >= ? AND start <= ? ORDER BY activities.id_member ASC';
$req = $bdd->prepare($q);
$req->execute([$_GET['start_month'] , $_GET['end_month']]);
$results = $req->fetchAll();
if (count($results) == 0){
    header( "location:../trainer_space.php?msg=No activities to export");
}else{
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10, "Export mensuel des activités");
    $pdf->Ln();
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(40,10, "Détail par membre:");
    $pdf->Ln();

    $member_id = 0;
    $member_total = 0;
    foreach ($results as $key => $activity) {
        $q2 = 'SELECT (firstname, lastname, mail) FROM members WHERE id = ?';
        $req2 = $bdd->prepare($q2);
        $req2->execute([$activity['id_member']]);
        $results2 = $req2->fetchAll();
        if ($member_id == $activity['id_member']) {
            $pdf->SetFont('Arial','',12);
            $pdf->Cell(40, 10, 'Type d\'activité : ' . $activity['type']);
            $pdf->Ln();
            $pdf->Cell(40, 10, 'Date de début : ' . $activity['start']);
            $pdf->Ln();
            $pdf->Cell(40, 10, 'Date de fin : ' . $activity['end']);
            $pdf->Ln();
            $pdf->Cell(40, 10, 'Coût : ' . $activity['cost'] . ' EUR');
            $pdf->Ln();

            $member_total += $activity['cost'];
        }else{
            if ($member_id != 0) {
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell(40, 10, 'Total :' . $member_total . ' EUR');
                $pdf->Ln();
                $member_total = 0;
            }
            $member_id = $activity["id_member"];
            $pdf->SetFont('Arial','',14);
            $pdf->Cell(40, 10, 'Nom complet :' . $results2['lastname'] . ' ' . $results2['firstname']);
            $pdf->Ln();
            $pdf->Cell(40, 10, 'Adresse mail :' . $results2['mail']);
            $pdf->Ln();

            $pdf->SetFont('Arial','',12);
            $pdf->Cell(40, 10, 'Type d\'activité : ' . $activity['type']);
            $pdf->Ln();
            $pdf->Cell(40, 10, 'Date de début : ' . $activity['start']);
            $pdf->Ln();
            $pdf->Cell(40, 10, 'Date de fin : ' . $activity['end']);
            $pdf->Ln();
            $pdf->Cell(40, 10, 'Coût : ' . $activity['cost'] . ' EUR');
            $pdf->Ln();

            $member_total += $activity['cost'];
        }

    }

    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(40, 10, 'Total :' . $member_total . ' EUR');
    $pdf->Ln();

    $filename = "Bill" .'-'. time() . ".pdf";
    $absoluteFilename = dirname(__DIR__) . "/Bills/" . $filename;
    $pdf->Output("F", $absoluteFilename);

    $email = new PHPMailer();
    $email->SetFrom('BillService@aeroclub.com');
    $email->Subject   = "Export mensuel des activités";
    $email->Body      = "Veuillez trouvez ci_joint l'export mensuel des activités de nos memberes.";
    $email->AddAddress("kicass@free.fr");

    $email->AddAttachment( $absoluteFilename , $filename );

    try {
        $email->Send();
        header( "location:../trainer_space.php?msg=Export envoyé avec succès");
    } catch (Exception $exc) {
        header( 'location:../trainer_space.php?msg=' . $exc->getMessage());
    }
}
