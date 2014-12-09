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
  define("CMS_MENU_DB_VERSION",        '1.0.3');
  define("CMS_MENU_DB_TABLE",          'cms_menu');
  
  define("CMS_MENU_ID",                  1000);
  define("CMS_MENU_PARENT",              1001);
  define("CMS_MENU_SITE",              1007);
  define("CMS_MENU_TITRE",             1002);
  define("CMS_MENU_URL",         1003);
  define("CMS_MENU_CONTENU",            1004);
  define("CMS_MENU_ORDRE",            1005);
  define("CMS_MENU_LANGUE",            1006);
  
  


//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class cmsMenu extends iptDbObject {

  var $hts_db_table   = CMS_MENU_DB_TABLE;
  var $hts_db_version = CMS_MENU_DB_VERSION;

//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( CMS_MENU_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      CMS_MENU_PARENT            => IPT_FIELD_TYPE_INT,
                                      CMS_MENU_TITRE            => IPT_FIELD_TYPE_TEXT,
                                      CMS_MENU_URL        => IPT_FIELD_TYPE_TEXT,
                                      CMS_MENU_CONTENU           => IPT_FIELD_TYPE_INT,
                                      CMS_MENU_ORDRE           => IPT_FIELD_TYPE_INT,
                                      CMS_MENU_LANGUE           => IPT_FIELD_TYPE_INT,
                                      CMS_MENU_SITE           => IPT_FIELD_TYPE_INT);
                                      
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (CMS_MENU_ID            => 'id',
                                      CMS_MENU_PARENT           => 'kcms_menu',
                                      CMS_MENU_TITRE  => 'ttitre',
                                      CMS_MENU_URL   => 'turl',
                                      CMS_MENU_CONTENU           => 'kcms_contenu',
                                      CMS_MENU_ORDRE           => 'iordre',
                                      CMS_MENU_LANGUE           => 'kcms_langue',
                                      CMS_MENU_SITE           => 'kcms_site');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       



  function ListeMenus($pParentId,$pLangue=-1,$pSite=-1) {
     
  	    
      				
      				 
              $req = "select cms_menu.*
                         from cms_menu
                         where cms_menu.kcms_menu=".intval($pParentId)."";
              if(intval($pLangue)!=-1) {
                   $req .=" and cms_menu.kcms_langue = ".intval($pLangue);                
              }           
              if(intval($pSite)!=-1) {
                   $req .=" and cms_menu.kcms_site = ".intval($pSite);                
              }           
              
              $req .="
                         order by cms_menu.iordre ";
     
     
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }

  function GetItemLink($pRs,$pRow,$pUrl) {
  
    $url = "#";
    if($pRs->GetValue("turl",$pRow)!="") {
           $url = $pRs->GetValue("turl",$pRow);
    } else {
    
        if($pRs->GetValue("kcms_contenu",$pRow)>0) {
           $url = $pUrl.$pRs->GetValue("kcms_contenu",$pRow);
        }
    }               
    
    return $url;
  
  }
  
  
 
  function MenusHTML($pParentId,$pLangue=-1,$pSite=-1,$pContentUrl="page.php?id=") {
     
  	    
      				
      				 
              $req = "select cms_menu.*, (select count(c2.id) from cms_menu c2 where c2.kcms_menu=cms_menu.id) nb_sub
                         from cms_menu
                         where cms_menu.kcms_menu=".intval($pParentId)."";
                         
              if(intval($pLangue)!=-1) {
                   $req .=" and cms_menu.kcms_langue = ".intval($pLangue);                
              }           
              if(intval($pSite)!=-1) {
                   $req .=" and cms_menu.kcms_site = ".intval($pSite);                
              }           
              
              $req .="
                         order by cms_menu.iordre ";
     
     
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
      		     $html ="";
              for($i=0;$i<$rs->RowCount();$i++) {
                    $html=$html."<li>";
                    $html=$html."<a href=\"";
                    $html=$html.$this->GetItemLink($rs,$i,$pContentUrl);
                    $html=$html."\"";
                    if(substr($this->GetItemLink($rs,$i,$pContentUrl),0,7)=="http://" || substr($this->GetItemLink($rs,$i,$pContentUrl),0,8)=="https://" ) {
                      $html=$html." target=\"_blank\"";  
                    }
                    $html=$html.">";
                    $html=$html.$rs->GetValue("ttitre",$i);
                    $html=$html."</a>";
                    if($rs->GetValue("nb_sub",$i)>0) {
                      $html=$html."\n <ul>";
                      $html=$html.$this->MenusHTML($rs->GetValue("id",$i),$pLangue,$pSite,$pContentUrl);
                      $html=$html."\n</ul>";
                    }
              
                   $html=$html."</li>\n";
              
              }
              
              
                         
              return $html;

  
  }


  function ListeSousMenus($pParentId) {
     
  	    
      				
                $req = "select cms_menu.kcms_menu
                         from cms_menu
                         where cms_menu.kcms_contenu=".intval($pParentId)." order by kcms_menu desc";
             
                $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
      				
      
              $myid= $rs->GetValue('kcms_menu',0);           
                         
                         
                             				 
              $req = "select cms_menu.*
                         from cms_menu
                         where cms_menu.kcms_menu=".intval($myid)."";
              $req .="
                         order by cms_menu.iordre ";
     
            
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
                       
              return $rs;

  
  }



  function ComboMenus($pSite=0) {
  
  
  
  $req= "select 0 id, 'Menu principal' ttitre, null  iordre
                         union
                         select cms_menu.id, cms_menu.ttitre, cms_menu.iordre
                         from cms_menu ";
     if(intval($pSite)!=0) {
                 $req.=" where cms_menu.kcms_site=".intval($pSite)." ";
             }   
             
             $req.="
                         order by 3";
             
  	          $rs = new iptDBQuery;
      				$rs->Open($req,$this->hts_db);
             
              return $rs;

  
  }


 
 
  function InfosMenu($pId,$pDefaultValues=true,$pLangue=0,$pSite=0) {
               
        
              $pId= intval($pId);


              if($pId==0 && $pDefaultValues) {
               
                       $query="select 0 id, 
                                      '' turl, 'Menu principal' ttitre, 'Ajouter un élément au menu' tlabel, '' tlabel2,'' tlabel3, 
                                      ".intval($pLangue)." kcms_langue,
                                      ".intval($pSite)." kcms_site,  
                                      0 iordre,
                                      0 kcms_menu,
                                      0 kcms_contenu ";
               
              } else {
              
                $query="select * ,'Modifier' tlabel ,'Retour' tlabel2 ,'Ajouter un item au menu' tlabel3
                           from cms_menu
                           where id=".intval($pId);

              }      			
                 //print $query;
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