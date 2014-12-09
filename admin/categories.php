<?


include('../inc/init.php');
include('../inc/admin_header.php');






if(!isset($_GET['parent'])) {
  $_GET['parent']=0;
}

 
if(isset($_POST['id'])) {
/* Ajout d'un enregistrement */                                    
                      
                                                                   
       $y = new cmsCategorie($active_db);
                                                          
       $y->LoadFromId(intval($_POST['id']));
       $y->SetParamsFromArray(array(  CMS_CATEGORIE_TITRE    => addslashes($_POST["ttitre"])));
         $y->SetParamsFromArray(array(  CMS_CATEGORIE_SPECIAL    => addslashes($_POST["ispecial"])));
        $y->SetParamsFromArray(array(  CMS_CATEGORIE_RESUME    => addslashes($_POST["tresume"])));
           $y->SetParamsFromArray(array(  CMS_CATEGORIE_DESCRIPTION    => addslashes($_POST["ldescription"])));
    $filename="";
      if(isset($_FILES['photo1']['tmp_name'])) {
      
        $filename = $_FILES['photo1']['tmp_name'];
      }                             
        $y->SetParam(CMS_CATEGORIE_FICHIER,$filename,true);
        
        
        $y->Save();                                                                       
    
         
    
}


if(isset($_GET['id'])) {
/* Affichage d'un enregistrement */

    $y = new cmsCategorie($active_db);
    $rs2 = $y->InfosCategorie($_GET['id']);
    $x = new iptWidget($_SESSION['TEMPLATES_DIR']."cms_categorie_form.html",$rs2);    
    $my_html= $x->GetHTML();
        
            
   
 
} else {
 /* Liste des entregistrements */   

    $y = new cmsCategorie($active_db);
    $rs2 = $y->ListeCategories();
    $x = new iptWidget($_SESSION['TEMPLATES_DIR']."cms_categorie_list.html",$rs2);
    $my_html= $x->GetHTML();
    
}






include('../inc/admin_template.php');


?>