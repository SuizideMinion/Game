<?php
include 'inc/lang/'.getDefaultVariable('sv_server_lang').'_userartefact.inc.lang.php';
include "inc/userartefact.inc.php";
include 'inc/lang/'.getDefaultVariable('sv_server_lang').'_trade.blackmarketinc.lang.php';
include_once "lib/religion.lib.php";

//den maximalen tick auslesen
$db_daten=mysql_query("SELECT MAX(tick) AS tick FROM de_user_data",$db);
$row = mysql_fetch_array($db_daten);
$maxtick=$row["tick"];

//owner id auslesen
$db_daten=mysql_query("SELECT owner_id FROM de_login WHERE user_id='$ums_user_id'",$db);
$row = mysql_fetch_array($db_daten);
$owner_id=intval($row["owner_id"]);

//preise f�r die spielerartefakte
$artefaktpreis=array(50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50);

//in der br die preise stark senken
if($maxtick>=2500000)
{
  $artefaktpreis=array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
  getDefaultVariable('sv_sm_preisliste') = array (1, 1, 100, 300, 1, 1, 1);
}



//creditpreise ggf. aufgrund des religi�sen ranges verringern
$relrang=get_religion_level($owner_id);
$relcreditmod=array(0,5,10,15,20,25,35,45,60,75,90);

for($i=0;$i<count($artefaktpreis);$i++)
{
  $artefaktpreis[$i]=$artefaktpreis[$i]-floor($artefaktpreis[$i]/100*$relcreditmod[$relrang]);
}

for($i=0;$i<count(getDefaultVariable('sv_sm_preisliste'));$i++)
{
  getDefaultVariable('sv_sm_preisliste')[$i]=getDefaultVariable('sv_sm_preisliste')[$i]-floor(getDefaultVariable('sv_sm_preisliste')[$i]/100*$relcreditmod[$relrang]);
}


//lieferzeiten definieren
$sm_col_lz=500;
$sm_kartefakt_lz=60;
$sm_tronic_lz=220;
$artefaktlz=array(1100, 1100, 1100, 1100, 1100, 1100, 1100, 1100, 1100, 1100, 1100, 1100, 1100, 1100, 1100, 1100, 1100, 1100, 1100, 1100);

//reminder de-/aktivieren
if($remsubmit1 OR $remsubmit2 OR $remsubmit3 OR $remsubmit4 OR $remsubmit100 OR $remsubmit101 OR $remsubmit102 OR $remsubmit103 OR
$remsubmit104 OR $remsubmit105 OR $remsubmit106 OR $remsubmit107 OR $remsubmit108 OR $remsubmit109 OR $remsubmit110 OR $remsubmit111
 OR $remsubmit112 OR $remsubmit113 OR $remsubmit114)
{
  //artefakte
  $artid=-1;
  if($remsubmit100)$artid=0;
  if($remsubmit101)$artid=1;
  if($remsubmit102)$artid=2;
  if($remsubmit103)$artid=3;
  if($remsubmit104)$artid=4;
  if($remsubmit105)$artid=5;
  if($remsubmit106)$artid=6;
  if($remsubmit107)$artid=7;
  if($remsubmit108)$artid=8;
  if($remsubmit109)$artid=9;
  if($remsubmit110)$artid=10;
  if($remsubmit111)$artid=11;
  if($remsubmit112)$artid=12;
  if($remsubmit113)$artid=13;
  if($remsubmit114)$artid=14;
  if($artid!='-1')
  {
    //schauen wie der status ist und dann �ndern
    $artid++;
    $result = mysql_query("SELECT sm_art".$artid."rem FROM de_user_data WHERE user_id='$ums_user_id'", $db);
    $row = mysql_fetch_array($result);
    if($row["sm_art".$artid."rem"]==1)$flag=0;else $flag=1;
    //db updaten
    mysql_query("UPDATE de_user_data SET sm_art".$artid."rem='$flag' WHERE user_id = '$ums_user_id'",$db);
  }
  //rohstofflieferung
  if($remsubmit1)
  {
    //schauen wie der status ist und dann �ndern
    $result = mysql_query("SELECT sm_rboost_rem FROM de_user_data WHERE user_id='$ums_user_id'", $db);
    $row = mysql_fetch_array($result);
    if($row["sm_rboost_rem"]==1)$flag=0;else $flag=1;
    //db updaten
    mysql_query("UPDATE de_user_data SET sm_rboost_rem='$flag' WHERE user_id = '$ums_user_id'",$db);
  }
  //troniclieferung
  if($remsubmit2)
  {
    //schauen wie der status ist und dann �ndern
    $result = mysql_query("SELECT sm_tronic_rem FROM de_user_data WHERE user_id='$ums_user_id'", $db);
    $row = mysql_fetch_array($result);
    if($row["sm_tronic_rem"]==1)$flag=0;else $flag=1;
    //db updaten
    mysql_query("UPDATE de_user_data SET sm_tronic_rem='$flag' WHERE user_id = '$ums_user_id'",$db);
  }
  //kriegsartefakt
  if($remsubmit3)
  {
    //schauen wie der status ist und dann �ndern
    $result = mysql_query("SELECT sm_kartefakt_rem FROM de_user_data WHERE user_id='$ums_user_id'", $db);
    $row = mysql_fetch_array($result);
    if($row["sm_kartefakt_rem"]==1)$flag=0;else $flag=1;
    //db updaten
    mysql_query("UPDATE de_user_data SET sm_kartefakt_rem='$flag' WHERE user_id = '$ums_user_id'",$db);
  }
  //kollektor
  if($remsubmit4)
  {
    //schauen wie der status ist und dann �ndern
    $result = mysql_query("SELECT sm_col_rem FROM de_user_data WHERE user_id='$ums_user_id'", $db);
    $row = mysql_fetch_array($result);
    if($row["sm_col_rem"]==1)$flag=0;else $flag=1;
    //db updaten
    mysql_query("UPDATE de_user_data SET sm_col_rem='$flag' WHERE user_id = '$ums_user_id'",$db);
  }
}


//k�ufe t�tigen
if($submit1)//kollektor
{
  //transaktionsbeginn
  if (setLock($ums_user_id))
  {
    //schauen ob er genug credits hat
    $db_daten=mysql_query("SELECT credits, sm_col FROM de_user_data WHERE user_id='$ums_user_id'",$db);
    $row = mysql_fetch_array($db_daten);
    $credits=$row[0];$sm_col=$row[1];

    if($sm_col < floor($maxtick/$sm_col_lz))
    {
      if($credits>=getDefaultVariable('sv_sm_preisliste')[0])
      {
        $errmsg.='<font color="#00FF00">'.$tradeblackmarketinc_lang[msg_1].'</font>';
        //kollektor gutschreiben und credits abziehen
        mysql_query("UPDATE de_user_data SET credits=credits-getDefaultVariable('sv_sm_preisliste')[0], col=col+1, sm_col=sm_col+1 WHERE user_id = '$ums_user_id'",$db);
        $sm_col++;
        $credits=$credits-getDefaultVariable('sv_sm_preisliste')[0];
        refererbonus(getDefaultVariable('sv_sm_preisliste')[0]);
        writetocreditlog($tradeblackmarketinc_lang[kolliegutschrift]);
        updatesmstat(1, getDefaultVariable('sv_sm_preisliste')[0]);
      }
      else
      $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_2].'</font>';
    }
    else $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_3].'</font>';

    //transaktionsende
    $erg = releaseLock($ums_user_id); //L�sen des Locks und Ergebnisabfrage
    if ($erg)
    {
      //print("Datensatz Nr. 10 erfolgreich entsperrt<br><br><br>");
    }
    else
    {
      print("$tradeblackmarketinc_lang[msg_4_1] ".$ums_user_id." $tradeblackmarketinc_lang[msg_4_2]!<br><br><br>");
    }
  }// if setlock-ende
  else echo '<br><font color="#FF0000">'.$tradeblackmarketinc_lang[msg_5].'</font><br><br>';
}//ende submit1

if($submit2)//kartefakt
{
  //transaktionsbeginn
  if (setLock($ums_user_id))
  {
    //schauen ob er genug credits hat
    $db_daten=mysql_query("SELECT credits, sm_kartefakt FROM de_user_data WHERE user_id='$ums_user_id'",$db);
    $row = mysql_fetch_array($db_daten);
    $credits=$row[0];$sm_kartefakt=$row[1];

    if($sm_kartefakt < floor($maxtick / $sm_kartefakt_lz))
    {
      if($credits>=getDefaultVariable('sv_sm_preisliste')[1])
      {
        $errmsg.='<font color="#00FF00">'.$tradeblackmarketinc_lang[msg_1].'</font>';
        //kriegsartefakt gutschreiben und credits abziehen
        mysql_query("UPDATE de_user_data SET credits=credits-getDefaultVariable('sv_sm_preisliste')[1], kartefakt=kartefakt+1, sm_kartefakt=sm_kartefakt+1 WHERE user_id = '$ums_user_id'",$db);
        $sm_kartefakt++;
        $credits=$credits-getDefaultVariable('sv_sm_preisliste')[1];
        refererbonus(getDefaultVariable('sv_sm_preisliste')[1]);

        writetocreditlog($tradeblackmarketinc_lang[kartigutschrift]);
        updatesmstat(2, getDefaultVariable('sv_sm_preisliste')[1]);
      }
      else
      $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_2].'</font>';
    }
    else $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_3].'</font>';

    //transaktionsende
    $erg = releaseLock($ums_user_id); //L�sen des Locks und Ergebnisabfrage
    if ($erg)
    {
      //print("Datensatz Nr. 10 erfolgreich entsperrt<br><br><br>");
    }
    else
    {
      print("$tradeblackmarketinc_lang[msg_4_1] ".$ums_user_id." $tradeblackmarketinc_lang[msg_4_2]!<br><br><br>");
    }
  }// if setlock-ende
  else echo '<br><font color="#FF0000">'.$tradeblackmarketinc_lang[msg_5].'</font><br><br>';
}//ende submit2

if($submit3)//rohstofflieferung alle 1000 wochen
{
  //transaktionsbeginn
  if (setLock($ums_user_id))
  {
    //schauen ob er genug credits hat
    $db_daten=mysql_query("SELECT credits, sm_rboost FROM de_user_data WHERE user_id='$ums_user_id'",$db);
    $row = mysql_fetch_array($db_daten);
    $credits=$row[0];$sm_rboost=$row[1];

    if($tick>$sm_rboost+1000)
    {
      if($credits>=getDefaultVariable('sv_sm_preisliste')[2])
      {
        $errmsg.='<font color="#00FF00">'.$tradeblackmarketinc_lang[msg_1].'</font>';
        //rohstoffe gutschreiben und credits abziehen
        $db_daten=mysql_query("SELECT MAX(tick) AS tick FROM de_user_data",$db);
        $row = mysql_fetch_array($db_daten);
        $rtick=$row["tick"];

        $res[0]=$rtick*1075;$res[1]=$rtick*500;$res[2]=$rtick*125;$res[3]=$rtick*100;
        mysql_query("UPDATE de_user_data SET credits=credits-getDefaultVariable('sv_sm_preisliste')[2],
        restyp01=restyp01+$res[0], restyp02=restyp02+$res[1], restyp03=restyp03+$res[2], restyp04=restyp04+$res[3], sm_rboost=tick
        WHERE user_id = '$ums_user_id'",$db);
        $credits=$credits-getDefaultVariable('sv_sm_preisliste')[2];
        refererbonus(getDefaultVariable('sv_sm_preisliste')[2]);
        $sm_rboost=$tick;
        writetocreditlog($tradeblackmarketinc_lang[rohstoffgutschrift]);
        updatesmstat(3, getDefaultVariable('sv_sm_preisliste')[2]);
      }
      else
      $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_2].'</font>';
    }
    else $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_3].'</font>';

    //transaktionsende
    $erg = releaseLock($ums_user_id); //L�sen des Locks und Ergebnisabfrage
    if ($erg)
    {
      //print("Datensatz Nr. 10 erfolgreich entsperrt<br><br><br>");
    }
    else
    {
      print("$tradeblackmarketinc_lang[msg_4_1] ".$ums_user_id." $tradeblackmarketinc_lang[msg_4_2]!<br><br><br>");
    }
  }// if setlock-ende
  else echo '<br><font color="#FF0000">'.$tradeblackmarketinc_lang[msg_5].'</font><br><br>';
}//ende submit3

if($submit4 AND getDefaultVariable('sv_payserver')==0)//premiumaccount
{
  //transaktionsbeginn
  if (setLock($ums_user_id))
  {
    //schauen ob er genug credits hat
    $db_daten=mysql_query("SELECT credits, sm_rboost FROM de_user_data WHERE user_id='$ums_user_id'",$db);
    $row = mysql_fetch_array($db_daten);
    $credits=$row[0];$sm_rboost=$row[1];

    if($credits>=getDefaultVariable('sv_sm_preisliste')[3])
    {
      //man hat noch keinen pa
      $errmsg.='<font color="#00FF00">'.$tradeblackmarketinc_lang[msg_1].'</font>';
      //premiumaccount aktivieren und rohstoffe abziehen
      $patime=time()+(3600*24*30);
      if ($palaufzeit<time())
      {
        $patime=time()+(3600*24*30);
        mysql_query("UPDATE de_user_data SET credits=credits-getDefaultVariable('sv_sm_preisliste')[3], premium=1, patime='$patime' WHERE user_id = '$ums_user_id'",$db);
      }
      else
      {
        mysql_query("UPDATE de_user_data SET credits=credits-getDefaultVariable('sv_sm_preisliste')[3], premium=1, patime=patime+2592000 WHERE user_id = '$ums_user_id'",$db);
        $patime=$palaufzeit+2592000;
      }
      $credits=$credits-getDefaultVariable('sv_sm_preisliste')[3];
      refererbonus(getDefaultVariable('sv_sm_preisliste')[3]);
      $ums_premium=1;
      $palaufzeit=$patime;
      writetocreditlog($tradeblackmarketinc_lang[pagutschrift]);
      updatesmstat(4, getDefaultVariable('sv_sm_preisliste')[3]);
    }
    else
    $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_2].'</font>';

    //transaktionsende
    $erg = releaseLock($ums_user_id); //L�sen des Locks und Ergebnisabfrage
    if ($erg)
    {
      //print("Datensatz Nr. 10 erfolgreich entsperrt<br><br><br>");
    }
    else
    {
      print("$tradeblackmarketinc_lang[msg_4_1] ".$ums_user_id." $tradeblackmarketinc_lang[msg_4_2]!<br><br><br>");
    }
  }// if setlock-ende
  else echo '<br><font color="#FF0000">'.$tradeblackmarketinc_lang[msg_5].'</font><br><br>';
}//ende submit4

if($submit5)//dartefakt
{
  //transaktionsbeginn
  if (setLock($ums_user_id))
  {
    //schauen ob er genug credits hat
    $db_daten=mysql_query("SELECT dartefakt, credits FROM de_user_data WHERE user_id='$ums_user_id'",$db);
    $row = mysql_fetch_array($db_daten);
    $dartefakt=$row["dartefakt"];
    $credits=$row["credits"];

    if($credits>=getDefaultVariable('sv_sm_preisliste')[4])
    {
      if($dartefakt<getDefaultVariable('sv_max_dartefakt'))
      {
        $errmsg.='<font color="#00FF00">'.$tradeblackmarketinc_lang[msg_1].'</font>';
        //kriegsartefakt gutschreiben und credits abziehen
        mysql_query("UPDATE de_user_data SET credits=credits-getDefaultVariable('sv_sm_preisliste')[4], dartefakt=dartefakt+1 WHERE user_id = '$ums_user_id'",$db);
        $credits=$credits-getDefaultVariable('sv_sm_preisliste')[4];
        refererbonus(getDefaultVariable('sv_sm_preisliste')[4]);
        writetocreditlog($tradeblackmarketinc_lang[diplogutschrift]);
        updatesmstat(5, getDefaultVariable('sv_sm_preisliste')[4]);
      }
      else
      $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_6].'.</font>';
    }
    else
    $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_2].'</font>';

    //transaktionsende
    $erg = releaseLock($ums_user_id); //L�sen des Locks und Ergebnisabfrage
    if ($erg)
    {
      //print("Datensatz Nr. 10 erfolgreich entsperrt<br><br><br>");
    }
    else
    {
      print("$tradeblackmarketinc_lang[msg_4_1] ".$ums_user_id." $tradeblackmarketinc_lang[msg_4_2]!<br><br><br>");
    }
  }// if setlock-ende
  else echo '<br><font color="#FF0000">'.$tradeblackmarketinc_lang[msg_5].'</font><br><br>';
}//ende submit5

if($submit6)//palenium
{
  //transaktionsbeginn
  if (setLock($ums_user_id))
  {
    //schauen ob er genug credits hat
    $db_daten=mysql_query("SELECT palenium, credits FROM de_user_data WHERE user_id='$ums_user_id'",$db);
    $row = mysql_fetch_array($db_daten);
    $palenium=$row["palenium"];
    $credits=$row["credits"];

    //schaue ob er den palenium-verst�rker hat
    if($techs[27]==1)
    {
      if($credits>=getDefaultVariable('sv_sm_preisliste')[5])
      {
        if($palenium<=getDefaultVariable('sv_max_palenium')-100)
        {
          $errmsg.='<font color="#00FF00">'.$tradeblackmarketinc_lang[msg_1].'</font>';
          //kriegsartefakt gutschreiben und credits abziehen
          mysql_query("UPDATE de_user_data SET credits=credits-getDefaultVariable('sv_sm_preisliste')[5], palenium=palenium+100 WHERE user_id = '$ums_user_id'",$db);
          $credits=$credits-getDefaultVariable('sv_sm_preisliste')[5];
          refererbonus(getDefaultVariable('sv_sm_preisliste')[5]);
          writetocreditlog($tradeblackmarketinc_lang[paleniumgutschrift]);
          updatesmstat(6, getDefaultVariable('sv_sm_preisliste')[5]);
        }
        else
        $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_7].'</font>';
      }
      else
      $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_2].'</font>';
    }
    else
    $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_8].'.</font>';

    //transaktionsende
    $erg = releaseLock($ums_user_id); //L�sen des Locks und Ergebnisabfrage
    if ($erg)
    {
      //print("Datensatz Nr. 10 erfolgreich entsperrt<br><br><br>");
    }
    else
    {
      print("$tradeblackmarketinc_lang[msg_4_1] ".$ums_user_id." $tradeblackmarketinc_lang[msg_4_2]!<br><br><br>");
    }
  }// if setlock-ende
  else echo '<br><font color="#FF0000">'.$tradeblackmarketinc_lang[msg_5].'</font><br><br>';
}//ende submit6
if($submit7)//tronic
{
  //transaktionsbeginn
  if (setLock($ums_user_id))
  {
    //schauen ob er genug credits hat
    $db_daten=mysql_query("SELECT credits, sm_tronic FROM de_user_data WHERE user_id='$ums_user_id'",$db);
    $row = mysql_fetch_array($db_daten);
    $credits=$row[0];$sm_tronic=$row[1];

    if($sm_tronic < floor ($maxtick / $sm_tronic_lz))
    {
      if($credits>=getDefaultVariable('sv_sm_preisliste')[6])
      {
        $errmsg.='<font color="#00FF00">'.$tradeblackmarketinc_lang[msg_1].'</font>';
        //kollektor gutschreiben und credits abziehen
        mysql_query("UPDATE de_user_data SET credits=credits-getDefaultVariable('sv_sm_preisliste')[6], restyp05=restyp05+25, sm_tronic=sm_tronic+1 WHERE user_id = '$ums_user_id'",$db);
        $sm_tronic++;
        $credits=$credits-getDefaultVariable('sv_sm_preisliste')[6];
        refererbonus(getDefaultVariable('sv_sm_preisliste')[6]);
        writetocreditlog($tradeblackmarketinc_lang[tronicgutschrift]);
        updatesmstat(7, getDefaultVariable('sv_sm_preisliste')[6]);
      }
      else
      $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_2].'</font>';
    }
    else $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_3].'</font>';

    //transaktionsende
    $erg = releaseLock($ums_user_id); //L�sen des Locks und Ergebnisabfrage
    if ($erg)
    {
      //print("Datensatz Nr. 10 erfolgreich entsperrt<br><br><br>");
    }
    else
    {
      print("$tradeblackmarketinc_lang[msg_4_1] ".$ums_user_id." $tradeblackmarketinc_lang[msg_4_2]!<br><br><br>");
    }
  }// if setlock-ende
  else echo '<br><font color="#FF0000">'.$tradeblackmarketinc_lang[msg_5].'</font><br><br>';
}//ende submit7

//artefaktlieferung
if($submit100 OR $submit101 OR $submit102 OR $submit103 OR $submit104 OR $submit105 OR $submit106 OR $submit107 OR $submit108
 OR $submit109 OR $submit110 OR $submit111 OR $submit112 OR $submit113 OR $submit114)
{

  //transaktionsbeginn
  if (setLock($ums_user_id))
  {
    //schauen welches artefakt es ist
    $artid=0;
    if($submit100)$artid=0;
    if($submit101)$artid=1;
    if($submit102)$artid=2;
    if($submit103)$artid=3;
    if($submit104)$artid=4;
    if($submit105)$artid=5;
    if($submit106)$artid=6;
    if($submit107)$artid=7;
    if($submit108)$artid=8;
    if($submit109)$artid=9;
    if($submit110)$artid=10;
    if($submit111)$artid=11;
    if($submit112)$artid=12;
    if($submit113)$artid=13;
    if($submit114)$artid=14;

    //schauen ob er genug credits hat und wie die lieferzeiten sind
    $result = mysql_query("SELECT credits, artbldglevel, sm_art1, sm_art2, sm_art3, sm_art4, sm_art5, sm_art6, sm_art7, sm_art8, sm_art9, sm_art10, sm_art11, sm_art12, sm_art13, sm_art14, sm_art15, sm_art16, sm_art17, sm_art18, sm_art19 FROM de_user_data WHERE user_id = '$ums_user_id'", $db);
    $row = mysql_fetch_array($result);
    $credits=$row[0];
    $artbldglevel=$row["artbldglevel"];

    $ai=$artid+1;
    if($row["sm_art$ai"] < floor($maxtick / $artefaktlz[$artid]))
    {
      if($credits>=$artefaktpreis[$artid])
      {
        //schauen ob man das artefaktgeb�ude hat
        if ($techs[28]==1)
        {
          //schauen ob man noch platz im artefaktgeb�ude hat
          //vorhandene artefakte
          $db_daten=mysql_query("SELECT id FROM de_user_artefact WHERE user_id='$ums_user_id'",$db);
          $num = mysql_num_rows($db_daten);
          if($num<$artbldglevel)
          {
            $errmsg.='<font color="#00FF00">'.$tradeblackmarketinc_lang[msg_1].'</font>';
            //credits abziehen
            mysql_query("UPDATE de_user_data SET credits=credits-'$artefaktpreis[$artid]', sm_art$ai=sm_art$ai+1 WHERE user_id = '$ums_user_id'",$db);
            //echo "UPDATE de_user_data SET credits=credits-'$artefaktpreis[$artid]', sm_art$ai=tick WHERE user_id = '$ums_user_id'";
            $credits=$credits-$artefaktpreis[$artid];
            refererbonus($artefaktpreis[$artid]);
            $row["sm_art$ai"]++;
            //@mail('issomad@die-ewigen.com', "$ua_name[$artid]-Artefaktgutschrift", $ums_user_id.' - '.$ums_nic.' - '.$ums_spielername);
            writetocreditlog("$ua_name[$artid]-".$tradeblackmarketinc_lang[artefaktgutschrift]);
            updatesmstat($artid+100, $artefaktpreis[$artid]);
            $errmsg.='<font color="#00FF00">'.$tradeblackmarketinc_lang[msg_9].'<br><br></font>';
            //artefakt zum spieler transferieren
            mysql_query("INSERT INTO de_user_artefact (user_id, id, level) VALUES ('$ums_user_id', '$ai', '1')",$db);
          }else $errmsg.='<table width=600><tr><td class="ccr">'.$tradeblackmarketinc_lang[msg_10].'.</td></tr></table>';
        }else $errmsg.='<table width=600><tr><td class="ccr">'.$tradeblackmarketinc_lang[msg_11].'</td></tr></table>';
      }
      else
      $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_2].'</font>';
    }
    else $errmsg.='<font color="#FF0000">'.$tradeblackmarketinc_lang[msg_3].'</font>';

    //transaktionsende
    $erg = releaseLock($ums_user_id); //L�sen des Locks und Ergebnisabfrage
    if ($erg)
    {
      //print("Datensatz Nr. 10 erfolgreich entsperrt<br><br><br>");
    }
    else
    {
      print("$tradeblackmarketinc_lang[msg_4_1] ".$ums_user_id." $tradeblackmarketinc_lang[msg_4_2]!<br><br><br>");
    }
  }// if setlock-ende
  else echo '<br><font color="#FF0000">'.$tradeblackmarketinc_lang[msg_5].'</font><br><br>';
}//ende submit7

//sm_rboost lieferzeitpunkt berechnen
if($tick>$sm_rboost+1000)
{
  //es ist lieferbar
  $lzp1='<i><font color="#00FF00">'.$tradeblackmarketinc_lang[msg_12].'</font></i>';
}
else
{
  $lzp1='<i>'.$tradeblackmarketinc_lang[msg_13_1].' '.(($tick-$sm_rboost-1000)*(-1)+1).' '.$tradeblackmarketinc_lang[msg_13_2].'.</i>';
}

//kollektorlieferzeit
/*
if($tick>$sm_col+100)
{
  //es ist lieferbar
  $lzp2='<i><font color="#00FF00">'.$tradeblackmarketinc_lang[msg_12].'</font></i>';
}
else
{
  $lzp2='<i>'.$tradeblackmarketinc_lang[msg_13_1].' '.(($tick-$sm_col-100)*(-1)+1).' '.$tradeblackmarketinc_lang[msg_13_2].'.</i>';
}*/

/*
if($tick>$sm_kartefakt+100)
{
  //es ist lieferbar
  $lzp3='<i><font color="#00FF00">'.$tradeblackmarketinc_lang[msg_12].'</font></i>';
}
else
{
  $lzp3='<i>'.$tradeblackmarketinc_lang[msg_13_1].' '.(($tick-$sm_kartefakt-100)*(-1)+1).' '.$tradeblackmarketinc_lang[msg_13_2].'.</i>';
}
*/
/*
if($tick>$sm_tronic+200)
{
  //es ist lieferbar
  $lzp4='<i><font color="#00FF00">'.$tradeblackmarketinc_lang[msg_12].'</font></i>';
}
else
{
  $lzp4='<i>'.$tradeblackmarketinc_lang[msg_13_1].' '.(($tick-$sm_tronic-200)*(-1)+1).' '.$tradeblackmarketinc_lang[msg_13_2].'.</i>';
}
*/


//berechnen bis wann der pa l�uft
if ($palaufzeit>time())
{
  //pa ist noch aktiv
  $palz=date("d.m.Y - G:i", $palaufzeit);
  $palz=$tradeblackmarketinc_lang[paruntime].': '.$palz;
}
else
{
  //pa ist nicht aktiv
  $palz=$tradeblackmarketinc_lang[pana];
}

////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
//info f�r sms/0900/usw. anzeigen
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
if($showpcs==1 AND getDefaultVariable('sv_pcs_id')>0)
{
  include "trade.blackmarket.billing.inc.php";
}

echo '<div align=center><br><table width=600>';
echo '<tr><td align=left><h2>'.$tradeblackmarketinc_lang[willkommen].'</h2></td></tr>';

if (getDefaultVariable('sv_pcs_id')>0 AND $showpcs==0 AND $ums_cooperation==0)
//echo '<tr><td><span class="info_box"><a href="trade.php?viewmode=blackmarket&showpcs=1"><span class="text3">'.$tradeblackmarketinc_lang[creditangebot].'</span></a></span><br><br></td></tr>';
echo '<tr><td><div class="info_box"><a href="http://login.bgam.es/index.php?command=credits" target="_blank"><span class="text3">'.$tradeblackmarketinc_lang[creditangebot].'</span></a></div><br><br></td></tr>';

echo '<tr><td>'.$tradeblackmarketinc_lang[msg_14_1].' <b>'.$credits.' '.$tradeblackmarketinc_lang[msg_14_2].'</b></td></tr>';
echo '<tr><td>'.$tradeblackmarketinc_lang[msg_14_3].'</td></tr>';

if ($errmsg!='')echo '<tr><td>'.$errmsg.'</td>';
echo '</table></div>';

echo("<br>");
echo("<form name=\"tradeform\" action=\"trade.php\" method=\" post\" id=\"tradeform\">");
echo("<input type=hidden name=viewmode value=$viewmode>");

//oberes men�
if($_REQUEST["page"]=='')$_REQUEST["page"]=1;
echo '<table width=600><tr>';
if($_REQUEST["page"]==1)$zusatz='<b>>> ';else $zusatz='';
echo '<td width="33%\" class="cl"><a href="trade.php?viewmode=blackmarket&page=1"><b>'.$zusatz.''.$tradeblackmarketinc_lang[rohstoffe].'</a></td>';
if($_REQUEST["page"]==2)$zusatz='<b>>> ';else $zusatz='';
echo '<td width="33%\" class="cl"><a href="trade.php?viewmode=blackmarket&page=2"><b>'.$zusatz.''.$tradeblackmarketinc_lang[artefakte].'</a></td>';
if($_REQUEST["page"]==3)$zusatz='<b>>> ';else $zusatz='';
echo '<td width="33%\" class="cl"><a href="trade.php?viewmode=blackmarket&page=3"><b>'.$zusatz.''.$tradeblackmarketinc_lang[sonstiges].'</a></td>';
echo '</tr></table><br>';
echo '<input type="hidden" name="page" value="'.$_REQUEST["page"].'">';

//rahmen oben
  echo '<table width=600 border="0" cellpadding="0" cellspacing="0">
        <tr>
        <td width="13" height="37" class="rol">&nbsp;</td>
        <td align="center" class="ro">'.$tradeblackmarketinc_lang[angebote].'</td>
        <td width="13" class="ror">&nbsp;</td>
        </tr>
        <tr>
        <td class="rl">&nbsp;</td><td>';


echo ('<table>');
echo('<tr class="cell1" align="center"><td width="480"><b>'.$tradeblackmarketinc_lang[artikel].'</td><td width="40"><b>'.$tradeblackmarketinc_lang[credits].'</td><td width="60"><b>'.$tradeblackmarketinc_lang[aktion].'</td></tr>');
if($_REQUEST["page"]==1)//rohstoffe
{
  $db_daten=mysql_query("SELECT MAX(tick) AS tick FROM de_user_data",$db);
  $row = mysql_fetch_array($db_daten);
  $rtick=$row["tick"];

  //rohstofflieferung
  //reminder button
  $db_daten = mysql_query("SELECT sm_rboost_rem FROM de_user_data WHERE user_id='$ums_user_id'",$db);
  $row = mysql_fetch_array($db_daten);
  if($row["sm_rboost_rem"]==1) $rembutton='<input type="submit" name="remsubmit1" value="'.$tradeblackmarketinc_lang[deacreminder].'">';
  else $rembutton='<input type="submit" name="remsubmit1" value="'.$tradeblackmarketinc_lang[acreminder].'">';
  echo('<tr class="cell" align="center"><td align="left">'.$tradeblackmarketinc_lang[msg_15_1].' ('.$rtick.' '.$tradeblackmarketinc_lang[wochen].') '.$tradeblackmarketinc_lang[msg_15_2].'<b>
  <br>'.number_format($rtick*1075, 0,"",".").' '.$tradeblackmarketinc_lang[m].'
  <br>'.number_format($rtick*500, 0,"",".").' '.$tradeblackmarketinc_lang[d].'
  <br>'.number_format($rtick*125, 0,"",".").' '.$tradeblackmarketinc_lang[i].'
  <br>'.number_format($rtick*100, 0,"",".").' '.$tradeblackmarketinc_lang[e].'</b>
  <br>'.$lzp1.'
  <br><i>'.$tradeblackmarketinc_lang[msg_15_3].'</i>
  <br><center>'.$rembutton.'
  </td><td>'.getDefaultVariable('sv_sm_preisliste')[2].'</td><td><input type="submit" name="submit3" value="'.$tradeblackmarketinc_lang[kaufen].'"></td></tr>');
  echo('<tr class="cell1" align="center"><td align="left"><u>'.$tradeblackmarketinc_lang[msg_16].'</i></td><td>'.getDefaultVariable('sv_sm_preisliste')[5].'</td><td><input type="submit" name="submit6" value="'.$tradeblackmarketinc_lang[kaufen].'"></td></tr>');
  //troniclieferung
  //reminder button
  $db_daten = mysql_query("SELECT sm_tronic_rem FROM de_user_data WHERE user_id='$ums_user_id'",$db);
  $row = mysql_fetch_array($db_daten);
  if($row["sm_tronic_rem"]==1) $rembutton='<input type="submit" name="remsubmit2" value="'.$tradeblackmarketinc_lang[deacreminder].'">';
  else $rembutton='<input type="submit" name="remsubmit2" value="'.$tradeblackmarketinc_lang[acreminder].'">';

  //beschreibung und m�gliche kaufanzahl
  if($sm_tronic < floor($maxtick/$sm_tronic_lz)){$str1='<font color="#00FF00">';$str2='</font>';}else{$str1='';$str2='';}
  $lzp4=$str1.$tradeblackmarketinc_lang[genutztelieferungen].': '.number_format($sm_tronic, 0,"",".").'/'.number_format(floor($maxtick/$sm_tronic_lz), 0,"",".").$str2;
  //beschreibung
  echo('<tr class="cell" align="center"><td align="left">'.$tradeblackmarketinc_lang[msg_17_1].'.<br>'.$lzp4.'<br><i>'.$tradeblackmarketinc_lang[msg_17_2].'</i><br><center>'.$rembutton.'</td><td>'.getDefaultVariable('sv_sm_preisliste')[6].'</td><td><input type="submit" name="submit7" value="'.$tradeblackmarketinc_lang[kaufen].'"></td></tr>');
}
elseif($_REQUEST["page"]==2)//artefakte
{
  //kriesartefakt
  //reminder button
  $db_daten = mysql_query("SELECT sm_kartefakt_rem FROM de_user_data WHERE user_id='$ums_user_id'",$db);
  $row = mysql_fetch_array($db_daten);
  if($row["sm_kartefakt_rem"]==1) $rembutton='<input type="submit" name="remsubmit3" value="'.$tradeblackmarketinc_lang[deacreminder].'">';
  else $rembutton='<input type="submit" name="remsubmit3" value="'.$tradeblackmarketinc_lang[acreminder].'">';
  //beschreibung und m�gliche kaufanzahl
  if($sm_kartefakt < floor($maxtick/$sm_kartefakt_lz)){$str1='<font color="#00FF00">';$str2='</font>';}else{$str1='';$str2='';}
  $lzp3=$str1.$tradeblackmarketinc_lang[genutztelieferungen].': '.number_format($sm_kartefakt, 0,"",".").'/'.number_format(floor($maxtick/$sm_kartefakt_lz), 0,"",".").$str2;
  //beschreibung
  echo('<tr class="cell" align="center"><td align="left">'.$tradeblackmarketinc_lang[msg_18_1].'.<br>'.$lzp3.'<br><i>'.$tradeblackmarketinc_lang[msg_18_2].'.</i><br><center>'.$rembutton.'</td><td>'.getDefaultVariable('sv_sm_preisliste')[1].'</td><td><input type="submit" name="submit2" value="'.$tradeblackmarketinc_lang[kaufen].'"></td></tr>');


  //diplomatieartefakt
  //beschreibung und m�gliche kaufanzahl
  $db_daten=mysql_query("SELECT dartefakt FROM de_user_data WHERE user_id='$ums_user_id'",$db);
  $row = mysql_fetch_array($db_daten);
  $dartefakt=$row["dartefakt"];

  if($dartefakt < getDefaultVariable('sv_max_dartefakt')){$str1='<font color="#00FF00">';$str2='</font>';}else{$str1='';$str2='';}
  $lzpdartefakt=$str1.$tradeblackmarketinc_lang[genutztelieferungen].': '.number_format($dartefakt, 0,"",".").'/'.number_format(getDefaultVariable('sv_max_dartefakt'), 0,"",".").$str2;

  echo('<tr class="cell1" align="center"><td align="left">'.$tradeblackmarketinc_lang[msg_19_1].' '.getDefaultVariable('sv_max_dartefakt').' '.$tradeblackmarketinc_lang[msg_19_3].'<br>'.$lzpdartefakt.'<br><i>'.$tradeblackmarketinc_lang[msg_19_4].'</i></td><td>'.getDefaultVariable('sv_sm_preisliste')[4].'</td><td><input type="submit" name="submit5" value="'.$tradeblackmarketinc_lang[kaufen].'"></td></tr>');


  //spielerartefakte
  //lieferzeiten auslesen
  $result = mysql_query("SELECT sm_art1, sm_art2, sm_art3, sm_art4, sm_art5, sm_art6, sm_art7, sm_art8, sm_art9,  sm_art10,  sm_art11,
   sm_art12, sm_art13, sm_art14, sm_art15,
   sm_art1rem, sm_art2rem, sm_art3rem, sm_art4rem, sm_art5rem, sm_art6rem, sm_art7rem, sm_art8rem, sm_art9rem, sm_art10rem, sm_art11rem,
   sm_art12rem, sm_art13rem, sm_art14rem, sm_art15rem
   FROM de_user_data WHERE user_id='$ums_user_id'", $db);
  $row = mysql_fetch_array($result);

  $submit=100;$c1=1;
  for($i=0;$i<=$ua_index;$i++)
  {
    if ($c1==0)
    {
      $c1=1;
      $bg='cell1';
    }
    else
    {
      $c1=0;
      $bg='cell';
    }

    //schauen wann wieder geliefert werden kann
    $ai=$i+1;
    /*
    if($tick>$row["sm_art$ai"]+1000)
    {
      //es ist lieferbar

      $lzart='<i><font color="#00FF00">'.$tradeblackmarketinc_lang[msg_12].'</font></i>';
    }
    else
    {
      $lzart='<i>'.$tradeblackmarketinc_lang[msg_13_1].' '.(($tick-$row["sm_art$ai"]-1000)*(-1)+1).' '.$tradeblackmarketinc_lang[msg_13_2].'.</i>';
    }*/
    //beschreibung und m�gliche kaufanzahl
    if($row["sm_art$ai"] < floor($maxtick/$artefaktlz[$i])){$str1='<font color="#00FF00">';$str2='</font>';}else{$str1='';$str2='';}
    $lzart=$str1.$tradeblackmarketinc_lang[genutztelieferungen].': '.number_format($row["sm_art$ai"], 0,"",".").'/'.number_format(floor($maxtick/$artefaktlz[$i]), 0,"",".").$str2;


    //reminder button
    if($row["sm_art".$ai."rem"]==1) $rembutton='<input type="submit" name="remsubmit'.$submit.'" value="'.$tradeblackmarketinc_lang[deacreminder].'">';
    else $rembutton='<input type="submit" name="remsubmit'.$submit.'" value="'.$tradeblackmarketinc_lang[acreminder].'">';

    echo('<tr class="'.$bg.'" align="center"><td align="left"><u>'.$ua_name[$i].'-'.$tradeblackmarketinc_lang[artilvleins].'</u><br>'.$ua_desc[$i].'<br>'.$lzart.'<br><i>'.$tradeblackmarketinc_lang[msg_20].'</i><br><center>'.$rembutton.'</td><td>'.$artefaktpreis[$i].'</td><td><input type="submit" name="submit'.$submit.'" value="'.$tradeblackmarketinc_lang[kaufen].'"></td></tr>');
    $submit++;
}

}
elseif($_REQUEST["page"]==3)//sonstiges
{
  //premiumaccount
  if(getDefaultVariable('sv_payserver')==0)
  {
    echo('<tr class="cell" align="center"><td align="left">'.$tradeblackmarketinc_lang[msg_21_1].' '.getDefaultVariable('sv_hf_archiv_p').'<br>
    + '.$tradeblackmarketinc_lang[msg_21_2].': '.getDefaultVariable('sv_hf_buddie_p').'<br>
    + '.$tradeblackmarketinc_lang[msg_21_3].': '.getDefaultVariable('sv_hf_ignore_p').'</i><br><br>
    <b>'.$palz.'</b><br><br><i>'.$tradeblackmarketinc_lang[msg_21_4].'</i><br><br><font color="#FF0000">'.$tradeblackmarketinc_lang[painfohauptaccount].'</font></td><td>'.getDefaultVariable('sv_sm_preisliste')[3].'</td><td><input type="submit" name="submit4" value="'.$tradeblackmarketinc_lang[kaufen].'"></td></tr>');
  }
  //gebrauchter kollektor
  //reminder button
  $db_daten = mysql_query("SELECT sm_col_rem FROM de_user_data WHERE user_id='$ums_user_id'",$db);
  $row = mysql_fetch_array($db_daten);
  if($row["sm_col_rem"]==1) $rembutton='<input type="submit" name="remsubmit4" value="'.$tradeblackmarketinc_lang[deacreminder].'">';
  else $rembutton='<input type="submit" name="remsubmit4" value="'.$tradeblackmarketinc_lang[acreminder].'">';
  //beschreibung und m�gliche kaufanzahl
  if($sm_col < floor($maxtick/$sm_col_lz)){$str1='<font color="#00FF00">';$str2='</font>';}else{$str1='';$str2='';}
  $lzp2=$str1.$tradeblackmarketinc_lang[genutztelieferungen].': '.number_format($sm_col, 0,"",".").'/'.number_format(floor($maxtick/$sm_col_lz), 0,"",".").$str2;
  echo('<tr class="cell1" align="center">
  <td align="left">'.$tradeblackmarketinc_lang[msg_22_1].'.
  <br>'.$lzp2.'
  <br><i>'.$tradeblackmarketinc_lang[msg_22_2].'</i>
  <br><center>'.$rembutton.'</td>

  <td>'.getDefaultVariable('sv_sm_preisliste')[0].'</td>
  <td><input type="submit" name="submit1" value="'.$tradeblackmarketinc_lang[kaufen].'"></td></tr>');
}

echo('</table>');

//rahmen unten
  echo '</td><td width="13" class="rr">&nbsp;</td>
        </tr>
        <tr>
        <td width="13" class="rul">&nbsp;</td>
        <td class="ru">&nbsp;</td>
        <td width="13" class="rur">&nbsp;</td>
        </tr>
        </table><br>';

echo '</form>';

function refererbonus($credits)
{
  /*
  global $db, $ums_user_id,$tradeblackmarketinc_lang;
  //schauen ob ihn jemand geworben hat 1. stufe
  $db_daten=mysql_query("SELECT werberid FROM de_user_data WHERE werberid>0 AND user_id='$ums_user_id'",$db);
  $num = mysql_num_rows($db_daten);
  if($num==1)
  {
    $time=strftime("%Y%m%d%H%M%S");
    //werber ist vorhanden und bekommt x prozent
    $row = mysql_fetch_array($db_daten);
    $werberid=$row["werberid"];

    //schauen ob der werber schon am limit ist
    $db_daten=mysql_query("SELECT tick, geworben FROM de_user_data WHERE user_id='$werberid'",$db);
    $row = mysql_fetch_array($db_daten);

    if($row["geworben"]<($row["tick"]/10))
    {
      //credits gutschreiben
      $cm=round($credits/10);
      if($cm>0)mysql_query("UPDATE de_user_data SET credits=credits+'$cm', geworben=geworben+'$cm' WHERE user_id='$werberid'",$db);

      //nachricht an den account
      $text=$tradeblackmarketinc_lang[msg_23_1].' '.$cm.' '.$tradeblackmarketinc_lang[msg_23_2];
      if($cm>0)mysql_query("INSERT INTO de_user_news (user_id, typ, time, text) VALUES ('$werberid', 60,'$time','$text')",$db);
    }
    //werber auf 2. level
    $db_daten=mysql_query("SELECT werberid FROM de_user_data WHERE werberid>0 AND user_id='$werberid'",$db);
    $num = mysql_num_rows($db_daten);
    if($num==1)
    {
      $time=strftime("%Y%m%d%H%M%S");
      //werber ist vorhanden und bekommt x prozent
      $row = mysql_fetch_array($db_daten);
      $werberid=$row["werberid"];

      //schauen ob der werber schon am limit ist
      $db_daten=mysql_query("SELECT tick, geworben FROM de_user_data WHERE user_id='$werberid'",$db);
      $row = mysql_fetch_array($db_daten);
      if($row["geworben"]<($row["tick"]/10))
      {
        //credits gutschreiben
        $cm=round($credits/50);
        if($cm>0)mysql_query("UPDATE de_user_data SET credits=credits+'$cm', geworben=geworben+'$cm' WHERE user_id='$werberid'",$db);

        //nachricht an den account
        $text=$tradeblackmarketinc_lang[msg_23_1].' '.$cm.' '.$tradeblackmarketinc_lang[msg_23_2];
        if($cm>0)mysql_query("INSERT INTO de_user_news (user_id, typ, time, text) VALUES ('$werberid', 60,'$time','$text')",$db);
      }
    }//ende level 2
  }//ende level 1
  */
}

function writetocreditlog($clog)
{
  global $ums_user_id, $credits;
  $datum=date("Y-m-d H:i:s",time());
  $ip=getenv("REMOTE_ADDR");
  $clog="Zeit: $datum\nIP: $ip\n".$clog."- Neuer Creditstand: $credits\n--------------------------------------\n";
  $fp=fopen("cache/creditlogs/$ums_user_id.txt", "a");
  fputs($fp, $clog);
  fclose($fp);
}

function updatesmstat($smid, $credits)
{
  global $db;
  mysql_query("UPDATE de_system SET smstat$smid=smstat$smid+'$credits'",$db);
}

?>
