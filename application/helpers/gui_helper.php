<?php

function get_ads($block,$class = '')
{
  if(is_logged() && config_item("hide_ads_registered") == '1')
    return false;
  $slot = substr($block, -1);
  if(config_item("ads_slot".$slot) == '')
    return false;
  $CI     =& get_instance();  
  return $CI->load->view('_common/ads/'.$block,array("class" => $class),true);

}

function get_social_icon($url,$type,$icon = '',$bg = '')
{
  if($icon == '')
    $icon = $type;  
  if($bg == '')
    $bg = $type;
  
  if($url)
    return '<a  target="_blank"  rel="nofollow" href="'.$url.'" class="btn azm-social azm-size-32  azm-'.$bg.' exclude external"><i class="fa fa-'.$icon.'"></i></a>';
}

function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function makeClickableLinks($s) {
  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" class="exclude external" target="_blank">$1</a>', $s);
}

function createRecomendationGoogle($sumary)
{
  foreach ($sumary->args as $key => $value) {
    if($value->type == 'INT_LITERAL')
      $sumary->format = str_ireplace("{{".$value->key."}}", $value->value, $sumary->format);
    if($value->type == 'HYPERLINK')
    {
      $sumary->format = str_ireplace("{{BEGIN_LINK}}", "<a rel='nofolow' target='_blank' href='".$value->value."'>", $sumary->format);
      $sumary->format = str_ireplace("{{END_LINK}}", "</a>", $sumary->format);
    }
  }
  return $sumary->format;
}
function converTypeToIcon($type)
{
    $icon['warning']  = 'zmdi-alert-triangle';
    $icon['error']    = 'zmdi-alert-polygon';
    $icon['success']  = 'zmdi-check';
    return $icon[$type];
}

function createRecomendation($type,$target,$ok,$error)
{
  if($type == $target)
    return $ok;
  return $error;
}

function avatar($img,$v=1)
{
  if($img == '')
    $img = base_url()."assets/images/default-avatar.gif";
  if(strpos($img, "http") === false)
    return base_url()."avatars/".$img."?v=".$v;
  return $img;
}


function getInput($data)
{
  $CI     =& get_instance();  
  if($data['type'] == 'numeric')
    $data['type'] = "number";  
  if($data['type'] == '')
    $data['type'] = "text";
  
  switch ($data['type']) {
    case 'textarea':
      $input = '<textarea class="form-control '.$data['class'].'" rows="5"  '.$data['attr'].' name="'.$data['var'].'" id="'.$data['var'].'">'.$data['value'].'</textarea>';
      break;    
   
    case 'select':      
      $temp = explode("|", $data['options']);
  
      foreach ($temp as $key => $value) 
      { 
        $lables     = explode(":", $value);
        $valuel     = $lables[0];
        if($lables[1] != '')
          $value = $lables[1];
        if($valuel == '')
          $valuel = $value;

         $selected = '';
         if($value == $data['value'])
           $selected = 'selected="selected"';
          if($value != '')
            $options .= "<option  $selected value='".$value."'>".$valuel."</option>";
      }
      
      $input = '<select class="form-control '.$data['class'].'" '.$data['attr'].' name="'.$data['var'].'" id="'.$data['var'].'">'.$options.'</select>';
      break; 

     case 'select-multiple':      
      $temp = explode("|", $data['options']);
  
      foreach ($temp as $key => $value) 
      { 
        $lables     = explode(":", $value);
        $valuel     = $lables[0];
        if($lables[1] != '')
          $value = $lables[1];
        if($valuel == '')
          $valuel = $value;

         $selected = '';
         $temp_values  = explode(",", $data['value']);
         if(in_array($value, $temp_values))
           $selected = 'selected="selected"';
          if($value != '')
            $options .= "<option  $selected value='".$value."'>".$valuel."</option>";
      }
      
      $input = '<select multiple="multiple" class="form-control '.$data['class'].'" '.$data['attr'].' name="'.$data['var'].'[]" id="'.$data['var'].'">'.$options.'</select>';
      break; 

    default:
      $input = '<input class="form-control '.$data['class'].'" type="'.$data['type'].'" '.$data['attr'].' name="'.$data['var'].'" id="'.$data['var'].'" value="'.$data['value'].'">';
      break;
  }
  $html ='<div class="form-group">
          <label for="'.$data['var'].'" class="col-sm-3 control-label">'.$data['label'].'</label>
          <div class="col-sm-9">
            '.$input.'
            <p class="help-block">'.$data['helper'].'</p>
          </div>
        </div>';
        return  $html;
}

function csrf()
{
  $CI       =& get_instance();
  $name     = $CI->security->get_csrf_token_name();
  $value    = $CI->security->get_csrf_hash();
  return "<input type='hidden' name='$name' value='$value'>";
}

function isBookmark($site)
{
   $CI       =& get_instance();
   $bookmark = $CI->Admin->getTable("bookmarks",array("idsite" => $site,"iduser" => _user("id")));
   if($bookmark->num_rows() ==1)
    return true;
  return false;

}

function show_register($id)
{
  if(is_logged())
  { 
    ?>
    <div class="register-user" id="<?php echo $id; ?>">
        <span><?php echo __("Only Premium Users"); ?></span>
        <h2><?php echo __("Upgrade your plan for see all features and reviews about this site"); ?></h2>
        <a href="<?php echo base_url(); ?><?php echo config_item("slug_subscriptions"); ?>"><?php echo __("Upgrade Plan"); ?></a>
    </div>
    <?php
  }
  else
  {
      ?>
    <div class="register-user" id="<?php echo $id; ?>">
        <span><?php echo __("Only Registered Users"); ?></span>
        <h2><?php echo __("Sign up for see all features and reviews about this site"); ?></h2>
        <a href="<?php echo base_url(); ?><?php echo config_item("slug_login"); ?>"><?php echo __("Login"); ?></a>
    </div>
    <?php
  }
}

function getScreenshot($url,$force=false)
{
  _log("Screenshot Start");
  $url      = strtolower($url);
  $remote   = config_item("api_screenshot");
  if(!$remote)
    $remote   = "http://free.pagepeeker.com/v2/thumbs.php?size=l&url={url}";
  $remote = str_ireplace("{url}", $url, $remote);

  if(config_item("download_screenshot") == '0')
  {
    _log("Screenshot End (No Download)");
    return "?remote=".urlencode($remote);
  }
  $folder   = "./uploads/screenshots/".substr(sha1($url),0,2)."/";
  $file     = sha1($url.$url).".png";
  if($force)
    unlink($folder.$file);
  if(file_exists($folder.$file))
  {    
    _log("Screenshot End (File Exists)");
    return "uploads/screenshots/".substr(sha1($url),0,2)."/".$file;
  }
  else
  {

    $ch = curl_init($remote);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    $type= curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
  
    if($type != 'image/gif')
    {
      @mkdir($folder,0777,TRUE);
      if (copy($remote, $folder.$file) ) 
      {
        _log("Screenshot End (Downloaded)");
        return "uploads/screenshots/".substr(sha1($url),0,2)."/".$file;
      }
    }    
  }
  _log("Screenshot End (No Found)");
  return "assets/images/no-picture.jpg";
}

function score2star($score)
{
  $star = ($score*5)/100;
  
    for($x=1;$x<=$star;$x++) {
        echo '<i class="zmdi zmdi-star"></i>';
    }
    if (strpos($star,'.')) {
        echo '<i class="zmdi zmdi-star-half"></i>';
        $x++;
    }
    while ($x<=5) {
        echo '<i class="zmdi zmdi-star-outline"></i>';
        $x++;
    }

}
function renderScreenshot($site,$mobile = false)
{
  if($mobile)
  {
    if($site->pagespeed_screenshot_m)
      return $site->pagespeed_screenshot_m;
    return '';
  }
  if($site->pagespeed_screenshot_d)
    return $site->pagespeed_screenshot_d;
  return base_url().$site->screenshot;
}


function getPlanName($plan)
{
  $planName = config_item('paypal_p'.$plan.'_name');
  if($plan ==1)
    return __("Free");
  if(!$planName)
    return __("Subscription #".$plan);
  return $planName;

}

function isAvailablePlan(){
  if(_user("plan") == 1)
  { 

    if(config_item('paypal_p'.(intval(_user("plan"))+1).'_enable') == 1)
      return true;
    
  }
  return false;
}

function canDownloadPdf(){
  
  if(config_item('paypal_p'._user("plan").'_pdf_repport') == 1)
    return true;
  return false;
}


function canSeeHistoricalData()
{
   if(config_item('paypal_p'._user("plan").'_historica_data') == 1)
    return true;
  return false;

 
}
function removeWatermark($type='small'){

  if(config_item('paypal_p'._user("plan").'_pdf_'.$type.'_wathermark') == 2)
    return true;
  return false;
}
?>