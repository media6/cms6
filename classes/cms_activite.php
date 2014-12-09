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
  define("CMS_ACTIVITE_DB_VERSION",        '1.0.2');
  define("CMS_ACTIVITE_DB_TABLE",          'cms_activite');
  
  define("CMS_ACTIVITE_ID",                  1000);
  define("CMS_ACTIVITE_DATE",              1001);
  define("CMS_ACTIVITE_TITRE",             1002);
  define("CMS_ACTIVITE_RESUME",             1003);
  define("CMS_ACTIVITE_CONTENU",            1004);
  define("CMS_ACTIVITE_FICHIER",            1005);
  define("CMS_ACTIVITE_URL",            1006);
  define("CMS_ACTIVITE_CATEGORIE",            1007);
  define("CMS_ACTIVITE_AUTEUR",            1008);
  define("CMS_ACTIVITE_SOURCE",            1009);
        
  define("CMS_ACTIVITE_ENTREPRISE",            1010);
  
  define("CMS_ACTIVITE_VILLE",            1011);
   define("CMS_ACTIVITE_SITE",            1013);
  define("CMS_ACTIVITE_LANGUE",            1014);
  define("CMS_ACTIVITE_TEXTECOMPLET",             1015);

//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class cmsActivite extends iptDbObject {

  var $hts_db_table   = CMS_ACTIVITE_DB_TABLE;
  var $hts_db_version = CMS_ACTIVITE_DB_VERSION;

//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( CMS_ACTIVITE_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      CMS_ACTIVITE_DATE            => IPT_FIELD_TYPE_DATE,
                                      CMS_ACTIVITE_TITRE            => IPT_FIELD_TYPE_TEXT,
                                      CMS_ACTIVITE_RESUME            => IPT_FIELD_TYPE_HTML,
                                      CMS_ACTIVITE_CONTENU           => IPT_FIELD_TYPE_INT,
                                      CMS_ACTIVITE_FICHIER          => IPT_FIELD_TYPE_FILE,
                                      CMS_ACTIVITE_URL => IPT_FIELD_TYPE_TEXT,
                                      CMS_ACTIVITE_CATEGORIE          => IPT_FIELD_TYPE_INT,
                                      CMS_ACTIVITE_AUTEUR => IPT_FIELD_TYPE_INT,
                                      CMS_ACTIVITE_ENTREPRISE   => IPT_FIELD_TYPE_INT,
                                      CMS_ACTIVITE_SOURCE => IPT_FIELD_TYPE_INT,
                                      CMS_ACTIVITE_LANGUE => IPT_FIELD_TYPE_INT,
                                      CMS_ACTIVITE_SITE => IPT_FIELD_TYPE_INT,
                                      CMS_ACTIVITE_TEXTECOMPLET => IPT_FIELD_TYPE_HTML,
                                      CMS_ACTIVITE_VILLE => IPT_FIELD_TYPE_INT);
                                      
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (CMS_ACTIVITE_ID            => 'id',
                                      CMS_ACTIVITE_DATE           => 'dinscrit',
                                      CMS_ACTIVITE_TITRE  => 'ttitre',
                                      CMS_ACTIVITE_RESUME            => 'tresume',
                                      CMS_ACTIVITE_CONTENU           => 'kcms_contenu',
                                      CMS_ACTIVITE_FICHIER          => 'zdata',
                                      CMS_ACTIVITE_URL => 'turl',
                                      CMS_ACTIVITE_CATEGORIE          => 'kcms_categorie',
                                      CMS_ACTIVITE_ENTREPRISE   => 'kgco_entreprise',
                                      CMS_ACTIVITE_AUTEUR => 'kgco_utilisateur',
                                      CMS_ACTIVITE_LANGUE => 'kcms_langue',
                                      CMS_ACTIVITE_SITE => 'kcms_site',
                                      CMS_ACTIVITE_TEXTECOMPLET => 'tcontenu',
                                      CMS_ACTIVITE_SOURCE => 'kcms_source',
                                      CMS_ACTIVITE_VILLE => 'kgco_ville');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       



  function ListeActivites($pLimit="",$pCategorie=0) {
     
  	                 
      				
      				 
              $req = "select cms_activite.id, cms_categorie.ttitre categorie, concat(substring(cms_activite.dinscrit,7,2),'/',substring(cms_activite.dinscrit,5,2),'/',substring(cms_activite.dinscrit,1,4)) dinscrit, 
                           cms_source.ttitre source,
                           substring(cms_activite.dinscrit,7,2) jour,
                           gco_entreprise.tnom entreprise,
                           case  
                            when substring(cms_activite.dinscrit,5,2)= '01' then 'JAN' 
                            when substring(cms_activite.dinscrit,5,2)= '02' then 'FÉV'
                            when substring(cms_activite.dinscrit,5,2)= '03' then 'MAR'
                            when substring(cms_activite.dinscrit,5,2)= '04' then 'AVR'
                            when substring(cms_activite.dinscrit,5,2)= '05' then 'MAI'
                            when substring(cms_activite.dinscrit,5,2)= '06' then 'JUN'
                            when substring(cms_activite.dinscrit,5,2)= '07' then 'JUL'
                            when substring(cms_activite.dinscrit,5,2)= '08' then 'AOÛ'
                            when substring(cms_activite.dinscrit,5,2)= '09' then 'SEP'
                            when substring(cms_activite.dinscrit,5,2)= '10' then 'OCT'
                            when substring(cms_activite.dinscrit,5,2)= '11' then 'NOV'
                            when substring(cms_activite.dinscrit,5,2)= '12' then 'DEC'
                            end
                             mois,
                           
                           cms_activite.*
          
                         from cms_activite
                          left outer join cms_categorie on cms_categorie.id=cms_activite.kcms_categorie
                           left outer join gco_entreprise on gco_entreprise.id=cms_activite.kgco_entreprise
                       left outer join cms_source on cms_source.id=cms_activite.kcms_source
                        
                        
                         ";
                
               $req .= "
                           order by cms_activite.dinscrit  asc, cms_activite.id asc
                         
                         ";
                         
                         
              if($pLimit!="") {
                   $req .=" limit ".$pLimit;                
              }          
        
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }



 
  function ListeActivitesVille($pLimit="",$pVille=0) {
     
  	                 
      				
      				 
              $req = "select cms_activite.id, cms_categorie.ttitre categorie, concat(substring(cms_activite.dinscrit,7,2),'/',substring(cms_activite.dinscrit,5,2),'/',substring(cms_activite.dinscrit,1,4)) dinscrit, 
                           cms_source.ttitre source,
                           substring(cms_activite.dinscrit,7,2) jour,  gco_entreprise.tnom entreprise,
                           case  
                            when substring(cms_activite.dinscrit,5,2)= '01' then 'JAN' 
                            when substring(cms_activite.dinscrit,5,2)= '02' then 'FÉV'
                            when substring(cms_activite.dinscrit,5,2)= '03' then 'MAR'
                            when substring(cms_activite.dinscrit,5,2)= '04' then 'AVR'
                            when substring(cms_activite.dinscrit,5,2)= '05' then 'MAI'
                            when substring(cms_activite.dinscrit,5,2)= '06' then 'JUN'
                            when substring(cms_activite.dinscrit,5,2)= '07' then 'JUL'
                            when substring(cms_activite.dinscrit,5,2)= '08' then 'AOÛ'
                            when substring(cms_activite.dinscrit,5,2)= '09' then 'SEP'
                            when substring(cms_activite.dinscrit,5,2)= '10' then 'OCT'
                            when substring(cms_activite.dinscrit,5,2)= '11' then 'NOV'
                            when substring(cms_activite.dinscrit,5,2)= '12' then 'DEC'
                            end
                             mois,
                           
                           cms_activite.*
          
                         from cms_activite
                          left outer join cms_categorie on cms_categorie.id=cms_activite.kcms_categorie
                               left outer join gco_entreprise on gco_entreprise.id=cms_activite.kgco_entreprise
                    left outer join cms_source on cms_source.id=cms_activite.kcms_source
                         ";
               
              if($pVille!=0) {
                   $req .=" where cms_activite.kgco_ville= ".intval($pVille)." ";                
              }   
                         
               $req .= "
                           order by cms_activite.dinscrit  asc, cms_activite.id asc
                         
                         ";
                         
                         
              if($pLimit!="") {
                   $req .=" limit ".$pLimit;                
              }          
        
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }





  function ListeActivitesCat($pLimit="") {
     
  	    
      				
      				 
              $req = "select cms_activite.id, 
              cms_categorie.ttitre categorie, 
              concat(substring(cms_activite.dinscrit,7,2),'/',substring(cms_activite.dinscrit,5,2),'/',substring(cms_activite.dinscrit,1,4)) dinscrit, 
                           cms_source.ttitre source,
                              cms_activite.ttitre, cms_activite.tresume,    gco_entreprise.tnom entreprise,
                              cms_activite.kcms_categorie
                         from cms_activite
                          left outer join cms_categorie on cms_categorie.id=cms_activite.kcms_categorie
                         left outer join cms_source on cms_source.id=cms_activite.kcms_source
                                    left outer join gco_entreprise on gco_entreprise.id=cms_activite.kgco_entreprise
               where cms_activite.id in (
                         select max(cms_activite.id)
          
                         from cms_categorie 
                   
                          left outer join cms_activite on cms_activite.kcms_categorie=cms_categorie.id
group by cms_categorie.id
                         )
                         ";
               
          
                         
               $req .= "
                           order by cms_activite.dinscrit  desc, cms_activite.id desc
                           
                           
                         
                         ";
                         
                         
              if($pLimit!="") {
                   $req .=" limit ".$pLimit;                
              }          
        
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }



  
 
  function InfosActivite($pId,$pDefaultValues=true,$pLangue=0) {
               
        
              $pId= intval($pId);


              if($pId==0 && $pDefaultValues) {
               
                       $query="select 0 id, 
                                    '' dinscrit,
                                        
                                      0 iordre,
                                      0 kcms_menu,
                                      0 kcms_contenu ";
               
              } else {
              
                $query="select  concat(substring(cms_activite.dinscrit,7,2),'/',substring(cms_activite.dinscrit,5,2),'/',substring(cms_activite.dinscrit,1,4)) dinscrit,
                             cms_categorie.ttitre categorie,
                             cms_source.ttitre source,
                             gco_ville.ttitre ville, gco_entreprise.tnom entreprise,
                            cms_activite.* 
                           from cms_activite
                           left outer join cms_categorie on cms_categorie.id=cms_activite.kcms_categorie
                           left outer join gco_ville on gco_ville.id=cms_activite.kgco_ville
                              left outer join gco_entreprise on gco_entreprise.id=cms_activite.kgco_entreprise
                    left outer join cms_source on cms_source.id=cms_activite.kcms_source
                           
                           where cms_activite.id=".intval($pId);

              }      			
           
              $rs = new iptDBQuery;
        				$rs->Open($query,$this->hts_db);
                           
              return $rs;

  
  }
  
  



  function TrouveActivites($pLimit="",$pCategorie=0,$pVille=0) {
     
  	                 
      				
      				 
              $req = "select cms_activite.id, cms_categorie.ttitre categorie, concat(substring(cms_activite.dinscrit,7,2),'/',substring(cms_activite.dinscrit,5,2),'/',substring(cms_activite.dinscrit,1,4)) dinscrit, 
                           cms_source.ttitre source,
                           substring(cms_activite.dinscrit,7,2) jour,
                           gco_entreprise.tnom entreprise,
                           case  
                            when substring(cms_activite.dinscrit,5,2)= '01' then 'JAN' 
                            when substring(cms_activite.dinscrit,5,2)= '02' then 'FÉV'
                            when substring(cms_activite.dinscrit,5,2)= '03' then 'MAR'
                            when substring(cms_activite.dinscrit,5,2)= '04' then 'AVR'
                            when substring(cms_activite.dinscrit,5,2)= '05' then 'MAI'
                            when substring(cms_activite.dinscrit,5,2)= '06' then 'JUN'
                            when substring(cms_activite.dinscrit,5,2)= '07' then 'JUL'
                            when substring(cms_activite.dinscrit,5,2)= '08' then 'AOÛ'
                            when substring(cms_activite.dinscrit,5,2)= '09' then 'SEP'
                            when substring(cms_activite.dinscrit,5,2)= '10' then 'OCT'
                            when substring(cms_activite.dinscrit,5,2)= '11' then 'NOV'
                            when substring(cms_activite.dinscrit,5,2)= '12' then 'DEC'
                            end
                             mois,
                           
                           cms_activite.*
          
                         from cms_activite
                          left outer join cms_categorie on cms_categorie.id=cms_activite.kcms_categorie
                           left outer join gco_entreprise on gco_entreprise.id=cms_activite.kgco_entreprise
                       left outer join cms_source on cms_source.id=cms_activite.kcms_source
                        where  cms_activite.dinscrit>='".date('Ymd')."'
                         
                         ";
               
              
                   $req .="  and (cms_activite.kcms_categorie= ".intval($pCategorie)." ";                
                   $req .=" or cms_activite.kgco_ville= ".intval($pVille).") ";                
               $req .= "
                           order by cms_activite.dinscrit  asc, cms_activite.id asc
                         
                         ";
                         
                         
              if($pLimit!="") {
                   $req .=" limit ".$pLimit;                
              }          
        
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
                         
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