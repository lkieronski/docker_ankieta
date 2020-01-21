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
// Page header
function Header()
{
	//$title = 'LOL';
	// Logo
	//$this->Image('logo.png',10,5,30);
	$this->SetFont('Arial','',20);
	$this->Cell(0,10,$this->title,'B',0,'C');
	$this->Ln(16);
}

// Page footer
function Footer()
{
	// Position at 1.5 cm from bottom
	$this->SetY(-15);
	// Arial italic 8
	$this->SetFont('Arial','I',8);
	$this->Cell(0,5,'Strona: '.$this->PageNo().'/{nb}','T',0,'C');
	$this->ln(3);
	$this->Cell(0,5,'Starostwo Powiatowe w Lipnie',0,0,'C');
	$this->ln(3);
	$this->Cell(0,5,'Sierakowskiego 10B, 87-600 Lipno',0,0,'C');
}

function PrintChapter($i, $p, $a, $last)
{
	$pytanie = iconv('UTF-8','ISO8859-2', $p->p);
    $la = $a->policz_ankiety_w_bazie($p->nazwa, $p->nr); // liczba udzielonych odpowiedzi
    $lnt = $a->policz_ankiety_w_bazie_na_tak($p->nazwa, $p->nr); // liczba udzielonych odpowiedzi na tak
    $lnn = $la - $lnt;
    //echo '<h4>Uwagi do pytania:</h4>';
    $aa = $a->czytaj_ankiety_z_bazy_z_uwagami($p->nazwa, $p->nr);
    $j=1;

    

    $this->MultiCell(0,5,$i.'.'.$pytanie,0,1);
    $this->Ln();
    $this->MultiCell(0,5,"Udzielone odpowiedzi: \nTAK: ".$lnt." | NIE: ".$lnn,0,'C');
    $this->Cell(2,0,'',0,0);
	$this->MultiCell(0,5,'Uwagi do pytania:',0,1);
    foreach ($aa as $aaa){
        if ($aaa->odpowiedz == 1){
            $odpowiedz = 'TAK';
        }
        else{
            $odpowiedz = 'NIE';
        }
        $uwaga = iconv('UTF-8','ISO8859-2', $aaa->uwagi);
        $this->Cell(3,0,'',0,0);
        $this->MultiCell(0,5,'-'.$odpowiedz.': '.$uwaga,0,1);
        $j++;
    }
    $this->Ln(6);

	$poz = $this->GetY();
	$hei = $this->GetPageHeight();
	$this->ln(4);
	if (($hei - $poz) < 60 && !($last)) {
		$this->AddPage();
	}
}

}

if (isset($_POST['ankieta'])){
	$ankieta = $_POST['ankieta'];
	$n = new Nazwa($conn);
	$nazwy = $n->czytaj_nazwy_z_bazy();
	$a = new Ankieter($conn);
	$pytania = $a->pobierz_pytania_z_bazy($ankieta);
	$pnazwa = $pytania[0]->nazwa;
	$pnr = $pytania[0]->nr;
	
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->title = 'Ankieta: '.$ankieta;
    $la = $a->policz_ankiety_w_bazie($pnazwa, $pnr);
	//$pdf->AliasNbPages();
	$pdf->AddFont('arialpl','','arialpl.php');
	$pdf->SetFont('arialpl','',10);
	$pdf->AddPage();
	$pdf->MultiCell(0,5,'LICZBA ANKIET: '.$la,0,'C');
	$pdf->Ln(10);
	$i=1;
	$lp = count($pytania);
	$last = false;
	foreach ($pytania as $p){
		if ($i == $lp) $last = true;
		$pdf->PrintChapter($i, $p, $a, $last);
	    $i++;
		}
	} 
$pdf->Output();
?>
