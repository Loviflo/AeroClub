<?php
require_once('../utils/database.php');


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

require('../lib/fpdf.php');
require_once('../lib/PHPMailer/src/PHPMailer.php');
require_once('../lib/PHPMailer/src/Exception.php');

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('../Images/Logo.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',16);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(80,10,'Export mensuel des activités',1,0,'C');
        // Line break
        $this->Ln(20);
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$bdd = getDatabaseConnection();
$q = 'SELECT * FROM schedule WHERE date >= ? AND date <= ? ORDER BY schedule.id_member ASC';
$req = $bdd->prepare($q);
$req->execute([$_GET['start_month'] , $_GET['end_month']]);
$results = $req->fetchAll();
if (count($results) == 0){
    header( "location:../trainer_space.php?msg=No activities to export");
}else{
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(40,10, "Détail par membre:");
    $pdf->Ln();

    $member_id = 0;
    $member_total = 0;
    foreach ($results as $key => $activity) {
        $q2 = 'SELECT * FROM members WHERE id = ?';
        $req2 = $bdd->prepare($q2);
        $req2->execute([$activity['id_member']]);
        $results2 = $req2->fetchAll();
        if ($member_id == $activity['id_member']) {
            $q3 = 'SELECT * FROM activities WHERE id = ?';
            $req3 = $bdd->prepare($q3);
            $req3->execute([$activity['id_activity']]);
            $results3 = $req3->fetchAll();

            $pdf->SetFont('Arial','',12);
            $pdf->Cell(40, 10, '    Type d\'activité : ' . $results3[0]['type']);
            $pdf->Ln();
            $pdf->Cell(40, 10, '    Date de début : ' . $activity['date']);
            $pdf->Ln();
            $pdf->Cell(40, 10, '    Heure de début : ' . $activity['hour']);
            $pdf->Ln();
            $pdf->Cell(40, 10, '    Durée : ' . $activity['length'] . ' heure(s)');
            $pdf->Ln();
            $pdf->Cell(40, 10, '        Coût : ' . $results3[0]['cost'] . ' EUR');
            $pdf->Ln();

            $member_total += $results3[0]['cost'];
        }else{
            $q3 = 'SELECT * FROM activities WHERE id = ?';
            $req3 = $bdd->prepare($q3);
            $req3->execute([$activity['id_activity']]);
            $results3 = $req3->fetchAll();

            if ($member_id != 0) {
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell(40, 10, 'Total :' . $member_total . ' EUR');
                $pdf->Ln();
                $member_total = 0;
            }
            $member_id = $activity["id_member"];
            $pdf->SetFont('Arial','',14);
            $pdf->Cell(40, 10, ' Nom complet : ' . $results2[0]['lastname'] . ' ' . $results2[0]['firstname']);
            $pdf->Ln();
            $pdf->Cell(40, 10, ' Adresse mail : ' . $results2[0]['mail']);
            $pdf->Ln();

            $pdf->SetFont('Arial','',12);
            $pdf->Cell(40, 10, '    Type d\'activité : ' . $results3[0]['type']);
            $pdf->Ln();
            $pdf->Cell(40, 10, '    Date de début : ' . $activity['date']);
            $pdf->Ln();
            $pdf->Cell(40, 10, '    Heure de début : ' . $activity['hour']);
            $pdf->Ln();
            $pdf->Cell(40, 10, '    Durée : ' . $activity['length'] . ' heure(s)');
            $pdf->Ln();
            $pdf->Cell(40, 10, '        Coût : ' . $results3[0]['cost'] . ' EUR');
            $pdf->Ln();

            $member_total += $results3[0]['cost'];
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
    $email->Body      = "Veuillez trouvez ci_joint l'export mensuel des activités de nos membres.";
    $email->AddAddress("kicass@live.fr");

    $email->AddAttachment( $absoluteFilename , $filename );

    try {
        $email->Send();
        header( "location:../trainer_space.php?msg=Export envoyé avec succès");
    } catch (Exception $exc) {
        header( 'location:../trainer_space.php?msg=' . $exc->getMessage());
    }
}
