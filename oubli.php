<? 


     
/******************************
Description:  Permet d'acceder a l'application via un navigateur internet
              Affiche le formulaire d'authentification si l'utilisateur n'est pas identifier
              Redirige vers l'accueil des utilisateurs ceux qui sont authentifier
********************************/

//Importation des classes et de la configuration
include('inc/init.php');

if(intval($_SESSION['ipt_user_id'])>0) {
    //Si l'utilisateur est deja identifier
    //Onl le redirige vers l'accueil des utilisateurs
    header('Location: admin/index.php');

} else {
    //L'utilisateur n'est pas identifier

    //Sert a reafficher le nom d'utilisateur inscrit dans le formulaire d'authentification
    //Cela evite a l'utilisateur d'avoir a le retapper en cas d'erreur d'authentification
    $default_username="";
    
    
if(!isset($_GET['done'])) { $_GET['done']=""; }
if(!isset($_POST['a_tuser'])) { $_POST['a_tuser']=""; }
if(!isset($_POST['a_tcourriel'])) { $_POST['a_tcourriel']=""; }
    
    if(($_POST['a_tuser']!="" || $_POST['a_tcourriel']!="")  ) {


 //     	$default_username=$_POST['tuser'];
        $u = new gstUtilisateur($active_db);
        $nb1 = $u->SendInfosByMail($_POST['a_tuser'],$_POST['a_tcourriel']);

    
        header("Location: oubli.php?done=2&nb=".$nb1);        
    
     
    } else if($_GET['done']=="2") {
    
         $nb1 = intval($_GET['nb']);
         
              
        if($nb1>0) {
            $my_c = new iptTemplate("html/ecrans/oubli_ok.html");
           //print "aaa";
        } else {
            //Initialisation du modele HTML de la page
           $my_c = new iptTemplate("html/ecrans/oubli_erreur.html");
         //   print "bbb";
        }        
        
        $my_c->Replace("[--nb--]",$nb1);
        $my_content = $my_c->GetContent();
     
    } else {
    
        //Preparation du formulaire d'authentification
        $rs2 = new iptDbQuery();
        $rs2->Open("select '".addslashes($default_username)."' tuser, '' status",$active_db);
        $x = new iptWidget("html/ecrans/oubli_motdepasse.html",$rs2);
        $my_content= $x->GetHTML();
    
        //Initialisation du modele HTML de la page
    
    }
    
    $my_template = new iptTemplate("html/interfaces/accueil.html");
    $my_template->Replace("[--content--]",$my_content);
    $my_html = $my_template->GetContent();

    
    //Impression de la page
    print $my_html;
}


?>
