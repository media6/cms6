<?
/******************************
Description:  Utiliser lorsqu'aucun utilisateur n'existe dans la base de donnees
********************************/

include('inc/header.php');


if(intval($_SESSION['ipt_user_id'])>0) {

    //Si l'utilisateur est deja authentifier on le redirige vers l'accueil de l'application
    header('Location: index.php');

} else {
    $default_username="";
    if(isset($_POST['tnewuser'])) {
      	$default_username=$_POST['tnewuser'];
      	$x = new gstUtilisateur($active_db);
      	$x->CreerUtilisateur(1, $_POST['tnewuser'], "", "", $_POST['tmotdepasse'], "");
        $rs2 = $x->InfosUtilisateur(1);
        $x = new iptWidget("html/dynamic/installation_reussie.html",$rs2);
        $my_content= $x->GetHTML();
    } else {
        $x = new gstUtilisateur($active_db);
        if($user_info->NbUtilisateurs()>0) {
            header('Location: index.php');
        } else {
    	    $rs2 = new iptDbQuery();
    	    $rs2->Open("select '".addslashes($default_username)."' tuser, '' status",$active_db);
    	    $x = new iptWidget("html/dynamic/installation.html",$rs2);
    	    $my_content= $x->GetHTML();
        }
    }
}


$template_file  ="html/interfaces/accueil.html";
$my_template = new iptTemplate($template_file);
$my_template->Replace("[--content--]",$my_content);
$my_html = $my_template->GetContent();
print $my_html;

?>
