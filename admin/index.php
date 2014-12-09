<?


 
include('../inc/header.php');
include('../inc/admin_header.php');

if(isset($_GET['search_mod'])) {

  header("Location: ".$_GET['search_mod'].".php?search=".$_GET['search']);
}

       $rs19 = new iptDbQuery();
     $rs19->Open("select 1",$active_db); 
       
       $rs3 = new iptDbQuery();
     $rs3->Open("select gst_historique.iparent_id id, gst_historique.dinscrit temps, gst_utilisateur.tnomutilisateur utilisateur 
                    from gst_historique 
                    left outer join gst_utilisateur on gst_utilisateur.id=gst_historique.kgst_utilisateur
                    order by gst_historique.id desc 
                    limit 5",$active_db);   
             
        
       
             
        
                                          
   $x = new iptWidget("../html/ecrans/bienvenue.html",$rs19);    
  $x->ParseData("row1",$rs3);

    $my_html= $x->GetHTML();
    

     $msg = "";
     $incorrect_menu= "";
     
     
     $rs2 = new iptDbQuery();
     $rs2->Open("select count(id) nb from cms_site",$active_db);
     if($rs2->GetValue("nb",0)==0) {
      $msg = "Vous n'avez pas encore créer de <a href=\"admin/sites.php\">site internet</a>. ";
     } elseif($rs2->GetValue("nb",0)==1) {
      $msg = "Vous avez <a href=\"admin/sites.php\">1 site internet</a> actif.";
     } else {
      $msg = "Vous avez <a href=\"admin/sites.php\">".$rs2->GetValue("nb",0)." sites internet</a> ";
     }   

     $rs2 = new iptDbQuery();
     $rs2->Open("select count(id) nb from cms_langue",$active_db);
    
     if($rs2->GetValue("nb",0)==0) {
      $msg .= " et n'avez pas encore configuré de <a href=\"admin/langues.php\">langue</a>. ";
     } elseif($rs2->GetValue("nb",0)==1) {
      $msg .= " et avez <a href=\"admin/langues.php\">1 langue</a> active. ";
     } else {
      $msg .= " et avez <a href=\"admin/langues.php\">".$rs2->GetValue("nb",0)." langues</a> actives. ";
     
     }   
     

     $rs2 = new iptDbQuery();
     $rs2->Open("select cms_menu.kcms_site,count(cms_menu.id) nb,cms_site.ttitre from cms_menu left outer join cms_site on cms_site.id=cms_menu.kcms_site group by cms_menu.kcms_site, cms_site.ttitre",$active_db);
     for($i=0;$i<$rs2->RowCount();$i++) {
      if($rs2->GetValue("nb",$i)==0) {
        if($incorrect_menu!="") {
          $incorrect_menu .= ", ";
        }
        $incorrect_menu .=  $rs2->GetValue("ttitre",$i);
      }
     }
     //$msg .= "<br>";
     
     if($incorrect_menu!="") {
          $msg .= " Aucun <a href=\"admin/menu.php\">menu</a> n'a été configuré pour le ou les sites suivants: ".$incorrect_menu.". "; 
     } elseif($rs2->RowCount()==1) {
      $msg .= "Vous avez configuré <a href=\"admin/menu.php\">1 menu</a>. ";
     } else {
      $msg .= "Vous avez configuré <a href=\"admin/menu.php\">".$rs2->RowCount()." menus</a>. ";
     
     }   
   
     // $msg .= "<br>";
   
     $rs2 = new iptDbQuery();
     $rs2->Open("select count(id) nb from cms_contenu",$active_db);
    
     if($rs2->GetValue("nb",0)==0) {
      $msg .= "Vous avez pas encore de <a href=\"admin/pages.php\">page de contenu</a>, ";
     } elseif($rs2->GetValue("nb",0)==1) {
      $msg .= " Vous avez <a href=\"admin/pages.php\">1 page de contenu</a>, ";
     } else {
      $msg .= "Vous avez <a href=\"admin/pages.php\">".$rs2->GetValue("nb",0)." pages de contenu</a>, ";
     
     }      
   

     $rs2 = new iptDbQuery();
     $rs2->Open("select count(id) nb from cms_nouvelle",$active_db);
    
     if($rs2->GetValue("nb",0)==0) {
      $msg .= "<a href=\"admin/nouvelles.php\">aucune nouvelle</a>, ";
     } elseif($rs2->GetValue("nb",0)==1) {
      $msg .= "<a href=\"admin/nouvelles.php\">1 nouvelle</a>, ";
     } else {
      $msg .= "<a href=\"admin/nouvelles.php\">".$rs2->GetValue("nb",0)." nouvelles</a>, ";
     
     }      
   


     $rs2 = new iptDbQuery();
     $rs2->Open("select count(id) nb from cms_activite",$active_db);
    
     if($rs2->GetValue("nb",0)==0) {
      $msg .= "et aucune activité. ";
     } elseif($rs2->GetValue("nb",0)==1) {
      $msg .= "et <a href=\"admin/activites.php\">aucune activité</a>. ";
     } else {
      $msg .= "et <a href=\"admin/activites.php\">".$rs2->GetValue("nb",0)." activités</a>. ";
     
     }      
     
      //$msg .= "<br>";

     $rs2 = new iptDbQuery();
     $rs2->Open("select count(id) nb from gst_utilisateur",$active_db);
    
     if($rs2->GetValue("nb",0)==1) {
      $msg .= "Vous êtes le seul <a href=\"admin/utilisateurs.php\">utilisateur</a> autorisé au système. ";
     } else {
      $msg .= "Vous avez <a href=\"admin/utilisateurs.php\">".$rs2->GetValue("nb",0)." comptes utilisateurs</a> de configuré. ";
     
     }      
          
        
   
        
    $my_html = str_replace("[--message--]",$msg,$my_html);
    
    
    

include('../inc/admin_template.php');
include('../inc/footer.php');


?>
