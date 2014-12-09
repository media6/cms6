<? 
/******************************
Description:  Permet d'acceder a l'application via un navigateur internet
              Affiche le formulaire d'authentification si l'utilisateur n'est pas identifier
              Redirige vers l'accueil des utilisateurs ceux qui sont authentifier
********************************/

//Importation des classes et de la configuration
include('inc/header.php');

        $x = new iptTemplate("html/ecrans/erreur.html",$rs2);
        $my_content= $x->GetContent();
    
    $my_template = new iptTemplate("html/interfaces/accueil.html");
    $my_template->Replace("[--content--]",$my_content);
    $my_html = $my_template->GetContent();

    
    //Impression de la page
    print $my_html;
}

die;

?>
