<?
 
  
//******************************************************************************
// STEP 1
// SET YOUR CONST VARS TO EASILY MANAGE YOUR UPDATES LATER
//******************************************************************************
  define("GST_HISTORIQUE_DB_VERSION",        '1.0.5');
  define("GST_HISTORIQUE_DB_TABLE",          'gst_historique');
  
  
  $id_const = 1000;
  define("GST_HISTORIQUE_ID",               $id_const++);
  define("GST_HISTORIQUE_DATE",             $id_const++);
  define("GST_HISTORIQUE_UTILISATEUR",      $id_const++);
  define("GST_HISTORIQUE_TABLE",            $id_const++); 
  define("GST_HISTORIQUE_ITEM_ID",            $id_const++); 
  define("GST_HISTORIQUE_ACTION",            $id_const++);
      
  define("GST_HISTORIQUE_URL",            $id_const++); 
  
  
             
//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class gstHistorique extends iptDbObject {

  var $hts_title   = "Historique";


  var $hts_db_table   = GST_HISTORIQUE_DB_TABLE;
  var $hts_db_version = GST_HISTORIQUE_DB_VERSION;

//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( GST_HISTORIQUE_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      GST_HISTORIQUE_DATE            => IPT_FIELD_TYPE_DATETIME,
                                      GST_HISTORIQUE_UTILISATEUR          => IPT_FIELD_TYPE_INT,
                                      GST_HISTORIQUE_TABLE          =>IPT_FIELD_TYPE_INT,
                                      GST_HISTORIQUE_URL          =>IPT_FIELD_TYPE_TEXT,
                                      GST_HISTORIQUE_ITEM_ID          =>IPT_FIELD_TYPE_INT,
                                      GST_HISTORIQUE_ACTION          =>IPT_FIELD_TYPE_INT);
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (GST_HISTORIQUE_ID            => 'id',
                                      GST_HISTORIQUE_DATE            => 'dinscrit',
                                      GST_HISTORIQUE_UTILISATEUR          => 'kgst_utilisateur',
                                      GST_HISTORIQUE_TABLE          =>'kgst_table',
                                      GST_HISTORIQUE_URL          =>'turl',
                                      GST_HISTORIQUE_ITEM_ID          =>'iparent_id',
                                      GST_HISTORIQUE_ACTION          =>'kgst_action');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       

  function Add($table_id,$item_id,$action) {
  
        //$x = new gstHistorique($this->hts_db);
        $this->LoadFromId(0);
        $this->SetParam(GST_HISTORIQUE_DATE,date('YmdHis'));
        $this->SetParam(GST_HISTORIQUE_TABLE,$table_id);
        $this->SetParam(GST_HISTORIQUE_ACTION,$action); 
        $this->SetParam(GST_HISTORIQUE_ITEM_ID,$item_id);
        $this->SetParam(GST_HISTORIQUE_UTILISATEUR,$_SESSION['ipt_user_id']);
        $this->SetParam(GST_HISTORIQUE_URL,$_SERVER['HTTP_REFERER']);
            
            
        $this->Save();

  }
  
  
  
    function ListeHistoriques($pUserId=0,$pLimit=25) {
     
     $req="SELECT gst_historique.iparent_id id, gst_historique.iparent_id, gst_historique.turl,
     
     concat(substring(gst_historique.dinscrit,7,2),'/',substring(gst_historique.dinscrit,5,2),'/',substring(gst_historique.dinscrit,1,4),' - ',substring(gst_historique.dinscrit,9,2),':',substring(gst_historique.dinscrit,11,2),':',substring(gst_historique.dinscrit,13,2)) temps, gst_utilisateur.tnomutilisateur utilisateur, gst_table.tnumero table_name,
CASE gst_historique.kgst_action
WHEN 1
THEN 'Ajouter'
WHEN 2
THEN 'Modification'
WHEN 3
THEN 'Suppression'
END AS
action
FROM gst_historique
LEFT OUTER JOIN gst_utilisateur ON gst_utilisateur.id = gst_historique.kgst_utilisateur
LEFT OUTER JOIN gst_table ON gst_table.id = gst_historique.kgst_table";

if(intval($pUserId)>0) {
     $req.=" where gst_historique.kgst_utilisateur=".intval($pUserId)." ";

}

$req.="
ORDER BY gst_historique.id desc limit ".intval($pLimit);
                         
  	          $rs = new iptDBQuery;
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }


 
 
  function InfosHistorique($pId,$pDefaultValues=true) {
               
        
              $pId= intval($pId);


              if($pId==0 && $pDefaultValues) {
               
                       $query="select 0 id, '' ttitre ";
               
              } else {
              
                $query="select * 
                           from gst_historique
                           where id=".intval($pId);

              }      			
           
              $rs = new iptDBQuery;
        				$rs->Open($query,$this->hts_db);
                           
              return $rs;

  
  }  
}



?>