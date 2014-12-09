<?
 
  
//******************************************************************************
// STEP 1
// SET YOUR CONST VARS TO EASILY MANAGE YOUR UPDATES LATER
//******************************************************************************
  define("GST_ACTION_DB_VERSION",        '1.0.2');
  define("GST_ACTION_DB_TABLE",          'gst_action');
  
  
  $id_const = 1000;
  define("GST_ACTION_ID",               $id_const++);
  define("GST_ACTION_TITRE",            $id_const++);
      
  
  
             
//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class gstAction extends iptDbObject {

  var $hts_title   = "Actions";


  var $hts_db_table   = GST_ACTION_DB_TABLE;
  var $hts_db_version = GST_ACTION_DB_VERSION;

//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( GST_ACTION_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      GST_ACTION_TITRE            => IPT_FIELD_TYPE_TEXT);
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (GST_ACTION_ID            => 'id',
                                      GST_ACTION_TITRE            => 'ttitre');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       


  
}



?>