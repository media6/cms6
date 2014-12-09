<?


include('../inc/header.php');
include('../inc/admin_header.php');


if(!isset($_GET['parent'])) {
  $_GET['parent']=0;
}
     
     
     
if(isset($_POST['id'])) {
/* Ajout d'un enregistrement */                                    
       
                                                                   
       $y = new gstConfig($active_db);
       $y->LoadFromId(intval($_POST['id']));
       $y->SetParamsFromArray(array(  GST_CONFIG_TITRE    => addslashes($_POST["ttitre"]),
                                      GST_CONFIG_VALEUR   => addslashes($_POST["tvaleur"])));
        $y->Save();                                                                       
    
          
       header('location: configuration.php');
    
}


if(isset($_GET['id'])) {
/* Affichage d'un enregistrement */

    $y = new gstConfig($active_db);
    $rs2 = $y->InfosConfig($_GET['id']);
    $x = new iptWidget("../html/ecrans/gst_config_form.html",$rs2);    
    $my_html= $x->GetHTML();
        
            
 
} else {
 /* Liste des entregistrements */   

    $y = new gstConfig($active_db);
    $rs2 = $y->ListeConfigs();

    $x = new iptWidget("../html/ecrans/gst_config_list.html",$rs2);


   
    $my_html= $x->GetHTML();
    
}



  


include('../inc/admin_template.php');
include('../inc/footer.php');


?>