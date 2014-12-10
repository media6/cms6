<?
if($my_db_host =="" || $my_db_user=="" || $my_db_pass=="" || $my_db_name=="") {
      print "Erreur de configuration!";
 $_SESSION = null;

} else {

  $db_link = new  iptDbLink($my_db_host,$my_db_user ,$my_db_pass);
  $active_db = new iptDb($db_link,$my_db_name);
  $active_db->Create();

	if(!$active_db->Connect()) {

		 print "<br>Connexion impossible au serveur de donnees";
		$_SESSION = null;
		die;
	} else {
	    if(!$active_db->DbObject()) {
	       print "<br>Connexion impossible à la base de données!";
		 $_SESSION = null;

		die;
	    } else {
	  	include_once(realpath(dirname(__FILE__))."/../classes/classes.php");
	  	include_once("login.php");
 	    }
	}

}


?>
