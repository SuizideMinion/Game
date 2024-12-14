<?php
include "inc/header.inc.php";
include 'inc/lang/'.getDefaultVariable('sv_server_lang').'_tauktion.lang.php';
include 'trade/trade.functions.inc.php';
require_once("misc.php");

$db_daten=mysql_query("SELECT restyp01, restyp02, restyp03, restyp04, restyp05, score, sector, system, newtrans, newnews, techs FROM de_user_data WHERE user_id='$ums_user_id'",$db);
$row = mysql_fetch_array($db_daten);
$restyp01=$row[0];$restyp02=$row[1];$restyp03=$row[2];$restyp04=$row[3];$restyp05=$row[4];$punkte=$row["score"];
$newtrans=$row["newtrans"];$newnews=$row["newnews"];$techs=$row["techs"];
$sector=$row["sector"];$system=$row["system"];

$increment = 1000;
$ticks = 20;

$uid = $ums_user_id;
$fehler='';
//echo html_form_start("tauktion.php");
//echo html_input_hidden("SID", $SID);
echo html_input_hidden("newAuktion", "1");
//echo html_form_end("Anbieten");
if($newAuktion <> '') // Neue Auktion anlegen
{
  //$amount=(int)$amount;
  $amount=5;
  if(($amount != "") && ($amount > 0))
  {
    list($has) = mysql_fetch_row(mysql_query("SELECT restyp05 FROM de_user_data WHERE user_id=".$uid));
	if($has < $amount)
	{
		$fehler = $tauction_lang['no_tronic'];
		//exit;
	}
    if ($fehler=='')
    {
        mysql_query("UPDATE de_user_data SET restyp05 = restyp05 - '".$amount."' where user_id=".$uid);
        mysql_query("INSERT INTO de_tauction SET amount='".$amount."',maxbid=0,bids=0,bidder=-1,ticks='".$ticks."',seller='".$uid."',sellername='".$ums_spielername." (".$sector.":".$system.")',biddername='-'");
		$fehler="<center>".$tauction_lang['bid_placed']."<br><br></center>";
		$restyp05=$restyp05-$amount;
	}
  }
}
else if($bieten) // Bieten
{
    $result=mysql_query("SELECT seller,maxbid,bids,bidder,amount FROM de_tauction WHERE id='".$bieten."'");
    $numrows=mysql_num_rows($result);
    if($numrows<>1)
    {
      $fehler='<font color="#FF0000">'.$tauction_lang['trade_already_done'].'</font>';
      //exit;
    }
    list($seller,$currentbet,$bids,$bidder,$amount) = mysql_fetch_row($result);
	if($currentbet == 1) $currentbet = 0;

    if($betrag != ($currentbet+($amount*$increment)))
	{
		$fehler='<font color="#FF0000">'.$tauction_lang['wrong_amount'].'</font>';
		//exit;
	}

    if($seller == $uid)
	{
		//wenn man f�r sein eigenes angebot bietet, wird man gesperrt und ausgeloggt

        //$fehler='<font color="#FF0000">Sie k�nnen nicht f�r Ihr eigenes Angebot bieten.</font>';
		//echo '<font color="#FF0000">Fehlerhafter Aufruf. Der Account wurde gesperrt.</font>';
        @$time=strftime("%Y-%m-%d %H:%M:%S");
        $para = "Der folgende Spieler $ums_spielername ($asec:$asys)[UserID:$ums_user_id] hat am $zeit am Auktions-Script rumgespielt. \n\n\n";
        @mail("Issomad@Die-Ewigen.com","Mogler am Auktionsscript entdeckt.",$para);

        $comment = mysql_query("select kommentar from de_user_info WHERE user_id='$ums_user_id'");
        $row = mysql_fetch_array($comment);

        $eintrag = "$row[kommentar] \n\n Wegen Auktionsmanipulation automatisch gesperrt! \n Agent Smith $time";

        mysql_query("UPDATE de_login SET status=2 WHERE user_id='$ums_user_id'");
        mysql_query("UPDATE de_user_info SET kommentar='$eintrag' WHERE user_id='$ums_user_id'");

        session_destroy();
        header("Location: index.php");

		//exit;
	}

	if($bidder == $uid)
	{
		$fehler='<font color="#FF0000">'. $tauction_lang['already_bidding'] .'</font>';
		//exit;
	}

	//list($giveback) = mysql_fetch_row(mysql_query("SELECT restyp04 FROM de_user_data WHERE user_id=".$uid));
	if($restyp04 < $currentbet+($increment*$amount))
	{
		$fehler='<font color="#FF0000">'.$tauction_lang['no_eternium'].'</font>';
        //exit;
	}
    //schauen ob es ein g�nstigeres angebot gibt
    //$result=mysql_query("SELECT id FROM de_tauction WHERE bids<'".$bids."'");
    //$result=mysql_query("SELECT id FROM de_tauction WHERE bids<'".$bids."' AND seller != '$uid'");
    $result=mysql_query("SELECT id FROM de_tauction WHERE bids<'".$bids."' AND NOT (seller = '$uid' OR bidder = '$uid')");
    //$result=mysql_query("SELECT id FROM de_tauction WHERE bids<'".$bids."' AND seller != '$uid' AND bidder != '$uid'");

    $numrows=mysql_num_rows($result);
    if($numrows>0)
    {
      $fehler='<font color="#FF0000">'.$tauction_lang['not_lowest_offer'].'</font>';
    }

  if ($fehler=='')
  {
	$bids++;

	// Dem vorherigen Zur�ckgeben und benachrichtigen
	if ($bidder > -1)
    {
	    mysql_query("UPDATE de_user_data SET restyp04=restyp04+'".$currentbet."' WHERE user_id=".$bidder);
		$time=strftime("%Y%m%d%H%M%S");
	    mysql_query("INSERT INTO de_user_news (user_id, typ, time, text) VALUES ($bidder, 1,'$time','".$tauction_lang['overbidden']."')",$db);
	    mysql_query("update de_user_data set newnews = 1 where user_id = $bidder",$db);
    }
    //echo $currentbet.':'.$increment.':'.$amount;

    //dem neuen anbieter abziehen
    $currentbet += ($increment*$amount);
    mysql_query("UPDATE de_user_data SET restyp04=restyp04-'".$currentbet."' WHERE user_id=".$ums_user_id);

	// Neue Werte Setzen
	mysql_query("UPDATE de_tauction SET maxbid='".$currentbet."',bids='".$bids."',bidder='".$uid."', ticks='".$ticks."', biddername='".$ums_spielername." (".$sector.":".$system.")' WHERE id='".$bieten."'");
    $restyp04=$restyp04-$currentbet;
  }
}


?>
<!doctype html>
<html>
<head>
<title>Tronic Auction</title>
<?php include "cssinclude.php"; ?>
</head>
<body>
<?php
echo "<center>";

include "resline.php";
include("trade/trade.menu.inc.php");

//�berpr�fen ob der handel aktiv ist
$trade_locked = getTradeStatus();
if ($trade_locked == 0)
{
  include("trade/trade.config.inc.php");
  include("trade/trade.msg.locked.php");
  include("trade/trade.footer.inc.php");
  die('</body></html>');
}

//�berpr�fen ob man die whg hat
if ($techs[4]==0)
{
  echo '<div class="info_box"><span class="text2">'.$tauction_lang['no_whg_message'].'</span></div><br>';
  include("trade/trade.footer.inc.php");
  die('</body></html>');
}

if ($fehler!='') echo $fehler.'</font><br>';

echo '<form action="tauktion.php" method="POST">';
echo "<br>".$tauction_lang['description_auction']."<br><br>";
echo '<table border="0" cellpadding="0" cellspacing="0">
<tr align="center">
<td width="13" height="37" class="rol">&nbsp;</td>
<td width="250" align="center" class="ro">'.$tauction_lang['start_auction'].'</td>
<td width="13" class="ror">&nbsp;</td>
</tr>';
//echo '<tr><td width="13" class="rl">&nbsp;</td>';
//echo '<td height="37" align="center">Tronic anbieten (Anzahl): <INPUT name="amount" type="text" Value="'.htmlspecialchars($val).'" size="6" maxlength="4"></td>';
//echo '<td width="13" class="rr">&nbsp;</td></tr>';
echo '<tr><td width="13" class="rl">&nbsp;</td>';
echo '<td height="37" align="center"><input type="Submit" name="newAuktion" value="'.$tauction_lang['start_auction_button'].'"></td>';
echo '<td width="13" class="rr">&nbsp;</td></tr>';
echo '
<tr height="20">
<td height="20" class="rul" width="13">&nbsp;</td>
<td class="ru">&nbsp;</td>
<td class="rur" width="13">&nbsp;</td>
</tr>
</table><br>';

//angebote ausgeben
$result = mysql_query("SELECT id,amount,bids,biddername FROM de_tauction where seller <> '$ums_user_id' AND bidder <> '$ums_user_id' ORDER BY bids,id ASC LIMIT 250");
$numrows=mysql_num_rows($result);
if($numrows>0)
{
?>
<table border="0" cellpadding="0" cellspacing="0">
<tr height="37">
<td width="13" height="37" class="rol">&nbsp;</td>
<td width="40" class="ro" align="center"><?php print($tauction_lang['amount']) ?></td>
<td width="40" class="ro" align="center"><?php print($tauction_lang['bids']) ?></td>
<td width="80" align="center" class="ro"><?php print($tauction_lang['maxbid']) ?></td>
<td width="200" class="ro" align="center"><?php print($tauction_lang['maxbidder']) ?></td>
<td width="70" class="ro" align="center"><?php print($tauction_lang['bid']) ?></td>
<td width="13" class="ror">&nbsp;</td>
</tr>
<tr>
<td width="13" class="rl">&nbsp;</td>
<td colspan="5">
<table border="0" cellpadding="0" cellspacing="1" width="100%">
<colgroup>
<col width="40">
<col width="40">
<col width="80">
<col width="200">
<col width="70">
</colgroup>
<?php
while(list($id, $amount, $bids,$biddername) = mysql_fetch_row($result))
{
  if ($varid!='')$varid=$varid.',';
  $varid=$varid.$id;

  if ($varamount!='')$varamount=$varamount.',';
  $varamount=$varamount.$amount;

  if ($varbids!='')$varbids=$varbids.',';
  $varbids=$varbids.$bids;

  if ($varbiddername!='')$varbiddername=$varbiddername.',';
  $varbiddername=$varbiddername.'"'.$biddername.'"';

  //$nextbid = $maxbid+($amount*$increment);
  //if($x) echo "<tr align='center' valign='middle' class='cell' ><td>".$amount."</td><td>".$bids."</td><td>".number_format($maxbid, 0,"",".")."</td><td>".$biddername."</td><td align=\"right\"><a class='link' href=\"tauktion.php?bieten=".$id."\">".number_format($nextbid, 0,"",".")."</a></td></tr>";
  //else   echo "<tr align='center' valign='middle' class='cell1'><td>".$amount."</td><td>".$bids."</td><td>".number_format($maxbid, 0,"",".")."</td><td>".$biddername."</td><td align=\"right\"><a class='link' href=\"tauktion.php?bieten=".$id."\">".number_format($nextbid, 0,"",".")."</a></td></tr>";
  //$x = !$x;
}
$varid='var d=new Array('.$varid.');';
$varamount='var a=new Array('.$varamount.');';
$varbids='var b=new Array('.$varbids.');';
$varbiddername='var n=new Array('.$varbiddername.');';

echo '<script type="text/javascript">
<!--
';

echo $varid;
echo $varamount;
echo $varbids;
echo $varbiddername;
echo 'var p='.$increment.';';
echo 'var bg="cell",c1=0;';

echo 'for (i=0; i<n.length; i++){if(c1==0){c1=1;bg="cell"}else{c1=0;bg="cell1"}; document.write("<tr align=\"center\" valign=\"middle\" class=\""+bg+"\"><td>"+a[i]+"</td><td>"+b[i]+"</td><td>"+(a[i]*b[i]*p)+"</td><td>"+n[i]+"</td><td><a class=\"link\" href=\"tauktion.php?betrag="+(a[i]*(b[i]+1)*p)+"&bieten="+d[i]+"\">"+(a[i]*(b[i]+1)*p)+"</a></td></tr>");}';
echo '
// -->
</script>';

    /*if ($c1==0)
    {
      $c1=1;
      $bg='cell';
    }
    else
    {
      $c1=0;
      $bg='cell1';
    } */


?>
</table>
</td>
<td width="13" class="rr">&nbsp;</td>
</tr>
<tr height="20">
<td height="20" class="rul" width="13">&nbsp;</td>
<td class="ru">&nbsp;</td>
<td class="ru">&nbsp;</td>
<td class="ru">&nbsp;</td>
<td class="ru">&nbsp;</td>
<td class="ru">&nbsp;</td>
<td class="rur" width="13">&nbsp;</td>
</tr>
</table>
<br>
<?php
echo '<a href="tauktion.php">'.$tauction_lang['refresh'].'</a><br><br>';
}
?>
<?php include "fooban.php"; ?>
</body>
</html>
