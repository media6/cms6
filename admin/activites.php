<?


include('../inc/header.php');
include('../inc/admin_header.php');


if(!isset($_GET['parent'])) {
  $_GET['parent']=0;
}
     
     
     
if(isset($_POST['id'])) {
/* Ajout d'un enregistrement */                                    
    
                                                                   
       $y = new cmsActivite($active_db);                                       
                                                          
       $y->LoadFromId(intval($_POST['id']));
       $y->SetParamsFromArray(array(  CMS_ACTIVITE_TITRE    => addslashes($_POST["ttitre"]),
                                       CMS_ACTIVITE_RESUME    => addslashes($_POST["tresume"]),
                                       CMS_ACTIVITE_URL    => addslashes($_POST["turl"]),
                                         CMS_ACTIVITE_AUTEUR  => ($_POST["kgco_utilisateur"]),
                                       CMS_ACTIVITE_CATEGORIE  => ($_POST["kcms_categorie"]),
                                        CMS_ACTIVITE_ENTREPRISE  => ($_POST["kgco_entreprise"]),
                                       CMS_ACTIVITE_TEXTECOMPLET    => $_POST["tresume"],
                                       CMS_ACTIVITE_SITE  => $_POST["kcms_site"],
                                       CMS_ACTIVITE_LANGUE  => $_POST["kcms_langue"],                                        
                                    CMS_ACTIVITE_SOURCE  => ($_POST["kcms_source"]),
                                      CMS_ACTIVITE_DATE   => substr($_POST["dinscrit"],6,4).substr($_POST["dinscrit"],3,2).substr($_POST["dinscrit"],0,2),
                                      CMS_ACTIVITE_CONTENU =>$_POST["kcms_contenu"]));
      
      $filename="";
      if(isset($_FILES['photo1']['tmp_name'])) {
      
        $filename = $_FILES['photo1']['tmp_name'];
      }                             
        $y->SetParam(CMS_ACTIVITE_FICHIER,$filename,true);
      
      $y->Save();
      
                                                                              
   
      header('Location: activites.php');                    
}                                                    


if(isset($_GET['id'])) {
/* Affichage d'un enregistrement */

    $y = new cmsActivite($active_db);
    $rs2 = $y->InfosActivite($_GET['id']);
    $x = new iptWidget("../html/ecrans/cms_activite_form.html",$rs2);    
  

 
  
    $my_html= $x->GetHTML();
        
          
               
               
   $y2 = new cmsSite($active_db);
    $rs3 =  $y2->ComboSites();
    $x2 = new iptWidget("../html/widgets/combo.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
                      
    $my_html = str_replace("[--combo_kcms_site--]",$my_cbo_entreprise,$my_html);
 
 
 
 
   
   $y2 = new cmsLangue($active_db);
    $rs3 =  $y2->ComboLangues();
    $x2 = new iptWidget("../html/widgets/combo_cms_langue.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
    $my_html = str_replace("[--combo_kcms_langue--]",$my_cbo_entreprise,$my_html);
 
     
    $y2 = new cmsContenu($active_db);
    $rs3 =  $y2->ComboContenus();
    $x2 = new iptWidget("../html/widgets/combo_cms_contenu.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
    $my_html = str_replace("[--combo_contenu--]",$my_cbo_entreprise,$my_html);
 
    $y2 = new gstUtilisateur($active_db);
    $rs3 =  $y2->ListeUtilisateurs();
    $x2 = new iptWidget("../html/widgets/combo_gst_utilisateur.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
    $my_html = str_replace("[--combo_utilisateur--]",$my_cbo_entreprise,$my_html);
  
       
} else {
 /* Liste des entregistrements */   

    $y = new cmsActivite($active_db);
    $rs2 = $y->ListeActivites();

    $x = new iptWidget("../html/ecrans/cms_activite_list.html",$rs2);

           

   
    $my_html= $x->GetHTML();
    
}



include('../inc/admin_template.php');
include('../inc/footer.php');
?>