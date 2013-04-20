<?php

// Sanitize fetched result.
array_walk($result, function(&$value, $key) {
	$search  = array('ć', 'č', 'đ', 'š', 'ž', 'Ć', 'Č', 'Đ', 'Š', 'Ž');
	$replace = array('c', 'c', 'd', 's', 'z', 'C', 'C', 'D', 'S', 'Z');

	$value = str_replace($search, $replace, $value);
});

extract($result);

// Generate the filename.
$filename_prefix = str_replace('/', '_', formatDate($document_date));
$filename = strtolower(preg_replace('#[^a-zA-Z0-9]+#', '_', $patient_full_name));
$filename_suffix = $document_uid;
$filename_format = '.pdf';

$filename = $filename_prefix . '-' . $filename . '-' . $filename_suffix . $filename_format;

// New PDF document.
require 'library/fPDF/fPDF.php';

$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial', 'B');
$pdf->MultiCell(0, 10, 'e-Zdravstvo, 2011.', 'B');
$pdf->ln(6);

// Document header.
$pdf->SetFont('Arial', 'B', 9);
$pdf->MultiCell(0, 10, 'Zaglavlje dokumenta:', 'B');
$pdf->ln(6);

$pdf->SetFont('Arial', '');
$pdf->Cell(30, 6, 'Jedinstveni broj:', 1);
$pdf->Cell(60, 6, padString($document_uid, 5), 1, 1);
$pdf->Cell(30, 6, 'Serija:', 1);
$pdf->Cell(60, 6, $document_series, 1, 1);
$pdf->Cell(30, 6, 'Broj:', 1);
$pdf->Cell(60, 6, padString($document_number, 3), 1, 1);
$pdf->Cell(30, 6, 'Nadnevak:', 1);
$pdf->Cell(60, 6, formatDate($document_date), 1, 1);
$pdf->ln(2);

// Patient information.
$pdf->SetFont('Arial', 'B');
$pdf->MultiCell(0, 10, 'Pacijent:', 'B');
$pdf->ln(6);

$pdf->SetFont('Arial', '');
$pdf->Cell(30, 6, 'Oznaka:', 1);
$pdf->Cell(60, 6, $patient_code, 1, 1);
$pdf->Cell(30, 6, 'Ime i prezime:', 1);
$pdf->Cell(60, 6, $patient_full_name, 1, 1);
$pdf->Cell(30, 6, 'Spol:', 1);
$pdf->Cell(60, 6, $patient_gender, 1, 1);
$pdf->Cell(30, 6, 'Broj godina:', 1);
$pdf->Cell(60, 6, $patient_age, 1, 1);
$pdf->ln(6);

// Document contents.
$pdf->SetFont('Arial', 'B');
$pdf->MultiCell(0, 10, 'Sadrzaj dokumenta:', 'B');
$pdf->ln(4);

if ($anamnesis) {
	$pdf->SetFont('Arial', 'U');
	$pdf->Cell(30, 6, 'Anamneza:', 0, 1);
	$pdf->SetFont('Arial', '');
	$pdf->MultiCell(0, 6, $anamnesis);
	$pdf->ln(2);
}

if ($examination) {
	$pdf->SetFont('Arial', 'U');
	$pdf->Cell(30, 6, 'Pregled:', 0, 1);
	$pdf->SetFont('Arial', '');
	$pdf->MultiCell(0, 6, $examination);
	$pdf->ln(2);
}

if ($diagnosis) {
	$pdf->SetFont('Arial', 'U');
	$pdf->Cell(30, 6, 'Dijagnoza:', 0, 1);
	$pdf->SetFont('Arial', '');
	$pdf->MultiCell(0, 6, $diagnosis);
	$pdf->ln(2);
}

if ($therapy) {
	$pdf->SetFont('Arial', 'U');
	$pdf->Cell(30, 6, 'Terapija:', 0, 1);
	$pdf->SetFont('Arial', '');
	$pdf->MultiCell(0, 6, $therapy);
	$pdf->ln(2);
}

if ($recommendation) {
	$pdf->SetFont('Arial', 'U');
	$pdf->Cell(30, 6, 'Preporuka:', 0, 1);
	$pdf->SetFont('Arial', '');
	$pdf->MultiCell(0, 6, $recommendation);
}

// Output PDF document.
$pdf->Output($filename, 'D');