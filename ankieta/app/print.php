<?php
require('fpdf.php');
require('config.php');
require('pytanie.class.php');
require('ankieta.class.php');
require('nazwa.class.php');
require('user.class.php');

class PDF extends FPDF
{
	public $title;
	public $kod;

// Page header
function Header()
{
	//$title = 'LOL';
	// Logo
	//$this->Image('logo.png',10,5,30);
	// Arial bold 15
	$this->SetFont('Arial','',20);
	// Move to the right
	//$this->Cell(80);
	// Title
	$this->Cell(0,10,$this->title,'B',0,'C');
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
	$this->Cell(0,5,'KOD ANKIETY: '.$this->kod,'T',0,'C');
	$this->ln(3);
	$this->Cell(0,5,'Starostwo Powiatowe w Lipnie',0,0,'C');
	$this->ln(3);
	$this->Cell(0,5,'Sierakowskiego 10B, 87-600 Lipno',0,0,'C');
}

function ChapterTitle($num, $label)
{
	// Arial 12
	$this->SetFont('Arial','',12);
	// Background color
	$this->SetFillColor(200,220,255);
	// Title
	$this->Cell(0,6,"Chapter $num : $label",0,1,'L',true);
	// Line break
	$this->Ln(4);
}

function ChapterBody($nr, $pytanie, $odpowiedz, $uwaga)
{
	$pytanie = iconv('UTF-8','ISO8859-2', $pytanie);
	$odpowiedz = iconv('UTF-8','ISO8859-2', $odpowiedz);
	$uwaga = iconv('UTF-8','ISO8859-2', $uwaga);
	$this->MultiCell(0,5,($nr+1).'.'.$pytanie,0,1);
	$this->Cell(5,0,'',0,0);
	$this->MultiCell(0,5,$odpowiedz,0,1);
	$this->Cell(5,0,'',0,0);
	$this->MultiCell(0,5,$uwaga,0,1);

	$poz = $this->GetY();
	//$this->MultiCell(0,5,$poz,0,1);

	$hei = $this->GetPageHeight();
	//$this->MultiCell(0,5,$hei,0,1);
	$this->ln(4);

	if ($hei - $poz < 50) {
		$this->AddPage();
	}
}

function PrintChapter($nr, $pytanie, $odpowiedz, $uwaga)
{
	//$this->AddPage();
	//$this->ChapterTitle($num,$title);
	$this->ChapterBody($nr, $pytanie, $odpowiedz, $uwaga);
}
}

// Instanciation of inherited class

$ank = array();
if (isset($_POST['ankietakod'])){
	$ankietakod = $_POST['ankietakod'];           
    $sql = "SELECT nazwa, odpowiedz, uwagi FROM Ankiety WHERE kod = '$ankietakod' ORDER BY `pytanie`";
    if(!$wynik = $conn->query($sql)){
        die('Unable to execute querry [' . $conn->connect_error . ']');
    }
    while($row = $wynik->fetch_assoc()){
        $ank[] = array("nazwa"=> $row['nazwa'], "odpowiedz"=>$row['odpowiedz'], "uwagi"=>$row['uwagi']);
    }
	$nazwaAnkiety = $ank[0]['nazwa'];

    $pdf = new PDF();
    $pdf->title = 'Ankieta: '.$nazwaAnkiety;
    $pdf->kod = $ankietakod;
	$pdf->AliasNbPages();
	$pdf->AddFont('arialpl','','arialpl.php');
	$pdf->SetFont('arialpl','',10);
	$pdf->AddPage();

	
                                                             
    $ankieta = new Pytania($conn, $nazwaAnkiety);
    $p = $ankieta->czytaj_pytania_z_bazy();
    $i = 0;
    foreach($p as $pytanie){
        if ($ank[$i]['odpowiedz'] == 1){
            $odp =  'TAK';
        }
        else{
            $odp = 'NIE';
        }
        $pdf->PrintChapter($i, $pytanie->p, $odp, $ank[$i]['uwagi']);
        $i++;
    }

}
$pdf->Output();
?>
