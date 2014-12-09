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
  define("CMS_ALBUM_DB_VERSION",        '1.0.0');
  define("CMS_ALBUM_DB_TABLE",          'cms_album');
  
  define("CMS_ALBUM_ID",                  1000);
  define("CMS_ALBUM_TITRE",             1002);
  define("CMS_ALBUM_DATEINSCRIT",            1003);
  
  


//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class cmsAlbum extends iptDbObject {

  var $hts_db_table   = CMS_ALBUM_DB_TABLE;
  var $hts_db_version = CMS_ALBUM_DB_VERSION;

//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( CMS_ALBUM_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      CMS_ALBUM_TITRE            => IPT_FIELD_TYPE_TEXT,
                                      CMS_ALBUM_DATEINSCRIT           => IPT_FIELD_TYPE_DATETIME);
                                      
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (CMS_ALBUM_ID            => 'id',
                                      CMS_ALBUM_TITRE  => 'ttitre',
                                      CMS_ALBUM_DATEINSCRIT           => 'dinscrit');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       



  function ListeAlbums() {
     
  	          $rs = new iptDBQuery;
      				$rs->Open("select cms_album.*
                         from cms_album
                         order by cms_album.dinscrit desc",$this->hts_db);
                         
              return $rs;

  
  }



  function ComboAlbums() {
  
  	          $rs = new iptDBQuery;
      				$rs->Open("select 0 id, 'Veuillez choisir un album' ttitre, ''  dinscrit
                         union
                         select cms_album.id, cms_album.ttitre, cms_album.dinscrit
                         from cms_album
                         order by 3 desc",$this->hts_db);
             
              return $rs;

  
  }


 
 
  function InfosAlbum($pId,$pDefaultValues=true) {
               
        
              $pId= intval($pId);


              if($pId==0 && $pDefaultValues) {
               
                       $query="select 0 id, 'Titre de l\'album' ttitre, ''  dinscrit ";
               
              } else {
              
                $query="select * 
                           from cms_album
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