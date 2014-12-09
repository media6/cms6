<?


 
include('../inc/header.php');

                                          
   $x = new iptTemplate("../html/doc/documentation.html");    
   $my_html= $x->GetContent();
    
    

include('../inc/doc_template.php');
include('../inc/footer.php');


?>
