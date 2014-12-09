<?
	
//Working with data
if(!isset($_POST['tpass'])) { $_POST['tpass']=""; }
if(!isset($_POST['tuser'])) { $_POST['tuser']=""; }
$pass =$_POST['tpass'];
$login=$_POST['tuser'];
            
$user_info = new gstUtilisateur($active_db);


if(isset($_GET['action'])) {
    if($_GET['action']=="logout") {
           $user_info->Deconnexion(); 
           header('Location: index.php');
    }
}

      if($user_info->NbUtilisateurs()>0) {
         //  $user_info->Deconnexion();
              
           if($_SERVER['PHP_SELF']=="/first.php") {
            
              header('Location: index.php');
              
           }
                
        }



if($login!="" && $pass!="") {
  
     if ($user_info->Authentification($login,$pass)) {
      
        //User has login successfully

          header('Location: admin/index.php');
        
      } else {





       
        if($user_info->NbUtilisateurs()==0) {
         //  $user_info->Deconnexion();
              
           if($_SERVER['PHP_SELF']!="/first.php") {
            
              header('Location: first.php');
              
           }
                
        }




        // print_r($_SESSION);
      // header('Location: index.php?error=1');
      //  print "Erreur dauthentification";
        //display login page
        
      }


} else {


  
}
  
?>