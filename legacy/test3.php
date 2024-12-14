<?php
$disablegzip=1;
include "inc/sv.inc.php";
include 'inccon.php';
include 'functions.php';


$db_daten = mysql_query("SELECT id, allytag FROM `de_allys` WHERE 1",$db);
while($row = mysql_fetch_array($db_daten)){
	$ally_id=$row['id'];
	$allytag=$row['allytag'];
	$sql="UPDATE de_user_data SET ally_id='$ally_id' WHERE allytag='$allytag';";
	echo '<br>'.$sql;
	mysql_query($sql,$db);
}


?>