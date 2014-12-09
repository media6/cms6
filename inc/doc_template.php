<?



   
         
/* Load your screen using template */


$tpl_file="../html/interfaces/documentation.html";
                                                      
$my_template = new iptTemplate($tpl_file);
$my_template->Replace("[--content--]",$my_html);

$cfg = new gstConfig($active_db);
$myval = $cfg->GetValeur("cie_nom");
$my_template->Replace("[--cie_nom--]",$myval);

$myval = $cfg->GetValeur("cie_logo");
$my_template->Replace("[--cie_logo--]",$myval);

 
$my_html = $my_template->GetContent();
         
print $my_html;




?>