<?

include('../inc/header.php');
include('../inc/admin_header.php');




if(!isset($_GET['parent'])) {                                                                              
  $_GET['parent']=0;
}
     
     
     
if(isset($_POST['id'])) {
/* Ajout d'un enregistrement */                                    
            //$_POST['contenu'] = str_replace("&quot;/","",$_POST['contenu');
            
                                                   
       $y = new cmsContenu($active_db);
                                                          
       $y->LoadFromId(intval($_POST['id']));
       $y->SetParamsFromArray(array(  CMS_CONTENU_TITRE    => addslashes($_POST["ttitre"]),
                                       CMS_CONTENU_CONTENU    => addslashes($_POST["tcontenu"]),
                                       CMS_CONTENU_SITE    => addslashes($_POST["kcms_site"]),
                                       CMS_CONTENU_LANGUE    => addslashes($_POST["kcms_langue"]),
                                       CMS_CONTENU_MENU    => addslashes($_POST["kcms_menu"])));
        $y->Save();                                                                       
    
    
    
}


if(isset($_GET['id'])) {
/* Affichage d'un enregistrement */

    $y = new cmsContenu($active_db);                                           
    $rs2 = $y->InfosContenu($_GET['id']);
    $x = new iptWidget("../html/ecrans/cms_contenu_form.html",$rs2);    
    $my_html= $x->GetHTML();
        
          
   
   $y2 = new cmsSite($active_db);
    $rs3 =  $y2->ComboSites();
    $x2 = new iptWidget("../html/widgets/combo.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
                      
    $my_html = str_replace("[--combo_kcms_site--]",$my_cbo_entreprise,$my_html);
 
    
   $y2 = new cmsMenu($active_db);
    $rs3 =  $y2->ComboMenus();
    $x2 = new iptWidget("../html/widgets/combo_cms_menu.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
                      
    $my_html = str_replace("[--combo_kcms_menu--]",$my_cbo_entreprise,$my_html);
  
   $y2 = new cmsLangue($active_db);
    $rs3 =  $y2->ComboLangues();
    $x2 = new iptWidget("../html/widgets/combo_cms_langue.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
    $my_html = str_replace("[--combo_kcms_langue--]",$my_cbo_entreprise,$my_html);
 
 
 
    $cfg = new gstConfig($active_db);
    $myval = $cfg->GetValeur("nouvelles_param1");
    $my_html = str_replace("[--param1--]",$myval,$my_html);
 
 
 
} else {
 /* Liste des entregistrements */   

    $y = new cmsContenu($active_db);
    $rs2 = $y->ListeContenus();

    $x = new iptWidget("../html/ecrans/cms_contenu_list.html",$rs2);

           
    $rs3 = $y->InfosContenu($_GET['parent']); 
    $x->ParseData("row2",$rs3);

   
    $my_html= $x->GetHTML();
    
}



include('../inc/admin_template.php');
include('../inc/footer.php');
?>