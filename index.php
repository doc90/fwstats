<?php
include('funz.php');
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
?>

<html>
	<title>Statistiche ForgottenWorld</title>
	<link rel="stylesheet" type="text/css" href="include/style.css" />
	<link rel="stylesheet" href="include/jquery.treeview.css" />
	<script src="include/jquery.js" type="text/javascript"></script>
	<script src="include/funz.js" type="text/javascript"></script>
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
		$(document).ready(function() {
			carica(<?php echo $mese.','.$anno; ?>);
		});
		
	</script>
	<div id='header'>
	<a href="../">Home</a> - <a onclick="alert('Lavori in corso')">Achievements</a> - <a href="../feedback-supporto-forum-7/7601-novita-statistiche-forgottenworld.html">Feedback</a>
	</div>
	<table width ='100%' cellpadding = '5px'>
		<tr>
			<td align="center" colspan="4">
				<b>Statistiche <span id="p"></span></b>
			</td>
		</tr>
		<tr>
			<td align='left' valign="top" rowspan="2">
				<?php periodi($mese, $anno, $tot); ?>
			</td>
			<td align='center'>
				<div id="toppost"></div>
			</td>
			<td align='center'>
				<div id="topthread"></div>
			</td>
			<td align='center'>
				<div id="topmipiace"></div>
			</td>
		</tr>
		<tr>
			<td align="center" colspan="2">
				<div id="topreply"></div>
			</td>
			<td align="center">
				<div id="topvarie"></div>
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
