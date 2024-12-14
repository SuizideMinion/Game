<?php
//	Funktion der Seite:		Austreten aus einer Allianz
include('inc/header.inc.php');
include('inc/lang/' . getDefaultVariable('sv_server_lang') . '_ally.austritt.lang.php');
include_once('functions.php');

$db_daten = mysql_query("SELECT restyp01, restyp02, restyp03, restyp04, restyp05, score, techs, sector, system, newtrans, newnews, allytag, spielername FROM de_user_data WHERE user_id='$ums_user_id'", $db);
$row = mysql_fetch_array($db_daten);
$restyp01 = $row[0];
$restyp02 = $row[1];
$restyp03 = $row[2];
$restyp04 = $row[3];
$restyp05 = $row[4];
$punkte = $row["score"];
$newtrans = $row["newtrans"];
$newnews = $row["newnews"];
$sector = $row["sector"];
$system = $row["system"];
$allytag = $row["allytag"];
$username = $row["spielername"];
$leave_fee = 25;

?>
    <!DOCTYPE HTML>
    <html>
    <head>
        <title><?php echo $allyaustritt_lang['title'] ?></title>
        <?php include('cssinclude.php'); ?>
    </head>
<body>

<?php

include('resline.php');
include('ally/ally.menu.inc.php');
include('lib/basefunctions.lib.php');

if (isset($_POST['a']) AND $_POST['a'] == 1) {
    $result_user = mysql_query("Select allytag FROM de_user_data WHERE user_id='$ums_user_id'");
    $clantag = mysql_result($result_user, 0, "allytag");
    $result = mysql_query("SELECT * FROM de_allys WHERE allytag='$clantag'");
    $leaderid = mysql_result($result, 0, "leaderid");
    $coleaderid1 = mysql_result($result, 0, "coleaderid1");
    $coleaderid2 = mysql_result($result, 0, "coleaderid2");
    $coleaderid3 = mysql_result($result, 0, "coleaderid3");

    //Falls ein aktiver Leader die Allianz verlassen will, wird ein Fehler ausgegeben
    if ($leaderid == $ums_user_id) {
        print($allyaustritt_lang['msg_1']);
    } else {
        if ($restyp05 >= $leave_fee) {
            mysql_query("UPDATE de_user_data SET ally_id=0, allytag='',status=0, restyp05=restyp05-'$leave_fee', ally_tronic='0' WHERE user_id='$ums_user_id'");
            //Falls ein Co-Leader die Allianz verläßt, wird die Anderung im Allianzdatensatz eingetragen
            if ($coleaderid1 == $ums_user_id) {
                $result_updateally = mysql_query("UPDATE de_allys SET coleaderid1=-1 WHERE allytag='$clantag'");
            } elseif ($coleaderid2 == $ums_user_id) {
                $result_updateally = mysql_query("UPDATE de_allys SET coleaderid2=-1 WHERE allytag='$clantag'");
            } elseif ($coleaderid3 == $ums_user_id) {
                $result_updateally = mysql_query("UPDATE de_allys SET coleaderid3=-1 WHERE allytag='$clantag'");
            }
            notifyUser($leaderid, $allyaustritt_lang['msg_2_1'] . ' <b>' . $username . '</b> ' . $allyaustritt_lang['msg_2_2'], 6);
            notifyUser($coleaderid1, $allyaustritt_lang['msg_2_1'] . ' <b>' . $username . '</b> ' . $allyaustritt_lang['msg_2_2'], 6);
            notifyUser($coleaderid2, $allyaustritt_lang['msg_2_1'] . ' <b>' . $username . '</b> ' . $allyaustritt_lang['msg_2_2'], 6);
            notifyUser($coleaderid3, $allyaustritt_lang['msg_2_1'] . ' <b>' . $username . '</b> ' . $allyaustritt_lang['msg_2_2'], 6);

            echo '<div class="cell" style="width: 552px; margin-top: 20px; padding: 20px;">';
            echo $allyaustritt_lang['msg_3_1'] . ' ' . $leave_fee . ' ' . $allyaustritt_lang['msg_3_2'];
            echo '<div>';

            include('ally/allyfunctions.inc.php');
            writeHistory($clantag, $allyaustritt_lang['msg_4_1'] . ' <i>' . $username . '</i> ' . $allyaustritt_lang['msg_4_2'], true);

        } else {
            echo '<div class="cell" style="width: 552px; margin-top: 20px; padding: 20px;">';
            print(str_replace('{VALUE}', $leave_fee, $allyaustritt_lang['msg_5']));
            echo '<div>';
        }
    }
} else {
    echo '<div class="cell" style="width: 552px; margin-top: 20px; padding: 20px;">';
    echo $allyaustritt_lang['msg_6_1'] . ' ' . $leave_fee . ' ' . $allyaustritt_lang['msg_6_2'] . '<br /><br />';
    echo '<a href="ally_austritt.php?a=1"><font style="font-size:14pt;"><b>' . $allyaustritt_lang['msg_7'] . '</a><br />';
    echo '<div>';
}


?>
<?php include('ally/ally.footer.inc.php'); ?>
