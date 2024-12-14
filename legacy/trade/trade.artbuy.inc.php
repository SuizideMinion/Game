<?php
include 'inc/lang/'.getDefaultVariable('sv_server_lang').'_userartefact.inc.lang.php';
include 'inc/lang/'.getDefaultVariable('sv_server_lang').'_trade.artbuy.lang.php';
include "inc/userartefact.inc.php";


$buymul=10;
$mincol=50;

$col=round($col/2);
if($col<$mincol)$col=$mincol;

//artefakt kaufen
if($id AND $lvl)
{
  //transaktionsbeginn
  if (setLock($ums_user_id))
  {
    $id=(int)$id;$lvl=(int)$lvl;
    //schauen ob die gilde das artefakt hat
    $db_daten=mysql_query("SELECT id FROM de_trade_artefact WHERE id='$id' AND level='$lvl'",$db);
    $num = mysql_num_rows($db_daten);

    if($num>0)
    {
      //schauen ob man genug rohstoffe hat
      $benres03=$ua_werte[$id-1][$lvl-1][1]*$col;
      $db_daten  	  = mysql_query("SELECT restyp03, artbldglevel FROM de_user_data WHERE user_id='$ums_user_id'",$db);
  	  $row 		  = mysql_fetch_array($db_daten);
	  $restyp03	  = $row["restyp03"];
	  $artbldglevel = $row["artbldglevel"];

      if($benres03<=$restyp03)
      {
        //schauen, ob man das artefaktgeb�ude hat
        if ($techs[28]==1)
        {
          //schauen ob man noch platz im artefaktgeb�ude hat
          $db_daten=mysql_query("SELECT id FROM de_user_artefact WHERE user_id='$ums_user_id'",$db);
          $num = mysql_num_rows($db_daten);
          if($num<$artbldglevel)
          {
            $errmsg.='<font color="#00FF00">'.$tradeartbuy_lang[msg_1].'.<br><br></font>';
            //tronic gutschreiben
            mysql_query("UPDATE de_user_data SET restyp03=restyp03-'$benres03' WHERE user_id = '$ums_user_id'",$db);
            //artefakt aus dem handel nehmen und zum spieler transferieren
            mysql_query("DELETE FROM de_trade_artefact WHERE id='$id' AND level='$lvl' LIMIT 1",$db);
            mysql_query("INSERT INTO de_user_artefact (user_id, id, level) VALUES ('$ums_user_id', '$id', '$lvl')",$db);
          }else $errmsg.='<table width=600><tr><td class="ccr">'.$tradeartbuy_lang[msg_2].'.</td></tr></table><br>';
        }else $errmsg.='<table width=600><tr><td class="ccr">'.$tradeartbuy_lang[msg_3].'.</td></tr></table><br>';
      }else $errmsg.='<table width=600><tr><td class="ccr">'.$tradeartbuy_lang[msg_4].'.</td></tr></table><br>';
    }
    else $errmsg.='<font color="#FF0000">'.$tradeartbuy_lang[msg_5].'.</font><br><br>';

    //transaktionsende
    $erg = releaseLock($ums_user_id); //L�sen des Locks und Ergebnisabfrage
    if ($erg)
    {
      //print("Datensatz Nr. 10 erfolgreich entsperrt<br><br><br>");
    }
    else
    {
      print("$tradeartbuy_lang[msg_6_1] ".$ums_user_id." $tradeartbuy_lang[msg_6_2]!<br><br><br>");
    }
  }// if setlock-ende
  else echo '<br><font color="#FF0000">'.$tradeartbuy_lang[msg_7].'</font><br><br>';
}//ende submit1


if ($techs[28]==0)
{
  $techcheck="SELECT tech_name FROM de_tech_data".$ums_rasse." WHERE tech_id=28";
  $db_tech=mysql_query($techcheck,$db);
  $row_techcheck = mysql_fetch_array($db_tech);
  echo "$tradeartbuy_lang[msg_8_1] ".$row_techcheck[tech_name]." $tradeartbuy_lang[msg_8_2].";
}
else
{
  echo '<br><table width=600><tr>
	<td width="50%\" class="cl"><a href="trade.php?viewmode=artsell">'.$tradeartbuy_lang[artefaktverkauf].'</a></td>
	<td width="50%\" class="cl"><a href="trade.php?viewmode=artbuy"><b>>> '.$tradeartbuy_lang[artefaktkauf].'</b></a></td>
	</tr>
    <tr>
    <td colspan="2" class="cl">'.$tradeartbuy_lang[msg_9].'</td>
    </tr>
    </table><br>';

  //meldungen ausgeben
  if ($errmsg!='')echo $errmsg;

  echo '<table width=600>';
  //artefakte ausgeben
  echo '<table width=600>';
  echo '<tr class="cc"><td width="50"><b>'.$tradeartbuy_lang[artefakt].'</td><td width="50"><b>'.$tradeartbuy_lang[level].'</td><td width="50"><b>'.$tradeartbuy_lang[bonus].'</td><td width="370"><b>'.$tradeartbuy_lang[info].'</td><td width="80"><b>'.$tradeartbuy_lang[onstock].'</td><td width="100"><b>'.$tradeartbuy_lang[iradium].'</td></tr>';

  //artefakte aus der db holen und darstellen
  $db_daten=mysql_query("SELECT id, level, count(id) AS anzahl FROM de_trade_artefact GROUP BY id, level ORDER BY id, level",$db);
  while($row = mysql_fetch_array($db_daten))
  {
    echo '<tr>
     <td><img src="'.$ums_gpfad.'g/arte'.$row["id"].'.gif" border="0" title="'.$ua_name[$row["id"]-1].'" alt="'.$ua_name[$row["id"]-1].'"></td>
     <td class="cc">'.$row["level"].'</td>
     <td class="cc">'.number_format($ua_werte[$row["id"]-1][$row["level"]-1][0], 2,",",".").'%</td>
     <td class="cc">'.$ua_desc[$row["id"]-1].'</td>
     <td class="cc">'.number_format($row["anzahl"], 0,",",".").'</td>
     <td class="cc"><a href="trade.php?viewmode=artbuy&id='.$row["id"].'&lvl='.$row["level"].'">'.
      number_format($ua_werte[$row["id"]-1][$row["level"]-1][1]*$col, 0,",",".").'</a></td>
     </tr>';
  }

  echo '</table>';

}
?>
