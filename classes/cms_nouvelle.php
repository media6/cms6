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
  define("CMS_NOUVELLE_DB_VERSION",        '1.0.11');
  define("CMS_NOUVELLE_DB_TABLE",          'cms_nouvelle');
  
  define("CMS_NOUVELLE_ID",                  1000);
  define("CMS_NOUVELLE_DATEINSCRIT",              1001);
  
  define("CMS_NOUVELLE_TITRE",             1002);
  define("CMS_NOUVELLE_RESUME",             1003);
  define("CMS_NOUVELLE_CONTENU",            1004);
  define("CMS_NOUVELLE_FICHIER",            1005);
  define("CMS_NOUVELLE_URL",            1006);
  define("CMS_NOUVELLE_CATEGORIE",            1007);
  define("CMS_NOUVELLE_AUTEUR",            1008);
  define("CMS_NOUVELLE_SOURCE",            1009);
  
  
  define("CMS_NOUVELLE_VILLE",            1011);
    define("CMS_NOUVELLE_INACTIF",            1012);
  
  define("CMS_NOUVELLE_SITE",            1013);
  define("CMS_NOUVELLE_LANGUE",            1014);
  define("CMS_NOUVELLE_TEXTECOMPLET",             1015);
  define("CMS_NOUVELLE_DATE",              1016);
  define("CMS_NOUVELLE_DATE_DEBUT",              1017);
  define("CMS_NOUVELLE_DATE_FIN",              1018);
  
//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class cmsNouvelle extends iptDbObject {

  var $hts_db_table   = CMS_NOUVELLE_DB_TABLE;
  var $hts_db_version = CMS_NOUVELLE_DB_VERSION;

//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array ( CMS_NOUVELLE_ID                 => IPT_FIELD_TYPE_AUTOID,
                                      CMS_NOUVELLE_DATEINSCRIT            => IPT_FIELD_TYPE_DATETIME,
                                      CMS_NOUVELLE_DATE     => IPT_FIELD_TYPE_DATE,
                                      CMS_NOUVELLE_TITRE            => IPT_FIELD_TYPE_TEXT,
                                      CMS_NOUVELLE_RESUME            => IPT_FIELD_TYPE_HTML,
                                      CMS_NOUVELLE_TEXTECOMPLET            => IPT_FIELD_TYPE_HTML,
                                      CMS_NOUVELLE_CONTENU           => IPT_FIELD_TYPE_INT,
                                      CMS_NOUVELLE_FICHIER          => IPT_FIELD_TYPE_FILE,
                                      CMS_NOUVELLE_URL => IPT_FIELD_TYPE_TEXT,
                                      CMS_NOUVELLE_CATEGORIE          => IPT_FIELD_TYPE_INT,
                                      CMS_NOUVELLE_AUTEUR => IPT_FIELD_TYPE_INT,
                                      CMS_NOUVELLE_SOURCE => IPT_FIELD_TYPE_INT,
                                      CMS_NOUVELLE_LANGUE => IPT_FIELD_TYPE_INT,
                                      CMS_NOUVELLE_SITE => IPT_FIELD_TYPE_INT,
                                                                            CMS_NOUVELLE_INACTIF   => IPT_FIELD_TYPE_INT,
                                      CMS_NOUVELLE_VILLE => IPT_FIELD_TYPE_INT,
                                      CMS_NOUVELLE_DATE_DEBUT     => IPT_FIELD_TYPE_DATE,
                                       CMS_NOUVELLE_DATE_FIN     => IPT_FIELD_TYPE_DATE);
                                      
                                      
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (CMS_NOUVELLE_ID            => 'id',
                                      CMS_NOUVELLE_DATEINSCRIT           => 'dinscrit',
                                      CMS_NOUVELLE_DATE           => 'daffichage',
                                      CMS_NOUVELLE_TITRE  => 'ttitre',
                                      CMS_NOUVELLE_RESUME            => 'tresume',
                                      CMS_NOUVELLE_TEXTECOMPLET   => 'tcontenu',
                                      CMS_NOUVELLE_CONTENU           => 'kcms_contenu',
                                      CMS_NOUVELLE_FICHIER          => 'zdata',
                                      CMS_NOUVELLE_URL => 'turl',  
                                      CMS_NOUVELLE_LANGUE          => 'kcms_langue',
                                      CMS_NOUVELLE_SITE          => 'kcms_site',
                                      CMS_NOUVELLE_CATEGORIE          => 'kcms_categorie',
                                      CMS_NOUVELLE_AUTEUR => 'kgco_utilisateur',
                                      CMS_NOUVELLE_SOURCE => 'kcms_source',
                                      CMS_NOUVELLE_INACTIF   => 'binactif',
                                      CMS_NOUVELLE_VILLE => 'kgco_ville',
                                      CMS_NOUVELLE_DATE_DEBUT     => 'ddebut',
                                       CMS_NOUVELLE_DATE_FIN     => 'dfin');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       

                

  function ListeNouvellesVille($pLimit="",$pVille=0,$pSource=0) {
     
  	    
      				
      				 
              $req = "select cms_nouvelle.id, cms_categorie.ttitre categorie, concat(substring(cms_nouvelle.dinscrit,7,2),'/',substring(cms_nouvelle.dinscrit,5,2),'/',substring(cms_nouvelle.dinscrit,1,4)) dinscrit, 
                             concat(substring(cms_nouvelle.dinscrit,9,2),':',substring(cms_nouvelle.dinscrit,11,2)) hinscrit,   cms_source.ttitre source,
                                                                                   concat(substring(cms_nouvelle.daffichage,7,2),'/',substring(cms_nouvelle.daffichage,5,2),'/',substring(cms_nouvelle.daffichage,1,4)) daffichage,
                           cms_nouvelle.* ,
                           concat(gco_utilisateur.tprenom,' ',gco_utilisateur.tnom) auteur
          
                         from cms_nouvelle
                          left outer join cms_categorie on cms_categorie.id=cms_nouvelle.kcms_categorie
                         left outer join cms_source on cms_source.id=cms_nouvelle.kcms_source
                           left outer join gco_utilisateur on gco_utilisateur.id=cms_nouvelle.kgco_utilisateur
                           
                               where cms_nouvelle.binactif=0
                          ";
               
              if($pVille!=0) {
                   $req .="  and cms_nouvelle.kgco_ville= ".intval($pVille)." ";                
              }   
                
              if($pSource!=0) {
                   $req .="  and cms_nouvelle.kcms_source= ".intval($pSource)." ";                
              }                   
               $req .= "
                           order by cms_nouvelle.dinscrit  desc, cms_nouvelle.id desc
                         
                         ";
                         
                         
              if($pLimit!="") {
                   $req .=" limit ".$pLimit;                
              }          
              
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
            
              return $rs;

  
  }




  function ListeNouvelles($pLimit="",$pCategorie=0,$pOnlySorted=false,$pSource=0) {
     
  	    
      				
      				 
              $req = "select cms_nouvelle.id, cms_categorie.ttitre categorie, 
              concat(substring(cms_nouvelle.dinscrit,7,2),'/',substring(cms_nouvelle.dinscrit,5,2),'/',substring(cms_nouvelle.dinscrit,1,4)) dinscrit,
              concat(substring(cms_nouvelle.daffichage,7,2),'/',substring(cms_nouvelle.daffichage,5,2),'/',substring(cms_nouvelle.daffichage,1,4)) daffichage, 
                             cms_source.ttitre source,
                           gco_ville.ttitre ville,
                           case when   substring(cms_nouvelle.dinscrit,9,2) ='' then   'red'
                           else 
                           
                             case when length(cms_nouvelle.zdata)=0 then  'red' 
                             else 
                             
                              case when length(cms_nouvelle.kgco_ville)=0 then  'red' 
                              else 
                              
                                case when length(cms_nouvelle.kcms_categorie)=0 then  'red' 
                                else 'black'   
                                end
                                                               
                              end
                               
                             end 
                           end 
                            vcolor,
                           
                           cms_nouvelle.ttitre,cms_nouvelle.tresume,cms_nouvelle.dinscrit,
                           concat(gco_utilisateur.tprenom,' ',gco_utilisateur.tnom) auteur ,
                           cms_nouvelle.kcms_site,cms_nouvelle.kcms_langue  ,cms_nouvelle.tcontenu,
                           cms_site.ttitre site, cms_langue.ttitre langue
          
                         from cms_nouvelle
                                left outer join gco_ville on gco_ville.id=cms_nouvelle.kgco_ville
                                  left outer join cms_categorie on cms_categorie.id=cms_nouvelle.kcms_categorie
                              left outer join gco_utilisateur on gco_utilisateur.id=cms_nouvelle.kgco_utilisateur
                              left outer join cms_site on cms_site.id=cms_nouvelle.kcms_site
                              left outer join cms_langue on cms_langue.id=cms_nouvelle.kcms_langue
                              
                     left outer join cms_source on cms_source.id=cms_nouvelle.kcms_source
                            where cms_nouvelle.binactif=0
                              ";
               
               if($pOnlySorted) {
                   $req .=" and cms_nouvelle.kcms_categorie>0 and cms_nouvelle.kgco_ville>0 ";                
              }   
                
                  if($pSource!=0) {
                   $req .="  and cms_nouvelle.kcms_source= ".intval($pSource)." ";                
              }    
                    if($pCategorie!=0) {
                   $req .=" and cms_nouvelle.kcms_categorie= ".intval($pCategorie)." ";                
              }   
                         
               $req .= "
                           order by cms_nouvelle.daffichage  desc, cms_nouvelle.id desc
                         
                         ";
                         
                         
              if($pLimit!="") {
                   $req .=" limit ".$pLimit;                
              }          
                
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }

                       

  function ListeUrgences($k_site=0) {
     
  	    
      				
      				 
              $req = "select cms_nouvelle.id, cms_categorie.ttitre categorie, 
              concat(substring(cms_nouvelle.dinscrit,7,2),'/',substring(cms_nouvelle.dinscrit,5,2),'/',substring(cms_nouvelle.dinscrit,1,4)) dinscrit,
              concat(substring(cms_nouvelle.daffichage,7,2),'/',substring(cms_nouvelle.daffichage,5,2),'/',substring(cms_nouvelle.daffichage,1,4)) daffichage, 
                             cms_source.ttitre source,
                           gco_ville.ttitre ville,
                           case when   substring(cms_nouvelle.dinscrit,9,2) ='' then   'red'
                           else 
                           
                             case when length(cms_nouvelle.zdata)=0 then  'red' 
                             else 
                             
                              case when length(cms_nouvelle.kgco_ville)=0 then  'red' 
                              else 
                              
                                case when length(cms_nouvelle.kcms_categorie)=0 then  'red' 
                                else 'black'   
                                end
                                                               
                              end
                               
                             end 
                           end 
                            vcolor,
                           
                           cms_nouvelle.ttitre,cms_nouvelle.tresume,cms_nouvelle.dinscrit,
                           concat(gco_utilisateur.tprenom,' ',gco_utilisateur.tnom) auteur ,
                           cms_nouvelle.kcms_site,cms_nouvelle.kcms_langue  ,cms_nouvelle.tcontenu,
                           cms_site.ttitre site, cms_langue.ttitre langue
          
                         from cms_nouvelle
                                left outer join gco_ville on gco_ville.id=cms_nouvelle.kgco_ville
                                  left outer join cms_categorie on cms_categorie.id=cms_nouvelle.kcms_categorie
                              left outer join gco_utilisateur on gco_utilisateur.id=cms_nouvelle.kgco_utilisateur
                              left outer join cms_site on cms_site.id=cms_nouvelle.kcms_site
                              left outer join cms_langue on cms_langue.id=cms_nouvelle.kcms_langue
                              
                     left outer join cms_source on cms_source.id=cms_nouvelle.kcms_source
                            where cms_nouvelle.binactif=0 and cms_nouvelle.ddebut>='".date('Ymd')."'
                            and cms_nouvelle.dfin<='".date('Ymd')."'
                            and cms_site.id=".intval($k_site)."
                              ";
             
               $req .= "
                           order by cms_nouvelle.daffichage  desc, cms_nouvelle.id desc
                         
                         ";
                         
           
                
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }



  function ListeEditos($pLimit="") {
     
  	    
      				
      				 
              $req = "select cms_nouvelle.id, cms_categorie.ttitre categorie, concat(substring(cms_nouvelle.dinscrit,7,2),'/',substring(cms_nouvelle.dinscrit,5,2),'/',substring(cms_nouvelle.dinscrit,1,4)) dinscrit, 
                            concat(substring(cms_nouvelle.dinscrit,9,2),':',substring(cms_nouvelle.dinscrit,11,2)) hinscrit,    cms_source.ttitre source,
                           gco_ville.ttitre ville,
                           case when   substring(cms_nouvelle.dinscrit,9,2) ='' then   'red'
                           else 
                           
                             case when length(cms_nouvelle.zdata)=0 then  'red' 
                             else 
                             
                              case when length(cms_nouvelle.kgco_ville)=0 then  'red' 
                              else 
                              
                                case when length(cms_nouvelle.kcms_categorie)=0 then  'red' 
                                else 'black'   
                                end
                                                               
                              end
                               
                             end 
                           end 
                            vcolor,
                           
                           cms_nouvelle.* ,
                           concat(gco_utilisateur.tprenom,' ',gco_utilisateur.tnom) auteur
          
                         from cms_nouvelle
                                left outer join gco_ville on gco_ville.id=cms_nouvelle.kgco_ville
                                  left outer join cms_categorie on cms_categorie.id=cms_nouvelle.kcms_categorie
                              left outer join gco_utilisateur on gco_utilisateur.id=cms_nouvelle.kgco_utilisateur
                     left outer join cms_source on cms_source.id=cms_nouvelle.kcms_source
                            where cms_nouvelle.binactif=0
                                                                           and cms_nouvelle.kcms_source=0
                           order by cms_nouvelle.dinscrit  desc, cms_nouvelle.id desc
                         
                         ";
                         
                         
              if($pLimit!="") {
                   $req .=" limit ".$pLimit;                
              }          
         
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }



  function ListeNouvellesCat($pLimit="") {
     
  	    
      				
      				 
              $req = "select cms_nouvelle.id, 
              cms_categorie.ttitre categorie, 
              concat(substring(cms_nouvelle.dinscrit,7,2),'/',substring(cms_nouvelle.dinscrit,5,2),'/',substring(cms_nouvelle.dinscrit,1,4)) dinscrit, 
                            concat(substring(cms_nouvelle.dinscrit,9,2),':',substring(cms_nouvelle.dinscrit,11,2)) hinscrit,    cms_source.ttitre source,
                              cms_nouvelle.ttitre, cms_nouvelle.tresume,
                              cms_nouvelle.kcms_categorie
                         from cms_nouvelle
                          left outer join cms_categorie on cms_categorie.id=cms_nouvelle.kcms_categorie
                         left outer join cms_source on cms_source.id=cms_nouvelle.kcms_source
                         where cms_nouvelle.id in (
                         select max(cms_nouvelle.id)
          
                         from  vw_manchettes
                          

                          left outer join cms_nouvelle on cms_nouvelle.kcms_categorie=vw_manchettes.kcms_categorie and cms_nouvelle.dinscrit= vw_manchettes.dmax
                          where cms_nouvelle.binactif=0 
group by vw_manchettes.kcms_categorie
                         )
                         ";
               
          
                         
               $req .= "   and   cms_categorie.ispecial=0
                           order by cms_nouvelle.dinscrit  desc, cms_nouvelle.id desc
                           
                           
                         
                         ";
                         
                         
              if($pLimit!="") {
                   $req .=" limit ".$pLimit;                
              }          
        
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }



 
  function ListeNouvellesSrc($pLimit="") {
     
  	    
      				
      				 
              $req = "select cms_nouvelle.id, 
              cms_source.ttitre source, 
              concat(substring(cms_nouvelle.dinscrit,7,2),'/',substring(cms_nouvelle.dinscrit,5,2),'/',substring(cms_nouvelle.dinscrit,1,4)) dinscrit, 
                              concat(substring(cms_nouvelle.dinscrit,9,2),':',substring(cms_nouvelle.dinscrit,11,2)) hinscrit,  cms_source.ttitre source,
                              cms_nouvelle.ttitre, cms_nouvelle.tresume,
                              cms_nouvelle.kcms_categorie,
                              cms_nouvelle.kcms_source
                         from cms_nouvelle
                          left outer join cms_categorie on cms_categorie.id=cms_nouvelle.kcms_categorie
                         left outer join cms_source on cms_source.id=cms_nouvelle.kcms_source
                         where length(cms_nouvelle.zdata)>0 and 
                           cms_nouvelle.kcms_categorie>0 and 
                          cms_nouvelle.id in (
                         select max(cms_nouvelle.id)
          
                         from cms_source 

                          left outer join cms_nouvelle on cms_nouvelle.kcms_source=cms_source.id
                          where cms_nouvelle.binactif=0 
group by cms_source.id
                         )
                         ";
               
          
                         
               $req .= "
                           order by cms_nouvelle.dinscrit  desc, cms_nouvelle.id desc
                           
                           
                         
                         ";
                         
                         
              if($pLimit!="") {
                   $req .=" limit ".$pLimit;                
              }          
        
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }
 
 
  function ListeNouvellesAuteur($pLimit="") {
     
  	    
      				
      				 
              $req = "select cms_nouvelle.id, 
              concat(gco_utilisateur.tprenom,' ',gco_utilisateur.tnom) auteur, 
              concat(substring(cms_nouvelle.dinscrit,7,2),'/',substring(cms_nouvelle.dinscrit,5,2),'/',substring(cms_nouvelle.dinscrit,1,4)) dinscrit, 
                                                      concat(substring(cms_nouvelle.dinscrit,9,2),':',substring(cms_nouvelle.dinscrit,11,2)) hinscrit,
                              cms_nouvelle.ttitre, cms_nouvelle.tresume,
                              cms_nouvelle.kcms_categorie,
                              cms_nouvelle.kgco_utilisateur
                         from cms_nouvelle
                          left outer join cms_categorie on cms_categorie.id=cms_nouvelle.kcms_categorie
                         left outer join gco_utilisateur on gco_utilisateur.id=cms_nouvelle.kgco_utilisateur
                         where cms_nouvelle.id in (
                         select max(cms_nouvelle.id)
          
                         from gco_utilisateur    g1
                          left outer join cms_nouvelle on cms_nouvelle.kgco_utilisateur=g1.id
                          where cms_nouvelle.kcms_source=0   and cms_nouvelle.binactif=0 
group by g1.id
                         )
                         ";
               
          
                         
               $req .= "
                           order by cms_nouvelle.dinscrit  desc, cms_nouvelle.id desc
                           
                           
                         
                         ";
                         
                         
              if($pLimit!="") {
                   $req .=" limit ".$pLimit;                
              }          
        
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }
 
 
 
 
  function ListeNouvellesMois($pLimit="") {
     
  	    
      				
      				 
              $req = "select  cms_nouvelle.id, 
              substring(cms_nouvelle.dinscrit,1,6) mois,
              count(cms_nouvelle.id) nb_nouvelle
 
                         from cms_nouvelle
                          left outer join cms_categorie on cms_categorie.id=cms_nouvelle.kcms_categorie
                         left outer join cms_source on cms_source.id=cms_nouvelle.kcms_source
                        where cms_nouvelle.binactif=0  
                         group by substring(cms_nouvelle.dinscrit,1,6)
                         
                         
                         ";
               
          
                         
               $req .= "
                           order by 2 desc
                           
                           
                         
                         ";
                         
                         
              if($pLimit!="") {
                   $req .=" limit ".$pLimit;                
              }          
        
  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
                         
              return $rs;

  
  }
  
  
  function CheckIfUrlExist($pUrl) {
  		 
              $req = "select  count(cms_nouvelle.id) nb
                         from cms_nouvelle
                         where cms_nouvelle.turl='".addslashes($pUrl)."'
                              
                         
                         ";

  	          $rs = new iptDBQuery;
      				
      				$rs->Open($req,$this->hts_db);
              if($rs->GetValue("nb",0)>0) {
                return true;
              } else {
                return false;
              }          
              

  }
  
  
  
  function InfosNouvelle($pId,$pDefaultValues=true,$pLangue=0) {
               
        
              $pId= intval($pId);


              if($pId==0 && $pDefaultValues) {
               
                       $query="select 0 id, 
                                    '' dinscrit,
                                       '' tcontenu,
                                       0 kcms_site,
                                       0 kcms_langue,
                                      '' tresume,
                                         '' ttitre,
                                      '".date('d/m/Y')."' daffichage, 
                                      0 iordre,
                                      0 kcms_menu,
                                      0 kcms_contenu ";
                
              } else {
              
                $query="select  concat(substring(cms_nouvelle.dinscrit,7,2),'/',substring(cms_nouvelle.dinscrit,5,2),'/',substring(cms_nouvelle.dinscrit,1,4)) dinscrit,
                 concat(substring(cms_nouvelle.dinscrit,9,2),':',substring(cms_nouvelle.dinscrit,11,2)) hinscrit,
                                                                       concat(substring(cms_nouvelle.daffichage,7,2),'/',substring(cms_nouvelle.daffichage,5,2),'/',substring(cms_nouvelle.daffichage,1,4)) daffichage,
                                    concat(substring(cms_nouvelle.ddebut,7,2),'/',substring(cms_nouvelle.ddebut,5,2),'/',substring(cms_nouvelle.ddebut,1,4)) ddebut,
                                    concat(substring(cms_nouvelle.dfin,7,2),'/',substring(cms_nouvelle.dfin,5,2),'/',substring(cms_nouvelle.dfin,1,4)) dfin,
                             cms_categorie.ttitre categorie,
                             cms_categorie.ispecial,
                             cms_source.ttitre source,
                             gco_ville.ttitre ville,
                            cms_nouvelle.*,
                                      concat(gco_utilisateur.tprenom,' ',gco_utilisateur.tnom) auteur
           
                           from cms_nouvelle
                                          left outer join gco_ville on gco_ville.id=cms_nouvelle.kgco_ville
                left outer join cms_categorie on cms_categorie.id=cms_nouvelle.kcms_categorie
                           left outer join cms_source on cms_source.id=cms_nouvelle.kcms_source
                                left outer join gco_utilisateur on gco_utilisateur.id=cms_nouvelle.kgco_utilisateur
                         
                           where cms_nouvelle.id=".intval($pId);

              }      			
           
              $rs = new iptDBQuery;
        				$rs->Open($query,$this->hts_db);
                           
              return $rs;

  
  }
      
      
  function ParseFromTCMedia($site="http://www.lautrevoix.com",$source,$site_id="174",$page="1") {
  
      $x = new iptParser();
              
      $x->Open($site."/?contextId=0&searchQueryString=&search_sortedBy=publicationDate%20DESC&controllerName=search&siteId=".$site_id."&searchInString=&searchTypesString=&search_start_date=&search_end_date=&action=put&facetName=content&facetValue=article&facetCaption=Article&searchCurrentPage=".$page);
      $my_html =$x->GetContent();
       //print $my_html;
      $pos1 = strpos($my_html,"highlight teaser tpl-1",0)+24;
      $table = explode("<article",substr($my_html,$pos1));
      for($i=1;$i<=10;$i++) {
                $titre="";
                $url="";
                $thumb="";
                $resume ="";
           
                $quand ="";  
                
                
                
               $content = $table[$i];
               $pos1 = strpos($content,"title=")+7;
               $pos2 = strpos($content,"\"",$pos1);
               print "\nFound a #".$i." news<br>\n";
               print "TITRE=".substr($content,$pos1,($pos2-$pos1))."<br>\n";
               $titre   =substr($content,$pos1,($pos2-$pos1));
               
               $pos1 = strpos($content,"href=",$pos2)+7;
               $pos2 = strpos($content,"\"",$pos1);
                print "URL=".$site."/".substr($content,$pos1,($pos2-$pos1))."<br>\n";
                $url  =$site."/".substr($content,$pos1,($pos2-$pos1));
                                 
      
               
               $pos1 = strpos($content,"src=",$pos2)+5;
               $pos2 = strpos($content,"\"",$pos1);
                  $thumb =    $site."/".substr($content,$pos1,($pos2-$pos1));
               print "<img src=\"".$thumb."\">";
             
                $thumb= str_replace("/thumb-","/",$thumb);
                $thumb= str_replace("-vignette.",".",$thumb);
              
              print "IMG=".$thumb."<br>\n";
                
                
                
        
               $pos1 = strpos($content,"p class=",$pos2)+9;
               $pos2 = strpos($content,"span",$pos1)+16;
               $pos3 = strpos($content,"<",$pos2);
               print "DATE=".substr($content,$pos2,($pos3-$pos2))."<br>\n";
                  
                  
                   $quand = substr($content,$pos2,($pos3-$pos2));
                   $quand = str_replace("janvier","/01/",$quand);
                   $quand = str_replace("février","/02/",$quand);
                   $quand = str_replace("mars","/03/",$quand);
                   $quand = str_replace("avril","/04/",$quand);
                   $quand = str_replace("mai","/05/",$quand);
                   $quand = str_replace("juin","/06/",$quand);
                   $quand = str_replace("juillet","/07/",$quand);
                   $quand = str_replace("août","/08/",$quand);
                   $quand = str_replace("septembre","/09/",$quand);
                   $quand = str_replace("octobre","/10/",$quand);
                   $quand = str_replace("novembre","/11/",$quand); 
                   $quand = str_replace("décembre","/12/",$quand);
                   $quand = str_replace(" ","",$quand);
                   
                   
                  print "DATE2=".$quand."<br>\n";
               
                  $quand = substr($quand,6,4).substr($quand,3,2).substr($quand,0,2);
                  
                  print "DATE3  =".$quand."<br>\n";
                 
                 
        
                
                               $new = new cmsNouvelle($this->hts_db);
                       if(!$new->CheckIfUrlExist($url)) {         
                 
                 
                 
                
                 $x2 = new iptParser();
                  $x2->Open($url);
                 $my_html =$x2->GetContent(); 
     
                 $pos1 = strpos($my_html,"content=",0)+9;
                 $pos2 = strpos($my_html,"\"",$pos1);
                  $resume  =substr($my_html,$pos1,($pos2-$pos1));
                   print "RESUME=".$resume."<br>\n";
             
 
                       unlink("/home/mplus/www/www.infocharlevoix.com/cms/tmp/thumb.jpg");
                $img = new iptImageSize();
                
                
                     $img->IPT_IS_ResizePicture(str_replace(" ","%20",$thumb), "/home/mplus/www/www.infocharlevoix.com/cms/tmp/thumb.jpg", 350, 281, 100);

                
 
                       
                              print "<b>this news WILL be added!</b><br><br>\n\n\n";
                                            
                       
                       $src = new cmsSource($this->hts_db);
                       $id_src=0;
                       $id_src= $src->GetSourceFromTitle($source);
                       if($id_src==0) {
                       
                               $src->LoadFromId(0);
                               $src->SetParam(CMS_SOURCE_TITRE,$source);
                               $id_src = $src->Save();   
                       }
                       
                       
                       
                       
                       
                       
                               $new->LoadFromId(0);
                               $new->SetParam(CMS_ACTIVITE_TITRE,$titre);
                               $new->SetParam(CMS_ACTIVITE_RESUME,$resume);
                               $new->SetParam(CMS_ACTIVITE_DATE,$quand.date('Hi'));
                               $new->SetParam(CMS_ACTIVITE_URL,$url);
                               $new->SetParam(CMS_ACTIVITE_SOURCE,$id_src);
                               if($thumb!="" && file_exists("/home/mplus/www/www.infocharlevoix.com/cms/tmp/thumb.jpg")) {
                                     $new->SetParam(CMS_ACTIVITE_FICHIER,"/home/mplus/www/www.infocharlevoix.com/cms/tmp/thumb.jpg",true);
                              }
                              $new->Save();             
                                        
                       }      else {
                       
                            print "this news won't be added!<br><br>\n\n\n";
                       }        
                
            
                
                     
      }
      
      
        //http://www.lautrevoix.com/?controllerName=search&contextId=0
  
  }    

  function ParseFromGoogle($keyword) {
                  
      $x = new iptParser();
      
      //https://www.google.ca/search?q=charlevoix&tbm=nws&source=lnms&tbas=0&tbs=sbd:1,nsd:1,qdr:d#q=charlevoix&tbas=0&tbm=nws&tbs=sbd:1,qdr:d
         $keyword=urlencode($keyword);
        
        //https://www.google.ca/search?q=charlevoix&num=20&tbm=nws&source=lnt&tbs=sbd:1&sa=X&ei=VFFIU4y5HLOK2QXc6oDgAw&ved=0CCMQpwUoAQ&biw=1288&bih=705&dpr=1.3
      //          https://www.google.ca/search?q=charlevoix&tbm=nws&source=lnms&tbas=0&tbm=nws&tbs=sbd:1,qdr:d#q=charlevoix&tbm=nws&tbs=sbd:1,qdr:m
      $myurl="https://www.google.ca/search?q=".$keyword."&num=20&tbm=nws&source=lnt&tbs=sbd:1&sa=X&ei=VFFIU4y5HLOK2QXc6oDgAw&ved=0CCMQpwUoAQ&biw=1288&bih=705&dpr=1.3";
      print $myurl;
      $x->Open($myurl,false);
      $my_html =$x->GetContent();
      //$my_html ="aaaaaaaaatsw news-media-strip-and-explore-in-depth-container".$my_html;
          $pos1 = strpos($my_html,"<tbody>",0)+7;
         $my_html  =substr($my_html,$pos1);   
         
    //   print $my_html;                                                                       
      $table = explode("tsw news-media-strip-and-explore-in-depth-container",$my_html);
                     //        news-thumbnail-container
                     
       
                       print "<br><div style=\"clear:both\">\n";
                            
                     
                     print "NBBBB=".count($table);
             
                       print "<br><div style=\"clear:both\">\n";
        if(count($table)==1) {
        
          $this->GoogleParse2($my_html);
        } else {              
                     
      for($i=1;$i<count($table);$i++) {
      
      
      
                $titre="";
                $url="";
                $thumb="";
                $resume ="";
                $source="";
                $quand ="";
               $content = $table[$i];
               $pos1 = strpos($content,"href=")+6;
               $pos2 = strpos($content,"\"",$pos1);
               
               if(substr($content,$pos1,1)=="h") {
               
                       print "\nFound a #".$i." news at:<br>\n";
                       print "URL=".substr($content,$pos1,($pos2-$pos1))."<br>\n";
                       
                        $url = substr($content,$pos1,($pos2-$pos1));
                        $pos0 = strpos($content,"esc-thumbnail");
                          
                       $pos1 = strpos($content,"src=\"",$pos0)+5;
                       $pos2 = strpos($content,"\"",$pos1);
                        
                        
                         if(substr($content,$pos1,3)=="htt") {
                         
                        //    print "THUMBNAIL=".substr($content,$pos1,($pos2-$pos1))."<br>\n";
                          //   print "<img src=\"".substr($content,$pos1,($pos2-$pos1))."\"><div style=\"clear:both\"></div>\n";
                              $thumb = substr($content,$pos1,($pos2-$pos1));
                     
                          
                          } else {
                            //    print "NO THUMBNAIL<br>\n";
                          
                               $thumb = "";
                     
                          }
                          
                       
                            
                       $pos1 = strpos($content,"<a class=\"l _Kc\" ",0)+17;
                       $pos2 = strpos($content,">",$pos1)+1;
                       $pos3 = strpos($content,"</a>",$pos2);
                       
                       
                                   
                    print "TITRE=".substr($content,$pos2,($pos3-$pos2))."<br>\n";
                         
                         
                         
                            $titre = substr($content,$pos2,($pos3-$pos2));
                          
                            $titre = str_replace("<em>","",$titre);
                     
                                   $titre = str_replace("</em>","",$titre);
                         
                                                 
                       $pos1 = strpos($content,"<span class=\"news-source _sK\">",0)+30;
                       $pos2 = strpos($content,"</span>",$pos1);
                    
                       
                         $source = substr($content,$pos1,($pos2-$pos1));
                     
                         
                    print "SOURCE=".substr($content,$pos1,($pos2-$pos1))."<br>\n";
                                         
                       $pos1 = strpos($content,"<span class=\"f nsa news-source-timestamp\">",0)+42;
                       $pos2 = strpos($content,"</span>",$pos1);
                         $quand = substr($content,$pos1,($pos2-$pos1));
                     
                   print "QUAND=".substr($content,$pos1,($pos2-$pos1))."<br>\n";
                        
                                       
                       $pos1 = strpos($content,"<div class=\"_uz st\">",0)+20;
                       $pos2 = strpos($content,"</div>",$pos1);
                         $resume = substr($content,$pos1,($pos2-$pos1));
                        $resume = str_replace("<em>","",$resume);
                     
                                   $resume = str_replace("</em>","",$resume);
                              
                 print "RESUME=".substr($content,$pos1,($pos2-$pos1))."<br>\n";
                        
                           /*                      
                  
                       
                     print "<code>\n";
                       print $content;
                       print "\n</code>\n";
                       */
              
                       print "<br><div style=\"clear:both\">\n";
                      
                       $new = new cmsNouvelle($this->hts_db);
                       if(!$new->CheckIfUrlExist($url)) {
                       
                              print "<b>this news WILL be added!</b><br><br>\n\n\n";
                                            
                       
                       $src = new cmsSource($this->hts_db);
                       $id_src=0;
                       $id_src= $src->GetSourceFromTitle($source);
                       if($id_src==0) {
                       
                               $src->LoadFromId(0);
                               $src->SetParam(CMS_SOURCE_TITRE,$source);
                               $id_src = $src->Save();   
                       }
                       
                          if($id_src!=19) {
                          
                      
                              
                                
                          
                          
                               $new->LoadFromId(0);
                               $new->SetParam(CMS_ACTIVITE_TITRE,$titre);
                               $new->SetParam(CMS_ACTIVITE_RESUME,$resume);
                               $new->SetParam(CMS_ACTIVITE_DATE,date('YmdHi'));
                               $new->SetParam(CMS_ACTIVITE_URL,$url);
                               $new->SetParam(CMS_ACTIVITE_SOURCE,$id_src);
                               if($thumb!="") {
                                                unlink("/home/mplus/www/www.infocharlevoix.com/cms/tmp/thumb.jpg");
                                    $img = new iptImageSize();
                                    
                                  
                                       $img->IPT_IS_ResizePicture(str_replace(" ","%20",$thumb), "/home/mplus/www/www.infocharlevoix.com/cms/tmp/thumb.jpg", 350, 281, 100);
                                      if( file_exists("/home/mplus/www/www.infocharlevoix.com/cms/tmp/thumb.jpg")) {
                                             $new->SetParam(CMS_NOUVELLE_FICHIER,"/home/mplus/www/www.infocharlevoix.com/cms/tmp/thumb.jpg",true);
                                      }
                              }
                              
                            
                              $new->Save();             
                           }             
                       }      else {
                       
                            print "this news won't be added!<br><br>\n\n\n";
                       }
              
              
              
              
              
              
               } else {
               /*
                      print "\nERRRRRRRRRRRROR Found a #".$i." news at:<br>\n";
                      print substr($content,$pos1,($pos2-$pos1));
                        print "<code>\n";
                       print $content;
                       print "\n</code>\n";  
                  */    
               }
                                      
      }
    }  
      /*
      
      
      
<table class="news-story-section ts news-main-story-table" id="esc-story-cluster-id-43982723368424">
	<tbody>
		<tr>
			<td class="news-main-story-table-cell">
				<div class="top news-thumbnail news-thumbnail-large">
					<div>
            <a class="news-thumbnail-link" href="http://fr.canoe.ca/infos/quebeccanada/politiqueprovinciale/archives/2014/04/20140410-202129.html"
             onmousedown="return rwt(this,'','','','1','AFQjCNGL2mQvsUSQABIYd8o9gKy9XG5Kag','','0CCoQpwIwAA','','',event)">
              <div class="news-thumbnail-container-large">
                <img class="th news-thumbnail-image news-thumbnail-image-large" 
                id="esc-thumbnail-43982723368424" 
                src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcS7LTZCizFFY4bO7wHXAt-Q8Ky0qyWbc2b-WMfzRZYrHqHJW3NidWY2fUwI4rmLh5orZqMlwrMQ" alt="">
              </div>
              <div class="f news-thumbnail-description news-thumbnail-description-large">Canoë</div>
            </a>
          </div>
        </div>
        
        
        
        
        <div class="news-lead-article-and-snippet">
                  <h3>
                    <h3 class="r" style="white-space:normal">
                      <a class="l _Kc" href="http://journalmetro.com/dossiers/elections-quebec-2014/478553/stephane-bedard-devient-le-chef-du-pq/" onmousedown="return rwt(this,'','','','1','AFQjCNH72oXMzGpMk0ISatCBeqLyMTXnSQ','','0CCsQqQIoADAA','','',event)">
                        Stéphane Bédard devient le chef du PQ
                      </a>
                    </h3>
                  </h3>
                  <div class="slp">
                    <span class="news-source _sK">Métro Montréal</span>
                    <span class="news-hyphen">-</span><span class="f nsa news-source-timestamp">il y a 2 heures</span>
                    </div>
                    <div class="_uz st">Rappelons que la chef péquiste, défaite dans sa circonscription de <em>Charlevoix</em>-Côte-de-Beaupré, n&#39;est plus députée et qu&#39;elle a annoncé sa démission comme&nbsp;...</div>
                    
            </div>
            
            
            <div><div class="news-extension-container" id="esc-extension-43982723368424"><div></div>
            </div></div><div class="tsw news-media-strip-and-explore-in-depth-container"></div></td></tr></tbody></table></li>
            <li class="g small" diversity="0" id="esc-story-cluster-id-43982722926055" secondary="0">
            <table class="news-story-section ts news-main-story-table" id="esc-story-cluster-id-43982722926055"><tbody><tr>
            <td class="news-main-story-table-cell"><div class="top news-thumbnail news-thumbnail-large">
            <div><a class="news-thumbnail-link" href="http://www.quebecspot.com/2014/04/anne-des-vingt-jours-en-salle-le-9-mai-10042014/" onmousedown="return rwt(this,'','','','2','AFQjCNFc0FocAoxrdLZhTQwsiLkpUzQStg','','0CC0QpwIwAQ','','',event)">
            
            
            
            
            
            <div class="news-thumbnail-container-large">
            <img class="th news-thumbnail-image news-thumbnail-image-large" id="esc-thumbnail-43982722926055" src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcQ-nJI3mEzQ-wZirPmNS06sN8oiPcQadxH3uNjU_G-p-z0jd-P4uhD8hkqEKNKXbPptvXW4UjRf" alt=""></div><div class="f news-thumbnail-description news-thumbnail-description-large"></div></a></div></div>
            
            
            <div class="news-lead-article-and-snippet"><h3><h3 class="r" style="white-space:normal"><a class="l _Kc" href="http://www.quebecspot.com/2014/04/anne-des-vingt-jours-en-salle-le-9-mai-10042014/" onmousedown="return rwt(this,'','','','2','AFQjCNFc0FocAoxrdLZhTQwsiLkpUzQStg','','0CC4QqQIoADAB','','',event)">Anne des vingt jours : En salle le 9 mai</a></h3></h3><div class="slp"><span class="news-source _sK">QuébecSpot Média</span><span class="news-hyphen">-</span><span class="f nsa news-source-timestamp">il y a 7 heures</span></div><div class="_uz st">Une auberge dans <em>Charlevoix</em>. Michel Langlois y travaille comme serveur. La poétesse Anne Hébert vient y séjourner trois semaines. Au fil de ces vingt jours,&nbsp;...</div></div><div><div class="news-extension-container" id="esc-extension-43982722926055"><div></div></div></div><div class="tsw news-media-strip-and-explore-in-depth-container"></div></td></tr></tbody></table></li><li class="g small" diversity="0" id="esc-story-cluster-id-43982723368424" secondary="0"><table class="news-story-section ts news-main-story-table" id="esc-story-cluster-id-43982723368424"><tbody><tr><td class="news-main-story-table-cell"><div class="top news-thumbnail news-thumbnail-large"><div><a class="news-thumbnail-link" href="http://fr.canoe.ca/infos/quebeccanada/politiqueprovinciale/archives/2014/04/20140410-202129.html" onmousedown="return rwt(this,'','','','3','AFQjCNGL2mQvsUSQABIYd8o9gKy9XG5Kag','','0CDAQpwIwAg','','',event)"><div class="news-thumbnail-container-large"><img class="th news-thumbnail-image news-thumbnail-image-large" id="esc-thumbnail-43982723368424" src="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcS7LTZCizFFY4bO7wHXAt-Q8Ky0qyWbc2b-WMfzRZYrHqHJW3NidWY2fUwI4rmLh5orZqMlwrMQ" alt=""></div><div class="f news-thumbnail-description news-thumbnail-description-large">Canoë</div></a></div></div><div class="news-lead-article-and-snippet"><h3><h3 class="r" style="white-space:normal"><a class="l _Kc" href="http://gatineau.rougefm.ca/info-rougefm/blogentry.aspx?BlogEntryID=10665089" onmousedown="return rwt(this,'','','','3','AFQjCNEZ6Yx4CAE79sU9ueBzyW2X3pWo6Q','','0CDEQqQIoADAC','','',event)">Stéphane Bédard devient chef intérimaire du Parti Québécois</a></h3></h3><div class="slp"><span class="news-source _sK">94,9 Rouge fm</span><span class="news-hyphen">-</span><span class="f nsa news-source-timestamp">il y a 7 heures</span></div><div class="_uz st">La première ministre Pauline Marois a quitté ses fonctions �  la suite de sa défaite dans <em>Charlevoix</em> lundi dernier. M. Bédard a précisé ses priorités.</div></div><div><div class="news-extension-container" id="esc-extension-43982723368424"><div></div></div></div><div class="tsw news-media-strip-and-explore-in-depth-container"></div></td></tr></tbody></table></li><li class="g small" diversity="0" id="esc-story-cluster-id-1480767164839792169" secondary="0"><table class="news-story-section ts news-main-story-table" id="esc-story-cluster-id-1480767164839792169"><tbody><tr><td class="news-main-story-table-cell"><div class="top news-thumbnail news-thumbnail-large"><div><a class="news-thumbnail-link" href="http://www.ledevoir.com/politique/quebec/405305/caroline-simard-au-devoir-elle-a-fait-tomber-marois" onmousedown="return rwt(this,'','','','4','AFQjCNHkuaBrbo_LTwoNUV3sW8Ojt-i6lw','','0CDMQpwIwAw','','',event)"><div class="news-thumbnail-container-large"><img class="th news-thumbnail-image late-tbn news-thumbnail-image-large" id="esc-thumbnail-1480767164839792169" 
            imgsrc="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcTZ6NNo7YCtmQEjJr_eOIsNApW1B3CQX_vf4lOm0aUlazshcbnUi41DjCh5dV4zYp85Tp1wvOo" alt=""></div><div class="f news-thumbnail-description news-thumbnail-description-large"></div></a></div></div><div class="news-lead-article-and-snippet"><h3><h3 class="r" style="white-space:normal"><a class="l _Kc" href="http://www.ledevoir.com/politique/quebec/405305/caroline-simard-au-devoir-elle-a-fait-tomber-marois" onmousedown="return rwt(this,'','','','4','AFQjCNHkuaBrbo_LTwoNUV3sW8Ojt-i6lw','','0CDQQqQIoADAD','','',event)">Elle a fait tomber Marois</a></h3></h3><div class="slp"><span class="news-source _sK">Le Devoir (Abonnement)</span><span class="news-hyphen">-</span><span class="f nsa news-source-timestamp">il y a 11 heures</span></div><div class="_uz st">La candidate libérale qui a défait Pauline Marois lundi soir dans la circonscription de <em>Charlevoix</em>–Côte-de-Beaupré ne semble pas être le simple « poteau » que&nbsp;...</div></div><div><div class="news-extension-container" id="esc-extension-1480767164839792169"><div></div></div></div><div class="tsw news-media-strip-and-explore-in-depth-container"></div></td></tr></tbody></table></li><li class="g small" diversity="0" id="esc-story-cluster-id-43982723368424" secondary="0"><table class="news-story-section ts news-main-story-table" id="esc-story-cluster-id-43982723368424"><tbody><tr><td class="news-main-story-table-cell"><div class="top news-thumbnail news-thumbnail-large"><div><a class="news-thumbnail-link" href="http://fr.canoe.ca/infos/quebeccanada/politiqueprovinciale/archives/2014/04/20140410-202129.html" onmousedown="return rwt(this,'','','','5','AFQjCNGL2mQvsUSQABIYd8o9gKy9XG5Kag','','0CDYQpwIwBA','','',event)"><div class="news-thumbnail-container-large"><img class="th news-thumbnail-image late-tbn news-thumbnail-image-large" id="esc-thumbnail-43982723368424" imgsrc="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcS7LTZCizFFY4bO7wHXAt-Q8Ky0qyWbc2b-WMfzRZYrHqHJW3NidWY2fUwI4rmLh5orZqMlwrMQ" alt=""></div><div class="f news-thumbnail-description news-thumbnail-description-large">Canoë</div></a></div></div><div class="news-lead-article-and-snippet"><h3><h3 class="r" style="white-space:normal"><a class="l _Kc" href="http://www.985fm.ca/national/nouvelles/stephane-bedard-est-elu-a-l-unanimite-chef-interim-312187.html" onmousedown="return rwt(this,'','','','5','AFQjCNGA9_wRfZvmazKttiRvs12ueaPVHA','','0CDcQqQIoADAE','','',event)">Stéphane Bédard est élu �  l&#39;unanimité chef intérimaire du Parti <em>...</em></a></h3></h3><div class="slp"><span class="news-source _sK">98,5 fm</span><span class="news-hyphen">-</span><span class="f nsa news-source-timestamp">il y a 13 heures</span></div><div class="_uz st">Rappelons que la chef péquiste, défaite dans sa circonscription de <em>Charlevoix</em>-Côte-de-Beaupré, n&#39;est plus députée et qu&#39;elle a annoncé sa démission comme&nbsp;...</div></div><div><div class="news-extension-container" id="esc-extension-43982723368424"><div></div></div></div><div class="tsw news-media-strip-and-explore-in-depth-container"></div></td></tr></tbody></table></li><li class="g small" diversity="0" id="esc-story-cluster-id-43982723368424" secondary="0"><table class="news-story-section ts news-main-story-table" id="esc-story-cluster-id-43982723368424"><tbody><tr><td class="news-main-story-table-cell"><div class="top news-thumbnail news-thumbnail-large"><div><a class="news-thumbnail-link" href="http://fr.canoe.ca/infos/quebeccanada/politiqueprovinciale/archives/2014/04/20140410-202129.html" onmousedown="return rwt(this,'','','','6','AFQjCNGL2mQvsUSQABIYd8o9gKy9XG5Kag','','0CDkQpwIwBQ','','',event)"><div class="news-thumbnail-container-large"><img class="th news-thumbnail-image late-tbn news-thumbnail-image-large" id="esc-thumbnail-43982723368424" imgsrc="https://encrypted-tbn2.gstatic.com/images?q=tbn:ANd9GcS7LTZCizFFY4bO7wHXAt-Q8Ky0qyWbc2b-WMfzRZYrHqHJW3NidWY2fUwI4rmLh5orZqMlwrMQ" alt=""></div><div class="f news-thumbnail-description news-thumbnail-description-large">Canoë</div></a></div></div><div class="news-lead-article-and-snippet"><h3><h3 class="r" style="white-space:normal"><a class="l _Kc" href="http://www.lapresse.ca/actualites/politique/politique-quebecoise/201404/10/01-4756502-elu-chef-interimaire-du-pq-bedard-promet-de-changer-de-ton.php" onmousedown="return rwt(this,'','','','6','AFQjCNGzcSz3HbYKFPYFsilkOLtFZDJP3A','','0CDoQqQIoADAF','','',event)">Élu chef intérimaire du PQ, Bédard promet de changer de ton</a></h3></h3><div class="slp"><span class="news-source _sK">LaPresse.ca</span><span class="news-hyphen">-</span><span class="f nsa news-source-timestamp">il y a 14 heures</span></div><div class="_uz st">Elle ne pouvait toutefois pas participer au caucus, car elle a perdu son siège de <em>Charlevoix</em>-Cote-de-Beaupré. Comme leader parlementaire, M. Bédard avait la&nbsp;...</div></div><div><div class="news-extension-container" id="esc-extension-43982723368424"><div></div></div></div><div class="tsw news-media-strip-and-explore-in-depth-container"></div></td></tr></tbody></table></li><li class="g small" diversity="0" id="esc-story-cluster-id-43982723368424" secondary="0"><table class="news-story-section ts news-main-story-table" id="esc-story-cluster-id-43982723368424"><tbody><tr><td class="news-main-story-table-cell"><div class="top news-thumbnail news-thumbnail-large"><div><a class="news-thumbnail-link" href="http://www.journaldemontreal.com/2014/04/09/bedard-pressenti-pour-etre-chef-par-interim-du-pq" onmousedown="return rwt(this,'','','','7','AFQjCNFTqgLjLxC2eS31emKaphVChk7G8w','','0CDwQpwIwBg','','',event)"><div class="news-thumbnail-container-large"><img class="th news-thumbnail-image late-tbn news-thumbnail-image-large" id="esc-thumbnail-43982723368424" imgsrc="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcQp8ykQ_8QVQE-OWp6FyIkCoq2lLftLb0I3uEKT0aj2jWy2wvJaBRjU-tsV2gldA9Zj1uG2BOXn" alt=""></div><div class="f news-thumbnail-description news-thumbnail-description-large">Journal de Montréal</div></a></div></div><div class="news-lead-article-and-snippet"><h3><h3 class="r" style="white-space:normal"><a class="l _Kc" href="http://quebec.huffingtonpost.ca/2014/04/10/stephane-bedard-devient-chef-parlementaire-interimaire-pq_n_5129324.html" onmousedown="return rwt(this,'','','','7','AFQjCNFgbU5xltqgo-KUzcOP3rAknjHR7Q','','0CD0QqQIoADAG','','',event)">Stéphane Bédard devient chef parlementaire intérimaire du PQ</a></h3></h3><div class="slp"><span class="news-source _sK">Le Huffington Post Quebec</span><span class="news-hyphen">-</span><span class="f nsa news-source-timestamp">il y a 15 heures</span></div><div class="_uz st">Rappelons que la chef péquiste, défaite dans sa circonscription de <em>Charlevoix</em>-Côte-de-Beaupré, n&#39;est plus députée et qu&#39;elle a annoncé sa démission comme&nbsp;...</div></div><div><div class="news-extension-container" id="esc-extension-43982723368424"><div></div></div></div><div class="tsw news-media-strip-and-explore-in-depth-container"></div></td></tr></tbody></table></li><li class="g small" diversity="0" id="esc-story-cluster-id-5593362894149115365" secondary="0"><table class="news-story-section ts news-main-story-table" id="esc-story-cluster-id-5593362894149115365"><tbody><tr><td class="news-main-story-table-cell"><div class="news-lead-article-and-snippet"><h3><h3 class="r" style="white-space:normal"><a class="l _Kc" href="http://www.lelezard.com/communique-3445412.html" onmousedown="return rwt(this,'','','','8','AFQjCNFP_8entnT4fqrxTWLWjJzs8ohekQ','','0CD8QqQIoADAH','','',event)">Le Centre de loisirs Ste-Agnès de <em>Charlevoix</em> a bénéficié d&#39;une aide <em>...</em></a></h3></h3><div class="slp"><span class="news-source _sK">LeLézard.com</span><span class="news-hyphen">-</span><span class="f nsa news-source-timestamp">il y a 20 heures</span></div><div class="_uz st">Le Centre de loisirs Ste-Agnès de <em>Charlevoix</em> a bénéficié d&#39;une aide financière du gouvernement du Canada pour améliorer une infrastructure sportive,&nbsp;...</div></div><div><div class="news-extension-container" id="esc-extension-5593362894149115365"><div></div></div></div><div class="tsw news-media-strip-and-explore-in-depth-container"></div></td></tr></tbody></table></li><li class="g small" diversity="0" id="esc-story-cluster-id-43982722675301" secondary="0"><table class="news-story-section ts news-main-story-table" id="esc-story-cluster-id-43982722675301"><tbody><tr><td class="news-main-story-table-cell"><div class="top news-thumbnail news-thumbnail-large"><div><a class="news-thumbnail-link" href="http://www.journaldemontreal.com/2014/04/10/caroline-simard-nest-pas-etonnee-davoir-battu-pauline-marois" onmousedown="return rwt(this,'','','','9','AFQjCNGqcGD1CbMQO2dIGXZGbo7baU_Rbw','','0CEEQpwIwCA','','',event)"><div class="news-thumbnail-container-large"><img class="th news-thumbnail-image late-tbn news-thumbnail-image-large" id="esc-thumbnail-43982722675301" imgsrc="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcS7onnqE-C5vKIGXm1FC25HMpvT8onrMiPMnRRApgQxzndr6zctU50ms-r9iVyC-tLpE1KUQYSh" alt=""></div><div class="f news-thumbnail-description news-thumbnail-description-large"></div></a></div></div><div class="news-lead-article-and-snippet"><h3><h3 class="r" style="white-space:normal"><a class="l _Kc" href="http://www.journaldemontreal.com/2014/04/10/caroline-simard-nest-pas-etonnee-davoir-battu-pauline-marois" onmousedown="return rwt(this,'','','','9','AFQjCNGqcGD1CbMQO2dIGXZGbo7baU_Rbw','','0CEIQqQIoADAI','','',event)">Caroline Simard n&#39;est pas étonnée d&#39;avoir battu Pauline Marois</a></h3></h3><div class="slp"><span class="news-source _sK">Journal de Montréal</span><span class="news-hyphen">-</span><span class="f nsa news-source-timestamp">2014-04-10</span></div><div class="_uz st">C&#39;est une femme terre-� -terre et sans aucune expérience politique qui a battu Pauline Marois dans <em>Charlevoix</em>-Côte-de-Beaupré. Et contrairement �  bien des&nbsp;...</div></div><div><div class="news-extension-container" id="esc-extension-43982722675301"><div></div></div></div><div class="tsw news-media-strip-and-explore-in-depth-container"></div></td></tr></tbody></table></li><li class="g small" diversity="0" id="esc-story-cluster-id-7749375647518338288" secondary="0"><table class="news-story-section ts news-main-story-table" id="esc-story-cluster-id-7749375647518338288"><tbody><tr><td class="news-main-story-table-cell"><div class="top news-thumbnail news-thumbnail-large"><div><a class="news-thumbnail-link" href="http://www.uquebec.ca/communications/article.cfm?archive=0&amp;annee=2014&amp;cat=1&amp;newsid=10677" onmousedown="return rwt(this,'','','','10','AFQjCNH1WK2AcDIUFMFuyrgeLUkmkCumXQ','','0CEQQpwIwCQ','','',event)"><div class="news-thumbnail-container-large"><img class="th news-thumbnail-image late-tbn news-thumbnail-image-large" id="esc-thumbnail-7749375647518338288" imgsrc="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcTUk0qlPbSzQ5sWqLn1c00qum9Dw-Yh167JuP3h_1Pm8RftWR2AeUNv9JsaHjuGhv-ZQfwViPL5" alt=""></div><div class="f news-thumbnail-description news-thumbnail-description-large"></div></a></div></div><div class="news-lead-article-and-snippet"><h3><h3 class="r" style="white-space:normal"><a class="l _Kc" href="http://www.uquebec.ca/communications/article.cfm?archive=0&amp;annee=2014&amp;cat=1&amp;newsid=10677" onmousedown="return rwt(this,'','','','10','AFQjCNH1WK2AcDIUFMFuyrgeLUkmkCumXQ','','0CEUQqQIoADAJ','','',event)">La clé des champs</a></h3></h3><div class="slp"><span class="news-source _sK">Université du Québec (Communiqué de presse)</span><span class="news-hyphen">-</span><span class="f nsa news-source-timestamp">2014-04-10</span></div><div class="_uz st">La prochaine édition de cette université ambulante aura lieu dans <em>Charlevoix</em>, l&#39;an prochain. «J&#39;essaie de faire sortir l&#39;université de ses murs; c&#39;est ma manière&nbsp;...</div></div><div><div class="news-extension-container" id="esc-extension-7749375647518338288"><div></div></div></div><div class="tsw news-media-strip-and-explore-in-depth-container"></div></td></tr></tbody></table></li><!--n--></ol></div><!--z--></div></div><div data-jibp="h" data-jiis="uc" id="bottomads"></div><div class="med" id="extrares" style="padding:0 8px"><div><div data-jibp="h" data-jiis="uc" id="botstuff"><style>.mfr{margin-top:1em;margin-bottom:1em}.uh_h,.uh_hp,.uh_hv{display:none;position:fixed}.uh_h{height:0px;left:0px;top:0px;width:0px}.uh_hv{background:#fff;border:1px solid #ccc;-moz-box-shadow:0 4px 16px rgba(0,0,0,0.2);margin:-8px;padding:8px;background-color:#fff}.uh_hp,.uh_hv,#uh_hp.v{display:block;z-index:5000}#uh_hp{-moz-box-shadow:0px 2px 4px rgba(0,0,0,0.2);display:none;opacity:.7;position:fixed}#uh_hpl{cursor:pointer;display:block;height:100%;outline-color:-moz-use-text-color;outline-style:none;outline-width:medium;width:100%}.uh_hi{border:0;display:block;margin:0 auto 4px}.uh_hx{opacity:0.5}.uh_hx:hover{opacity:1}.uh_hn,.uh_hr,.uh_hs,.uh_ht,.uh_ha{margin:0 1px -1px;padding-bottom:1px;overflow:hidden}.uh_ht{font-size:123%;line-height:120%;max-height:1.2em;word-wrap:break-word}.uh_hn{line-height:120%;max-height:2.4em}.uh_hr{color:#093;white-space:nowrap}.uh_hs{color:#093;white-space:normal}.uh_ha{color:#777;white-space:nowrap}a.uh_hal{color:#36c;text-decoration:none}a:hover.uh_hal{text-decoration:underline}</style><div id="uh_hp"><a href="#" id="uh_hpl"></a></div><div id="uh_h"><a id="uh_hl"></a></div><div><span>Restez informé sur ce sujet d'actualité</span>: <a class="news-alerts-section" href="/alerts?t=1&amp;q=charlevoix&amp;h1=fr&amp;sa=X&amp;ei=fBBIU7_HCarw8AHb34DIBg&amp;ved=0CEcQjC8oAA">Créer une alerte e-mail pour charlevoix</a></div></div></div></div><div><div id="foot" role="contentinfo"><div data-jibp="h" data-jiis="uc" id="cljs"></div><span data-jibp="h" data-jiis="uc" id="xjs"><div id="navcnt"><table id="nav" style="border-collapse:collapse;text-align:left;margin:30px auto 30px"><tr valign="top"><td class="b navend"><span class="csb gbil" style="background:url(/images/nav_logo170_hr.png) no-repeat;background-position:-24px 0;background-size:167px;width:28px"></span></td><td class="cur"><span class="csb gbil" style="background:url(/images/nav_logo170_hr.png) no-repeat;background-position:-53px 0;background-size:167px;width:20px"></span>1</td><td><a class="fl" href="/search?q=charlevoix&amp;tbas=0&amp;tbs=sbd:1,nsd:1,qdr:d&amp;tbm=nws&amp;ei=fBBIU7_HCarw8AHb34DIBg&amp;start=10&amp;sa=N"><span class="csb gbil ch" style="background:url(/images/nav_logo170_hr.png) no-repeat;background-position:-74px 0;background-size:167px;width:20px"></span>2</a></td><td class="b navend"><a class="pn" href="/search?q=charlevoix&amp;tbas=0&amp;tbs=sbd:1,nsd:1,qdr:d&amp;tbm=nws&amp;ei=fBBIU7_HCarw8AHb34DIBg&amp;start=10&amp;sa=N" id="pnnext" style="text-decoration:none;text-align:left"><span class="csb gbil ch" style="background:url(/images/nav_logo170_hr.png) no-repeat;background-position:-96px 0;background-size:167px;width:71px"></span><span style="display:block;margin-left:53px;text-decoration:underline">Suivant</span></a></td></tr></table></div><div class="f nwd">La sélection et le positionnement des articles de cette page ont été réalisés automatiquement par un programme informatique.&nbsp;L'heure ou la date affichée permet de savoir quand un article a été ajouté ou mis �  jour dans Google Actualités.</div></span><div data-jibp="h" data-jiis="uc" id="gfn"></div></div></div></div></div><div class="col"><div data-jibp="h" data-jiis="uc" id="rhscol"><div id="rhs"><div id="rhs_block"><script>(function(){var c4=1072;var c5=1160;var bc=1250;var bd=0;try{var w=document.body.offsetWidth,n=3;if(w>bc){c4+=bd;c5+=bd;}
if(w>=c4)n=w<c5?4:5;document.getElementById('rhs_block').className+=' rhstc'+n;}catch(e){}
})();</script>       </div></div></div></div><div style="clear:both"></div></div><div data-jibp="h" data-jiis="uc" id="bfoot">  <div id="nyc" role="dialog" style="display:none"> <div id="nycp"> <div id="nycxh"> <button title="Masquer les détails des résultats" id="nycx"></button> </div> <div id="nycntg"></div> <div id="nycpp"> <div style="position:absolute;left:0;right:0;text-align:center;top:45%"> <img id="nycli"> <div id="nycm"></div> </div> <div id="nycprv"></div> </div> </div> <div id="nyccur"></div> </div> <div id="nycf"></div>  </div><div data-jibp="h" data-jiis="uc" id="hbce"></div></div><div id="footcnt">  <div> <style>.fmulti{}._Dp{bottom:0;left:0;position:absolute;right:0}._Zh{background:#f2f2f2;bottom:0;left:0;position:absolute;right:0;-webkit-text-size-adjust:none}.fbar p{display:inline}.fbar a,#fsettl{text-decoration:none;white-space:nowrap}.fbar ._le{padding:0 0 0 27px !important;margin:0 !important}.fbar ._Di{padding:0 !important;margin:0 !important}._Lg a:hover{text-decoration:underline}._wf img{margin-right:4px}._wf a,._Zh #swml a{text-decoration:none}.fmulti{text-align:center}.fmulti #fsr{display:block;float:none}.fmulti #fuser{display:block;float:none}#fuserm{line-height:25px}#fsr{float:right;white-space:nowrap}#fsl{white-space:nowrap}#fsett{background:#fff;border:1px solid #999;bottom:30px;padding:10px 0;position:absolute;box-shadow:0 2px 4px rgba(0,0,0,0.2);-moz-box-shadow:0 2px 4px rgba(0,0,0,0.2);text-align:left;z-index:100}#fsett a{display:block;line-height:44px;padding:0 20px;text-decoration:none;white-space:nowrap}._Lg #fsettl:hover{text-decoration:underline}._Lg #fsett a:hover{text-decoration:underline}._fb{color:#777}._qb{color:#222;font-size:14px;font-weight:normal;-moz-tap-highlight-color:rgba(0,0,0,0)}._qb:hover,._qb:active{color:#444}._kd{display:inline-block;position:relative}._Pb,._Bc{height:13px;width:8px}._Pb:before,._Bc:before{border:8px solid rgba(255,255,255,0);border-radius:8px;content:'';position:absolute}._Pb:before{border-left:8px solid #777;left:1px}._Bc:before{border-right:8px solid #777;left:-9px}._Pb:after,._Bc:after{border:12px solid rgba(255,255,255,0);content:'';position:absolute;top:-4px}._Pb:after{border-left:10px solid #f6f6f6;left:-4px}._Bc:after{border-right:10px solid #f6f6f6;left:-10px}._vj ._Pb:after{border-left:10px solid white}._vj ._Bc:after{border-right:10px solid white}._qb{padding:8px 16px;margin-right:10px}._fb{margin:40px 0}._ig{margin-right:10px}.fbar{background:#f2f2f2;border-top:1px solid #e4e4e4;line-height:40px;min-width:980px}._Ep{margin-left:135px}._Cp{margin-left:135px}.fbar p,.fbar a,#fsettl,#fsett a{color:#777}.fbar a:hover,#fsett a:hover{color:#333}.fbar{font-size:small}#fuser{float:right}</style>   <div id="fbarcnt" style="position:relative;visibility:hidden"> <div id="fbar" style="position:absolute;bottom:0;left:0;right:0">  <div class="fbar"> <span class="_Ep">  <span id="fsl">   <a class="_Di" href="//support.google.com/websearch/?p=ws_results_help&amp;hl=fr-CA&amp;fg=1">Aide</a> <a class="_le" href="javascript:void(0)" data-bucket="websearch" jsaction="gf.sf" id="_rR" target="_blank" data-ved="0CEwQLg">  Envoyer des commentaires </a>  <a class="_le" href="/intl/fr/policies/?fg=1">Confidentialité et conditions d'utilisation</a> <span class="_le" data-jibp="h" data-jiis="uc" id="fescapehatch"> <a href="https://www.google.ca/setprefdomain?prefdom=US&amp;prev=https://www.google.com/search?q%3Dcharlevoix%26tbm%3Dnws%26source%3Dlnms%26tbas%3D0%26tbs%3Dsbd:1,nsd:1,qdr:d&amp;sig=0_AzNT8T5imbFHyZYUi04eN05zZRk%3D&amp;fg=1">Utiliser Google.com</a> </span> <span data-jibp="h" data-jiis="uc" id="fbbv">  </span> <span data-jibp="h" data-jiis="uc" id="fbsh">   </span> </span> </span> </div> </div> </div> </div> </div><div data-jibp="h" data-jiis="uc" id="bpsw"><script>(function(){var _mstr='\74div id\75cnt\76\74/div\76\74div id\75xfootw\76\74/div\76\74div id\75xjsi\76\74/div\076';var commands = [];var index = 0;var gstyle = document.getElementById('gstyle');if (gstyle){commands[index++]=
{'n':'pcs','i':'gstyle','css':gstyle.innerHTML,'is':'','r':true,'sc':true};}
commands[index++]=
{'n':'pc','i':'cst','h':document.getElementById('cst').innerHTML,'is':'','r':true,'sc':true};commands[index]=
{'n':'pc','i':'main','h':_mstr,'is':'','r':true,'sc':true};google.j[1]={cmds:commands};})();</script><script data-url="/extern_chrome/c7c23fdf370e04d9.js?tbm=nws&amp;bav=or.r_qf" id="ecs"></script></div><div id="xfootw" data-jiis="bp"><div data-jibp="h" data-jiis="uc" id="xfoot"><script>google.react=google.react||{};(function(){google.react.c=[]
;google.react.g=[]
;})();</script><div id=xjsd></div><div id=xjsi data-jiis="bp"><script>if(google.y)google.y.first=[];(function(){function b(a){window.setTimeout(function(){var c=document.createElement("script");c.src=a;document.getElementById("xjsd").appendChild(c)},0)}google.dljp=function(a){google.xjsu=a;b(a)};google.dlj=b;})();
if(!google.xjs){window._=window._||{};window._._DumpException=function(e){throw e};if(google.timers&&google.timers.load.t){google.timers.load.t.xjsls=new Date().getTime();}google.dljp('/xjs/_/js/k\x3dxjs.s.en_US.nZdU-ju1wak.O/m\x3dc,sb,cr,jp,jsa,elog,r,hsm,j,p,pcc,csi/am\x3dAcHwPxu6FSJY/rt\x3dj/d\x3d1/sv\x3d1/rs\x3dAItRSTPu2q2w7wXy0V6KLydzYmzqsOHaWw');google.xjs=1;}google.sn='newssearch';google.pmc={"c":{"mcr":5},"sb":{"agen":false,"cgen":true,"client":"serp","dh":true,"ds":"n","eqch":true,"hint":"Rechercher dans les actualités","host":"google.ca","jam":1,"jsonp":true,"msgs":{"dym":"Essayez avec cette orthographe :","lcky":"J\u0026#39;ai de la chance","lml":"En savoir plus","oskt":"Outils de saisie","psrc":"Cette suggestion a bien été supprimée de votre \u003Ca href=\"/history\"\u003Ehistorique Web\u003C/a\u003E.","psrl":"Supprimer","sbit":"Recherche par image","srch":"Recherche Google"},"ovr":{},"pq":"charlevoix","psy":"p","qcpw":false,"scd":10,"sce":4,"stok":"68T__M69JmtwuhYo7abiC1oj2lc"},"cr":{"eup":false,"qir":false,"rctj":true,"ref":true,"uff":false},"cdos":{"dima":"b"},"gf":{"pid":70865},"jp":{"mcr":5,"rt":1367369205},"vm":{"bv":64542518,"d":"b2U","tc":true,"te":true,"tk":true,"ts":true},"tbui":{"dfi":{"am":["janv.","févr.","mars","avr.","mai","juin","juil.","août","sept.","oct.","nov.","déc."],"df":["EEEE d MMMM y","d MMMM y","d MMM y","yyyy-MM-dd"],"fdow":6,"nw":["D","L","M","M","J","V","S"],"sw":["dim.","lun.","mar.","mer.","jeu.","ven.","sam."],"wm":["janvier","février","mars","avril","mai","juin","juillet","août","septembre","octobre","novembre","décembre"]},"m":{"app":true,"bks":true,"blg":true,"dsc":true,"fin":true,"flm":true,"frm":true,"isch":true,"klg":true,"map":true,"mobile":true,"nws":true,"plcs":true,"ppl":true,"prc":true,"pts":true,"rcp":true,"shop":true,"vid":true},"t":{"nsd":"1","nws":"1","qdr":"d","sbd":"1"}},"wta":{"s":true},"llc":{"carmode":"list","cns":false,"dst":0,"fdltopl":true,"float":true,"hot":false,"ime":true,"lsw":false,"mpi":2000,"oq":"charlevoix","p":true,"prich":false,"t":false},"async":{"act":false},"foot":{"pf":true,"po":false},"riu":{"cnfrm":"Problème signalé","prmpt":"Signaler comme inapproprié"},"jsa":{},"rmcl":{"bl":"Signaler un problème","db":"Signalé","di":"Merci.","dl":"Signaler un autre problème","rb":"Faux ?","ri":"Veuillez nous signaler le problème.","rl":"Annuler"},"rk":{"bl":"Signaler un problème","db":"Signalé","di":"Merci.","dl":"Signaler un autre problème","efe":true,"rb":"Faux ?","ri":"Veuillez nous signaler le problème.","rl":"Annuler"},"lu":{"uab":true},"m":{"ab":{"on":true},"ajax":{"gl":"ca","hl":"fr","q":"charlevoix"},"css":{"showTopNav":true},"exp":{"kvs":true,"tnav":true},"msgs":{"details":"Détails du résultat","hPers":"Masquer les résultats privés","hPersD":"Résultats privés masqués","loading":"Chargement en cours d'exécution","mute":"Couper le son","noPreview":"Aperçu non disp.","sPers":"Afficher tous les résultats","sPersD":"Résultats privés affichés","unmute":"Réactiver le son"},"nokjs":{"on":true},"time":{"hUnit":1500}},"me":{"bnOn":false,"js":true,"rhs4Col":1072,"rhs5Col":1160,"rhsOn":true},"tnv":{"m":false,"ms":false,"t":false},"ttbcdr":{"m":false},"adp":{},"am":{},"elog":{},"erh":{},"hv":{},"jsaleg":{},"lc":{},"lorw":{},"nws":{},"r":{},"rkab":{},"sf":{},"shlb":{},"st":{},"hsm":{},"j":{"cmt":true,"daus":true,"ftwd":200,"icmt":false,"mcr":5,"rmcfbp":true,"rt":1367369206,"scmt":true,"sirs":"clone","tct":" \\u3000?","tlh":true,"ufl":true},"p":{"ae":true,"avgTtfc":2000,"brba":false,"dlen":24,"dper":3,"eae":true,"fbdc":500,"fbdu":-1,"fbh":true,"fd":1000000,"focus":true,"gpsj":true,"hiue":true,"hpt":310,"iavgTtfc":2000,"knrt":true,"lpu":[],"maxCbt":1500,"mds":"dfn,klg,prc,sp,mbl_he,mbl_hs,mbl_re,mbl_rs,mbl_sv","msg":{"dym":"Essayez avec cette orthographe :","gs":"Recherche Google","kntt":"Utilisez les flèches vers le haut et vers le bas pour sélectionner un résultat, puis appuyez sur \"Entrée\" pour accéder au résultat choisi.","pcnt":"Nouvel onglet","sif":"Essayez avec l'orthographe","srf":"Résultats pour"},"nprr":1,"ohpt":false,"ophe":true,"pmt":250,"pq":true,"rpt":50,"sc":"psy-ab","tdur":50},"pcc":{},"csi":{"acsi":true},"hLaaFQ":{"ed":"Veuillez saisir une description.","eu":"Veuillez saisir une URL valide."},"zF4mTg":{},"/nNC3A":{},"TG8rFw":{},"2WcKhg":{},"v3wifQ":{},"c+PT4g":{},"/1S6iw":{},"GqeGtQ":{},"BwDLOw":{},"8aqNqA":{},"vitigA":{},"A/Ucpg":{}};google.y.first.push(function(){google.loadAll(['cdos','gf','vm','tbui','wta','async','foot','lu','m','me','tnv','adp','erh','hv','jsaleg','lc','nws','sf']);if(google.med){google.med('init');google.initHistory();google.med('history');}});if(google.j&&google.j.en&&google.j.xi){window.setTimeout(google.j.xi,0);}</script></div><script>(function(){if(google.timers&&google.timers.load.t){var b,c,d,e,g=function(a,f){a.removeEventListener?(a.removeEventListener("load",f,!1),a.removeEventListener("error",f,!1)):(a.detachEvent("onload",f),a.detachEvent("onerror",f))},h=function(a){e=(new Date).getTime();++c;a=a||window.event;a=a.target||a.srcElement;g(a,h)},k=document.getElementsByTagName("img");b=k.length;for(var l=c=0,m;l<b;++l)m=k[l],m.complete||"string"!=typeof m.src||!m.src?++c:m.addEventListener?(m.addEventListener("load",h,!1),m.addEventListener("error",
h,!1)):(m.attachEvent("onload",h),m.attachEvent("onerror",h));d=b-c;var n=function(){if(google.timers.load.t){google.timers.load.t.ol=(new Date).getTime();google.timers.load.t.iml=e;google.kCSI.imc=c;google.kCSI.imn=b;google.kCSI.imp=d;void 0!==google.stt&&(google.kCSI.stt=google.stt);google.csiReport&&google.csiReport()}};window.addEventListener?window.addEventListener("load",n,!1):window.attachEvent&&
window.attachEvent("onload",n);google.timers.load.t.prt=e=(new Date).getTime()};})();
</script></div></div><div data-jibp="h" data-jiis="uc" id="lfoot"></div></div><div data-async-type="reviewDialog" id="reviewDialog" class="y yp" data-ved="0CE8QxCw"></div></div><script>window.gbar&&gbar.up&&gbar.up.tp&&gbar.up.tp();</script></body></html>
      
      
      */
      

  
  }




function GoogleParse2($my_html) {

   
        $table = explode("<li class=\"g\">",$my_html);
                
      
                     //        news-thumbnail-container
                     
       
                       print "<br><div style=\"clear:both\">\n";
                            
                     
                     print "NBBBB=".count($table);
             
                       print "<br><div style=\"clear:both\">\n";
          //     print_r($table);       
      if(count($table)>1) {               
      for($i=1;$i<count($table);$i++) {
      
             //   print $table[$i];
                $titre="";
                $url="";
                $thumb="";
                $resume ="";
                $source="";
                $quand ="";
               $content = $table[$i];
               $pos1 = strpos($content,"href=")+6;
               $pos2 = strpos($content,"\"",$pos1);
               
               if(substr($content,$pos1,1)=="h") {
               
                       print "\nFound a #".$i." news at:<br>\n";
                       print "URL=".substr($content,$pos1,($pos2-$pos1))."<br>\n";
                       
                        $url = substr($content,$pos1,($pos2-$pos1));
                   
                 //   print "MYCOD=<br>".$content."<br>";
                   
                   
                       $pos0 = strpos($content,"-image\" src=\"")+13;
                          
                       $pos1 = strpos($content,"\"",$pos0);

                   //       print substr($content,$pos0,3);
                        
                         if(substr($content,$pos0,3)=="htt") {
                         
                        //    print "THUMBNAIL=".substr($content,$pos1,($pos2-$pos1))."<br>\n";
                          //   print "<img src=\"".substr($content,$pos1,($pos2-$pos1))."\"><div style=\"clear:both\"></div>\n";
                              $thumb = substr($content,$pos0,($pos1-$pos0));
                     
                          
                          } else {
                            //    print "NO THUMBNAIL<br>\n";
                          
                               $thumb = "";
                     
                          }
                          
                       
                       
                           print "THUMBNAIL=".$thumb."<br>";
                       
                   
                   
                          
                       $pos1 = strpos($content,"<h3",0)+5;
                      
                            
                       $pos2 = strpos($content,">",$pos1)+1;
                       $pos2 = strpos($content,">",$pos2)+1;
                      
                       $pos3 = strpos($content,"</",$pos2);
                       
                       
                                   
                    print "TITRE=".substr($content,$pos2,($pos3-$pos2))."<br>\n";
                         
                         
                         
                            $titre = substr($content,$pos2,($pos3-$pos2));
                          
                            $titre = str_replace("<em>","",$titre);
                     
                                   $titre = str_replace("</em>","",$titre);
                         
                                                 
                       $pos1 = strpos($content,"news-source _cY",0)+17;
                       $pos2 = strpos($content,"</span>",$pos1);
                    
                       
                         $source = substr($content,$pos1,($pos2-$pos1));
                     
                         
                    print "SOURCE=".substr($content,$pos1,($pos2-$pos1))."<br>\n";
                                         
                       $pos1 = strpos($content,"<span class=\"f nsa news-source-timestamp\">",0)+42;
                       $pos2 = strpos($content,"</span>",$pos1);
                         $quand = substr($content,$pos1,($pos2-$pos1));
                     
                   print "QUAND=".substr($content,$pos1,($pos2-$pos1))."<br>\n";
                        
                                       
                       $pos1 = strpos($content," class=\"st\">",0)+12;
                       $pos2 = strpos($content,"</div>",$pos1);
                         $resume = substr($content,$pos1,($pos2-$pos1));
                        $resume = str_replace("<em>","",$resume);
                     
                                   $resume = str_replace("</em>","",$resume);
                              
                 print "RESUME=".substr($content,$pos1,($pos2-$pos1))."<br>\n";
                        
                           /*                      
                  
                       
                     print "<code>\n";
                       print $content;
                       print "\n</code>\n";
                       */
              
                       print "<br><div style=\"clear:both\">\n";
                      
     
                       $new = new cmsNouvelle($this->hts_db);
                       if(!$new->CheckIfUrlExist($url)) {
                       
                              print "<b>this news WILL be added!</b><br><br>\n\n\n";
                                            
                       
                       $src = new cmsSource($this->hts_db);
                       $id_src=0;
                       $id_src= $src->GetSourceFromTitle($source);
                       if($id_src==0) {
                       
                               $src->LoadFromId(0);
                               $src->SetParam(CMS_SOURCE_TITRE,$source);
                               $id_src = $src->Save();   
                       }
                       
                        if($id_src!=19) {
                               $new->LoadFromId(0);
                               $new->SetParam(CMS_ACTIVITE_TITRE,$titre);
                               $new->SetParam(CMS_ACTIVITE_RESUME,$resume);
                               $new->SetParam(CMS_ACTIVITE_DATE,date('YmdHi'));
                               $new->SetParam(CMS_ACTIVITE_URL,$url);
                               $new->SetParam(CMS_ACTIVITE_SOURCE,$id_src);
                               if($thumb!="") {
                                                unlink("/home/mplus/www/www.infocharlevoix.com/cms/tmp/thumb.jpg");
                                    $img = new iptImageSize();
                                    
                                  
                                       $img->IPT_IS_ResizePicture(str_replace(" ","%20",$thumb), "/home/mplus/www/www.infocharlevoix.com/cms/tmp/thumb.jpg", 350, 281, 100);
                                       
                                      if( file_exists("/home/mplus/www/www.infocharlevoix.com/cms/tmp/thumb.jpg")) {
                                      print "tRYNIG TO IMPORT IT ";
                                             $new->SetParam(CMS_NOUVELLE_FICHIER,"/home/mplus/www/www.infocharlevoix.com/cms/tmp/thumb.jpg",true);
                                      }
                              }
                              
                          
                              $new->Save();             
                           }             
                       }      else {
                       
                            print "this news won't be added!<br><br>\n\n\n";
                       }
              
              
              
              
              
              
               } else {
               /*
                      print "\nERRRRRRRRRRRROR Found a #".$i." news at:<br>\n";
                      print substr($content,$pos1,($pos2-$pos1));
                        print "<code>\n";
                       print $content;
                       print "\n</code>\n";  
                  */    
               }
                                      
      }
      }
}







  function RechercheNouvelles($pLimit="",$pSearch="") {
     
  	    
      				
      				 
              $req = "select cms_nouvelle.id, cms_categorie.ttitre categorie, concat(substring(cms_nouvelle.dinscrit,7,2),'/',substring(cms_nouvelle.dinscrit,5,2),'/',substring(cms_nouvelle.dinscrit,1,4)) dinscrit, 
                            concat(substring(cms_nouvelle.dinscrit,9,2),':',substring(cms_nouvelle.dinscrit,11,2)) hinscrit,    cms_source.ttitre source,
                                                      concat(substring(cms_nouvelle.daffichage,7,2),'/',substring(cms_nouvelle.daffichage,5,2),'/',substring(cms_nouvelle.daffichage,1,4)) daffichage,

 gco_ville.ttitre ville,
                           case when   substring(cms_nouvelle.dinscrit,9,2) ='' then   'red'
                           else 
                           
                             case when length(cms_nouvelle.zdata)=0 then  'red' 
                             else 
                             
                              case when length(cms_nouvelle.kgco_ville)=0 then  'red' 
                              else 
                              
                                case when length(cms_nouvelle.kcms_categorie)=0 then  'red' 
                                else 'black'   
                                end
                                                               
                              end
                               
                             end 
                           end 
                            vcolor,
                           
                           cms_nouvelle.* ,
                           concat(gco_utilisateur.tprenom,' ',gco_utilisateur.tnom) auteur
          
                         from cms_nouvelle
                                left outer join gco_ville on gco_ville.id=cms_nouvelle.kgco_ville
                                  left outer join cms_categorie on cms_categorie.id=cms_nouvelle.kcms_categorie
                              left outer join gco_utilisateur on gco_utilisateur.id=cms_nouvelle.kgco_utilisateur
                     left outer join cms_source on cms_source.id=cms_nouvelle.kcms_source
                            where cms_nouvelle.binactif=0
                             
                             and (cms_nouvelle.ttitre like '%".addslashes($pSearch)."%' 
                             or cms_nouvelle.tresume like '%".addslashes($pSearch)."%' )
                             
                              ";
               
         
                   $req .=" and cms_nouvelle.kcms_categorie>0 and cms_nouvelle.kgco_ville>0 ";                
    
                         
               $req .= "
                           order by cms_nouvelle.dinscrit  desc, cms_nouvelle.id desc
                         
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