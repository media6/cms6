<?
header('Content-Type: text/html; charset=UTF-8'); 


if(!isset($_SESSION['REFERENCE_3'])) { $_SESSION['REFERENCE_3']=""; }
if(!isset($_SESSION['REFERENCE_2'])) { $_SESSION['REFERENCE_2']=""; }
if(!isset($_SESSION['REFERENCE_1'])) { $_SESSION['REFERENCE_1']=""; }
if(!isset($_SERVER['HTTP_REFERER'])) { $_SERVER['HTTP_REFERER']=""; }


$_SESSION['REFERENCE_3']  = $_SESSION['REFERENCE_2'];
$_SESSION['REFERENCE_2']  = $_SESSION['REFERENCE_1'];
$_SESSION['REFERENCE_1']  = $_SERVER['HTTP_REFERER'];

if(intval($_SESSION['ipt_user_id'])<=0) {
	header('location: ../');
}

?>