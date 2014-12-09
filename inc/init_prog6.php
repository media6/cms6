<?

//
if(class_exists ("iptFile")){
} else {
	include($_SESSION['IPT_VARS_DIR']."file.php");
}

$myDir = $_SESSION['IPT_VARS_DIR'];
$x = new iptFile($myDir);

$x->IncludeFilesInDir("",".php",array("index.php","config.php","file.php"));



?>
