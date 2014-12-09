<?


include('../inc/header.php');
include('../inc/admin_header.php');



if(!isset($_GET['parent'])) {
  $_GET['parent']=0;
}
     
     
if(isset($_GET['delete'])) {
      $rs2 = new iptDbUpdate();  
      $rs2->Begin("cms_photo","id",$_GET['delete'],$active_db);
      $rs2->Delete($_GET['delete']);
      
}

     
if(isset($_POST['id'])) {
/* Ajout d'un enregistrement */                                    
    
                                                           

                                          


      $rs2 = new iptDbUpdate();  
      $rs2->Begin("cms_photo","id",$_POST['id'],$active_db);
      
      $rs2->SetValue("ttitre",$_POST['ttitre'],IPT_FIELD_TYPE_TEXT);
      $rs2->SetValue("dinscrit",date('YmdHis'),IPT_FIELD_TYPE_TEXT);
      $rs2->SetValue("kcms_album",$_GET['id'],IPT_FIELD_TYPE_INT);
      
      if($_FILES['photo1']['tmp_name']!="") {
        $rs2->SetValue("tnom",$_FILES["photo1"]["name"],IPT_FIELD_TYPE_TEXT);
        $rs2->SetValue("zfichier",$_FILES['photo1']['tmp_name'],IPT_FIELD_TYPE_FILE);
      }
      $newid = $rs2->Update();
    //  die;
  //     print $newid;
  

              
}                                                    


if(isset($_GET['id'])) {
/* Affichage d'un enregistrement */

    $y = new cmsPhoto($active_db);
    $rs2 = $y->InfosPhoto($_GET['id']);
    $x = new iptWidget("../html/ecrans/cms_photo_form.html",$rs2);    
  

 
  
    $my_html= $x->GetHTML();
        
          
               
                   
   $y2 = new cmsAlbum($active_db);
    $rs3 =  $y2->ComboAlbums();
    $x2 = new iptWidget("../html/widgets/combo_cms_album.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
    $my_html = str_replace("[--combo_album--]",$my_cbo_entreprise,$my_html);
 
     
  
 
} else {
 /* Liste des entregistrements */   

header('Location: albums.php');    
}




include('../inc/admin_template.php');
include('../inc/footer.php');

?>