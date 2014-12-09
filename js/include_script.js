include('request_url.js');
//----jquery-plagins----
include('jquery-1.8.3.min.js');
include('jquery.ba-resize.min.js');
include('jquery.easing.js');
include('jquery.color.js');
include('jquery.image_resize.js');
include('jquery.jqtransform.js');
include('../webext/jquery/jquery.mask.min.js');
include('../webext/jquery/jquery-ui.js');
include('../webext/jquery/jquery.ui.datepicker-fr.js');
//----bootstrap----
//----All-Scripts----
include('forms.js');
include('jquery.mobilemenu.js');
include('scroll_to_top.js');
include('ajax.js.switch.js');

include('script.js');
//----Include-Function----
function include(url){ 
  document.write('<script type="text/javascript" src="js/'+ url + '"></script>'); 
  return false ;
}