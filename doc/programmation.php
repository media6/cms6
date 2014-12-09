<?


 
include('../inc/header.php');

                                          
   $x = new iptTemplate("../html/doc/programmation.html");    
   $my_html= $x->GetContent();
    
    

include('../inc/doc_template.php');
include('../inc/footer.php');


?>
