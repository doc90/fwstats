<?php
include("../includes/config.php"); //config di vbulletin

$host=$config['MasterServer']['servername'];
$user=$config['MasterServer']['username'];
$pass=$config['MasterServer']['password'];
$nomedb=$config['Database']['dbname'];


//////////////////////////////
// Funzioni niubbe database //
//////////////////////////////

function connetti(&$db) {
	global $host, $user, $pass, $nomedb;
	$db = new mysqli($host, $user, $pass, $nomedb);
	if (mysqli_connect_errno()) {
		echo 'Connessione fallita';
		exit ;
	}
}

function seleziona(&$db, $query) {
	return $db -> query($query);
}

function get_num_rows($result) {
	return $result -> num_rows;
}

function scorri_record($result) {
	return $result -> fetch_assoc();
}


//////////////////////////////
// Funzioni creazione liste //
//////////////////////////////

function scrivilistapost($mese, $anno, $mese1, $anno1) { //top 10 per numero post
	connetti($db);
	$query = "SELECT username, count(*) post FROM vb_post WHERE dateline >= unix_timestamp(DATE('" . $anno . "-" . $mese . "-01')) and dateline < unix_timestamp(DATE('" . $anno1 . "-" . ($mese1) . "-01')) and username<>'' and userid<>770 group by username order by post desc limit 10";
	$result = seleziona($db, $query);
	$n_righe = get_num_rows($result);
	if ($n_righe > 0) {
		echo '<table>';
		echo '<tr><th>Username</th><th>Post scritti</th></tr>';
		for ($i = 0; $i < $n_righe; $i++) {
			$riga = scorri_record($result);
			echo '<tr><td>' . $riga['username'] . '</td><td>' . $riga['post'] . '</td></tr>';
		}
		echo '</table>';
	}
}

function scrivilistathread($mese, $anno, $mese1, $anno1) { //top 10 per numero discussioni
	connetti($db);
	$query = "SELECT postusername, count(*) thread FROM `vb_thread` WHERE dateline >= unix_timestamp(DATE('".$anno."-".$mese."-01')) and dateline < unix_timestamp(DATE('" . $anno1 . "-" . ($mese1) . "-01')) and postusername<>'' and postuserid<>770 group by postusername order by thread desc limit 10";
	$result = seleziona($db, $query);
	$n_righe = get_num_rows($result);
	if ($n_righe > 0) {
		echo '<table>';
		echo '<tr><th>Username</th><th>Thread aperti</th></tr>';
		for ($i = 0; $i < $n_righe; $i++) {
			$riga = scorri_record($result);
			echo '<tr><td>' . $riga['postusername'] . '</td><td>' . $riga['thread'] . '</td></tr>';
		}
		echo '</table>';
	}
}

function scrividiscussioni($mese, $anno, $mese1, $anno1) { //top 10 discussioni per reply
	connetti($db);
	$query="select title, postusername, replycount from vb_thread where dateline >= unix_timestamp(DATE('".$anno."-".$mese."-01')) and dateline < unix_timestamp(DATE('" . $anno1 . "-" . ($mese1) . "-01')) and postusername<>'' and postuserid<>770 order by replycount desc limit 10";
	$result = seleziona($db, $query);
	$n_righe = get_num_rows($result);
	if ($n_righe > 0) {
		echo '<table>';
		echo '<tr><th>Username</th><th>Thread</th><th>Reply</th>';
		for ($i = 0; $i < $n_righe; $i++) {
			$riga = scorri_record($result);
			echo '<tr><td>' . $riga['postusername'] . '</td><td>' . trunc($riga['title'],50) . '</td><td>' . $riga['replycount'] . '</td></tr>';
		}
		echo '</table>';
	}
}

function scrivimipiace($mese, $anno, $mese1, $anno1) { //top 10 "mi piace"
	connetti($db);
	$query="SELECT username, count(*) n FROM vb_vbseo_likes left join vb_user on l_dest_userid=userid where l_dateline >= unix_timestamp(DATE('".$anno."-".$mese."-01')) and l_dateline < unix_timestamp(DATE('" . $anno1 . "-" . ($mese1) . "-01')) and username<>'' and userid<>770 group by username order by n desc limit 10";
	$result = seleziona($db, $query);
	$n_righe = get_num_rows($result);
	if ($n_righe > 0) {
		echo '<table>';
		echo '<tr><th>Username</th><th>"Mi piace" ricevuti</th>';
		for ($i = 0; $i < $n_righe; $i++) {
			$riga = scorri_record($result);
			echo '<tr><td>' . $riga['username'] . '</td><td>' . trunc($riga['n'],50) . '</td></tr>';
		}
		echo '</table>';
	}
}

function periodi($mese,$anno,$tot) { //treeview periodi
	connetti($db);
	$query = "select distinct year(from_unixtime(`dateline`)) a from vb_post order by a desc";
	$result = seleziona($db, $query);
	$n_righe = get_num_rows($result);
	if ($n_righe > 0) {
		echo '<div id="sidetreecontrol" style="padding-top:10px"> <a href="">Comprimi</a> | <a href="">Espandi</a> </div>
		Anni
		<ul class="treeview" id="tree">';
		for ($i = 0; $i < $n_righe; $i++) {
			$anni = scorri_record($result);
			$query = "select distinct month(from_unixtime(`dateline`)) m from vb_post where year(from_unixtime(`dateline`)) = ".$anni['a']." order by m asc";
			$result2 = seleziona($db, $query);
			$n_righe2 = get_num_rows($result2);
			if ($n_righe2>0) {
				echo '<li class="expandable"><div class="hitarea expandable-hitarea"></div> ';
				if ((int)$anni['a']==$anno)
					echo '<a href="index.php?mese=0&anno='.$anni['a'].'"><b>'.$anni['a'].'</b></a>';
				else 
					echo '<a href="index.php?mese=0&anno='.$anni['a'].'">'.$anni['a'].'</a>';
				echo '<ul style="display: none;">';
				for ($z=0; $z<$n_righe2; $z++) {
					$mesi=scorri_record($result2);
					if ($tot==0 && (((int)$mesi['m']==$mese) && ((int)$anni['a']==$anno))){
						echo '<li><a href="index.php?mese='.$mesi['m'].'&anno='.$anni['a'].'"><b>'.mese_desc($mesi['m']).'</b></a></li>';
						}
					else {
						echo '<li><a href="index.php?mese='.$mesi['m'].'&anno='.$anni['a'].'">'.mese_desc($mesi['m']).'</a></li>';
						}
				}
				echo '</ul></li>';
			}
		}
		echo '</ul>';
	}
}


/////////////
// Utility //
/////////////

function mese_desc($i) {
	switch ($i) {
		case 1: return 'Gennaio';    break;
		case 2: return 'Febbraio';   break;
		case 3: return 'Marzo';      break;
		case 4: return 'Aprile';     break;
		case 5: return 'Maggio';     break;
		case 6: return 'Giugno';     break;
		case 7: return 'Luglio';     break;
		case 8: return 'Agosto';     break;
		case 9: return 'Settembre';  break;
		case 10: return 'Ottobre';   break;
		case 11: return 'Novembre';  break;
		case 12: return 'Dicembre';  break;
		
		default: return '---';       break;
	}
}

function trunc($s, $l) { //se $s è più lunga di $l caratteri la tronca e ci aggiunge '...'
	if (strlen($s) > $l) 
		$r=substr($s,0,($l-3)).'...'; 
	else
		$r=$s;
	return $r;
}

?>