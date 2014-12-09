<?
                

include('../inc/header.php');
include('../inc/admin_header.php');

       
if(!isset($_GET['action'])) {$_GET['action']="";}

$reqListe = "select gin_categorie.id,gin_categorie.tnumero, gin_categorie.ttitre, count(gin_produit.id) nb
                  
            from    gin_categorie
           left outer join gin_produit on gin_produit.id= gin_categorie.kgin_produit
           
            group by gin_categorie.id,gin_categorie.tnumero, gin_categorie.ttitre
            
            order by gin_categorie.tnumero asc
            ";
   
$x = new iptMagicScreen($active_db,$_SESSION['BASE_DIR']."inc/classes/","gin_categorie");


                             
$x->Set_List_Template($_SESSION['TEMPLATES_DIR']."gin_categorie_list.html");
$x->Set_List_Querys(array(array($reqListe,"row")));



$x->Set_Field_Param(GIN_CATEGORIE_TITRE,IMS_FIELD_PARAM_LABEL,'Titre');
$x->Set_Field_Param(GIN_CATEGORIE_NUMERO,IMS_FIELD_PARAM_LABEL,'Numéro');

$x->Set_Field_Param(GIN_CATEGORIE_DATEINSCRIT,IMS_FIELD_PARAM_HIDDEN,true);                        


$my_html = $x->Init($_SESSION['TEMPLATES_DIR']);



/***********************************************************/





include('../inc/admin_template.php');
include('../inc/footer.php');






?>