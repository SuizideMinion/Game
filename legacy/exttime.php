<?php
//tickzeiten laden
include "cache/lasttick.tmp";
include "cache/lastmtick.tmp";
include 'inc/sv.inc.php';
include 'inccon.php';

echo strftime("%H:%M:%S");
echo ";";
echo $lasttick;
echo ";";
echo $lastmtick;

//tickgeschwindigkeit auslesen
$filename="tickler/runtick.sh";
$cachefile = fopen ($filename, 'r');

$wticks=trim(fgets($cachefile, 1024));
$kticks=trim(fgets($cachefile, 1024));

$anzwticksprostunde=0;
for($i=1;$i<=60;$i++)if($wticks[$i]==1)$anzwticksprostunde++;

$anzkticksprostunde=0;
for($i=1;$i<=60;$i++)if($kticks[$i]==1)$anzkticksprostunde++;

echo ";";
echo $anzwticksprostunde;
echo ";";
echo $anzkticksprostunde;

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//rundenlaufzeit
//////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
echo ";";
echo getDefaultVariable('sv_winscore');

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//eh-zeit
//////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
echo ";";
echo getDefaultVariable('sv_benticks');

//////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////
//verbleibende ticks, eh-ticks, br-ticks
//////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////
echo ";";
//rundenstatus auslesen
$db_daten=mysql_query("SELECT MAX(tick) AS tick FROM de_user_data",$db);
$row = mysql_fetch_array($db_daten);
if($row["tick"]<=0)$ticks=1;else $ticks=$row["tick"];
//$ticks=353333000;
if ($ticks<2500000 OR $sv_comserver_roundtyp==1){

	if($sv_comserver_roundtyp==1)$ticks-=2500000;//fix f�r community-server in der BR
	//wenn die ticks kleiner als die maximale tickzahl sind, dann l�uft die runde noch
	if($ticks<getDefaultVariable('sv_winscore')){
		echo 'N'.(getDefaultVariable('sv_winscore')-$ticks);
	}
	else //erhabenenkampf, oder die runde ist zu ende
	{
		//�berpr�fen ob der eh-kampf noch l�uft, oder ab es schon rum ist
		$result = mysql_query("SELECT doetick, winid, winticks FROM de_system",$db);
		$row = mysql_fetch_array($result);
		$doetick=$row["doetick"];
		$winticks=$row["winticks"];
		$winid=$row["winid"];

		if($winticks<=1 AND $doetick==0 AND $winid>0)//rundenende
		{
			echo 'S';
		}
		else //eh-kampf l�uft
		{
			echo 'E'.$winticks;
		}
	}
}
else //battleround
{
	echo 'B';
}
?>
