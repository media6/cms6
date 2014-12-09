<?
/*
Usage example :
  $t= new swqUtilisateur($active_db);
  $t->CreerUtilisateur(1,'wz');
  */
  
  
  
//******************************************************************************
// STEP 1
// SET YOUR CONST VARS TO EASILY MANAGE YOUR UPDATES LATER
//******************************************************************************
  define("CMS_PHOTO_DB_VERSION",        '1.0.5');
  define("CMS_PHOTO_DB_TABLE",          'cms_photo');
  
  define("CMS_PHOTO_ID",                  1000);
  define("CMS_PHOTO_NOM",             1002);
  define("CMS_PHOTO_TITRE",             1006);
  define("CMS_PHOTO_DATE",            1003);
  define("CMS_PHOTO_FICHIER",            1004);
  define("CMS_PHOTO_ALBUM",            1005);
                         


//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class cmsPhoto extends iptDbObject {

  var $hts_db_table   = CMS_PHOTO_DB_TABLE;
  var $hts_db_version = CMS_PHOTO_DB_VERSION;

//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( CMS_PHOTO_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      CMS_PHOTO_NOM            => IPT_FIELD_TYPE_TEXT,
                                      CMS_PHOTO_TITRE           => IPT_FIELD_TYPE_TEXT,
                                      CMS_PHOTO_DATE           => IPT_FIELD_TYPE_DATETIME,
                                      CMS_PHOTO_FICHIER            => IPT_FIELD_TYPE_FILE,
                                      CMS_PHOTO_ALBUM       => IPT_FIELD_TYPE_INT);
                                      
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (CMS_PHOTO_ID            => 'id',
                                      CMS_PHOTO_NOM  => 'tnom',
                                      CMS_PHOTO_TITRE            => 'ttitre',
                                      CMS_PHOTO_DATE           => 'dinscrit',
                                      
                                      CMS_PHOTO_FICHIER => 'zfichier',
                                       CMS_PHOTO_ALBUM => 'kcms_album');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       



  function ListePhotos($pAlbum=0) {
     
     $req="select cms_photo.*
                         from cms_photo";
                         if ($pAlbum!=0) {
                         $req.=" where
                         kcms_album=".intval($pAlbum)."";
                         }
                         $req.="
                         order by cms_photo.id asc";
                         
  	          $rs = new iptDBQuery;
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }



 
 
  function InfosPhoto($pId,$pDefaultValues=true) {
               
        
              $pId= intval($pId);


              if($pId==0 && $pDefaultValues) {
               
                       $query="select 0 id, '' tnom, '' ttitre, ''  dinscrit,0 kcms_album ";
               
              } else {
              
                $query="select * 
                           from cms_photo
                           where id=".intval($pId);

              }      			
           
              $rs = new iptDBQuery;
        				$rs->Open($query,$this->hts_db);
                           
              return $rs;

  
  }
      
  
  function Event_Save_After($pId) {
       
       
        $y = new gstTable($this->hts_db);
        $table_id = $y->GetIdFromNo($this->hts_db_table);
        $x = new gstHistorique($this->hts_db);
        $x->Add($table_id,$pId,$this->hts_action);
  
  }
  
}



?>