<?
               
 

global $_SESSION;

include('../inc/header.php');
include('../inc/admin_header.php');






  
if(isset($_GET['site'])) {
  $_SESSION['current_cms_site']=intval($_GET['site']);
}   



  
if(isset($_GET['langue'])) {
  $_SESSION['current_cms_langue']=intval($_GET['langue']);
}

if(!isset($_GET['parent'])) {
  $_GET['parent']=0;
}
     
     
     
if(isset($_POST['id'])) {
/* Ajout d'un enregistrement */
    
                                    
       $y = new cmsMenu($active_db);
                                                          
       $y->LoadFromId(intval($_POST['id']));
       $y->SetParamsFromArray(array(  CMS_MENU_CONTENU  => $_POST["kcms_contenu"],
                                      CMS_MENU_URL      => $_POST["turl"],
                                      CMS_MENU_ORDRE    => $_POST["iordre"],
                                      CMS_MENU_TITRE    => $_POST["ttitre"],
                                      CMS_MENU_LANGUE    => $_POST["kcms_langue"],
                                      CMS_MENU_SITE    => $_POST["kcms_site"],
                                      CMS_MENU_PARENT   => $_POST["kcms_menu"]));
        $y->Save();
    
       header("Location: menu.php?parent=".$_POST["kcms_menu"]); 
    
}


if(isset($_GET['id'])) {
/* Affichage d'un enregistrement */
     
                               
    $y = new cmsMenu($active_db);                                          
    $rs2 = $y->InfosMenu($_GET['id'],true,$_SESSION['current_cms_langue'],$_SESSION['current_cms_site']);
    $x = new iptWidget("../html/ecrans/cms_menu_form.html",$rs2);    
    $my_html= $x->GetHTML();
        
           
    $y2 = new cmsMenu($active_db);                                      
    $rs3 =  $y->ComboMenus($rs2->GetValue("kcms_site",0));
    $x2 = new iptWidget("../html/widgets/combo_cms_menu.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
    $my_html = str_replace("[--combo_parent--]",$my_cbo_entreprise,$my_html);
                   
    $y2 = new cmsContenu($active_db);
    $rs3 =  $y2->ComboContenus($rs2->GetValue("kcms_site",0));
    $x2 = new iptWidget("../html/widgets/combo_cms_contenu.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
    $my_html = str_replace("[--combo_contenu--]",$my_cbo_entreprise,$my_html);
 
  
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
  
      if(!isset($_SESSION['current_cms_langue'])) {
      $_SESSION['current_cms_langue']=0;
      } 

      if(!isset($_SESSION['current_cms_site'])) {
      $_SESSION['current_cms_site']=0;
      } 

    $y = new cmsMenu($active_db);
    //print intval($_SESSION['current_cms_langue'])."ddd".intval($_SESSION['current_cms_site']);
    $rs2 = $y->ListeMenus(intval($_GET['parent']),intval($_SESSION['current_cms_langue']),intval($_SESSION['current_cms_site']));
    $x = new iptWidget("../html/ecrans/cms_menu_list.html",$rs2);
    $rs3 = $y->InfosMenu($_GET['parent'],true,$_SESSION['current_cms_langue'],$_SESSION['current_cms_site']); 
    $x->ParseData("row2",$rs3);
    $my_html= $x->GetHTML();


    $y2 = new cmsLangue($active_db);
    $rs3 =  $y2->ComboLangues();
    $x2 = new iptWidget("../html/widgets/combo_cms_langue.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
    $my_html = str_replace("[--combo_langue--]",$my_cbo_entreprise,$my_html);
   
   
   $y2 = new cmsSite($active_db);
    $rs3 =  $y2->ComboSites();
    $x2 = new iptWidget("../html/widgets/combo.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
                      
    $my_html = str_replace("[--combo_site--]",$my_cbo_entreprise,$my_html);
 
   
   
   
    
}


include('../inc/admin_template.php');
include('../inc/footer.php');

?>