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
  define("CMS_LANGUE_DB_VERSION",        '1.0.0');
  define("CMS_LANGUE_DB_TABLE",          'cms_langue');
  
  define("CMS_LANGUE_ID",                  1000);
  define("CMS_LANGUE_TITRE",             1002);
  define("CMS_LANGUE_DATEINSCRIT",            1003);
  
  


//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class cmsLangue extends iptDbObject {

  var $hts_db_table   = CMS_LANGUE_DB_TABLE;
  var $hts_db_version = CMS_LANGUE_DB_VERSION;

//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( CMS_LANGUE_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      CMS_LANGUE_TITRE            => IPT_FIELD_TYPE_TEXT,
                                      CMS_LANGUE_DATEINSCRIT           => IPT_FIELD_TYPE_DATETIME);
                                      
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (CMS_LANGUE_ID            => 'id',
                                      CMS_LANGUE_TITRE  => 'ttitre',
                                      CMS_LANGUE_DATEINSCRIT           => 'dinscrit');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       



  function ListeLangues() {
     
  	          $rs = new iptDBQuery;
      				$rs->Open("select cms_langue.*
                         from cms_langue
                         order by cms_langue.dinscrit desc",$this->hts_db);
                         
              return $rs;

  
  }



  function ComboLangues() {
  
  	          $rs = new iptDBQuery;
      				$rs->Open("select 0 id, 'Veuillez choisir une langue' ttitre, ''  dinscrit
                         union
                         select cms_langue.id, cms_langue.ttitre, cms_langue.dinscrit
                         from cms_langue
                         order by 3 desc",$this->hts_db);
             
              return $rs;

  
  }


 
 
  function InfosLangue($pId,$pDefaultValues=true) {
               
        
              $pId= intval($pId);


              if($pId==0 && $pDefaultValues) {
               
                       $query="select 0 id, 'Langue' ttitre, ''  dinscrit ";
               
              } else {
              
                $query="select * 
                           from cms_langue
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