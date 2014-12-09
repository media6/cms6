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
    if(isset($_POST['tuser'])) {
  	$default_username=$_POST['tuser'];
    }

    //Preparation du formulaire d'authentification
    $rs2 = new iptDbQuery();
    $rs2->Open("select '".addslashes($default_username)."' tuser, '' status",$active_db);
    $x = new iptWidget("html/ecrans/authentification.html",$rs2);
    $my_content= $x->GetHTML();

    //Initialisation du modele HTML de la page
    $my_template = new iptTemplate("html/interfaces/accueil.html");
    $my_template->Replace("[--content--]",$my_content);
    
    
    
     
    $cfg = new gstConfig($active_db);
    $myval = $cfg->GetValeur("cie_nom");
    $my_template->Replace("[--cie_nom--]",$myval);

    $myval = $cfg->GetValeur("cie_logo");
    $my_template->Replace("[--cie_logo--]",$myval);
    
    
    
    $my_html = $my_template->GetContent();

    //Impression de la page
    print $my_html;
}

?>
