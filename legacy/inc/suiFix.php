<?php

function getPostValue($key, $default = null)
{
    return isset($_POST[$key]) ? $_POST[$key] : $default;
}

function include_base($relativePath)
{
    // Erstellt den vollständigen Pfad zur Datei basierend auf base_path
    $fullPath = base_path() . '/legacy/' . $relativePath;

    if (file_exists($fullPath)) {
        return include $fullPath;
    } else {
        dd("Die Datei $fullPath wurde nicht gefunden.");
    }
}

function basePath($path)
{
    return base_path() . '/legacy/' . $path;
}

function getLang($url, $lang = 1)
{
    $fullPath = base_path('legacy/inc/lang/' . $lang . '_' . $url . '.lang.php');

    if (file_exists($fullPath)) {
        return include $fullPath;
    } else {
        dd("Die Datei $fullPath wurde nicht gefunden.");
    }
}
$sv_oscar=1;
$suiHatBotschutzAbfrageGeKillt = true;
$sv_comserver = 0;
$eftacss = 0;
$soucss = 0;
$newcss = 0;
$loadcssmenu = $loadcssmenu ?? 1;
$GLOBALS['deactivate_old_design'] = $GLOBALS['deactivate_old_design'] ?? false;
$sv_hardcore = $sv_hardcore ?? 0;
$sv_deactivate_blackmarket = $sv_deactivate_blackmarket ?? 0;
$sv_comserver_roundtyp = $sv_comserver_roundtyp ?? 0;
$newtrans = $newtrans ?? 0;
$newnews = $newnews ?? 0;

$_SERVER['DOCUMENT_ROOT'] = base_path('legacy');



