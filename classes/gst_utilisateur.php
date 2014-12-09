<?

  
//******************************************************************************
// STEP 1
// SET YOUR CONST VARS TO EASILY MANAGE YOUR UPDATES LATER
//******************************************************************************
  define("GST_UTILISATEUR_DB_VERSION",        '1.0.1');
  define("GST_UTILISATEUR_DB_TABLE",          'gst_utilisateur');
  define("GST_UTILISATEUR_CRYPT_KEY",         'r8dij02d');


  define("GST_UTILISATEUR_ID",                1000);
  define("GST_UTILISATEUR_PRENOM",            1001);
  define("GST_UTILISATEUR_NOM",               1002);
  define("GST_UTILISATEUR_UTILISATEUR",       1003);
  define("GST_UTILISATEUR_MOTDEPASSE",        1004);
  define("GST_UTILISATEUR_COURRIEL",          1005);
  define("GST_UTILISATEUR_PHOTO",             1006);
  define("GST_UTILISATEUR_ACTIF",             1007);
  define("GST_UTILISATEUR_ADMIN",             1008);
  define("GST_UTILISATEUR_DATE_RENOUVELLEMENT",             1009);  
  define("GST_UTILISATEUR_DATE_INSCRIT",             1010);    

if(!isset($_SESSION['ipt_user_id'])) { $_SESSION['ipt_user_id']=""; }
//******************************************************************************
// STEP 2
// RENAME YOUR CLASS
//******************************************************************************                              
class gstUtilisateur extends iptDbObject {

  var $hts_db_table   = GST_UTILISATEUR_DB_TABLE;
  var $hts_db_version = GST_UTILISATEUR_DB_VERSION;

  var $hts_action = null;
//******************************************************************************
// STEP 3
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                              
  var $hts_db_fieldstype =    array (GST_UTILISATEUR_ID             => IPT_FIELD_TYPE_AUTOID,
                                      GST_UTILISATEUR_PRENOM        => IPT_FIELD_TYPE_TEXT,
                                      GST_UTILISATEUR_NOM           => IPT_FIELD_TYPE_TEXT,
                                      GST_UTILISATEUR_UTILISATEUR   => IPT_FIELD_TYPE_TEXT,
                                      GST_UTILISATEUR_PHOTO         => IPT_FIELD_TYPE_FILE,
                                      GST_UTILISATEUR_MOTDEPASSE    => IPT_FIELD_TYPE_TEXT,
                                      GST_UTILISATEUR_COURRIEL      => IPT_FIELD_TYPE_TEXT,
                                      GST_UTILISATEUR_ACTIF         => IPT_FIELD_TYPE_INT,
                                      GST_UTILISATEUR_ADMIN         => IPT_FIELD_TYPE_INT,
                                      GST_UTILISATEUR_DATE_RENOUVELLEMENT         => IPT_FIELD_TYPE_DATE,
                                      GST_UTILISATEUR_DATE_INSCRIT         => IPT_FIELD_TYPE_DATETIME);
 
//******************************************************************************
// STEP 4
// DEFINE TABLE NAME AND FIELD LISTING FOR READ/WRITE TO DB
//******************************************************************************                                   
  var $hts_db_params =         array (GST_UTILISATEUR_ID            => 'id',
                                      GST_UTILISATEUR_PRENOM        => 'tprenom',
                                      GST_UTILISATEUR_NOM           => 'tnom',
                                      GST_UTILISATEUR_UTILISATEUR   => 'tnomutilisateur',
                                      GST_UTILISATEUR_PHOTO         => 'zphoto',
                                      GST_UTILISATEUR_MOTDEPASSE    => 'tmotdepasse',
                                      GST_UTILISATEUR_COURRIEL      => 'tcourriel',
                                      GST_UTILISATEUR_ACTIF         => 'bactive',
                                      GST_UTILISATEUR_ADMIN         => 'badmin',
                                      GST_UTILISATEUR_DATE_RENOUVELLEMENT         => 'drenouvellement',
                                      GST_UTILISATEUR_DATE_INSCRIT         => 'dinscrit');
 
//******************************************************************************
// STEP 5
// IMPLEMENT YOUR OWN FUNCTIONS....
//******************************************************************************       
  function CreerUtilisateur($pId, $pUtilisateur, $pPrenom="", $pNom="", $pMotDePasse="", $pCourriel="", $pActif=true, $pPhoto="",$pRenouvellement="",$pAdmin=true) {
       if($pMotDePasse=="") {
              $pMotDePasse = "b1d0n1234";
       }
           $encrypt = new iptCrypt(GST_UTILISATEUR_CRYPT_KEY);
           $pMotDePasse_crypter =  $encrypt->Encrypt($pMotDePasse);                          

          $my_vals = array(GST_UTILISATEUR_PRENOM       => $pPrenom,
                                           GST_UTILISATEUR_NOM          => $pNom,
                                           GST_UTILISATEUR_UTILISATEUR  => $pUtilisateur,
                                           GST_UTILISATEUR_PHOTO        => $pPhoto,
                                           GST_UTILISATEUR_MOTDEPASSE   => $pMotDePasse_crypter,
                                           GST_UTILISATEUR_COURRIEL     => $pCourriel,
                                           GST_UTILISATEUR_ACTIF        => $pActif,
                                           GST_UTILISATEUR_ADMIN        => $pAdmin);

      if(intval($pId)==0) {
        $my_vals[GST_UTILISATEUR_DATE_INSCRIT]= date('YmdHis');
      }
     
       $bExist = $this->LoadFromId(intval($pId));
       
       $this->SetParamsFromArray($my_vals);
     
       return $this->Save();
       
       
   
   }
  
  
  function EncryptPass($pPass) { 
             $encrypt = new iptCrypt(GST_UTILISATEUR_CRYPT_KEY);
             return $encrypt->Encrypt($pPass);
  
  
  }
  
          
  function Authentification($pUtilisateur,$pMotDePasse) {
  
        
             $encrypt = new iptCrypt(GST_UTILISATEUR_CRYPT_KEY);
             $pMotDePasse =  $encrypt->Encrypt($pMotDePasse);

             $pUtilisateur = addslashes($pUtilisateur);
             $pMotDePasse = addslashes($pMotDePasse);


  	          $rs = new iptDBQuery;
      				$rs->Open("select id
                         from ".GST_UTILISATEUR_DB_TABLE."
                         where tnomutilisateur='".$pUtilisateur."' and
                               tmotdepasse='".$pMotDePasse."' and
                               bactive=1
                         limit 1",$this->hts_db);

      				if($rs->RowCount()==1) {

                 $this->LoadFromId(intval($rs->GetValue("id",0)));
                 $this->SetSessionValues();
                 return true;

              } else {

                return false;

              }


  }

  function SetSessionValues($pForced=false) {
  
  
                 
                 $_SESSION['ipt_user_id'] =  $this->GetParam(GST_UTILISATEUR_ID);
                 $_SESSION['ipt_user_prenom'] =  $this->GetParam(GST_UTILISATEUR_PRENOM);
                 $_SESSION['ipt_user_nom'] =  $this->GetParam(GST_UTILISATEUR_NOM);
                 $_SESSION['ipt_user_email'] =  $this->GetParam(GST_UTILISATEUR_COURRIEL);
                 $_SESSION['ipt_user_login'] =  $this->GetParam(GST_UTILISATEUR_UTILISATEUR);
                 
  
                 
                 if(!$pForced) {
                   $_SESSION['ipt_user_admin'] =  $this->GetParam(GST_UTILISATEUR_ADMIN);
                   $_SESSION['ipt_user_admin_id'] =  $this->GetParam(GST_UTILISATEUR_ID);
                  
                 }
   
  }
 
 

  function ForcedLogin($pId) {
  
        

       $this->LoadFromId(intval($pId));
       $this->SetSessionValues(true);
       return true;

  
  
  
  
  } 
  
  function Deconnexion() {
  
     $_SESSION['ipt_user_id']     =  "";
     $_SESSION['ipt_user_prenom'] =  "";
     $_SESSION['ipt_user_nom']    =  "";
     $_SESSION['ipt_user_email']  =  "";
     $_SESSION['ipt_user_login']  =  "";
     $_SESSION['ipt_user_admin'] =  "";

  }
  
  
  function Authentifier() {
  
     $bConnecter = false;
     
     if(intval($_SESSION['ipt_user_id'])>0) {
        $bExist = $this->LoadFromId(intval($_SESSION['ipt_user_id']));
        if($bExist) {
          $bConnecter = true;
        }
     }
  
  
  }
  
  
  
  
  function ListeUtilisateurs() {
  
        
  
  	          $rs = new iptDBQuery;
      				$rs->Open("select * 
                         from gst_utilisateur
                         order by tnomutilisateur ",$this->hts_db);
                         
      			
              return $rs;

  
  }
   
  
  

  
  function NbUtilisateurs() {
  
        
  
  	          $rs = new iptDBQuery;
      				$rs->Open("select count(id) nb
                         from gst_utilisateur",$this->hts_db);
                         
      			
              return $rs->GetValue("nb",0);

  
  }
   
  
  
 
  function InfosUtilisateur($pId,$pHiddenPass=false) {
  
        
              $pId= intval($pId);


              if($pId==0) {
                       $query="select 0 id, 
                                      'username' tnomutilisateur, 
                                      '' tprenom, 
                                      '' tnom,
                                      '' tmotdepasse ";
    
              } else {
                 if($pHiddenPass) {
                     $query="select 'bidon' tmotdepasse,gst_utilisateur.* 
                           from gst_utilisateur
                           where id=".intval($pId);
                 } else {
                 
                $query="select * 
                           from gst_utilisateur
                           where id=".intval($pId);
                }
              }      			

    	        $rs = new iptDBQuery;
        				$rs->Open($query,$this->hts_db);
                           
              return $rs;

  
  }
      
  
  function SendInfosByMail($pUsername="",$pEmail="") {
  
  	          $rs = new iptDBQuery;
      				$rs->Open("select * from gst_utilisateur where tnomutilisateur='".addslashes($pUsername)."' or tcourriel='".addslashes($pEmail)."'",$this->hts_db);
              
              $nb=0;
              for($i=0;$i<$rs->RowCount();$i++) {
              
               // $this = new gstUtilisateur($this->hts_db);
                $this->LoadFromId($rs->GetValue("id",$i));

                $newpass = $this->RandomPass();
                $newpass_enc = $this->EncryptPass($newpass);
                
                $this->SetParam(GST_UTILISATEUR_MOTDEPASSE,$newpass_enc);
                $this->Save();
                                                                                          
                $my_template = new iptTemplate("html/courriels/infos_utilisateurs.html");
 
                 
                 $my_template->Replace("[--serveur--]",$_SERVER['SERVER_NAME']);
                $my_template->Replace("[--username--]",$rs->GetValue("tnomutilisateur",$i));
                $my_template->Replace("[--newpass--]",$newpass);
                $my_template->Replace("[--nomcomplet--]",$rs->GetValue("tprenom",$i)." ".$rs->GetValue("tnom",$i));
                $my_mail= $my_template->GetContent();
  
  
  
  
            
                if(strpos($rs->GetValue("tcourriel",$i),"@")>0) {
  
      
                  
                   
                  $cfg = new gstConfig($this->hts_db);
                  
              
                  $from_email = $cfg->GetValeur("admin_courriel");
                  if($from_email=="") {
                    $from_email="simple-cms@".$_SERVER['SERVER_NAME'];
                  }
                  
  
                  $y = new iptEmail();
                  $y->Init($from_email,$my_mail);                       
                  $y->Send($rs->GetValue("tcourriel",$i),"Informations de connexion Simple-CMS");
                  $nb++;
                }
                
              }
                         
                         
                         
        return $nb;   
            
        
        
  }
  
   
  function Event_Save_Before($pId) {
  
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
   
  function RandomPass() {
      $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 10; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
  }
  
}


?>