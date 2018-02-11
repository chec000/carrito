<?php
/*require('fpdf/fpdf.php');
require('fpdf/fpdi.php');
$pdf = new fpdf();
$pdf->AddPage();

if (!empty($_POST)) {
	$email =  $_POST['email'];
	$pwd = $_POST['pwd'];
}
$pdf->SetFont("Arial");
$pdf->cell(10,10,"welcome {$email}",0,1,C);
$pdf->output();*/

require('fpdf/fpdf.php');
require('fpdi/fpdi.php');
/*$filename="/var/www/html/t/test2.pdf";
$pdf = new fpdi();
$pdf->setSourceFile("test.pdf");
$tplIdx = $pdf->importPage(1, '/BleedBox');
$pdf->addPage();
$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true); 

$pdf->SetFont('Arial');
$pdf->SetTextColor(236,65,65);
$pdf->SetXY(31, 45);

$pdf->Write(2,"Hola mundo");
$pdf->SetTextColor(236,65,65);
$pdf->SetXY(92.5, 45);

$pdf->Write(2,"Hola mundo x2");
$tplIdx = $pdf->importPage(2, '/MediaBox');
$pdf->addPage();
$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true); 
$pdf->Output($filename,'F');*/
if (!empty($_POST)) {
$filename="/var/www/html/t/contract.pdf";
$pdf = new fpdi();
$pdf->setSourceFile("pr.pdf");
$tplIdx = $pdf->importPage(1, '/MediaBox');
$pdf->addPage();
$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true); 

$pdf->SetFont('Arial');
$pdf->SetTextColor(236,65,65);

$pdf->SetXY(51, 35);
$pdf->Write(1,$_POST['email']);
$pdf->SetTextColor(236,65,65);

$pdf->SetXY(45, 55);
$pdf->Write(2,$_POST['pwd']);
$pdf->SetTextColor(236,65,65);

$pdf->SetXY(45, 74);
$pdf->Write(2,md5($_POST['pwd']));
$pdf->SetTextColor(236,65,65);

$pdf->SetXY(25, 202);
$pdf->Write(2,$_POST['name']);
$pdf->SetTextColor(236,65,65);


$pdf->useTemplate($tplIdx, 0, 0, 0, 0, true); 
$pdf->Output();
$pdf->Output($filename,'F');
}else{
	echo "error";
}