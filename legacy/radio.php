<?php
include "inc/header.inc.php";
include("lib/transaction.lib.php");
include "lib/kampfbericht.lib.php";
include 'inc/lang/'.getDefaultVariable('sv_server_lang').'_kampfbericht.lib.lang.php';
include "inc/userartefact.inc.php";
include 'inc/lang/'.getDefaultVariable('sv_server_lang').'_secret.lang.php';



$db_daten=mysql_query("SELECT restyp01, restyp02, restyp03, restyp04, restyp05, sonde, agent, score, techs, sector, system, newtrans, newnews, scanhistory FROM de_user_data WHERE user_id='$ums_user_id'",$db);
$row = mysql_fetch_array($db_daten);
$restyp01=$row[0];$restyp02=$row[1];$restyp03=$row[2];$restyp04=$row[3];
$restyp05=$row[4];$punkte=$row["score"];
$techs=$row["techs"];$newtrans=$row["newtrans"];$newnews=$row["newnews"];$sonde=$row["sonde"];
$agent=$row["agent"];$sector=$row["sector"];$system=$row["system"];
$gr01=$restyp01;$gr02=$restyp02;$gr03=$restyp03;$gr04=$restyp04;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Radio Streams</title>
<?php include "cssinclude.php";?>
</head>
<body>
<?
include "resline.php";
?>
<br><br>
<a target=_blank href="http://www.rgx-radio.com/"><img src="http://grafik-de.maedhros.com/b/rgxbanner1.jpg" border=0></a>
<br><br>

<table>
	<tr><td align=center><strong>Offizielles Die Ewigen Radio</strong></td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td align=center>HINWEIS:<br><br>Die unten angef�hrten Stream-URLs �ffnen Audiostreams direkt vom Server des Radio Betreibers. Das Angebot wird nicht von Die Ewigen bereit gestellt. Die Ewigen haftet nicht f�r Fehler oder Probleme die durch die Nutzung dieses externen Angebots entstehen k�nnten.</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td align=center>
		Stream 1 DSL - Player w�hlen<br><br><br><a href="http://www.auktionenabc.de/RGX/rgx.pls" target=_blank><img src="http://www.rgx-radio.com/images/stories/windsl.gif" alt="listen" with="" winamp="" border="0"></a>&nbsp;<a href="http://www.auktionenabc.de/RGX/11280neu.asx" target=_blank><img src="http://www.rgx-radio.com/images/stories/meddsl.gif" alt="listen" with="" window="" media="" player="" border="0"></a><br>
	</td></tr>
</table>

<div align=center>

</div>

<?php include "fooban.php"; ?>
</body>
</html>
