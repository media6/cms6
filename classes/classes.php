<?
/***
Description:   Importe automatiquement tous les fichier contenus dans le meme repertoire que ce fichier
***/

$myDir = realpath(dirname(__FILE__))."/";

$x = new iptFile($myDir);
$x->IncludeFilesInDir("",".php",array("index.php","classes.php"));

?>
