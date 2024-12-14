<?php
include "../inccon.php";
//sv.inc.php includen
include "../inc/sv.inc.php";
?>
<html>
<head>
<?php include "cssinclude.php";?>
</head>
<body>
<form action="de_server_einstellungen.php" method="post">
<div align="center">
<?php

include "det_userdata.inc.php";

if ($savedata)
{
  $filename="../inc/sv.inc.php";
  $cachefile = fopen ($filename, 'w');

  $str="<?php\n\n";

  $str.='getDefaultVariable('sv_image_server')="'.getDefaultVariable('sv_image_server').'";'."\n";

  for ($i=0;$i<count(getDefaultVariable('sv_image_server_list'));$i++)
  $str.='getDefaultVariable('sv_image_server_list')[]="'.getDefaultVariable('sv_image_server_list')[$i].'";'."\n";

  if(!validDigit($gewinnpunktzahl))$gewinnpunktzahl=0;
  if(!validDigit($gewinnhaltezeit))$gewinnhaltezeit=0;
  $str.='getDefaultVariable('sv_winscore')='.$gewinnpunktzahl.';'."\n\n";
  $str.='getDefaultVariable('sv_benticks')='.$gewinnhaltezeit.';'."\n\n";

  $str.='getDefaultVariable('sv_maxuser')='.getDefaultVariable('sv_maxuser').';'."\n\n";

  if(!validDigit($maxsec))$maxsec=0;
  if(!validDigit($maxsys))$maxsys=0;
  $str.='getDefaultVariable('sv_maxsector')='.$maxsec.';'."\n\n";
  $str.='getDefaultVariable('sv_maxsystem')='.$maxsys.';'."\n\n";

  if(!validDigit($inaktdeltime))$inaktdeltime=1;
  if ($inaktdeltime<1)$inaktdeltime=1;
  $str.='getDefaultVariable('sv_inactiv_deldays')='.$inaktdeltime.';'."\n\n";
  $str.='getDefaultVariable('sv_not_activated_deldays')='.getDefaultVariable('sv_not_activated_deldays').';'."\n\n";

  $str.='getDefaultVariable('sv_hf_deldays')='.getDefaultVariable('sv_hf_deldays').';'."\n\n";
  $str.='getDefaultVariable('sv_nachrichten_deldays')='.getDefaultVariable('sv_nachrichten_deldays').';'."\n\n";
  $str.='getDefaultVariable('sv_max_efta_bew_punkte')='.getDefaultVariable('sv_max_efta_bew_punkte').';'."\n\n";

  if(!validDigit($attgrenze))$attgrenze=0;
  if(!validDigit($attgrenzewhg))$attgrenzewhg=0;
  $attgrenze=$attgrenze/100;
  $attgrenzewhg=$attgrenzewhg/100;
  $str.='getDefaultVariable('sv_attgrenze')='.$attgrenze.';'."\n\n";
  $str.='getDefaultVariable('sv_attgrenze_whg_bonus')='.$attgrenzewhg.';'."\n\n";

  $str.='getDefaultVariable('sv_show_maxsector')='.getDefaultVariable('sv_show_maxsector').';'."\n\n";
  $str.='getDefaultVariable('sv_npc_minsector')='.getDefaultVariable('sv_npc_minsector').';'."\n\n";
  $str.='getDefaultVariable('sv_npc_maxsector')='.getDefaultVariable('sv_npc_maxsector').';'."\n\n";
  $str.='getDefaultVariable('sv_free_startsectors')='.getDefaultVariable('sv_free_startsectors').';'."\n\n";

  if(!validDigit($votegrenze))$votegrenze=0;
  $str.='getDefaultVariable('sv_voteoutgrenze')='.$votegrenze.';'."\n\n";

  if(!validDigit($maxsecmoves))$maxsecmoves=0;
  if(!validDigit($minsecmovesmember))$minsecmovesmember=0;
  if(!validDigit($maxsecmovesmember))$maxsecmovesmember=0;
  $str.='getDefaultVariable('sv_max_secmoves')='.$maxsecmoves.';'."\n\n";
  $str.='getDefaultVariable('sv_min_user_per_regsector')='.$minsecmovesmember.';'."\n\n";
  $str.='getDefaultVariable('sv_max_user_per_regsector')='.$maxsecmovesmember.';'."\n\n";
  $str.='getDefaultVariable('sv_min_regsec')='.getDefaultVariable('sv_min_regsec').';'."\n\n";

  //$str.='getDefaultVariable('sv_server_tag')="'.getDefaultVariable('sv_server_tag').'";'."\n\n";
  $str.='getDefaultVariable('sv_server_name')="'.$servername.'";'."\n\n";

  if(!validDigit($schildbonus))$schildbonus=0;
  $str.='getDefaultVariable('sv_ps_bonus')='.$schildbonus.';'."\n\n";

  if(!validDigit($recyclotron))$recyclotron=0;
  if(!validDigit($recyclotronwhg))$recyclotronwhg=0;
  $str.='getDefaultVariable('sv_recyclotron_bonus')='.$recyclotron.';'."\n\n";
  $str.='getDefaultVariable('sv_recyclotron_bonus_whg')='.$recyclotronwhg.';'."\n\n";

  $str.='getDefaultVariable('sv_servid')='.getDefaultVariable('sv_servid').';'."\n\n";
  $str.='getDefaultVariable('sv_anz_schiffe')='.getDefaultVariable('sv_anz_schiffe').';'."\n";
  $str.='getDefaultVariable('sv_anz_tuerme')='.getDefaultVariable('sv_anz_tuerme').';'."\n";
  $str.='getDefaultVariable('sv_anz_rassen')='.getDefaultVariable('sv_anz_rassen').';'."\n";
  $str.='getDefaultVariable('sv_hf_buddie')='.getDefaultVariable('sv_hf_buddie').';'."\n";
  $str.='getDefaultVariable('sv_hf_ignore')='.getDefaultVariable('sv_hf_ignore').';'."\n";
  $str.='getDefaultVariable('sv_hf_archiv')='.getDefaultVariable('sv_hf_archiv').';'."\n\n";
  $str.='getDefaultVariable('sv_hf_buddie_p')='.getDefaultVariable('sv_hf_buddie_p').';'."\n";
  $str.='getDefaultVariable('sv_hf_ignore_p')='.getDefaultVariable('sv_hf_ignore_p').';'."\n";
  $str.='getDefaultVariable('sv_hf_archiv_p')='.getDefaultVariable('sv_hf_archiv_p').';'."\n\n";

  if(!validDigit($klaurate))$klaurate=0;
  $klaurate=$klaurate/100;
  $str.='getDefaultVariable('sv_kollie_klaurate')='.$klaurate.';'."\n\n";

  if(!validDigit($kollieertrag))$kollieertrag=0;
  if(!validDigit($kollieertragpa))$kollieertragpa=0;
  $str.='getDefaultVariable('sv_kollieertrag')='.$kollieertrag.';'."\n\n";
  $str.='getDefaultVariable('sv_kollieertrag_pa')='.$kollieertragpa.';'."\n\n";

  if(!validDigit($pga1))$pga1=0;
  if(!validDigit($pga2))$pga2=0;
  if(!validDigit($pga3))$pga3=0;
  if(!validDigit($pga4))$pga4=0;
  if(!validDigit($pga1whg))$pga1whg=0;
  if(!validDigit($pga2whg))$pga2whg=0;
  if(!validDigit($pga3whg))$pga3whg=0;
  if(!validDigit($pga4whg))$pga4whg=0;

  $str.='getDefaultVariable('sv_plan_grundertrag')=array('.$pga1.','.$pga2.','.$pga3.','.$pga4.');'."\n\n";
  $str.='getDefaultVariable('sv_plan_grundertrag_whg')=array('.$pga1whg.','.$pga2whg.','.$pga3whg.','.$pga4whg.');'."\n\n";

  $str.='getDefaultVariable('mods')=array(0);'."\n\n";
  $str.='getDefaultVariable('sv_session_lifetime')='.getDefaultVariable('sv_session_lifetime').';'."\n\n";

  if(!validDigit($tronicw))$tronicw=0;
  if(!validDigit($zufallw))$zufallw=0;
  if(!validDigit($zufallstart))$zufallstart=0;
  $str.='getDefaultVariable('sv_globalw_tronic')='.$tronicw.';'."\n\n";
  $str.='getDefaultVariable('sv_globalw_zufall')='.$zufallw.';'."\n\n";
  $str.='getDefaultVariable('sv_global_start_zufall')='.$zufallstart.';'."\n\n";

  if(!validDigit($artefaktstart))$artefaktstart=0;
  $str.='$sv_artefaktstart='.$artefaktstart.';'."\n\n";

  if(!validDigit($activetime))$activetime=0;
  $str.='getDefaultVariable('sv_activetime')='.$activetime.';'."\n\n";

  if(!validDigit($maxdartefakt))$maxdartefakt=0;
  $str.='getDefaultVariable('sv_max_dartefakt')='.$maxdartefakt.';'."\n\n";

  if(!validDigit($maxpalenium))$maxpalenium=0;
  $str.='getDefaultVariable('sv_max_palenium')='.$maxpalenium.';'."\n\n";

  if(!validDigit($kartepunkte))$kartepunkte=0;
  $str.='$sv_kartepunkte='.($kartepunkte/100).';'."\n\n";

  $str.='getDefaultVariable('sv_sm_preisliste')=array (50, 40, 100, 300, 175, 20, 50);'."\n\n";

  $str.='getDefaultVariable('sv_pcs_id')='.getDefaultVariable('sv_pcs_id').';'."\n\n";



  $str.="\n\n?>";

  if ($cachefile) fwrite ($cachefile, $str);
  fclose($cachefile);
  echo '<br><a href="de_server_einstellungen.php">Die Daten wurden gespeichert.<br>Zur Aktualisierung der Anzeige hier klicken.</a>';
  die('</body></html>');
}
?>
<?php
echo '<br><b>Servereinstellungen<b><br><br>';
echo '<table cellpadding="3" cellspacing="4">';
echo '<tr><td><b>Art</b></td> <td><b>Wert</b></td><td><b>Info</b></td></tr>';
echo '<tr><td>Gewinnpunktzahl</td> <td><input type="text" name="gewinnpunktzahl" value="'.getDefaultVariable('sv_winscore').'"></td><td>Die Punktzahl die erreicht werden mu� um die Runde zu gewinnen.</td></tr>';
echo '<tr><td>Gewinnhaltezeit</td> <td><input type="text" name="gewinnhaltezeit" value="'.getDefaultVariable('sv_benticks').'"></td><td>Anzahl der Wirtschaftsticks, die n�tig sind um Erhabener zu werden.</td></tr>';

echo '<tr><td>Max. Sektor</td> <td><input type="text" name="maxsec" value="'.getDefaultVariable('sv_maxsector').'"></td><td>Anzahl der Sektoren, auf welche die Spieler verteilt werden.<br>Standard: 20</td></tr>';
echo '<tr><td>Max. System</td> <td><input type="text" name="maxsys" value="'.getDefaultVariable('sv_maxsystem').'"></td><td>Maximalanzahl der Spieler pro Sektor.<br>Standard: 10</td></tr>';

echo '<tr><td>Inaktivenl�schzeit</td> <td><input type="text" name="inaktdeltime" value="'.getDefaultVariable('sv_inactiv_deldays').'"></td><td>Die Zeit nach der inaktive Spieler gel�scht werden.<br>Standard: 4</td></tr>';

echo '<tr><td>Angriffsgrenze</td> <td><input type="text" name="attgrenze" value="'.(getDefaultVariable('sv_attgrenze')*100).'"></td><td>Bis wieviel Prozent der eigenen Punkte kann man angreifen.<br>Standard: 60</td></tr>';
echo '<tr><td>Angriffsgrenze WHG-Bonus</td> <td><input type="text" name="attgrenzewhg" value="'.(getDefaultVariable('sv_attgrenze_whg_bonus')*100).'"></td><td>Durch den Bau der Weltraumhandelsgilde kann sich die Angriffsgrenze weiter senken, dieser hier angegebene Wert verringert die Angriffsgrenze.<br>Standard: 20<br>Angriffsgrenze (60) - Angriffsgrenze WHG-Bonus (20) = Endangriffsgrenze (40)</td></tr>';

echo '<tr><td>Rausvotegrenze</td> <td><input type="text" name="votegrenze" value="'.getDefaultVariable('sv_voteoutgrenze').'"></td><td>Prozentzahl der n�tigen Stimmen um einen Spieler aus dem Sektor zu voten.<br>Standard: 60</td></tr>';

echo '<tr><td>Max. Sph�renspr�nge</td> <td><input type="text" name="maxsecmoves" value="'.getDefaultVariable('sv_max_secmoves').'"></td><td>Anzahl der Umz�ge welche der Spieler mit der Unendlichkeitssph�re durchf�hren darf. Der Wert 0 deaktiviert die Sph�re.<br>Standard: 0</td></tr>';
echo '<tr><td>Min. Sph�renmitglieder</td> <td><input type="text" name="minsecmovesmember" value="'.getDefaultVariable('sv_min_user_per_regsector').'"></td><td>Minimalanzahl der Mitglieder beim Sph�renumzug pro Sektor.<br>Standard: 4</td></tr>';
echo '<tr><td>Max. Sph�renmitglieder</td> <td><input type="text" name="maxsecmovesmember" value="'.getDefaultVariable('sv_max_user_per_regsector').'"></td><td>Maximalanzahl der Mitglieder beim Sph�renumzug pro Sektor.<br>Standard: 6</td></tr>';

//echo '<tr><td>Servertag</td> <td><input type="text" name="servertag" value="'.getDefaultVariable('sv_server_tag').'"></td><td>1</td></tr>';
echo '<tr><td>Servername</td> <td><input type="text" name="servername" value="'.getDefaultVariable('sv_server_name').'"></td><td>Der gew�hlte Name f�r den Server, z.B. Orion Centauri</td></tr>';

echo '<tr><td>Planetarer Schildbonus</td> <td><input type="text" name="schildbonus" value="'.getDefaultVariable('sv_ps_bonus').'"></td><td>Gibt die St�rke des Planetaren Schildes in Prozent an. Die Prozentzahl der T�rme �berlebt einen Angriff.<br>Standard: 10</td></tr>';

echo '<tr><td>Recyclotronertrag</td> <td><input type="text" name="recyclotron" value="'.getDefaultVariable('sv_recyclotron_bonus').'"></td><td>Gr��e des recyclebaren Materials in Prozent.<br>Standard: 15</td></tr>';
echo '<tr><td>Recyclotronertrag mit WHG</td> <td><input type="text" name="recyclotronwhg" value="'.getDefaultVariable('sv_recyclotron_bonus_whg').'"></td><td>Gr��e des Recyclebaren Materials wenn die WHG vorhanden ist.<br>Standard: 30</td></tr>';

echo '<tr><td>Kollektorklaurate</td> <td><input type="text" name="klaurate" value="'.(getDefaultVariable('sv_kollie_klaurate')*100).'"></td><td>Gibt an, wieviel Prozent der Kollektoren pro Angriff gestohlen werden k�nnen.<br>Standard: 15</td></tr>';

echo '<tr><td>Kollektorertrag</td> <td><input type="text" name="kollieertrag" value="'.getDefaultVariable('sv_kollieertrag').'"></td><td>Energieertrag pro Kollektor.<br>Standard: 100</td></tr>';
echo '<tr><td>Kollektorertrag PA</td> <td><input type="text" name="kollieertragpa" value="'.getDefaultVariable('sv_kollieertrag_pa').'"></td><td>Energieertrag pro Kollektor bei einem Premium-Account.<br>Standard: 100</td></tr>';

echo '<tr><td>Planetarer Grundertrag</td> <td>
<input type="text" name="pga1" value="'.getDefaultVariable('sv_plan_grundertrag')[0].'">M<br>
<input type="text" name="pga2" value="'.getDefaultVariable('sv_plan_grundertrag')[1].'">D<br>
<input type="text" name="pga3" value="'.getDefaultVariable('sv_plan_grundertrag')[2].'">I<br>
<input type="text" name="pga4" value="'.getDefaultVariable('sv_plan_grundertrag')[3].'">E</td><td>Der Rohstoffertrag den jeder Account pro Wirtschaftstick bekommt.<br>Standard: 1000/100/0/0</td></tr>';

echo '<tr><td>Planetarer Grundertrag mit WHG</td> <td>
<input type="text" name="pga1whg" value="'.getDefaultVariable('sv_plan_grundertrag_whg')[0].'">M<br>
<input type="text" name="pga2whg" value="'.getDefaultVariable('sv_plan_grundertrag_whg')[1].'">D<br>
<input type="text" name="pga3whg" value="'.getDefaultVariable('sv_plan_grundertrag_whg')[2].'">I<br>
<input type="text" name="pga4whg" value="'.getDefaultVariable('sv_plan_grundertrag_whg')[3].'">E</td><td>Der Rohstoffertrag den jeder Account pro Wirtschaftstick bekommt, sobald die WHG vorhanden ist.<br>Standard: 4000/500/100/50</td></tr>';


echo '<tr><td>Wahrscheinlichkeit f�r Tronicverteilung</td> <td><input type="text" name="tronicw" value="'.getDefaultVariable('sv_globalw_tronic').'"></td><td>Der Prozentsatz mit dessen Wahrscheinlichkeit man Tronic bekommt.<br>Standard: 15</td></tr>';
echo '<tr><td>Wahrscheinlichkeit f�r Zufallsevent</td> <td><input type="text" name="zufallw" value="'.getDefaultVariable('sv_globalw_zufall').'"></td><td>Der Prozentsatz mit dessen Wahrscheinlichkeit ein Zufallsereignis stattfindet bekommt.<br>Standard: 15</td></tr>';
echo '<tr><td>Tickgrenze Zufallsevent</td> <td><input type="text" name="zufallstart" value="'.getDefaultVariable('sv_global_start_zufall').'"></td><td>Anzahl der Wirtschaftsticks ab denen die Zufallsergnisse beginnen.<br>Standard: 2000</td></tr>';
echo '<tr><td>Artefaktgrenze</td> <td><input type="text" name="artefaktstart" value="'.$sv_artefaktstart.'"></td><td>Anzahl der Sektorraumbasen, die vorhanden sein m�ssen, damit die Artefaktverteilung beginnt.<br>Standard: 10</td></tr>';

echo '<tr><td>Creditaussch�ttung</td> <td><input type="text" name="activetime" value="'.getDefaultVariable('sv_activetime').'"></td><td>Gibt an, alle wieviel Sekunden man durch Aktivit�t ein Credit bekommt.<br>Standard: 3600</td></tr>';
echo '<tr><td>Max. Diplomatieartefakte</td> <td><input type="text" name="maxdartefakt" value="'.getDefaultVariable('sv_max_dartefakt').'"></td><td>Gibt an, wieviele Diplomatieartefakte man maximal haben kann.<br>Standard: 3</td></tr>';
echo '<tr><td>Max. Palenium</td> <td><input type="text" name="maxpalenium" value="'.getDefaultVariable('sv_max_palenium').'"></td><td>Gibt an, wieviel Palenium man maximal haben kann.<br>Standard: 400</td></tr>';

echo '<tr><td>Kriegsartefaktpunkte</td> <td><input type="text" name="kartepunkte" value="'.($sv_kartepunkte*100).'"></td><td>Gibt an, bei wievielen Punkten Flottenverlust man ein Kriegsartefakt bekommt.<br>Standard: 500000</td></tr>';

echo '</table>';
echo '<br><br><input type="Submit" name="savedata" value="Einstellungen speichern"><br><br><br>';

function validDigit($digit) {
    $isavalid = 1;
    for ($i=0; $i<strlen($digit); $i++)
    {
      if (!ereg("[0-9]",$digit[$i]))
      {
        $isavalid = 0;
        break;
      }
    }
    if($digit=='')$isavalid=0;
    //echo $isavalid;
    return($isavalid);
}
?>
</form>
</body>
</html>
