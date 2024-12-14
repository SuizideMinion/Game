<?php
include 'inc/lang/'.getDefaultVariable('sv_server_lang').'_trade.artsell.lang.php';
include 'inc/lang/'.getDefaultVariable('sv_server_lang').'_userartefact.inc.lang.php';
include "inc/userartefact.inc.php";

$sellmul=2500;

//artefakt verkaufen
if($id AND $lvl)
{
  //transaktionsbeginn
  if (setLock($ums_user_id))
  {
    $id=(int)$id;$lvl=(int)$lvl;
    //schauen ob man das artefakt hat
    $db_daten=mysql_query("SELECT user_id FROM de_user_artefact WHERE user_id='$ums_user_id' AND id='$id' AND level='$lvl'",$db);
    $num = mysql_num_rows($db_daten);

    if($num>0)
    {
      $gutschrift=$lvl*$sellmul;
      $tradescore=$lvl*1000;
      $errmsg.='<font color="#00FF00">'.$tradeartsell_lang[msg_1_1].'<br><br></font>';
      //erfahrungspunkte gutschreiben
      $exp=$gutschrift;
      //exp verteilen
      $fleet_id=$ums_user_id.'-0';
      mysql_query("UPDATE de_user_fleet SET komdef=komdef+'$exp' WHERE user_id='$fleet_id'",$db);

      $fleet_id=$ums_user_id.'-1';
      mysql_query("UPDATE de_user_fleet SET komatt=komatt+'$exp', komdef=komdef+'$exp' WHERE user_id='$fleet_id'",$db);

      $fleet_id=$ums_user_id.'-2';
      mysql_query("UPDATE de_user_fleet SET komatt=komatt+'$exp', komdef=komdef+'$exp' WHERE user_id='$fleet_id'",$db);

      $fleet_id=$ums_user_id.'-3';
      mysql_query("UPDATE de_user_fleet SET komatt=komatt+'$exp', komdef=komdef+'$exp' WHERE user_id='$fleet_id'",$db);

      mysql_query("UPDATE de_user_data SET defenseexp=defenseexp+'$exp' WHERE user_id='$ums_user_id'",$db);

      //handelspunkte gutschreiben
      mysql_query("UPDATE de_user_data SET tradescore=tradescore+'$tradescore' WHERE user_id = '$ums_user_id'",$db);

      //artefakt abziehen und in den handel transferieren
      mysql_query("DELETE FROM de_user_artefact WHERE user_id='$ums_user_id' AND id='$id' AND level='$lvl' LIMIT 1",$db);
      mysql_query("INSERT INTO de_trade_artefact (id, level) VALUES ('$id', '$lvl')",$db);

    }
    else $errmsg.='<font color="#FF0000">'.$tradeartsell_lang[msg_3].'.</font><br><br>';

    //transaktionsende
    $erg = releaseLock($ums_user_id); //L�sen des Locks und Ergebnisabfrage
    if ($erg)
    {
      //print("Datensatz Nr. 10 erfolgreich entsperrt<br><br><br>");
    }
    else
    {
      print("$tradeartsell_lang[msg_2_1] ".$ums_user_id." $tradeartsell_lang[msg_2_2]!<br><br><br>");
    }
  }// if setlock-ende
  else echo '<br><font color="#FF0000">'.$tradeartsell_lang[msg_4].'.</font><br><br>';
}//ende submit1


if ($techs[28]==0)
{
  $techcheck="SELECT tech_name FROM de_tech_data".$ums_rasse." WHERE tech_id=28";
  $db_tech=mysql_query($techcheck,$db);
  $row_techcheck = mysql_fetch_array($db_tech);
  echo "$tradeartsell_lang[msg_5_1] ".$row_techcheck[tech_name]." $tradeartsell_lang[msg_5_2].";
}
else
{
  echo '<br><table width=600><tr>
	<td width="50%\" class="cl"><a href="trade.php?viewmode=artsell"><b>>> '.$tradeartsell_lang[artefaktverkauf].'</b></a></td>
	<td width="50%\" class="cl"><a href="trade.php?viewmode=artbuy">'.$tradeartsell_lang[artefaktkauf].'</a></td>
	</tr>
    <tr>
    <td colspan="2" class="cl">'.$tradeartsell_lang[msg_6].'</td>
    </tr>
    </table><br>';

  //meldungen ausgeben
  if ($errmsg!='')echo $errmsg;

  //artefakte ausgeben
  echo '<table width=600>';
  echo '<tr class="cc"><td width="50"><b>'.$tradeartsell_lang[artefakt].'</td><td width="50"><b>'.$tradeartsell_lang[level].'</td><td width="50"><b>'.$tradeartsell_lang[bonus].'</td><td width="450"><b>'.$tradeartsell_lang[info].'</td><td width="100"><b>'.$tradeartsell_lang[bp].'</td></tr>';

  //artefakte aus der db holen und darstellen
  $db_daten=mysql_query("SELECT id, level FROM de_user_artefact WHERE user_id='$ums_user_id' ORDER BY id, level",$db);
  while($row = mysql_fetch_array($db_daten))
  {
    echo '<tr>
     <td><img src="'.$ums_gpfad.'g/arte'.$row["id"].'.gif" border="0" title="'.$ua_name[$row["id"]-1].'" alt="'.$ua_name[$row["id"]-1].'"></td>
     <td class="cc">'.$row["level"].'</td>
     <td class="cc">'.number_format($ua_werte[$row["id"]-1][$row["level"]-1][0], 2,",",".").'%</td>
     <td class="cc">'.$ua_desc[$row["id"]-1].'</td>
     <td class="cc"><a href="trade.php?viewmode=artsell&id='.$row["id"].'&lvl='.$row["level"].'">'.number_format(($row["level"]*$sellmul), 0,",",".").'</a></td>
     </tr>';
  }

  echo '</table>';

}
?>
