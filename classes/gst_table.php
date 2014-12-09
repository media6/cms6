<?
/*
Usage example :
  $t= new swqUtilisateur($active_db);
  $t->CreerUtilisateur(1,'wz');

Comment créer une nouvelle classe:
1- remplacer le mot GCO_CONTACT par votre nouveau nom d'objet
2- remplacer le mot gco_envoie par le nom de la table
2- remplacer le mot gcoContact par le nom de la classe

*/
  
  
  
//******************************************************************************
// STEP 1
// SET YOUR CONST VARS TO EASILY MANAGE YOUR UPDATES LATER
//******************************************************************************
  define("GST_TABLE_DB_VERSION",        '1.0.1');
  define("GST_TABLE_DB_TABLE",          'gst_table');
  
  
  $id_const = 1000;
  define("GST_TABLE_ID",              $id_const++);
  define("GST_TABLE_NUMERO",             $id_const++);
  define("GST_TABLE_TITRE",             $id_const++);
  define("GST_TABLE_LINK",             $id_const++);
    
  
  
             
//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class gstTable extends iptDbObject {

  var $hts_title   = "Tables";


  var $hts_db_table   = GST_TABLE_DB_TABLE;
  var $hts_db_version = GST_TABLE_DB_VERSION;

//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( GST_TABLE_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      GST_TABLE_TITRE            => IPT_FIELD_TYPE_TEXT,
                                      GST_TABLE_NUMERO          => IPT_FIELD_TYPE_TEXT,
                                      GST_TABLE_LINK          =>IPT_FIELD_TYPE_TEXT);
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (GST_TABLE_ID            => 'id',
                                      GST_TABLE_TITRE            => 'ttitre',
                                      GST_TABLE_NUMERO          => 'tnumero',
                                      GST_TABLE_LINK          =>'tlink');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       


    function GetIdFromNo($pTable) {
    
           $id=0;
                $query = "select id from gst_table where tnumero='".addslashes($pTable)."'";
                  $rs = new iptDBQuery;
        				$rs->Open($query,$this->hts_db);
                         
               if($rs->RowCount()==1) {          
                         
                         $id = $rs->GetValue('id',0);
                } else {
                    $this->LoadFromId(0);
                    $this->SetParam(GST_TABLE_NUMERO,addslashes($pTable));
                    $id = $this->Save();
                
                }
                           
              return $id;
    }

  
}



?>