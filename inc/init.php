<?


session_start();


$default_config_dir ="../config/config.php";

if(file_exists ( $default_config_dir )) {

    include_once($default_config_dir);
    include_once("init_session.php");
    include_once("init_prog6.php");
    include_once("init_db.php");


} else {

print "Setup not completed. Please checkout your /install directory";

}


?>