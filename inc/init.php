<?


$default_config_dir ="config/config.php";
$default_db_file ="config/db.php";

if(file_exists ( $default_config_dir )) {

    include_once($default_config_dir);
    include_once("init_session.php");
    include_once("init_prog6.php");
    include($default_db_file);
    include_once("init_db.php");


} else {

print "Setup not completed. Please checkout your /install directory";

}


?>