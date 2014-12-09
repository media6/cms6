<?



   
         
/* Load your screen using template */


if($_SESSION['ipt_user_admin']==1) { 
$tpl_file="../html/interfaces/admin.html";
} else {
$tpl_file="../html/interfaces/collaborateur.html";
        }
                                              
$my_template = new iptTemplate($tpl_file);
$my_template->Replace("[--content--]",$my_html);
$my_template->Replace("[--baseurl--]",$_SESSION['BASE_URL']);   

$my_template->Replace("[--scriptname--]",$_SERVER['SCRIPT_NAME']);   
                     
$my_template->Replace("[--username--]",$_SESSION['ipt_user_login']);
$my_template->Replace("[--user_prenom--]",$_SESSION['ipt_user_prenom']);
$my_template->Replace("[--user_nom--]",$_SESSION['ipt_user_nom']);
$my_template->Replace("[--userid--]",$_SESSION['ipt_user_id']);     
 
 
    $cfg = new gstConfig($active_db);
    $myval = $cfg->GetValeur("cie_nom");
    $my_template->Replace("[--cie_nom--]",$myval);

    $myval = $cfg->GetValeur("cie_logo");
    $my_template->Replace("[--cie_logo--]",$myval);
    
 
 
/*

$my_template->Replace("[--userid--]",$_SESSION['ipt_user_id']);         
$my_template->Replace("[--username--]",$_SESSION['ipt_user_login']);
$my_template->Replace("[--cash--]",$_SESSION['ipt_user_cash']);
$my_template->Replace("[--energy--]",$_SESSION['ipt_user_energy']);
$my_template->Replace("[--max_energy--]",$_SESSION['ipt_user_maxenergy']);
$my_template->Replace("[--level--]",$_SESSION['ipt_user_level']);
$my_template->Replace("[--xp--]",$_SESSION['ipt_user_xp']);
$my_template->Replace("[--next_xp--]",$_SESSION['ipt_user_next_xp']);
                        */
$my_html = $my_template->GetContent();
         
print $my_html;




?>