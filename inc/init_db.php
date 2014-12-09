<?


include($_SESSION['BASE_DIR'].$my_db_config);  
if($my_db_host =="" || $my_db_user=="" || $my_db_pass=="" || $my_db_name=="") {
      print "Erreur de configuration!";
} else {

  $db_link = new  iptDbLink($my_db_host,$my_db_user ,$my_db_pass);
  $active_db = new iptDb($db_link,$my_db_name);
  $active_db->Create();
  
  if(!$active_db->DbObject()) {
       print "Connexion impossible à la base de données!";
 
  } else {
  	include_once(realpath(dirname(__FILE__))."/../classes/classes.php");
  	include_once("login.php");
  }

}


?>