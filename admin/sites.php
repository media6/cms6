<?


include('../inc/init.php');
include('../inc/admin_header.php');


if(!isset($_GET['parent'])) {
  $_GET['parent']=0;
}
     
     
     
if(isset($_POST['id'])) {
/* Ajout d'un enregistrement */                                    
        
                                                                   
       $y = new cmsSite($active_db);
                                                          
       $y->LoadFromId(intval($_POST['id']));
       $y->SetParamsFromArray(array(  CMS_SITE_TITRE    => addslashes($_POST["ttitre"])));
        $y->Save();                                                                       
    
       //   die;
       header('location: sites.php');
    
}


if(isset($_GET['id'])) {
/* Affichage d'un enregistrement */

    $y = new cmsSite($active_db);
    $rs2 = $y->InfosSite($_GET['id']);
    $x = new iptWidget("../html/ecrans/cms_site_form.html",$rs2);    
    $my_html= $x->GetHTML();
        
            
 
} else {
 /* Liste des entregistrements */   

    $y = new cmsSite($active_db);
    $rs2 = $y->ListeSites();
    
    $x = new iptWidget("../html/ecrans/cms_site_list.html",$rs2);
    
    $my_html= $x->GetHTML();
    
}



include('../inc/admin_template.php');


?>