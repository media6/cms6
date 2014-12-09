<?

include('../inc/init.php');
include('../inc/admin_header.php');




if(!isset($_GET['parent'])) {
  $_GET['parent']=0;
}
     
   
if(isset($_FILES['photo1'])) {

                                        
      $y = new cmsPhoto($active_db);
      $y->LoadFromId(0);


      $rs2 = new iptDbUpdate();  
      $rs2->Begin("cms_photo","id",0,$active_db);
      $rs2->SetValue("tnom",$_FILES["photo1"]["name"],IPT_FIELD_TYPE_TEXT);
      
      $rs2->SetValue("dinscrit",date('YmdHis'),IPT_FIELD_TYPE_TEXT);
      $rs2->SetValue("kcms_album",$_GET['id'],IPT_FIELD_TYPE_INT);
      $rs2->SetValue("zfichier",$_FILES['photo1']['tmp_name'],IPT_FIELD_TYPE_FILE);

      $newid = $rs2->Update();
    
    
    
  
}
     
     
if(isset($_POST['id'])) {
/* Ajout d'un enregistrement */                                    
    
                                                                   
       $y = new cmsAlbum($active_db);
                                                          
       $y->LoadFromId(intval($_POST['id']));
       $y->SetParamsFromArray(array(  CMS_ALBUM_TITRE    => addslashes($_POST["ttitre"]),
                                      CMS_ALBUM_DATEINSCRIT   => $_POST["dinscrit"]));
        $y->Save();                                                                       
    
   
}


if(isset($_GET['id'])) {
/* Affichage d'un enregistrement */

    $y = new cmsAlbum($active_db);
    $rs2 = $y->InfosAlbum($_GET['id']);
    $x = new iptWidget("../html/ecrans/cms_album_form.html",$rs2);    
   
    $y3 = new cmsPhoto($active_db);
         
    $rs3 = $y3->ListePhotos($_GET['id']); 
    $x->ParseData("row2",$rs3);
        $x->ParseData("row3",$rs3);
   
    $my_html= $x->GetHTML();
        
                     
            
    $y2 = new cmsAlbum($active_db);
    $rs3 =  $y->ComboAlbums();
    $x2 = new iptWidget("../html/widgets/cms_album_combo.html",$rs3);
    $my_cbo_entreprise = $x2->GetHTML();
    $my_html = str_replace("[--combo_parent--]",$my_cbo_entreprise,$my_html);
    
    
    
   
 
} else {
 /* Liste des entregistrements */   

    $y = new cmsAlbum($active_db);
    $rs2 = $y->ListeAlbums();

    $x = new iptWidget("../html/ecrans/cms_album_list.html",$rs2);

           
    $rs3 = $y->InfosAlbum($_GET['parent']); 
    $x->ParseData("row2",$rs3);

   
    $my_html= $x->GetHTML();
    
}



include('../inc/admin_template.php');

?>