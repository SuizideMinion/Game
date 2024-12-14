<?php
include "inc/header.inc.php";
include "inc/allyjobs.inc.php";
include "functions.php";
include "lib/transaction.lib.php";
include 'ally/allyfunctions.inc.php';

//include 'inc/lang/'.getDefaultVariable('sv_server_lang').'_community.lang.php';

$db_daten=mysql_query("SELECT restyp01, restyp02, restyp03, restyp04, restyp05, score, sector, system, newtrans, newnews, allytag, status FROM de_user_data WHERE user_id='$ums_user_id'",$db);
$row = mysql_fetch_array($db_daten);
$restyp01=$row[0];$restyp02=$row[1];$restyp03=$row[2];$restyp04=$row[3];$restyp05=$row["restyp05"];
$punkte=$row["score"];$newtrans=$row["newtrans"];$newnews=$row["newnews"];
$sector=$row["sector"];$system=$row["system"];
if ($row["status"]==1) $ownally = $row["allytag"];

?>
<!DOCTYPE HTML>
<head>
<title>Allysector</title>
<?php include "cssinclude.php";?>
</head>
<body>
<div align="center">
<?php
//stelle die ressourcenleiste dar
include "resline.php";

//allydaten laden
$db_daten=mysql_query("SELECT * FROM de_allys WHERE allytag='$ownally'", $db);
$row = mysql_fetch_array($db_daten);
$allyid=$row['id'];
$ownallyid=$allyid;

if(isset($_REQUEST['sf']))$sf=intval($_REQUEST['sf']);
else $sf=2000;

if ($sf<2000)$sf=2000;


//den button f�rs bl�ttern durch die sektoren darstellen
echo '<form action="sectora.php" name="secform" method="POST">';

echo '<table><tr align="center"><td>';
echo '<a href="sectora.php?sf='.($sf-2).'" class="secbutton1"></a><a href="sectora.php?sf='.($sf-1).'" class="secbutton2">&nbsp;</a><span class="secbutton3"><input type="text" name="sf" value="'.$sf.'" size="4" maxlength="5" class="secbutton3"></span><a href="javascript:document.secform.submit();" class="secbutton4"></a><a href="sectora.php?sf='.($sf+1).'" class="secbutton5"></a><a href="sectora.php?sf='.($sf+2).'" class="secbutton6"></a>';
if($ownally!='') echo '&nbsp;&nbsp;<a href="sectora.php?sf='.($allyid+2000).'"><img src="'.$ums_gpfad.'g/symbol13.png" title="Zum eigenen Allianzsektor"></a>';
echo '</td></tr></table>';
echo '</form>';



//npc mainsektor
if($sf==2000)
{
  echo '<div class="info_box" style="color: #FFFFFF;">';
  echo 'Allianzsektor Fraktion 666<br>';
  echo 'Anf&uuml;hrer: Executor Karlath<br>';
  echo 'Nachricht von Executor Karlath: Wer nicht aufs Kleine schaut, scheitert am Gro�en.<br>';
  echo '</div><br>';

  echo '<div class="info_box" style="color: #FFFFFF;">';
  if($ownally!='')
  {
    //�berpr�fen ob schon eine aufgabe aktiv ist
    if($row['questgoal']==0)
    {
      echo '<font color="#00FF00">Euch wurde noch keine Aufgabe gestellt.</font>';
    }
    else
    {
      echo 'Folgende Aufgabe stellen wir Deiner Allianz: <br>';
      echo '<font color="#00FF00">'.$allyjobs[$row['questtyp']][0].'<br>';
      echo 'Fortschritt: '.number_format($row['questreach'], 0,"",".").' von '.number_format($row['questgoal'], 0,"",".").'<br>';
      echo 'Verbleibende Zeit (WT): '.number_format($row['questtime'], 0,"",".").'<br>';
      echo 'Belohnung: 100 + '.round($row['questtime']/10).' (Zeitbonus) Allianz-Rundensiegartefakte<br></font>';
    }
  }
  else
  {
    echo 'Wenn Du in einer Allianz bist, dann warten hier ein paar Aufgaben.<br>';
  }
  echo '</div><br>';

  echo '<img style="border: solid 1px #333333;" src="http://die-ewigen.com/b/eki.jpg">';
}
else //allianzsektor
{
  $allyid=$sf-2000;
  $db_daten=mysql_query("SELECT * FROM de_allys WHERE id='$allyid'", $db);
  $num = mysql_num_rows($db_daten);
  if($num==1)
  {
    $row = mysql_fetch_array($db_daten);
    $leaderid=$row['leaderid'];

	//allianzgeb�ude definieren
	unset($def_allybldg);

	$def_allybldg[0]['name']='Allianzsektorraumbasis';
	$def_allybldg[0]['desc']='Die Allianzraumbasis dient als Grundstock aller weiteren Projekte.';
	$def_allybldg[0]['artpreis']=5;
	$def_allybldg[0]['grafikfile']='sbtagsfbw.gif';
	$def_allybldg[0]['haslevel']=$row['bldg0'];
	$def_allybldg[0]['maxlevel']=1;

	$def_allybldg[1]['name']='Diplomatiezentrum';
	$def_allybldg[1]['desc']='Das Diplomatiezentrum wird f&uuml;r ein Allianzb&uuml;ndnis ben&ouml;tigt.<br>Pro Projektstufe erh�lt man 1% der Projektboni des B&uuml;ndnispartners.';
	$def_allybldg[1]['artpreis']=2;
	$def_allybldg[1]['grafikfile']='symbol11.png';
	$def_allybldg[1]['haslevel']=$row['bldg1'];
	$def_allybldg[1]['maxlevel']=50;

	$def_allybldg[2]['name']='Scannerphalanx';
	$def_allybldg[2]['desc']='Die Scannerphalanx dient zum scannen anderer Allianzen.';
	$def_allybldg[2]['artpreis']=10;
	$def_allybldg[2]['grafikfile']='t/1_12.jpg';
	$def_allybldg[2]['haslevel']=$row['bldg2'];
	$def_allybldg[2]['maxlevel']=1;

	$def_allybldg[3]['name']='Leitzentrale Feuroka';
	$def_allybldg[3]['desc']='Die Leitzentrale Feuroka verst&auml;rkt die Feuerkraft von Raumschiffen um 1% pro Stufe.';
	$def_allybldg[3]['artpreis']=10;
	$def_allybldg[3]['grafikfile']='arte6.gif';
	$def_allybldg[3]['haslevel']=$row['bldg3'];
	$def_allybldg[3]['maxlevel']=10;

	$def_allybldg[4]['name']='Leitzentrale Bloroka';
	$def_allybldg[4]['desc']='Die Leitzentrale Bloroka verst&auml;rkt die L&auml;hmkraft von Raumschiffen um 1% pro Stufe.';
	$def_allybldg[4]['artpreis']=5;
	$def_allybldg[4]['grafikfile']='arte7.gif';
	$def_allybldg[4]['haslevel']=$row['bldg4'];
	$def_allybldg[4]['maxlevel']=10;


    //////////////////////////////////////////////////////
    //////////////////////////////////////////////////////
    // geb�ude bauen
    //////////////////////////////////////////////////////
    //////////////////////////////////////////////////////
    if(isset($_REQUEST['build']))
    {
  	  if (setLock($ums_user_id))
  	  {

        //test ob es der leader ist
	    if($ums_user_id==$leaderid)
        {
		  $build=intval($_REQUEST['build']);
		  //nochmal die geb�udestufe auslesen, damit alles konsistent ist
  		  $db_daten=mysql_query("SELECT * FROM de_allys WHERE id='$allyid'", $db);
		  $row = mysql_fetch_array($db_daten);
		  $haslevel=$row['bldg'.$build];
		  $hasartefacts=$row['artefacts'];
		  $allytag=$row['allytag'];
		  //�berpr�fen ob es noch weiter ausbaubar ist
		  if($haslevel<$def_allybldg[$build]['maxlevel'])
		  {
		    //test ob genug allianzartefakte zum bezahlten vorhanden sind
		    $artpreis=$def_allybldg[$build]['artpreis']*($def_allybldg[$build]['haslevel']+1);
		    if($hasartefacts>=$artpreis)
		    {
		      //artefakte abziehen und das geb�ude in der db hinterlegen, dazu questpoints gutschreiben
		      mysql_query("UPDATE de_allys SET artefacts=artefacts-'$artpreis', bldg".$build."=bldg".$build."+1, questpoints=questpoints+10 WHERE id='$allyid'", $db);
		      $def_allybldg[$build]['haslevel']++;
		      $row['artefacts']-=$artpreis;

		      $entry='Allianzprojekt abgeschlossen: '.$def_allybldg[$build]['name'].' ('.$def_allybldg[$build]['haslevel'].'/'.$def_allybldg[$build]['maxlevel'].')';
		      //meldung im chat hinterlegen
		      //insert_chat_msg($entry, 1, $ums_user_id);
		      insert_chat_msg($allyid, 1, '', $allytag.'-'.$entry);

		      //meldung in der allianzhistorie hinterlegen
		      writeHistory($allytag, $entry);

		      //meldung f�r den bauer
		      echo '<div class="info_box text1">'.$entry.'</div><br>';
		    }
		    else
		    {
		      //fehlermeldung zu wenig artefakte
		      echo '<div class="info_box text2">Die Allianz hat nicht genug Allianzartefakte.</div><br>';
		    }
		  }
        }
        else
        {
          echo '<div class="info_box text2">Nur der Allianzleiter kann Allianzprojekte in Auftrag geben.</div><br>';
        }
        //transaktionsende
    	$erg = releaseLock($ums_user_id); //L�sen des Locks und Ergebnisabfrage
    	if ($erg)
    	{
	      //print("Datensatz Nr. 10 erfolgreich entsperrt<br><br><br>");
    	}
    	else
    	{
      	  print('Datensatz Nr. '.$ums_user_id.' Konnte nicht entsperrt werden.<br><br>');
    	}
  	  }// if setlock-ende
  	  else echo '<br><font color="#FF0000">Es ist zur Zeit bereits eine Transaktion aktiv. Bitte warten Sie, bis die Transaktion abgeschlossen ist.</font><br><br>';
    }

    //////////////////////////////////////////////////////
    //////////////////////////////////////////////////////
    // allianzsektor darstellen
    //////////////////////////////////////////////////////
    //////////////////////////////////////////////////////

    echo '<div class="info_box">';
    echo 'Allianzsektor: '.$row['allyname'].' ('.$row['allytag'].')<br>';
    //leader auslesen

    $db_datenx=mysql_query("SELECT * FROM de_user_data WHERE user_id='$leaderid'", $db);
    $rowx = mysql_fetch_array($db_datenx);
    echo 'Anf&uuml;hrer: <a href="details.php?se='.$rowx['sector'].'&sy='.$rowx['system'].'">'.$rowx['spielername'].'</a><br>';
	//partnerallianz
	$allyidpartner=get_allyid_partner($allyid);
	if($allyidpartner>0)
	{
	  $db_daten2=mysql_query("SELECT * FROM de_allys WHERE id='$allyidpartner'", $db);
	  $row2 = mysql_fetch_array($db_daten2);
      echo 'Partnerallianz: '.$row2['allyname'].' ('.$row2['allytag'].')<br>';
	}
    echo 'Eroberte Kollektoren: '.$row['colstolen'].'<br>';
    //echo 'Zerst&ouml;rte Kollektoren: '.$row['coldestroy'].'<br>';
    echo 'Verlorene Kollektoren: '.$row['collost'].'<br>';

    //platz nach rundensiegpunkten
    $questpoints=$row['questpoints'];
    $db_datenx=mysql_query("SELECT COUNT(*) AS wert FROM de_allys WHERE questpoints>'$questpoints' ORDER BY id ASC", $db);
    $rowx = mysql_fetch_array($db_datenx);
    $platz=$rowx['wert']+1;
    echo 'Allianz-Rundensiegartefakte: '.$questpoints.' (Platz: '.$platz.')<br>';
    if($allyid==$ownallyid)
    {
      echo 'Allianzartefakte: '.$row['artefacts'].'<br>';
    }
    echo '</div><br>';

    //baubare geb�ude anzeigen, wenn es die eigene allianz ist
    if($allyid==$ownallyid)
    {
      //ggf. daten einer partnerally auslesen
      unset($allybldgpartner);
      if($allyidpartner>0)
      {
        $allybldgpartner=get_allybldg($allyidpartner);
      }

      rahmen_oben('Allianzprojekte');
      $cssheight=80;

      echo '<div class="cell" style="width: 580px; height: '.$cssheight.'px; top: -0px; position: relative; font-size: 10px; text-align: center;">';

      for($i=0;$i<count($def_allybldg);$i++)
      {
        if($i==0 OR ($def_allybldg[0]['haslevel']>0 AND $i>0))
        {
          $title=$def_allybldg[$i]['name'].'&'.$def_allybldg[$i]['desc'];
          if($def_allybldg[$i]['haslevel']<$def_allybldg[$i]['maxlevel'])$title.='<br>Baukosten: '.($def_allybldg[$i]['artpreis']*($def_allybldg[$i]['haslevel']+1)).' Allianzartefakte';
          if(isset($allybldgpartner))$title.='<br>Partnerfortschritt: '.$allybldgpartner[$i].'/'.$def_allybldg[$i]['maxlevel'];
          if($def_allybldg[$i]['haslevel']<$def_allybldg[$i]['maxlevel'])echo '<a href="sectora.php?sf='.$sf.'&build='.$i.'">';
          echo '<div id="bc'.$i.'" title="'.$title.'" style="position: relative; margin-left: 5.5px; margin-top: 4px; width: 50px; height: 64px; border: 1px solid #333333; float: left; background-color: #000000;">';
          echo '<span style="position: absolute; left: 0px; top: 0px; height: 50px; width: 100%;"><img src="'.$ums_gpfad.'g/'.$def_allybldg[$i]['grafikfile'].'" border="0" alt="'.$def_allybldg[$i]['name'].'" width="100%" height="100%"></span>';
          echo '<span style="position: absolute; left: 0px; top: 50px; width: 100%;">'.$def_allybldg[$i]['haslevel'].'/'.$def_allybldg[$i]['maxlevel'].'</span>';
          echo '</div>';
          if($def_allybldg[$i]['haslevel']<$def_allybldg[$i]['maxlevel'])echo '</a>';
        }
      }
      echo '</div>';
      rahmen_unten();
    }
  }
  else echo '<div class="info_box">Dies ist ein unbesetzter Allianzsektor.</div>';
}

/*
geb�ude:allianzsektorraumbasis
scanner
diplomatie
feuerkraft
blockkraft
eh-punkte

kosten:
tronic
rohstoffe
credits
alle spielerartefakte
besondere spielerartefakte

 */





?>
</div>
<br>
<?php include "fooban.php"; ?>
</body>
</html>
