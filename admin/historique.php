<?


include('../inc/init.php');
include('../inc/admin_header.php');


if(!isset($_GET['parent'])) {
  $_GET['parent']=0;
}
     
     
     



 /* Liste des entregistrements */   

    $y = new gstHistorique($active_db);

     if($_SESSION['ipt_user_admin']!=1) { 
      
          $rs2 = $y->ListeHistoriques($_SESSION['ipt_user_id']);      
      
      } else {
      $rs2 = $y->ListeHistoriques();
      }       
    

    $x = new iptWidget("../html/ecrans/gst_historique_list.html",$rs2);


   
    $my_html= $x->GetHTML();
    


  


include('../inc/admin_template.php');

?>