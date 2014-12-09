<?


include('../inc/header.php');
include('../inc/admin_header.php');


if(!isset($_GET['parent'])) {
  $_GET['parent']=0;
}
     
     
     
if(isset($_POST['id'])) {
/* Ajout d'un enregistrement */                                    
    
                                                                   
       $y = new cmsNouvelle($active_db);                                       
                                                          
       $y->LoadFromId(intval($_POST['id']));
       $y->SetParamsFromArray(array(  CMS_NOUVELLE_TITRE    => addslashes($_POST["ttitre"]),
                                       CMS_NOUVELLE_RESUME    => addslashes($_POST["tresume"]),
                                       CMS_NOUVELLE_TEXTECOMPLET    => ($_POST["tresume"]),
                                        CMS_NOUVELLE_AUTEUR  => ($_POST["kgco_utilisateur"]),
                                       CMS_NOUVELLE_SITE  => ($_POST["kcms_site"]),
                                       CMS_NOUVELLE_LANGUE  => ($_POST["kcms_langue"]),
                                      CMS_NOUVELLE_DATE   => substr($_POST["daffichage"],6,4).substr($_POST["daffichage"],3,2).substr($_POST["daffichage"],0,2),
                                      CMS_NOUVELLE_DATE_DEBUT   => substr($_POST["ddebut"],6,4).substr($_POST["ddebut"],3,2).substr($_POST["ddebut"],0,2),
                                      CMS_NOUVELLE_DATE_FIN   => substr($_POST["dfin"],6,4).substr($_POST["dfin"],3,2).substr($_POST["dfin"],0,2)));
      
      $filename="";
      if(isset($_FILES['photo1']['tmp_name'])) {
      
        $filename = $_FILES['photo1']['tmp_name'];
      }                             
        $y->SetParam(CMS_NOUVELLE_FICHIER,$filename,true);
      
      $y->Save();
      
                                                                              
                                   
                    
}                                                    


if(isset($_GET['id'])) {
/* Affichage d'un enregistrement */

    $y = new cmsNouvelle($active_db);
    $rs2 = $y->InfosNouvelle($_GET['id']);
    $x = new iptWidget("../html/ecrans/cms_nouvelle_form.html",$rs2);    
  

 
  
    $my_html= $x->GetHTML();

                   
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
 
 
 
 
 
 
 
 
 
} else {
 /* Liste des entregistrements */   


 
    $y = new cmsNouvelle($active_db);
    $rs2 = $y->ListeNouvelles(25,0,false);




    $x = new iptWidget("../html/ecrans/cms_nouvelle_list.html",$rs2);

           

   
    $my_html= $x->GetHTML();
    
}



include('../inc/admin_template.php');
include('../inc/footer.php');
?>
