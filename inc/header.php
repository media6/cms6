<?
 
session_start();

$_SESSION['BASE_DIR'] = realpath(dirname(__FILE__))."/../";
$_SESSION['BASE_URL'] = "/";
$_SESSION['IPT_VARS_DIR'] = $_SESSION['BASE_DIR']."prog6/php/"; //This line must be edited with current prog6 php folder
$_SESSION['TEMPLATES_DIR'] = $_SESSION['BASE_DIR']."html/";
$_SESSION['RFM_UPLOAD_DIR']='/public/images/';
$_SESSION['RFM_REL_PATH']='../../../public/images/';
$_SESSION['RFM_REL_THUMBS']='../../../public/thumbs/';


include_once("prog6.php");
include(realpath(dirname(__FILE__))."/../config.php"); //This line must be edited 

$db_link = new  iptDbLink($db_host,$db_user ,$db_pass);
$active_db = new iptDb($db_link,$db_name);
$active_db->Create();

if(!$active_db->DbObject()) {

} else {
	include_once(realpath(dirname(__FILE__))."/../classes/classes.php");
	include_once("login.php");
}


?>
