<?php
//fix um den chat von der botabfrage unabh�ngig zu machen, gleichzeitig darf man aber keine credits bekommmen
$eftachatbotdefensedisable=1;
$soucss=1;
include "inc/header.inc.php";
include 'inc/lang/'.getDefaultVariable('sv_server_lang').'_chat.lang.php';
include 'soudata/lib/sou_functions.inc.php';
include "soudata/lib/sou_dbconnect.php";

$refreshtime=5000;

//farben definieren
$chat_sectorcolor='#FFFFFF';
$chat_allycolor='#4a91fc';

$tbl_chat='sou_chat_msg';

$chan_global=0;
$chan_frac=$_SESSION["sou_fraction"];

//schauen ob die clear-variable gesetzt ist
/*
if(!isset($_SESSION["ums_chat_cleartime"]))
{
  $db_daten=mysql_query("SELECT chatclear FROM de_user_data WHERE user_id='$ums_user_id'",$soudb);
  $row = mysql_fetch_array($db_daten);
  //sektor in die session schreiben
  $_SESSION["ums_chat_cleartime"]=$row["chatclear"];
}
$cleartime=$_SESSION["ums_chat_cleartime"];
*/
$cleartime=0;

//check4new - id der gr��ten nachricht ausgeben
if ($_REQUEST["check4new"]==1)
{
  /*
  $db_daten=mysql_query("SELECT MAX(counter) AS counter FROM de_sector_chat_msg WHERE sector='$sector' AND ",$soudb);
  if(mysql_num_rows($db_daten)==1)
  {
    $row = mysql_fetch_array($db_daten);
    $id=$row["counter"];
  }
  else $id=0;*/
  //tempdaten aus der datei auslesen
  $filename="soudata/cache/chat/chan$chan_global.tmp";
  if (file_exists($filename))
  {
    $fp=fopen($filename, "r");
    $str=fgets($fp, 1024);
    fclose($fp);
    $werte=explode(";", $str);
    if($cleartime>$werte[1])$id0='-1';else $id0=$werte[0];
  }
  else $id0='-1';

  $filename="soudata/cache/chat/chan$chan_frac.tmp";
  if (file_exists($filename))
  {
    $fp=fopen($filename, "r");
    $str=fgets($fp, 1024);
    fclose($fp);
    $werte=explode(";", $str);
    if($cleartime>$werte[1])$id1='-1';else $id1=$werte[0];
  }
  else $id1='-1';

  die($id0.';'.$id1);
}

//msg in der db eintragen / auf befehle reagieren
if ($_REQUEST["insert"]==1 AND $_REQUEST["chat_message"]!='' AND $_SESSION["sou_spielername"]!='')
{
  $time=time();

  //filter laden
  include('outputlib.php');

  //fix f�r sonderzeichen
  $_REQUEST["chat_message"]=str_replace("&#43;", "+", $_REQUEST["chat_message"]);

  //nachricht filtern
  $_REQUEST["chat_message"] = trim($_REQUEST["chat_message"]);
  $chat_message = format_output($_REQUEST["chat_message"]);
  $chat_message = str_replace("<","&lt;",$chat_message);
  $chat_message = str_replace(">","&gt;",$chat_message);
  $chat_message = str_replace("\\","/",$chat_message);

  if($sou_chat_channeltyp==1 AND $chan_frac<1) $dontwritetodb=1;

  if($dontwritetodb==0 AND $chat_message!='')
  {
    //nachricht in der db ablegen
    if($sou_chat_channeltyp==0)$channel=$chan_global;
    else $channel=$chan_frac;

    insert_chat_msg($_SESSION[sou_spielername], $chat_message, $chan_frac, $channel);

    /*
    //counter auslesen
    if($sou_chat_channeltyp==1)
    $db_daten=mysql_query("SELECT MAX(counter) AS counter FROM $tbl_chat WHERE channel='$chan_frac'",$soudb);
    else $db_daten=mysql_query("SELECT MAX(counter) AS counter FROM $tbl_chat WHERE channel='$chan_global'",$soudb);

    if(mysql_num_rows($db_daten)==1)
    {
      $row = mysql_fetch_array($db_daten);
      $counter=$row["counter"]+1;
    }
    else $counter=0;
    if($sou_chat_channeltyp==0)$channel=$chan_global;
    else $channel=$chan_frac;


    mysql_query("INSERT INTO $tbl_chat (spielername, message, timestamp, fraction, counter, channel) VALUES ('$_SESSION[sou_spielername]', '$chat_message', '$time', '$chan_frac','$counter', '$channel')",$soudb);

    //f�r check4new nen file anlegen mit id und timestampt
    if($sou_chat_channeltyp==0)
    {
      $fp=fopen("soudata/cache/chat/chan$chan_global.tmp", "w");
      $str=$counter.';'.$time;
      fputs($fp, $str);
      fclose($fp);
    }
    else
    {
      $fp=fopen("soudata/cache/chat/chan$chan_frac.tmp", "w");
      $str=$counter.';'.$time;
      fputs($fp, $str);
      fclose($fp);
    }

    //evtl. zuviel vorhandene nachrichten killen
    $counter=$counter-100;
    mysql_query("DELETE FROM $tbl_chat WHERE counter<'$counter' AND channel='$channel'",$soudb);
    */
    //timestamp setzen, damit man nen schnelleren refresh bekommt
    $_SESSION["sou_chat_timestamp"]=time();

  }
}

//include "functions.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Chat</title>
<?php //if ($_REQUEST["input"]==1 OR $_REQUEST["oben"]==1){include "cssinclude.php";}?>
<?php if (!$_REQUEST["frame"]==1){include "cssinclude.php";}?>
<?
echo '<script type="text/javascript">';
echo 'self.offscreenBuffering = true;';
echo '</script>';

if ($_REQUEST["input"]==1)
{
?>
<script type="text/javascript">
 <!--
  function empty_field_and_submit()
  {
   var loctarget=document.f.chat_message.value.replace("+", "&#43;");
   loctarget="sou_chat.php?insert=1&chat_message="+escape(loctarget);
   document.f.chat_message.value='';
   document.f.chat_message.focus();
   parent.chat_mitte.location.href = loctarget;
   return false;
  }
 // -->
</script>
<?php
}
elseif($_REQUEST["frame"]==1)
{
  //erzeuge den chatbereich
  echo '
  <frameset framespacing="0" border="0" frameborder="0" rows="*,18">
    <frame name="chat_mitte" src="sou_chat.php" scrolling="auto" marginwidth=0 marginheight=0 noresize>
    <frame name="chat_unten" src="sou_chat.php?input=1" scrolling="no" marginwidth=0 marginheight=0 noresize>
  </frameset>';
  exit;
}
/*
elseif($_REQUEST["oben"]==1)//stelle den titel dar
{
  echo '<table class="cell" width="100%" border="0" cellpadding="0" cellspacing="0">';
  echo '<tr><td align="center"><b class="ueber">&nbsp;'.$chat_lang[chat].'&nbsp;</b></td></tr>';
  echo '</table>';
  exit;
}
*/
else//metarefresh
{
  //refreshwert berechnen
  if($_SESSION["sou_chat_timestamp"]+240>time())$refreshtime=30000; else $refreshtime=120000;
  //echo '<meta http-equiv="refresh" content="'.$time.';URL=efta_chat.php">';
  echo '<META HTTP-EQUIV="Cache-Control" content="no-cache">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="Sat, 06 Apr 2002 08:58:45 GMT">';
  //runterscrollen
  echo '<script type="text/javascript">
 <!--
  function gd()
  {
    self.scrollTo(0, 100000);
  }
 // -->
</script>';
}
?>
</head>
<?php
if ($_REQUEST["input"]==1 OR $_REQUEST["frame"]==1 OR $_REQUEST["oben"]==1)echo '<body bgcolor="#000000">';
else
echo '<body bgcolor="#000000" onLoad="gd()">';
//inputbereich ausgeben
if ($_REQUEST["input"]==1)
{

	//bereich definieren
  echo '<form action="sou_chat.php" method="GET" target="chat_mitte" name="f" OnSubmit="return empty_field_and_submit()">';
  echo '<input type="hidden" name="insert" value="1">';
  echo '<table width="100%" border="0" cellpadding="0" cellspacing="0">';
  echo '<tr><td width="180">Schreibe an: ';

  //schauen ob er ne ally hat, falls nicht immer sektor aktivieren
  //if($chan_frac<1)$_REQUEST["channeltyp"]=0;

  if($_REQUEST["channeltyp"]=='')$_REQUEST["channeltyp"]=1;

  if($_REQUEST["channeltyp"]==0)
  {
  	$_SESSION["sou_chat_channeltyp"]=0;
  	echo '<font color="'.$chat_sectorcolor.'"><b>Allgemein</b></font> <a href="sou_chat.php?input=1&channeltyp=1"><font size="1" color="'.$chat_allycolor.'">Fraktion</font></a>';
  }
  else
  {
  	$_SESSION["sou_chat_channeltyp"]=1;
  	echo '<a href="sou_chat.php?input=1&channeltyp=0"><font size="1" color="'.$chat_sectorcolor.'">Allgemein</font></a> <font color="'.$chat_allycolor.'"><b>Fraktion</b></font> ';
  }

  echo '</td><td><input class="chatinput" type="text" name="chat_message" maxlength="400" value="" style="width:100%;"></td>
  <td width="10"><input type="Submit" name="send" value="Senden"></td></tr></table>';

  echo '</form>';
  echo '</body></html>';
  //script beenden
  exit;
}
//chat anzeigen
echo '<font size="2">';
//daten aus der db laden
$db_daten=mysql_query("SELECT * FROM $tbl_chat WHERE (channel='$chan_global' OR channel='$chan_frac') ORDER BY timestamp ASC",$soudb);
//ausgeben
$first=1;
while ($row = mysql_fetch_array($db_daten))
{
  if($first==1){$first=0;}else echo '<br>';
  if($row["fraction"]>0){$fraction=$row["fraction"];}else {$fraction='?';}
  $zeit=strftime ("%H:%M", $row["timestamp"]);
  $datum=strftime ("%d.%m.%Y", $row["timestamp"]);
  //schauen ob es einen nachricht vom reporter ist
  if($row["spielername"]=='^Der Reporter^')$row["spielername"]='<font color="#FDFB59">'.$row["spielername"].'</font>';
  //schauen ob es ein emote ist
  if($row["message"][0]=='/' AND $row["message"][1]=='m' AND $row["message"][2]=='e')
  {
    //me entfernen
  	$row["message"] = str_replace("/me","",$row["message"]);

  	if($row["channel"]>0)//fraktionschat
  	{
  	  $color=$chat_allycolor;
  	  echo '<font color="'.$color.'" title="'.$datum.'">'.$zeit.' <font color="#FF771D">'.$row["spielername"].' '.$row["message"].'</font>';

  	}
  	else //allgemeiner chat
  	{
  	  $color=$chat_sectorcolor;
  	  echo '<font color="'.$color.'" title="'.$datum.'">'.$zeit.' ['.$fraction.'] <font color="#FF771D">'.$row["spielername"].' '.$row["message"].'</font>';
  	}
  }
  else
  {
    if($row["channel"]>0)//fraktionschat
    {
      $color=$chat_allycolor;
      echo '<font color="'.$color.'" title="'.$datum.'">'.$zeit.' '.$row["spielername"].': '.$row["message"].'</font>';
    }
    else //allgemeiner chat
    {
      $color=$chat_sectorcolor;
      echo '<font color="'.$color.'" title="'.$datum.'">'.$zeit.' ['.$fraction.'] '.$row["spielername"].': '.$row["message"].'</font>';
    }


  }
  //die gr��te id speichern

  if($row["channel"]>0)$maxid1=$row["counter"];
  else $maxid0=$row["counter"];
}

//einen div f�r ne meldung definieren
echo '<div id="meldung"></div>';

//echo $GLOBALS["getDefaultVariable('sv_server_tag')"]["sec$sector"];
if($maxid0=='')$maxid0=0;
if($maxid1=='')$maxid1=0;
//ajax-�berpr�fung im hintergrund auf neuen eintrag
echo "
<script type=\"text/javascript\" language=\"javascript\">
var http_request = false;
var url = 'sou_chat.php';
function check4new()
{
  http_request = false;

  if (window.XMLHttpRequest)  //FF
  {
    http_request = new XMLHttpRequest();
    if (http_request.overrideMimeType)
    {
      http_request.overrideMimeType('text/xml');
    }
  }
  else if (window.ActiveXObject)// IE
  {
    try
    {
      http_request = new ActiveXObject(\"Msxml2.XMLHTTP\");
    }
    catch (e)
    {
      try
      {
        http_request = new ActiveXObject(\"Microsoft.XMLHTTP\");
      }
      catch (e)
      {}
    }
  }
  if (!http_request)
  {
    alert('Fehler: Kann keine XMLHTTP-Instanz erzeugen');
    return false;
  }
  http_request.open('POST', url, true);
  http_request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  http_request.onreadystatechange = checkdata;
  http_request.send('check4new=1');
  setTimeout(\"check4new()\", ".$refreshtime.");
}

function checkdata()
{
  if (http_request.readyState == 4)
  {
    if (http_request.status == 200)
    {
      if(http_request.responseText!='-1;-1')
      {
        var a = http_request.responseText.split(';');
        if(".$maxid0."<a[0])location.href='sou_chat.php';
        if(".$maxid1."<a[1])location.href='sou_chat.php';
      }
    }
    else
    {
      document.getElementById('meldung').innerHTML = '<font color=\'#FF0000\'>Auf den Chat konnte nicht zugegriffen werden. �berpr�fe bitte ob Du richtig eingeloggt bist.';
      self.scrollTo(0, 100000);
    }
  }
}
setTimeout(\"check4new()\", ".$refreshtime.");
</script>";
echo '</font>';

//      alert(http_request.responseText+\";\"+".$maxid0."+\";\"+".$maxid1.");
?>
</body>
</html>
