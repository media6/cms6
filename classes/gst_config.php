<?

  
//******************************************************************************
// STEP 1
// SET YOUR CONST VARS TO EASILY MANAGE YOUR UPDATES LATER
//******************************************************************************
  define("GST_CONFIG_DB_VERSION",        '1.0.9');
  define("GST_CONFIG_DB_TABLE",          'gst_config');


  define("GST_CONFIG_ID",                1000);
  define("GST_CONFIG_TITRE",             1001);
  define("GST_CONFIG_VALEUR",             1002);
  define("GST_CONFIG_FICHIER",             1003);
  
 
 

if(!isset($_SESSION['ipt_user_id'])) { $_SESSION['ipt_user_id']=""; }
//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class gstConfig extends iptDbObject {

  var $hts_db_table   = GST_CONFIG_DB_TABLE;
  var $hts_db_version = GST_CONFIG_DB_VERSION;

  var $hts_action = null;
//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array (GST_CONFIG_ID             => IPT_FIELD_TYPE_AUTOID,
                                      GST_CONFIG_TITRE        => IPT_FIELD_TYPE_TEXT,
                                      GST_CONFIG_VALEUR        => IPT_FIELD_TYPE_TEXT,
                                      GST_CONFIG_FICHIER           => IPT_FIELD_TYPE_FILE);
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (GST_CONFIG_ID            => 'id',
                                      GST_CONFIG_TITRE        => 'ttitre',
                                      GST_CONFIG_VALEUR        => 'tvaleur',
                                      GST_CONFIG_FICHIER           => 'zdata');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       
 
  
  
  
  function ListeConfigs() {
  
        
  
  	          $rs = new iptDBQuery;
      				$rs->Open("select * 
                         from gst_config
                         order by ttitre ",$this->hts_db);
                         
      			        print   "select * 
                         from gst_config
                         order by ttitre ";
              return $rs;

  
  }
   
  
  


 
  function InfosConfig($pId) {
  
        
              $pId= intval($pId);


              if($pId==0) {
                       $query="select 0 id, 
                                      'nom' ttitre,
                                         'valeur' tvaleur ";
    
              } else {
         
                $query="select * 
                           from gst_config
                           where id=".intval($pId);
               
              }      			

    	        $rs = new iptDBQuery;
        				$rs->Open($query,$this->hts_db);
                           
              return $rs;

  
  }
      
  
  
  
 
  function GetValeur($pParam) {
  

         
         
                $query="select id,tvaleur 
                           from gst_config
                           where ttitre='".addslashes($pParam)."'";
               
                			

    	        $rs = new iptDBQuery;
        				$rs->Open($query,$this->hts_db);
                           
                           if($rs->RowCount()>0) {
                              return $rs->GetValue("tvaleur",0);             
                           } else {
                            $this->LoadFromId(0);
                            $this->SetParam(GST_CONFIG_TITRE,$pParam);
                            $this->Save();
                            return "";
                           }
              

  
  }
      
   
  
         
 
  function SetValeur($pTitre,$pParam) {
  
        
          
         
                $query="select id,tvaleur 
                           from gst_config
                           where ttitre='".addslashes($pTitre)."'";
               
                			

    	        $rs = new iptDBQuery;
        				$rs->Open($query,$this->hts_db);
                           
                           if($rs->RowCount()>0) {
                            $this->LoadFromId($rs->GetValue("id",0));
                            
                            } else {
                            $this->LoadFromId(0);
                            $this->SetParam(GST_CONFIG_TITRE,$pTitre);
                            
                           }
                            $this->SetParam(GST_CONFIG_VALEUR,$pParam);
                            $this->Save();
                            

  
  }
        
  
  function Event_Save_After($pId) {
       
       
        $y = new gstTable($this->hts_db);
        $table_id = $y->GetIdFromNo($this->hts_db_table);
        $x = new gstHistorique($this->hts_db);
        $x->Add($table_id,$pId,$this->hts_action);
  
  }
  
}


?>