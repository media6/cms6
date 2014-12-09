<?


include('../inc/init.php');
include('../inc/admin_header.php');






if(!isset($_GET['parent'])) {
  $_GET['parent']=0;
}
    
 
if(isset($_POST['id'])) {
/* Ajout d'un enregistrement */                                    
                      
     
      if($_SESSION['ipt_user_admin']!=1 && $_POST['id']!=$_SESSION['ipt_user_id']) { 
      
   header("Location: utilisateurs.php?id=".$_SESSION['ipt_user_id']);      
      
      }                                                               
       $y = new gstUtilisateur($active_db);
                                                          
       $y->LoadFromId(intval($_POST['id']));
       $y->SetParamsFromArray(array(  GST_UTILISATEUR_UTILISATEUR    => addslashes($_POST["tuser"]),
                                      GST_UTILISATEUR_COURRIEL    => addslashes($_POST["tcourriel"]),
                                      GST_UTILISATEUR_NOM    => addslashes($_POST["tnom"]),
                                      GST_UTILISATEUR_PRENOM    => addslashes($_POST["tprenom"]),
                                      GST_UTILISATEUR_ACTIF    => intval($_POST["bactive"]),
                                      GST_UTILISATEUR_ADMIN    => intval($_POST["badmin"])));
        if($_POST["tpass"]!="bidon") {
          $y->SetParam(GST_UTILISATEUR_MOTDEPASSE,$y->EncryptPass($_POST["tpass"])) ;
        }
        
      //  $filename="";
      //if(isset($_FILES['photo1']['tmp_name'])) {
      
      //  $filename = $_FILES['photo1']['tmp_name'];
    
     //}                             
          //$y->SetParam(GST_UTILISATEUR_PHOTO,$filename,true);     
        $y->Save();                                                                       
    
         
    
}


if(isset($_GET['id'])) {
/* Affichage d'un enregistrement */
      if($_SESSION['ipt_user_admin']!=1 && $_GET['id']!=$_SESSION['ipt_user_id']) { 
      
        header("Location: utilisateurs.php?id=".$_SESSION['ipt_user_id']);      
      
      }                                                               

    $y = new gstUtilisateur($active_db);
    $rs2 = $y->InfosUtilisateur($_GET['id'],true);
    $x = new iptWidget("../html/ecrans/gst_utilisateur_form.html",$rs2);    
    $my_html= $x->GetHTML();
        
            
   
 
} else {
 /* Liste des entregistrements */   

       if($_SESSION['ipt_user_admin']!=1 ) { 
      
          header("Location: utilisateurs.php?id=".$_SESSION['ipt_user_id']);      
      
      }                                                               


    $y = new gstUtilisateur($active_db);
    $rs2 = $y->ListeUtilisateurs();
    $x = new iptWidget("../html/ecrans/gst_utilisateur_list.html",$rs2);
    $my_html= $x->GetHTML();
    
}


include('../inc/admin_template.php');

?>