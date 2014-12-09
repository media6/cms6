<?

include('inc/init.php');



if(intval($_GET['id'])>0) {

  $query="select zfichier data from cms_photo where id=".intval($_GET['id']);
  	$lst_img = mysql_query($query,$active_db->DbObject());
   //print $active_db->DbObject();
}

  
  if (mysql_errno()!=0) { die; }
  while($img_fetcher = mysql_fetch_array($lst_img)) {
     print $img_fetcher["data"];
  }
  
    // Checking if the client is validating his cache and if it is current.
    if (isset($headers['If-Modified-Since']) && (strtotime($headers['If-Modified-Since']) == filemtime($fn))) {
        // Client's cache IS current, so we just respond '304 Not Modified'.
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($fn)).' GMT', true, 304);
    } else {
        // Image not cached or cache outdated, we respond '200 OK' and output the image.
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($fn)).' GMT', true, 200);
        header('Content-Length: '.filesize($fn));
        header('Content-Type: image/jpg');
        print file_get_contents($fn);
    }
    
    
    
      
  
  mysql_free_result($lst_img);
  
  
  
  
  
  
  
  
  
  
  


?>