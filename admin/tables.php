<?
                

include('../inc/header.php');
include('../inc/admin_header.php');

       
if(!isset($_GET['action'])) {$_GET['action']="";}


   
$x = new iptMagicScreen($active_db,$_SESSION['BASE_DIR']."inc/classes/","gst_table");


          

$my_html = $x->Init($_SESSION['TEMPLATES_DIR']);



/***********************************************************/


















include('../inc/admin_template.php');
include('../inc/footer.php');






?>