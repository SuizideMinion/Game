<?php
$session_subdir=1;
include "../inc/sv.inc.php";
include "../inc/session.inc.php";
@include "../inccon.php";

$db_daten=mysql_query("SELECT ircname FROM de_user_info WHERE user_id='$ums_user_id'",$db);
$row = mysql_fetch_array($db_daten);
$db_ircname=$row["ircname"];
?>

<html>
<head>
<title>Die Ewigen - IRC</title>
<?php include "cssinclude.php"; ?>
</head>
<body>
<?php
if($db_ircname=='') echo '<center><h1>Trage bitte einen IRC-Namen unter Optionen ein.</h1></center>';
else
{
?>
<applet code=IRCApplet.class archive="irc.jar,pixx.jar"  width=100% height=100%>
<param name="CABINETS" value="irc.cab,securedirc.cab,pixx.cab">

<param name="nick" value="<?=$db_ircname; ?>">
<param name="alternatenick" value="<?=$db_ircname; ?>42">
<param name="fullname" value="<?=$db_ircname; ?>">
<param name="host" value="irc.us.gamesurge.net">
<param name="gui" value="pixx">
<param name="quitmessage" value="http://die-ewigen.com">
<param name="asl" value="true">
<param name="command1" value="/j #die-ewigen">
<param name="command2" value="/j #speed-de">

<param name="style:bitmapsmileys" value="true">
<param name="style:smiley1" value=":) img/sourire.gif">
<param name="style:smiley2" value=":-) img/sourire.gif">
<param name="style:smiley3" value=":-D img/content.gif">
<param name="style:smiley4" value=":d img/content.gif">
<param name="style:smiley5" value=":-O img/OH-2.gif">
<param name="style:smiley6" value=":o img/OH-1.gif">
<param name="style:smiley7" value=":-P img/langue.gif">
<param name="style:smiley8" value=":p img/langue.gif">
<param name="style:smiley9" value=";-) img/clin-oeuil.gif">
<param name="style:smiley10" value=";) img/clin-oeuil.gif">
<param name="style:smiley11" value=":-( img/triste.gif">
<param name="style:smiley12" value=":( img/triste.gif">
<param name="style:smiley13" value=":-| img/OH-3.gif">
<param name="style:smiley14" value=":| img/OH-3.gif">
<param name="style:smiley15" value=":'( img/pleure.gif">
<param name="style:smiley16" value=":$ img/rouge.gif">
<param name="style:smiley17" value=":-$ img/rouge.gif">
<param name="style:smiley18" value="(H) img/cool.gif">
<param name="style:smiley19" value="(h) img/cool.gif">
<param name="style:smiley20" value=":-@ img/enerve1.gif">
<param name="style:smiley21" value=":@ img/enerve2.gif">
<param name="style:smiley22" value=":-S img/roll-eyes.gif">
<param name="style:smiley23" value=":s img/roll-eyes.gif">
<param name="style:floatingasl" value="true">

<param name="pixx:timestamp" value="true">
<param name="pixx:nickfield" value="true">
<param name="pixx:language" value="pixx-german">
<param name="pixx:highlight" value="true">
<param name="pixx:highlightnick" value="true">
<param name="pixx:leaveonundockedwindowclose" value="true">

</applet>
<?php
}
?>

</body>
</html>
