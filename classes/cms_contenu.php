<?
/***
Description:   Permet de stocker des contenus au format HTML
***/

define("CMS_CONTENU_DB_VERSION",        '1.0.5');        //Doit etre incrementer lorsque la structure 
							 //de la base de donnees est modifiee

define("CMS_CONTENU_DB_TABLE",          'cms_contenu');  //Nom de la table de donnees

//Liste des champs de donnees
define("CMS_CONTENU_ID",                 1000);
define("CMS_CONTENU_TITRE",              1002);
define("CMS_CONTENU_CONTENU",            1004);
define("CMS_CONTENU_DATE_INSCRIT",        1003);
define("CMS_CONTENU_DATE_MODIF",        1008);
define("CMS_CONTENU_USER_INSCRIT",        1009);
define("CMS_CONTENU_USER_MODIF",        1010);
define("CMS_CONTENU_LANGUE",             1005);
define("CMS_CONTENU_SITE",               1006);
define("CMS_CONTENU_MENU",               1007);

class cmsContenu extends iptDbObject {

  var $hts_db_table   = CMS_CONTENU_DB_TABLE;
  var $hts_db_version = CMS_CONTENU_DB_VERSION;

  //Definition des types de champs de donnees
  var $hts_db_fieldstype =    array ( CMS_CONTENU_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      CMS_CONTENU_TITRE              => IPT_FIELD_TYPE_TEXT,
                                      CMS_CONTENU_CONTENU            => IPT_FIELD_TYPE_HTML,
                                      CMS_CONTENU_SITE               => IPT_FIELD_TYPE_INT,
                                      CMS_CONTENU_LANGUE             => IPT_FIELD_TYPE_INT,
                                      CMS_CONTENU_MENU               => IPT_FIELD_TYPE_INT,
                                      CMS_CONTENU_DATE_INSCRIT        => IPT_FIELD_TYPE_DATETIME,
                                      CMS_CONTENU_DATE_MODIF        => IPT_FIELD_TYPE_DATETIME,
                                      CMS_CONTENU_USER_INSCRIT        => IPT_FIELD_TYPE_INT,
                                      CMS_CONTENU_USER_MODIF        => IPT_FIELD_TYPE_INT);

  //Nom des champs de donnees (via la table de donnees)
  var $hts_db_params =         array (CMS_CONTENU_ID                 => 'id',
                                      CMS_CONTENU_TITRE  	     => 'ttitre',
                                      CMS_CONTENU_CONTENU	     => 'tcontenu',
                                      CMS_CONTENU_SITE               => 'kcms_site',
                                      CMS_CONTENU_LANGUE             => 'kcms_langue',
                                      CMS_CONTENU_MENU        	     => 'kcms_menu',
                                      CMS_CONTENU_DATE_INSCRIT        => 'dinscrit',
                                      CMS_CONTENU_DATE_MODIF        => 'dmodif',
                                      CMS_CONTENU_USER_INSCRIT        => 'kgst_utilisateur_inscrit',
                                      CMS_CONTENU_USER_MODIF        => 'kgst_utilisateur_modif');

  function ListeContenus() {

	$rs = new iptDBQuery;
	$rs->Open("select cms_contenu.*, cms_site.ttitre site, cms_langue.ttitre langue , gst_utilisateur.tnomutilisateur
                   from cms_contenu
                   left outer join cms_langue on cms_langue.id=cms_contenu.kcms_langue
                   left outer join cms_site on cms_site.id=cms_contenu.kcms_site
                   left outer join gst_utilisateur on gst_utilisateur.id=cms_contenu.kgst_utilisateur_modif
                   order by cms_site.ttitre, cms_langue.ttitre, cms_contenu.ttitre asc
                   ",$this->hts_db);
        return $rs;

  }



  function ComboContenus($pSite=0) {

	$rs = new iptDBQuery;
      	
        
        $req="select 0 id, '' ttitre, ''  dinscrit
                   union
                   select cms_contenu.id, cms_contenu.ttitre, cms_contenu.dinscrit
                   from cms_contenu  ";
             if(intval($pSite)!=0) {
                 $req.=" where cms_contenu.kcms_site=".intval($pSite)." ";
             }      
            $req .= "
                   order by 3 desc";
                   
                   $rs->Open($req,$this->hts_db);
        return $rs;

  }


  function InfosContenu($pId,$pDefaultValues=true) {

	$pId= intval($pId);
        if($pId==0 && $pDefaultValues) {

	        $query="select 0 id, 'Titre' ttitre, ''  dinscrit, '' tcontenu, 0 as kcms_langue, 0 as kcms_site ";

        } else {

                $query="select cms_contenu.*
                        from cms_contenu
                        where id=".intval($pId);

        }

        $rs = new iptDBQuery;
	$rs->Open($query,$this->hts_db);
        return $rs;
  }
  
  
  
  
  
  
  
  function Event_Save_Before($pId) {
         

       
       if($this->GetParam(CMS_CONTENU_DATE_INSCRIT)=="") {
            $this->SetParam(CMS_CONTENU_DATE_INSCRIT,date('YmdHis'));
                $this->SetParam(CMS_CONTENU_USER_INSCRIT,$_SESSION['ipt_user_id']);
            
       }
       $this->SetParam(CMS_CONTENU_USER_MODIF,$_SESSION['ipt_user_id']);
       $this->SetParam(CMS_CONTENU_DATE_MODIF,date('YmdHis'));
      
     if(intval($pId)==0) {
      $this->hts_action = 1;
     } else {
      $this->hts_action = 2;
     }
  
  }
  
  
   
   
  
  function Event_Save_After($pId) {
       
       
        $y = new gstTable($this->hts_db);
        $table_id = $y->GetIdFromNo($this->hts_db_table);
        $x = new gstHistorique($this->hts_db);
        $x->Add($table_id,$pId,$this->hts_action);
        
  
  
  }
     

}



?>
