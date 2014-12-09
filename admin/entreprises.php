<?
                

include('../inc/init.php');
include('../inc/admin_header.php');
                                                                                                           
if(!isset($_GET['action'])) {$_GET['action']="";}
            
$x = new gcoEntreprise($active_db);
if($_GET['action']=="" || $_GET['action']=="list") {
 $reqListe = $x->GetQuery("liste");
} else if($_GET['action']=="list_budget") {
 $reqListe = $x->GetQuery("budget");
} else if($_GET['action']=="list_suivi") {
 $reqListe = $x->GetQuery("suivi");
}

                

 
if(isset($_GET['search'])) {
  $reqListe=str_replace("order by "," where gco_entreprise.tnom like '%".addslashes($_GET['search'])."%' order by  ",$reqListe);
 
}


    if(!isset($_GET['page'])) {
      $_GET['page']=0;   
    }

   $bizz = new iptPageNumber($active_db,$reqListe,$_GET['page'],50);
   $reqRow=$bizz->GetPageQuery();
   $reqListe=$bizz->GetDataQuery();


    
//$reqListe = $reqListe." limit ".(intval($_GET['page'])*$nb_item_page).", ".$nb_item_page;


                                       



$x = new iptMagicScreen($active_db,$_SESSION['BASE_DIR']."inc/classes/","gco_entreprise");
$x->Set_List_Template($_SESSION['TEMPLATES_DIR']."gco_entreprise_list.html");
$x->Set_List_Querys(array(array($reqListe,"row"),array($reqRow,"row2"),array($reqRow,"row3")));




$x->Set_Field_Param(GCO_ENTREPRISE_RESPONSABLE,IMS_FIELD_PARAM_NAME,'kgco_utilisateur');
$x->Set_Field_Param(GCO_ENTREPRISE_RESPONSABLE,IMS_FIELD_PARAM_TYPE,IMS_FIELD_TYPE_COMBO);   
$x->Set_Field_Param(GCO_ENTREPRISE_RESPONSABLE,IMS_FIELD_PARAM_COMBO_QUERY,"select 0 as id, '' as tnom union select id, replace(tnomutilisateur,\"'\",\"\\\'\") tnom from gco_utilisateur ");
$x->Set_Field_Param(GCO_ENTREPRISE_RESPONSABLE,IMS_FIELD_PARAM_LABEL,'Utilisateur');
      
      
$x->Set_Field_Param(GCO_ENTREPRISE_CONTACT,IMS_FIELD_PARAM_NAME,'kgco_contact');
$x->Set_Field_Param(GCO_ENTREPRISE_CONTACT,IMS_FIELD_PARAM_TYPE,IMS_FIELD_TYPE_COMBO);   
$x->Set_Field_Param(GCO_ENTREPRISE_CONTACT,IMS_FIELD_PARAM_COMBO_QUERY,"select 0 as id, '' as tnom union select id, replace(concat(tnom,', ',tprenom),\"'\",\"\\\'\") tnom from gco_contact ");
$x->Set_Field_Param(GCO_ENTREPRISE_CONTACT,IMS_FIELD_PARAM_LABEL,'Contact');
      
      
       
$x->Set_Field_Param(GCO_ENTREPRISE_ACTIF,IMS_FIELD_PARAM_NAME,'bactif');
$x->Set_Field_Param(GCO_ENTREPRISE_ACTIF,IMS_FIELD_PARAM_TYPE,IMS_FIELD_TYPE_COMBO);   
$x->Set_Field_Param(GCO_ENTREPRISE_ACTIF,IMS_FIELD_PARAM_COMBO_QUERY,"select 0 as id, 'Non' as tnom union select 1 as id, 'Oui' as tnom ");

$x->Set_Field_Param(GCO_ENTREPRISE_PROVINCE,IMS_FIELD_PARAM_NAME,'kgco_province');
$x->Set_Field_Param(GCO_ENTREPRISE_PROVINCE,IMS_FIELD_PARAM_TYPE,IMS_FIELD_TYPE_COMBO);   
$x->Set_Field_Param(GCO_ENTREPRISE_PROVINCE,IMS_FIELD_PARAM_COMBO_QUERY,"select 0 as id, '' as tnom union select gco_province.id, replace(concat(gco_province.ttitre,' (',gco_pays.ttitre,')'),\"'\",\"\\\'\") tnom from gco_province left outer join gco_pays on gco_pays.id=gco_province.kgco_pays ");
 
  
$x->Set_Field_Param(GCO_ENTREPRISE_VILLE,IMS_FIELD_PARAM_NAME,'kgco_ville');
$x->Set_Field_Param(GCO_ENTREPRISE_VILLE,IMS_FIELD_PARAM_TYPE,IMS_FIELD_TYPE_COMBO);   
$x->Set_Field_Param(GCO_ENTREPRISE_VILLE,IMS_FIELD_PARAM_COMBO_QUERY,"select 0 as id, '' as tnom union select gco_ville.id, replace(gco_ville.ttitre,\"'\",\"\\\'\") tnom from gco_ville ");
 

      $x->Set_Field_Param(GCO_ENTREPRISE_PROVINCE,IMS_FIELD_PARAM_DEFAULT,"1");
      $x->Set_Field_Param(GCO_ENTREPRISE_PROVINCE,IMS_FIELD_PARAM_LABEL,'Province');
      
      
      $x->Set_Field_Param(GCO_ENTREPRISE_ACTIF,IMS_FIELD_PARAM_DEFAULT,"1");   
      $x->Set_Field_Param(GCO_ENTREPRISE_ACTIF,IMS_FIELD_PARAM_LABEL,'Statut');
          
      
      $x->Set_Field_Param(GCO_ENTREPRISE_TELEPHONE,IMS_FIELD_PARAM_NAME,'ttelephone');
      $x->Set_Field_Param(GCO_ENTREPRISE_TELEPHONE,IMS_FIELD_PARAM_DEFAULT,"");
      $x->Set_Field_Param(GCO_ENTREPRISE_TELEPHONE,IMS_FIELD_PARAM_LABEL,'Téléphone');


      $x->Set_Field_Param(GCO_ENTREPRISE_COURRIEL,IMS_FIELD_PARAM_NAME,'tcourriel');
      $x->Set_Field_Param(GCO_ENTREPRISE_COURRIEL,IMS_FIELD_PARAM_DEFAULT,"");
      $x->Set_Field_Param(GCO_ENTREPRISE_COURRIEL,IMS_FIELD_PARAM_LABEL,'Courriel');
                                                                             
      
       $x->Set_Field_Param(GCO_ENTREPRISE_REMARQUES,IMS_FIELD_PARAM_NAME,'tremarques');
      $x->Set_Field_Param(GCO_ENTREPRISE_REMARQUES,IMS_FIELD_PARAM_DEFAULT,"");
      $x->Set_Field_Param(GCO_ENTREPRISE_REMARQUES,IMS_FIELD_PARAM_LABEL,'Remarques');

      $x->Set_Field_Param(GCO_ENTREPRISE_VILLE,IMS_FIELD_PARAM_LABEL,'Ville');
         
           
       $x->Set_Field_Param(GCO_ENTREPRISE_ADRESSE,IMS_FIELD_PARAM_NAME,'tadresse');
      $x->Set_Field_Param(GCO_ENTREPRISE_ADRESSE,IMS_FIELD_PARAM_DEFAULT,"");  
      $x->Set_Field_Param(GCO_ENTREPRISE_ADRESSE,IMS_FIELD_PARAM_LABEL,'Adresse');
               

       $x->Set_Field_Param(GCO_ENTREPRISE_CODEPOSTAL,IMS_FIELD_PARAM_NAME,'tcodepostal');
      $x->Set_Field_Param(GCO_ENTREPRISE_CODEPOSTAL,IMS_FIELD_PARAM_DEFAULT,"");
      $x->Set_Field_Param(GCO_ENTREPRISE_CODEPOSTAL,IMS_FIELD_PARAM_LABEL,'Code postal');
                                                                                                                   

       $x->Set_Field_Param(GCO_ENTREPRISE_NOM,IMS_FIELD_PARAM_NAME,'tnom');
      $x->Set_Field_Param(GCO_ENTREPRISE_NOM,IMS_FIELD_PARAM_DEFAULT,"");   
      $x->Set_Field_Param(GCO_ENTREPRISE_NOM,IMS_FIELD_PARAM_LABEL,'Nom');
      
      
  
       $x->Set_Field_Param(GCO_ENTREPRISE_SITEWEB,IMS_FIELD_PARAM_NAME,'tsiteweb');                  
      $x->Set_Field_Param(GCO_ENTREPRISE_SITEWEB,IMS_FIELD_PARAM_DEFAULT,"http://");   
      $x->Set_Field_Param(GCO_ENTREPRISE_SITEWEB,IMS_FIELD_PARAM_LABEL,'Site internet');
      
      
       $x->Set_Field_Param(GCO_ENTREPRISE_TELECOPIEUR,IMS_FIELD_PARAM_NAME,'ttelecopieur');
      $x->Set_Field_Param(GCO_ENTREPRISE_TELECOPIEUR,IMS_FIELD_PARAM_DEFAULT,"");  
      $x->Set_Field_Param(GCO_ENTREPRISE_TELECOPIEUR,IMS_FIELD_PARAM_LABEL,'Télécopieur');
          
      $x->Set_Field_Param(GCO_ENTREPRISE_MTBUDGET,IMS_FIELD_PARAM_LABEL,'Budget');
      $x->Set_Field_Param(GCO_ENTREPRISE_DATEINSCRIT,IMS_FIELD_PARAM_LABEL,'Inscrit le');
      
      $x->Set_Field_Param(GCO_ENTREPRISE_DTREQUIS,IMS_FIELD_PARAM_LABEL,'Requis le');
                                           
   
      $x->Set_Field_Param(GCO_ENTREPRISE_LATT,IMS_FIELD_PARAM_NAME,'tlatt');
      $x->Set_Field_Param(GCO_ENTREPRISE_LATT,IMS_FIELD_PARAM_DEFAULT,"");
      $x->Set_Field_Param(GCO_ENTREPRISE_LATT,IMS_FIELD_PARAM_LABEL,'Lattitude');
                                                                             
                                             
   
      $x->Set_Field_Param(GCO_ENTREPRISE_LONG,IMS_FIELD_PARAM_NAME,'tlong');
      $x->Set_Field_Param(GCO_ENTREPRISE_LONG,IMS_FIELD_PARAM_DEFAULT,"");
      $x->Set_Field_Param(GCO_ENTREPRISE_LONG,IMS_FIELD_PARAM_LABEL,'Longitude');    
      
      $x->Set_Field_Param(GCO_ENTREPRISE_COURRIEL,IMS_FIELD_PARAM_NAME,'tcourriel');
      $x->Set_Field_Param(GCO_ENTREPRISE_COURRIEL,IMS_FIELD_PARAM_DEFAULT,"");
      $x->Set_Field_Param(GCO_ENTREPRISE_COURRIEL,IMS_FIELD_PARAM_LABEL,'Courriel');
                                                                             
      
      
           
$x->Set_Field_Param(GCO_ENTREPRISE_DATEINSCRIT,IMS_FIELD_PARAM_DISCARD,true);   

                             
 if(isset($_GET['id'])) {
  
  $x->Add_Form_Menu("Suivis","#"," onclick=\"document.getElementById('noteform').style.display='block';document.getElementById('mainform').style.display='none';\""); 
  
  
 }




       
$my_html = $x->Init($_SESSION['TEMPLATES_DIR']);
         
if(!isset($_GET['id'])) {
  $_GET['id']="";
}                     

if(intval($_GET['id'])>0) {
 $_SESSION['IPT_WIDGET_PARENT']="gco_entreprise";
  include($_SESSION['BASE_DIR']."inc/widgets/notes.php");
}
    

include('../inc/admin_template.php');




?>