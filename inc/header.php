<?
 
session_start();


//print "DIRNAME=".dirname(__FILE__)."<br>";
//print "REALPATH=".realpath(dirname(__FILE__))."<br>";



include(realpath(dirname(__FILE__))."/../ipt/ipt.php");
include(realpath(dirname(__FILE__))."/../config/config.php");
/* Classes definitions Application */
include_once(realpath(dirname(__FILE__))."/../classes/classes.php");

//$active_db;
 //Validation du login
include_once("login.php");


?>