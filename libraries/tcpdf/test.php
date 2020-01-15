<?php

require_once('config/tcpdf_config.php');

require_once('tcpdf.php');

 

// create new PDF document

$pdf = new TCPDF(); 

 

// set font

$pdf->SetFont('times', '', 16);

 

// add a page

$pdf->AddPage();

 

// print a line

$pdf->Cell(0, 0, 'Some text');

 

// print html formated text

$pdf->writeHtml('Html text:<br /><b>Bold</b>');

 

// draw a circle

$pdf->Circle(30, 30, 10);

 

//Close and output PDF document

$pdf->Output('out.pdf', 'I');

?>