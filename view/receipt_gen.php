<?php
/**
 * Created by PhpStorm.
 * User: StreetHustling
 * Date: 3/15/16
 * Time: 5:24 PM
 */

require_once 'fpdf.php';

session_start();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'i', 14);

$pdf->Ln();
$pdf->Cell(80, 20, 'Hello World!', 1);
$pdf->Ln();
$pdf->Cell(80, 20, 'Hello World 2!', 1);


$pdf->Ln();
$pdf->Image('images/home/logo.png', 95, 0, 100);
$pdf->Ln();
$aLotOfText = "Lorem Ipsum Vardum Ipsam Decorum Mentusia Vanustsi Advan
How do you restrict directory access by IP address using htaccess?
Overview

This can be a very effective way to protect your Joomla! administrator directory. Any other directory in public_html can be protected in the same way. This method only works if you have a static IP address assigned to you. Anyone attempting to browse such directories using a different IP Address will get a 403 Forbidden error.

Directions

In the directory you wish to protect, open (or create) a file called, .htaccess. (Note the dot at the beginning of the file name.)
Add the following code to this file, replacing 100.100.100.100 in this example with the static IP address you plan to allow:";

$pdf->MultiCell(0, 10, $aLotOfText, 0, 'L');
$pdf->PageNo();


$pdf->AddPage();
$pdf->SetFont('Arial', 'i', 14);
$pdf->Ln();

$pdf->Ln();
$pdf->Cell(80, 20, 'Hello World!', 1);
$pdf->Ln();
$pdf->Cell(80, 20, 'Hello World 2!', 1);


$pdf->Ln();
$pdf->Image('images/home/logo.png', 10, 10, 50);
$pdf->Ln();

$data = $_SESSION['cart_details'];

$headings = array("Item", "Price", "Quantity", "Total");

foreach($headings as $key=>$col){
    if($key == 0){
        $pdf->Cell(80, 7, $col, 1);
    }else{
        $pdf->Cell(30, 7, $col, 1);
    }
}
$pdf->Ln();


foreach ($data as $row) {
    $name = $row['brand_name'] ." ".$row['name']." ".$row['furniture_type'];
    $pdf->Cell(80, 6, $name , 1, 'L');
    $pdf->Cell(30, 6, $row['cost'] , 1, 'L');
    $pdf->Cell(30, 6, $row['count'] , 1, 'L');
    $pdf->Cell(30, 6, $row['itemTotal'] , 1, 'L');
    $pdf->Ln();
}


$pdf->Cell($pdf->PageNo());
$pdf->Output();