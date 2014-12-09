<?
 
  
//******************************************************************************
// STEP 1
// SET YOUR CONST VARS TO EASILY MANAGE YOUR UPDATES LATER
//******************************************************************************
  define("CMS_SITE_DB_VERSION",        '1.0.0');
  define("CMS_SITE_DB_TABLE",          'cms_site');
  
  
  $id_const = 1000;
  define("CMS_SITE_ID",               $id_const++);
  define("CMS_SITE_TITRE",            $id_const++);
      
  
  
             
//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class cmsSite extends iptDbObject {

  var $hts_title   = "Sites";


  var $hts_db_table   = CMS_SITE_DB_TABLE;
  var $hts_db_version = CMS_SITE_DB_VERSION;

//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( CMS_SITE_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      CMS_SITE_TITRE            => IPT_FIELD_TYPE_TEXT);
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (CMS_SITE_ID            => 'id',
                                      CMS_SITE_TITRE            => 'ttitre');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       

  

  function ListeSites() {
     
     $req="select cms_site.*
                         from cms_site";
                         $req.="
                         order by cms_site.ttitre asc";
                         
  	          $rs = new iptDBQuery;
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }

 
  function ComboSites() {
     
     $req="select 0 id,'Veuillez choisir un site' tnom union 
      select cms_site.id, cms_site.ttitre tnom
                         from cms_site";
                         $req.="
                         order by 1";
                         
  	          $rs = new iptDBQuery;
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }




 
 
  function InfosSite($pId,$pDefaultValues=true) {
               
        
              $pId= intval($pId);


              if($pId==0 && $pDefaultValues) {
               
                       $query="select 0 id, '' ttitre ";
               
              } else {
              
                $query="select * 
                           from cms_site
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