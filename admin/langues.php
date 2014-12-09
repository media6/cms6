<?


include('../inc/init.php');
include('../inc/admin_header.php');


if(!isset($_GET['parent'])) {
  $_GET['parent']=0;
}
     
     
     
if(isset($_POST['id'])) {
/* Ajout d'un enregistrement */                                    
        
                                                                   
       $y = new cmsLangue($active_db);
                                                          
       $y->LoadFromId(intval($_POST['id']));
       $y->SetParamsFromArray(array(  CMS_ALBUM_TITRE    => addslashes($_POST["ttitre"]),
                                      CMS_ALBUM_DATEINSCRIT   => $_POST["dinscrit"]));
        $y->Save();                                                                       
    
       //   die;
       header('location: langues.php');
    
}


if(isset($_GET['id'])) {
/* Affichage d'un enregistrement */

    $y = new cmsLangue($active_db);
    $rs2 = $y->InfosLangue($_GET['id']);
    $x = new iptWidget("../html/ecrans/cms_langue_form.html",$rs2);    
    $my_html= $x->GetHTML();
        
            
    $y2 = new cmsLangue($active_db);
    $rs3 =  $y->ComboLangues();
    $x2 = new iptWidget("../html/cms_langue_combo.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
    $my_html = str_replace("[--combo_parent--]",$my_cbo_entreprise,$my_html);
   
 
} else {
 /* Liste des entregistrements */   

    $y = new cmsLangue($active_db);
    $rs2 = $y->ListeLangues();

    $x = new iptWidget("../html/ecrans/cms_langue_list.html",$rs2);

           
    $rs3 = $y->InfosLangue($_GET['parent']); 
    $x->ParseData("row2",$rs3);

   
    $my_html= $x->GetHTML();
    
}



  


include('../inc/admin_template.php');


?>