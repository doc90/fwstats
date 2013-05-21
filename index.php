<?php
include('funz.php');
if ((isset($_GET['mese'])) && (isset($_GET['anno']))) {
	$mese=(int)$_GET['mese'];
	$anno=(int)$_GET['anno'];
	if (($mese<0)||($mese>12)||($anno<2010)||($anno>Date("Y"))) { //antifurbo 1
		echo '<script>alert("Lascia stare...");location.href = "/fwstats/";</script>';
		exit;
	}
	if (($anno==date("Y")) & ($mese>date("n"))) { //antifurbo 2
		echo '<script>alert("Eh, mica possiamo predire il futuro...");location.href = "/fwstats/";</script>';
		exit;
	}
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
?>

<html>
	<title>Statistiche ForgottenWorld</title>
	<link rel="stylesheet" type="text/css" href="include/style.css" />
	<link rel="stylesheet" href="include/jquery.treeview.css" />
	<script src="include/jquery.js" type="text/javascript"></script>
	<script src="include/jquery.treeview.js" type="text/javascript"></script>
	
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-7958919-13']);
		_gaq.push(['_setDomainName', 'forgottenworld.it']);
		_gaq.push(['_trackPageview']);

		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();

		$(function() { //http://jquery.bassistance.de/treeview/demo/
			$("#tree").treeview({
				collapsed: true,
				animated: "fast",
				control:"#sidetreecontrol",
				prerendered: true,
				persist: "location"
			});
		});
	</script>
	<div id='header'>
	<a href="../">Home</a> - <a a href="#" onclick="alert('Lavori in corso')">Achievements</a> - <a href="../feedback-supporto-forum-7/7601-novita-statistiche-forgottenworld.html">Feedback</a>
	</div>
	<table width ='100%' cellpadding = '5px'>
		<tr>
			<td align="center" colspan="4">
				<b>Statistiche <?php if ($tot==0)
						echo mese_desc($mese).' ';
					echo $anno;?></b>
			</td>
		</tr>
		<tr>
			<td align='left' valign="top" rowspan="2">
				<?php periodi($mese, $anno, $tot); ?>
			</td>
			<td align='center'>
				<?php scrivilistapost($mese, $anno, $mese1, $anno1); ?>
			</td>
			<td align='center'>
				<?php scrivilistathread($mese, $anno, $mese1, $anno1); ?>
			</td>
			<td align='center'>
				<?php scrivimipiace($mese, $anno, $mese1, $anno1); ?>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<?php scrividiscussioni($mese, $anno, $mese1, $anno1); ?>
			</td>
			<td align="center">
				<?php scrivivarie($mese, $anno, $mese1, $anno1); ?>
			</td>
		</tr>
	</table>
	<table width ='100%' cellpadding = '5px'>
		<tr>
			<td align="center" colspan="4">
				<b>Top 5 generali</b>
			</td>
		</tr>
		<tr>
			<td align="center">
				<?php scrivitop5listapost(); ?>
			</td>
			<td align="center">
				<?php scrivitop5listathread(); ?>
			</td>
			<td align="center">
				<?php scrivitop5mipiace(); ?>
			</td>
			<td align="center">
				<?php scrivitop5sezioni(); ?>
			</td>
		</tr>
		<tr>
			<td align="right" colspan="4" id='footer'>
				By <a href="http://www.forgottenworld.it/members/doc.html">Doc</a> - <a href="https://github.com/doc90/fwstats">GitHub</a> - <a href="changelog.txt">Changelog</a>
			</td>
		</tr>
	</table>
</html>
