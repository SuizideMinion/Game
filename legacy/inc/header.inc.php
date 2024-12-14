<?php
include "suiFix.php";
include "sv.inc.php";
include_once "env.inc.php";
if($sv_comserver==1)include 'svcomserver.inc.php';
include "session.inc.php";
if (isset($_SESSION['ums_user_id']) && !empty($_SESSION['ums_user_id'])) {
    session()->put('ums_user_id', $_SESSION['ums_user_id']);
}
include basePath("inccon.php");
?>
