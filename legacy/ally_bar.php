<?php
print("
<div align=center><br>
		<img src=" . $ums_gpfad . "g/ally/" . $ums_rasse . "_cars.gif alt=\"Central Alliance Registration System\"><br><br>
</div>
");

//	--------------------------------- allybar.php ---------------------------------
//	Funktion der Seite:		Anzeige des Allianzmen�s
//	Letzte �nderung:		05.09.2002
//	Letzte �nderung von:	Ascendant
//
//	�nderungshistorie:
//
//	05.02.2002 (Ascendant)	- Erweiterung um Anzeige eines Men�s f�r Coleader
//
//  --------------------------------------------------------------------------------
$allys = mysql_query("SELECT * FROM de_allys where leaderid='$ums_user_id'");

// ------�nderung von Ascendant (01.09.2002) - Erweiterung f�r Co-Leader Funktionen------
// Analog zum Feststellen der Leaderbefugnis wird auch f�r die beiden Coleader eine Abfrage
// durchgef�hrt.
$coleader = mysql_query("SELECT * FROM de_allys where coleaderid1='$ums_user_id' OR coleaderid2='$ums_user_id'");
// wird an dieser Stelle ein Resultset mit einem Datensatz zur�ckgegeben, ist der eingeloggte User
// ein Co-Leader der Allianz
// ------------------------ �nderung Ende ---------------------------------------


if (mysql_numrows($allys) >= 1) {
    print_LEADER_ally_bar($ums_gpfad, $ums_rasse, $allymenu_lang);
    $isleader = true;
    $iscoleader = false;  //Hinzugef�gt von Ascendant (01.09.2002)
    $ismember = false;
} // ------�nderung von Ascendant (01.09.2002) - Erweiterung f�r Co-Leader Funktionen------
elseif (mysql_numrows($coleader) >= 1) {
    print_COLEADER_ally_bar($ums_gpfad, $ums_rasse, $allymenu_lang);
    $isleader = false;
    $iscoleader = true;  //Hinzugef�gt von Ascendant (01.09.2002)
    $ismember = false;
} // --------------------- �nderung Ende -------------------------------
else {
    $query = "SELECT count(*) FROM de_user_data where user_id='$ums_user_id' and status=1";
    $hatereineally = mysql_query($query);
    if (mysql_result($hatereineally, 0, 0) == 0) {
        print_NOBODY_ally_bar($db, $ums_gpfad, $ums_rasse, $allymenu_lang, $ums_user_id, $ums_spielername);
        if ($leaderpage)
            die ("<BR><BR>Leider ist ihnen der Zugriff nicht gestattet. Auf dieses Dokument d�rfennur Allianzanf�hrer zugreifen.");
        $isleader = false;
        $iscoleader = false;   //Hinzugef�gt von Ascendant (01.09.2002)
        $ismember = false;
    } else {
        print_MEMBER_ally_bar($ums_gpfad, $ums_rasse, $allymenu_lang);
        if ($leaderpage)
            die ("<BR><BR>Leider ist ihnen der Zugriff nicht gestattet. Auf dieses Dokument d�rfennur Allianzanf�hrer zugreifen.");
        $isleader = false;
        $iscoleader = false;   //Hinzugef�gt von Ascendant (01.09.2002)
        $ismember = true;
    }
}

if (!isset($isleader)) $isleader = false;
if (!isset($iscoleader)) $iscoleader = false;
if (!isset($ismember)) $ismember = false;

function print_LEADER_ally_bar($ums_gpfad, $ums_rasse)
{
    echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" .
        "<tr>" .
        "<td width=\"13\" height=\"37\" class=\"rol\">&nbsp;</td>" .
        "<td  align=\"center\" class=\"ro\">Allianzmenu</td>" .
        "<td width=\"13\" class=\"ror\">&nbsp;</td>" .
        "</tr>" .
        "<tr>" .
        "<td width=\"13\" class=\"rl\">&nbsp;</td>" .
        "<td>" .
        "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" .
        "<tr>\n" .
        "<td><a href=\"allymain.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_allgemein.gif\"></a></td>\n" .
        "<td><a href=\"ally_members.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_mitglieder.gif\"></a></td>\n" .
        "<td><a href=\"ally_message.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_hfmember.gif\"></a></td>" .
        "<td><a href=\"ally_partner.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_buendnis.gif\"></a></td>\n" .
        "</tr><tr>\n" .
        "<td><a href=\"ally_delete.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_loeschen.gif\"></a></td>\n" .
        "<td><a href=\"ally_antrag.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_antraege.gif\"></a></td>\n" .
        "<td><a href=\"ally_message_leader.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_hfleader.gif\"></a></td>\n" .
        "<td><a href=\"ally_war.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_krieg.gif\"></a></td>\n" .
        "</tr><tr>\n" .
        "<td><a href=\"ally_coleader.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_coleader.gif\"></a></td>\n" .
        "<td><a href=\"ally_coleader.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_coleader.gif\"></a></td>\n" .
        "<td></td>\n" .
        "<td></td>\n" .
        "</tr>" .
        "</table>" .
        "</td>" .
        "<td width=\"13\" class=\"rr\">&nbsp;</td>" .
        "</tr>" .
        '<tr><td width="13" class="rul">&nbsp;</td>' .
        '<td width="13" class="ru">&nbsp;</td>' .
        '<td width="13" class="rur">&nbsp;</td>' .
        '</tr>' .
        "</table><BR><BR>\n";
}

// ------�nderung von Ascendant (01.09.2002) - Erweiterung f�r Co-Leader Funktionen------
// Ausgabe des Allianzenmen�s f�r Co-Leader
function print_COLEADER_ally_bar($ums_gpfad, $ums_rasse)
{
    echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" .
        "<tr>" .
        "<td width=\"13\" height=\"37\" class=\"rol\">&nbsp;</td>" .
        "<td  align=\"center\" class=\"ro\">Allianzmenu</td>" .
        "<td width=\"13\" class=\"ror\">&nbsp;</td>" .
        "</tr>" .
        "<tr>" .
        "<td width=\"13\" class=\"rl\">&nbsp;</td>" .
        "<td>" .
        "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" .
        "<tr>\n" .
        "<td><a href=\"allymain.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_allgemein.gif\"></a></td>\n" .
        "<td><a href=\"ally_members.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_mitglieder.gif\"></a></td>\n" .
        "<td><a href=\"ally_message.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_hfmember.gif\"></a></td>" .
        "<td><a href=\"ally_partner.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_buendnis.gif\"></a></td>\n" .
        "</tr><tr>\n" .
        "<td><a href=\"ally_austritt.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_austreten.gif\"></a></td>\n" .
        "<td><a href=\"ally_antrag.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_antraege.gif\"></a></td>\n" .
        "<td><a href=\"ally_message_leader.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_hfleader.gif\"></a></td>\n" .
        "<td><a href=\"ally_war.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_krieg.gif\"></a></td>\n" .
        "</tr>" .
        "</table>" .
        "</td>" .
        "<td width=\"13\" class=\"rr\">&nbsp;</td>" .
        "</tr>" .
        '<tr><td width="13" class="rul">&nbsp;</td>' .
        '<td width="13" class="ru">&nbsp;</td>' .
        '<td width="13" class="rur">&nbsp;</td>' .
        '</tr>' .
        "</table><BR><BR>\n";
}

// --------------------- �nderung Ende -------------------------------------------

function print_MEMBER_ally_bar($ums_gpfad, $ums_rasse)
{
    echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" .
        "<tr>" .
        "<td width=\"13\" height=\"37\" class=\"rol\">&nbsp;</td>" .
        "<td  align=\"center\" class=\"ro\">Allianzmenu</td>" .
        "<td width=\"13\" class=\"ror\">&nbsp;</td>" .
        "</tr>" .
        "<tr>" .
        "<td width=\"13\" class=\"rl\">&nbsp;</td>" .
        "<td>" .
        "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" .
        "<tr>\n" .
        "<td><a href=\"allymain.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_allgemein.gif\"></a></td>\n" .
        "<td><a href=\"ally_members.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_mitglieder.gif\"></a></td>\n" .
        "<td><a href=\"ally_austritt.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_austreten.gif\"></a></td>\n" .
        "</tr><tr>\n" .
        "<td><a href=\"ally_partner.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_buendnis.gif\"></a></td>\n" .
        "<td><a href=\"ally_war.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_krieg.gif\"></a></td>\n" .
        "</tr>" .
        "</table>" .
        "</td>" .
        "<td width=\"13\" class=\"rr\">&nbsp;</td>" .
        "</tr>" .
        '<tr><td width="13" class="rul">&nbsp;</td>' .
        '<td width="13" class="ru">&nbsp;</td>' .
        '<td width="13" class="rur">&nbsp;</td>' .
        '</tr>' .
        "</table><BR><BR>\n";
}

function print_NOBODY_ally_bar($ums_gpfad, $ums_rasse)
{
    echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" .
        "<tr>" .
        "<td width=\"13\" height=\"37\" class=\"rol\">&nbsp;</td>" .
        "<td  align=\"center\" class=\"ro\">Allianzmenu</td>" .
        "<td width=\"13\" class=\"ror\">&nbsp;</td>" .
        "</tr>" .
        "<tr>" .
        "<td width=\"13\" class=\"rl\">&nbsp;</td>" .
        "<td>" .
        "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">" .
        "<tr>\n" .
        "<td><a href=\"ally_register.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_gruenden.gif\"></a></td>\n" .
        "<td><a href=\"ally_join.php\"><img border=\"0\" src=\"" . $ums_gpfad . "g/ally/" . $ums_rasse . "_beitreten.gif\"></a></td>\n" .
        "</tr>" .
        "</table>" .
        "</td>" .
        "<td width=\"13\" class=\"rr\">&nbsp;</td>" .
        "</tr>" .
        '<tr><td width="13" class="rul">&nbsp;</td>' .
        '<td width="13" class="ru">&nbsp;</td>' .
        '<td width="13" class="rur">&nbsp;</td>' .
        '</tr>' .
        "</table><BR><BR>\n";
}

?>
