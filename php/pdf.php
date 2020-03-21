<?php

use setasign\Fpdi\Fpdi;
require_once('../vendor/setasign/fpdf/fpdf.php');
require_once('../vendor/setasign/fpdi/src/autoload.php');


// initiate FPDI
$pdf = new Fpdi();
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile('../attestation.pdf');
// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page and place it at position 10,10 with a width of 100 mm
$pdf->useTemplate($tplIdx, 0, 0);

// now write some text above the imported page
$pdf->SetFont('Helvetica');
$pdf->SetTextColor(0, 0, 0);

// write name and last name
$pdf->SetXY(48, 75);
$pdf->Write(0, $_POST['name'].' '.$_POST['lastName']);

// write birthday
$pdf->SetXY(48, 85);
$pdf->Write(0, $_POST['date']);

// write address
$pdf->SetXY(48, 98);
$pdf->Write(0, $_POST['address']);

// write postcode and city
$pdf->SetXY(48, 108);
$pdf->Write(0, $_POST['postCode'].' '.$_POST['city']);

// write city and date
$pdf->SetXY(131, 246);
$pdf->Write(0, $_POST['city']);
$pdf->SetXY(168, 246);
$pdf->Write(0, date("j"));
$pdf->SetXY(176, 246);
$pdf->Write(0, date("m"));

$pdf->SetFontSize(20);

if ($_POST['reason'] == '1') {
    $pdf->SetXY(20, 150);
    $pdf->Write(0, 'X');
} elseif ($_POST['reason'] == '2') {
    $pdf->SetXY(20, 175);
    $pdf->Write(0, 'X');
} elseif ($_POST['reason'] == '3') {
    $pdf->SetXY(20, 188);
    $pdf->Write(0, 'X');
} elseif ($_POST['reason'] == '4') {
    $pdf->SetXY(20, 200);
    $pdf->Write(0, 'X');
} elseif ($_POST['reason'] == '5') {
    $pdf->SetXY(20, 218);
    $pdf->Write(0, 'X');
}

$pdf->SetXY(20, 250);
$data_uri = $_POST["signValue"];
$encoded_image = explode(",", $data_uri)[1];
$decoded_image = base64_decode($encoded_image);
file_put_contents("signature.png", $decoded_image);
$pdf->Image('signature.png',150,260,-300);

$pdf->Output("I", "attestation.pdf");