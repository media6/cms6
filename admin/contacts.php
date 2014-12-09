<?
                

include('../inc/init.php');
include('../inc/admin_header.php');

       
if(!isset($_GET['action'])) {$_GET['action']="";}




$reqListe = "select gco_contact.*,
                    gco_entreprise.tnom entreprise 
                  
            from    gco_contact
            left outer join gco_entreprise on gco_entreprise.id=gco_contact.kgco_entreprise
            order by  gco_contact.tnom, gco_contact.tprenom
            ";
         
          

 
if(isset($_GET['search'])) {
  $reqListe=str_replace("order by "," where gco_contact.tnom like '%".addslashes($_GET['search'])."%' or gco_contact.tprenom like '%".addslashes($_GET['search'])."%'  order by  ",$reqListe);
 
}


    if(!isset($_GET['page'])) {
      $_GET['page']=0;   
    }

   $bizz = new iptPageNumber($active_db,$reqListe,$_GET['page'],50);
   $reqRow=$bizz->GetPageQuery();
   $reqListe=$bizz->GetDataQuery();




                                                         

$x = new iptMagicScreen($active_db,$_SESSION['BASE_DIR']."inc/classes/","gco_contact");


                             
$x->Set_List_Template($_SESSION['TEMPLATES_DIR']."gco_contact_list.html");
$x->Set_List_Querys(array(array($reqListe,"row"),array($reqRow,"row2"),array($reqRow,"row3")));


$x->Set_Field_Param(GCO_CONTACT_ENTREPRISE,IMS_FIELD_PARAM_NAME,'kgco_entreprise');
$x->Set_Field_Param(GCO_CONTACT_ENTREPRISE,IMS_FIELD_PARAM_TYPE,IMS_FIELD_TYPE_COMBO);   
$x->Set_Field_Param(GCO_CONTACT_ENTREPRISE,IMS_FIELD_PARAM_COMBO_QUERY,"select 0 id, '' tnom union select gco_entreprise.id, replace(concat(gco_entreprise.tnom),\"'\",\"\\\'\") tnom from gco_entreprise");
                        

$x->Set_Field_Param(GCO_CONTACT_ENTREPRISE,IMS_FIELD_PARAM_LABEL,'Entreprise');
$x->Set_Field_Param(GCO_CONTACT_NOM,IMS_FIELD_PARAM_LABEL,'Nom');
$x->Set_Field_Param(GCO_CONTACT_PRENOM,IMS_FIELD_PARAM_LABEL,'Prénom');
$x->Set_Field_Param(GCO_CONTACT_COURRIEL,IMS_FIELD_PARAM_LABEL,'Courriel');
$x->Set_Field_Param(GCO_CONTACT_TELEPHONE1,IMS_FIELD_PARAM_LABEL,'Téléphone (bureau)');
$x->Set_Field_Param(GCO_CONTACT_TELEPHONE2,IMS_FIELD_PARAM_LABEL,'Téléphone (maison)');
$x->Set_Field_Param(GCO_CONTACT_CELLULAIRE,IMS_FIELD_PARAM_LABEL,'Cellulaire');

$x->Set_Field_Param(GCO_CONTACT_DATEINSCRIT,IMS_FIELD_PARAM_HIDDEN,true);                        

/*
$x->Set_Field_Param(GVE_SOUMISSION_ITEM_DATE_INSCRIT,IMS_FIELD_PARAM_HIDDEN,true);
$x->Set_Field_Param(GVE_SOUMISSION_ITEM_UTILISATEUR_INSCRIT,IMS_FIELD_PARAM_HIDDEN,true);
$x->Set_Field_Param(GVE_SOUMISSION_ITEM_DATE_MISEAJOUR,IMS_FIELD_PARAM_HIDDEN,true);
$x->Set_Field_Param(GVE_SOUMISSION_ITEM_UTILISATEUR_MISEAJOUR,IMS_FIELD_PARAM_HIDDEN,true);
$x->Set_Field_Param(GVE_SOUMISSION_ITEM_SOUMISSION,IMS_FIELD_PARAM_HIDDEN,true);
$x->Set_Field_Param(GVE_SOUMISSION_ITEM_SOUSTOTAL,IMS_FIELD_PARAM_HIDDEN,true);
$x->Set_Field_Param(GVE_SOUMISSION_ITEM_TACHE,IMS_FIELD_PARAM_HIDDEN,true);


$x->Set_Field_Param(GVE_SOUMISSION_ITEM_NUMERO,IMS_FIELD_PARAM_LABEL,'Numéro');
$x->Set_Field_Param(GVE_SOUMISSION_ITEM_TITRE,IMS_FIELD_PARAM_LABEL,'Titre');
$x->Set_Field_Param(GVE_SOUMISSION_ITEM_QTE,IMS_FIELD_PARAM_LABEL,'Qte');
$x->Set_Field_Param(GVE_SOUMISSION_ITEM_TXHRE,IMS_FIELD_PARAM_LABEL,'Prix unitaire');

*/

         


  
                             
 if(isset($_GET['id'])) {
  
  $x->Add_Form_Menu("Suivis","#"," onclick=\"document.getElementById('noteform').style.display='block';document.getElementById('mainform').style.display='none';\""); 
  
  
 }







$my_html = $x->Init($_SESSION['TEMPLATES_DIR']);



/***********************************************************/
         
if(!isset($_GET['id'])) {
  $_GET['id']="";
}                     

if(intval($_GET['id'])>0) {
 $_SESSION['IPT_WIDGET_PARENT']="gco_contact";
  include($_SESSION['BASE_DIR']."inc/widgets/notes.php");
}
    

















include('../inc/admin_template.php');





?>