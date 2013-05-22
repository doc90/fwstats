<?php
include('funz.php');

if(isset($_GET['t'])) {
    $t = (int)$_GET['t'];
}
if ((isset($_GET['mese'])) && (isset($_GET['anno']))) {
	$mese=(int)$_GET['mese'];
	$anno=(int)$_GET['anno'];
	antifurbo($mese,$anno);
}	
else { //se nessuna data è specificata allora prendo in automatico l'ultimo mese
	$mese=date("n");
	$anno=date("Y");
}

switch ($mese) {
	case 0: //tutto l'anno
		$mese=1;
		$mese1=1;
		$anno1=$anno+1;
		$tot=1;
		break;
	case 12: //dicembre
		$mese1=1;
		$anno1=$anno+1;
		$tot=0;
		break;
	default:
		$mese1=$mese+1;
		$anno1=$anno;
		$tot=0;
		break;
}

switch ($t) {
	case 0:
		if ($tot==1)
			$a=array('mese' => '', 'anno' => $anno);
		else
			$a=array('mese' => mese_desc($mese), 'anno' => $anno);
		echo json_encode($a);
		break;
	case 1:
		scrivilistapost($mese, $anno, $mese1, $anno1);
		break;
	case 2:
		scrivilistathread($mese, $anno, $mese1, $anno1);
		break;
	case 3:
		scrivimipiace($mese, $anno, $mese1, $anno1);
		break;
	case 4:
		scrividiscussioni($mese, $anno, $mese1, $anno1);
		break;
	case 5:
		scrivivarie($mese, $anno, $mese1, $anno1);
		break;
	default:
		exit;
		break;
	}
?>