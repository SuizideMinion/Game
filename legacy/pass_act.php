<?php
include "inc/sv.inc.php";
include "inc/lang/".getDefaultVariable('sv_server_lang')."_pass_act.lang.php";
include "inccon.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=$passact_lang[title]?></title>
<?php
$ums_rasse=1;
$ums_gpfad=getDefaultVariable('sv_image_server_list')[0];
include "cssinclude.php";
?>
</head>
<body>
<?php include "topframe.php"; ?>
<div align="center">
<?php
if ($_POST["nic"] or $_POST["email"]) //schauen ob was eingegeben worden ist
{
  $email=$_POST["email"];
  $nic=$_POST["nic"];

  if($email)
  {
    $where="reg_mail='$email'";
  }
  else
  {
    $where="nic='$nic'";
  }
  $sql="SELECT user_id, nic, pass, reg_mail, status FROM de_login WHERE $where";

  $result=mysql_query($sql, $db);
  $num = mysql_num_rows($result);

  if($num>0) //user existiert
  {
    $row = mysql_fetch_array($result);
    if($row["status"]==0)//account noch nicht aktiviert -> aktivierungsmail nochmal schicken
    {
      // Aktivierungs-Link
      $directory=str_replace("/pass_act.php","/",$_SERVER["PHP_SELF"]);
      $server=$_SERVER["SERVER_NAME"].$directory;
      $link="http://".$server."register/activate.php?activate=".$row["user_id"]."&nic=".$row["nic"];


      //neues pw generieren
      $pwstring='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      $newpass=$pwstring[rand(0, strlen($pwstring)-1)];
      for($i=1; $i<=6; $i++) $newpass.=$pwstring[rand(0, strlen($pwstring)-1)];

      //$text=implode("",file("register/check_text.txt"));
      $text=$passact_lang[actmailbody];
      //Paswort und Login-Name eintragen
      $text=str_replace("{SPIELER}","",$text);
      $text=str_replace("{LOGIN}",$row["nic"],$text);
      $text=str_replace("{PASS}",$newpass,$text);
      $text=str_replace("{ACTIV-LINK}",$link,$text);

      //passwort in db eintragen
      $uid=$row["user_id"];
      $sql="UPDATE de_login set newpass=OLD_PASSWORD('$newpass') WHERE user_id=$uid";
      mysql_query($sql, $db);

      //mail Senden:
      @mail($row["reg_mail"], $passact_lang[actmailbetreff], $text, 'FROM: noreply@die-ewigen.com');
      echo '<br><font size="2" color="#00FF00">'.$passact_lang[versendet].'<br><br><a href="index.php">'.$passact_lang[login].'</a>';
      exit;
    }
    else //alternativpasswort setzen und versenden
    {
      //neues pw generieren
      $pwstring='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
      $newpass=$pwstring[rand(0, strlen($pwstring)-1)];
      for($i=1; $i<=6; $i++) $newpass.=$pwstring[rand(0, strlen($pwstring)-1)];
      //passwort in db eintragen
      $uid=$row["user_id"];
      $sql="UPDATE de_login set newpass=OLD_PASSWORD('$newpass') WHERE user_id=$uid";
      mysql_query($sql, $db);
      //passwort versenden
      //$text=implode("",file("register/pass_act.txt"));
      $text=$passact_lang[passmailbody];
      //Paswort und Login-Name eintragen
      $text=str_replace("{LOGIN}",$row["nic"],$text);
      $text=str_replace("{PASS}",$newpass,$text);
      $text=str_replace("{EMAIL}",$row["reg_mail"],$text);
      //mail Senden:
      @mail($row["reg_mail"], $passact_lang[passmailbetreff], $text, 'FROM: noreply@die-ewigen.com');
      echo '<br><font size="2" color="#00FF00">'.$passact_lang[versendet].'<br><br><a href="index.php">'.$passact_lang[login].'</a>';
      exit;
    }
  }
  else echo '<br><font size="2" color="#FF0000">'.$passact_lang[keinaccount].'</font>';
}
?>
<form action="pass_act.php" method="post">
<br>
<table border="0" cellpadding="0" cellspacing="0">
<tr align="center">
<td width="13" height="37" class="rol">&nbsp;</td>
<td width="300" align="center" class="ro"><?=$passact_lang[ueberschrift]?></td>
<td width="13" class="ror">&nbsp;</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0">
<tr align="center">
<td width="13" height="25" class="rl">&nbsp;</td>
<td width="300"><font color="#00FF00"><?=$passact_lang[msg1]?><br><br><?=$passact_lang[msg2]?><br><br><font color="#FF0000"><?=$passact_lang[msg3]?></td>
<td width="13" class="rr">&nbsp;</td>
</tr>
<table border="0" cellpadding="0" cellspacing="0">
<tr align="center">
<td width="13" height="25" class="rl">&nbsp;</td>
<td width="150"><?=$passact_lang[loginname]?></td>
<td width="150"><input type="text" name="nic" value=""></td>
<td width="13" class="rr">&nbsp;</td>
</tr>
<table border="0" cellpadding="0" cellspacing="0">
<tr align="center">
<td width="13" height="25" class="rl">&nbsp;</td>
<td width="150"><?=$passact_lang[email]?></td>
<td width="150"><input type="text" name="email" value=""></td>
<td width="13" class="rr">&nbsp;</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0">
<tr align="center">
<td width="13" height="25" class="rl">&nbsp;</td>
<td width="300"><input type="submit" name="send_pass" value="<?=$passact_lang[emailanfordern]?>"></td>
<td width="13" class="rr">&nbsp;</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="13" class="rul">&nbsp;</td>
<td class="ru" width="150">&nbsp;</td>
<td class="ru" width="150">&nbsp;</td>
<td width="13" class="rur">&nbsp;</td>
</tr>
</table>
<br>
</form>
<?php include "fooban.php"; ?>
</body>
</html>
