<?
 
session_start();

$_SESSION['BASE_DIR'] = realpath(dirname(__FILE__))."/../";
$_SESSION['BASE_URL'] = "/";
$_SESSION['IPT_VARS_DIR'] = $_SESSION['BASE_DIR']."../prog6/php/";
$_SESSION['TEMPLATES_DIR'] = $_SESSION['BASE_DIR']."html/";
$_SESSION['RFM_UPLOAD_DIR']='/public/images/';
$_SESSION['RFM_REL_PATH']='../../../public/images/';
$_SESSION['RFM_REL_THUMBS']='../../../public/thumbs/';


include(realpath(dirname(__FILE__))."/../../aaa_config/config.php");
include_once(realpath(dirname(__FILE__))."/../classes/classes.php");

include_once("login.php");


?>
