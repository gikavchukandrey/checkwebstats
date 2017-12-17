<?php

function _curl($url,$post = false,$headers = false,$json = false,$put = false,$cert=false,$timeout = 20) {    
    $CI     =& get_instance();  
    
    $CI->load->library('user_agent');
   // $hash   = sha1($url);
   // 

    
    //_log("CURL: ".$url);
    $ch = curl_init(); 
    //curl_setopt($ch, CURLOPT_HEADER, 0);  
    curl_setopt($ch,CURLOPT_USERAGENT,getUserAgent());
    //curl_setopt($ch,CURLOPT_USERAGENT,"Opera/9.80 (J2ME/MIDP; Opera Mini/4.2.14912/870; U; id) Presto/2.4.15");
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);    
    curl_setopt($ch,CURLOPT_TIMEOUT, $timeout); 

    curl_setopt($ch,CURLOPT_ENCODING, ""); 
  
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);  


     
    curl_setopt($ch,CURLOPT_REFERER,base_url());  
    curl_setopt($ch, CURLOPT_MAX_RECV_SPEED_LARGE, 100000);
    
    $headers[] = 'Accept-Language: en';
   // @curl_setopt($ch,CURLOPT_MAX_RECV_SPEED_LARGE,256000);  
    if($post)
    {
        $fields_string  = "";
        if(is_array($post))
        {
            foreach($post as $key => $value)
            {
                $fields_string .= $key."=".$value."&";
            }
            $fields_string          =rtrim ($fields_string,'&');
        }
        else
        {
            $fields_string          = $post;   
        }
        curl_setopt($ch,CURLOPT_POST,count($post));
        if($json)
        {
            $headers[]              = 'Accept: application/json';           
            $headers[]              = 'Content-Type: application/json';         
            if(is_array($post))
                $fields_string = json_encode($post);
            curl_setopt($ch,CURLOPT_POST,1);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
    }
    if(strtolower(parse_url($url, PHP_URL_SCHEME)) == 'https')
    {
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        if($cert)
        {            
            curl_setopt($ch, CURLOPT_CAINFO, $cert); 
        }
    }
    if($CI->config->item("proxy") != '')
    {       
        curl_setopt($ch, CURLOPT_PROXY, $CI->config->item("proxy"));
    }
     if($headers)
    {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    if($put)
    {
        if($put === true)
            $put = "PUT";
         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $put);
        //curl_setopt($ch, CURLOPT_PUT, true);
    }

    curl_setopt($ch, CURLOPT_URL, $url); 
    $data = curl_exec($ch);
    curl_close($ch); 
     //_log("CURL END");
    return $data;
}

function img2base64($path)
{
    
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}
function ping($url,$timeout = 15)
{
   
    if(intval($timeout)<3)
        $timeout = 8;
    
    $CI     =& get_instance();  

    $headers[] = 'Accept-Language: en';
    
    $CI->load->library('user_agent');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch,CURLOPT_USERAGENT,getUserAgent());
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);    
    curl_setopt($ch,CURLOPT_TIMEOUT, $timeout); 
    curl_setopt($ch,CURLOPT_FOLLOWLOCATION,false); 
    //curl_setopt($ch,CURLOPT_MAXREDIRS,6); 
    curl_setopt($ch,CURLOPT_REFERER,base_url());  
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_MAX_RECV_SPEED_LARGE, 100000);

    curl_exec($ch);
    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);
    
    return $retcode;
    
}


function _curl_headers($url)
{
       $CI     =& get_instance();  
    
    $CI->load->library('user_agent');
   $curl = curl_init();

    $opts = array (
            CURLOPT_URL => $url,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => FALSE,
            CURLOPT_ENCODING => 'gzip',
            CURLOPT_HEADER => true,
            CURLOPT_NOBODY => true,
            CURLOPT_COOKIESESSION, true,
            CURLOPT_MAX_RECV_SPEED_LARGE => 100000,
            CURLOPT_USERAGENT => getUserAgent()
    );

    curl_setopt_array($curl, $opts);
    $return = curl_exec($curl);
    list($rawHeader, $response) = explode("\r\n\r\n", $return, 2);
    $cutHeaders = explode("\r\n", $rawHeader);
    $headers = array();
    foreach ($cutHeaders as $row)
    {
        $cutRow = explode(":", $row, 2);
        $headers[$cutRow[0]] = trim($cutRow[1]);
    }

    return implode("<br>",$cutHeaders);
}


function getUserAgent()
{
    $CI     =& get_instance();
    $CI->load->library('user_agent');
    if(config_item("ua"))
        return config_item("ua");
    return $CI->agent->browser().' '.$CI->agent->version();
}
function is_logged()
{
  
    $CI     =& get_instance();
    $user = $CI->session->userdata('user');
    if(intval($user['id'])>0)
        return true;
    return false;
}

function _user($field)
{
    $CI     =& get_instance();
    $user = $CI->session->userdata('user');
    return $user[$field];
}

function sendNotificationNewUser($name,$email)
{
    if(config_item("email_new_user") == '1')
    {
        $CI     =& get_instance();
        $ip = $CI->input->ip_address();
        $user = $name." - ".$email;
        $message2 = "New user registration on your site <br><br><strong>User: </strong>$user<br><strong>IP Address: </strong>$ip";
        email(get_email_admin(),__("New user registration"),$message2);
    }
}
function __($code)
{
    $CI     =& get_instance();
    $translation = config_item('translation');
    

    $label = $translation[sha1(strtolower($code))];    
    // Hack to save new labels
    if(get_cookie("lang") == 'en' && $label == '')
    {
        $CI->Admin->setTableIgnore("languages",array("name" => "English","code" => 'en'));
        $CI->Admin->setTableIgnore("translation",array("code" => sha1(strtolower($code)),"translation" => $code,"code_lang" => 'en'));
    }
    if($label)
        return $label;
    return $code;
}

function get_email_admin()
{
    $CI     =& get_instance();
    $data = $CI->Admin->getTable("users",array("is_admin" => "1"));
    $temp = $data->row();
    return $temp->email;

}
function get_session($field)
{
     $CI     =& get_instance();
    return $CI->session->userdata($field);
}
function is_admin()
{
   
    $CI     =& get_instance();    
    $user = $CI->session->userdata('user');
    if(intval($user['is_admin'])>0)
        return true;
    return false;
}
function is_demo()
{
   
    $CI     =& get_instance();    
    $user = $CI->session->userdata('user');
    if(intval($user['is_demo'])>0)
        return true;
    return false;
}

function echo_json($json)
{
    $CI     =& get_instance();   
    echo $CI->output->set_content_type('application/json')->set_output(json_encode($json));
}
function is_sadmin()
{   
    
    $CI     =& get_instance();    
    $user = $CI->session->userdata('user');
    if(intval($user['is_admin'])>0)
        return true;
    return false;
}
function is_ajax()
{
    $CI     =& get_instance();   
    return $CI->input->is_ajax_request();
}
function is_mobile()
{
    $CI     =& get_instance();   
    return $CI->agent->is_mobile();
}
function getUserID()
{
    $CI     =& get_instance();
    $user = $CI->session->userdata('user');
    return intval($user['id']);
}
function is_spotify()
{
    $CI     =& get_instance();    
    $user = $CI->session->userdata('user');
    if($user['spotify']['access_token'])
        return true;
    return false;
}
function tdrows($elements)
{
    $str = "";
    foreach ($elements as $element) {
        $str .= $element->nodeValue . "||||";
    }

    return $str;
}

function getCountryCode()
{
   
    $CI     =& get_instance();  
    if($CI->session->geoplugin_countryCode)
        return $CI->session->geoplugin_countryCode;
    $ip         = $CI->input->ip_address();
    $url = "http://www.geoplugin.net/json.gp?ip=$ip";
    $data = json_decode(_curl($url));
    $code = $data->geoplugin_countryCode;
    if($code != '')
        $CI->session->set_userdata('geoplugin_countryCode', $code);
    if($code == '')
        $code = 'us';
    return $code;

}

function getLang()
{

    $lang = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
    if($lang != '')
        return $lang;
    return config_item("default_lang");
}



function hex2rgba($color, $opacity = false) {
 
    $default = 'rgb(0,0,0)';
    
    //Return default if no color provided
    if(empty($color))
          return $default; 
 
    //Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}
function dslug($string)
{
    //$string = str_ireplace("-", "+", $string);
    //return urldecode($string);
    $string = urldecode($string);
    //$string = stripslashes($string);
    $string = addslashes($string);
    
    $string = str_ireplace("/", "-", $string);
    


    return $string;
}

function _ucwords($str)
{
    return mb_convert_case(strtolower($str), MB_CASE_TITLE, "UTF-8");
}
function _strtolower($str)
{
    return strtolower($str);
}

function _url_title($string,$remove=false)
{
    $string = strtolower($string, 'UTF-8');    
    if($remove)
    {
        $string = str_ireplace("'", "",$string);
    }
    $string = str_ireplace("'", "%27",$string);
    $string = str_ireplace('"', "",$string);
    $string = str_ireplace('(', " ",$string);
    $string = str_ireplace(')', " ",$string);
    $string = str_ireplace(',', " ",$string);
    $string = str_ireplace(" ", "-",$string);
    $string = str_ireplace("--", "-",$string);
    $string = str_ireplace("--", "-",$string);
    $string = str_ireplace("--", "-",$string);
    $string = str_ireplace("--", "-",$string);
    $string = str_ireplace("+", "-",$string);
    $string = str_ireplace('&', "and",$string);
    $string = str_ireplace('*', "",$string);
    return $string;
}
function _remove_acents($string) {
    $acents= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
    $l= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
    $string_ok = str_replace($acents, $l ,$string);
    return $string_ok;
}

function _clean_special($string) {
   

   return preg_replace('/[^a-zA-Z0-9ñÑ\s]/', '', _remove_acents($string));
}
function _clean_ip($string) {
   

   return preg_replace('/[^0-9.\s]/', '', $string);
}

function _clean_string($string)
{
    $string = str_ireplace("'", "",$string);
    $string = str_ireplace('"', " ",$string);                
    return $string;
}

function slug($string)
{    
    $string = normalize_name($string);
    return urlencode($string);
    return _url_title(convert_accented_characters($string));
}
function get_slug($slug)
{
    $CI     =& get_instance();     
    return $CI->config->item('slug_'.$slug);
}
function prepare($json)
{
    $json =  str_ireplace("</a","</span",str_ireplace("<a", "<span", $json));
    $json = str_ireplace("#text", "text", $json);
    return $json;
}
function mmss($seconds) {
  $t = round($seconds/1000);
  return sprintf('%02d:%02d', ($t/60%60), $t%60);
}
function _log($data)
{   
    $CI         =& get_instance(); 
    if($data == 'query' || $data=='db')
        $data = $CI->db->last_query();
    
    Console::log($data);
}


function _debug($msg)
{
    Console::log_memory();
    if(is_array($msg))
    {
        Console::log(date("H:i:s"));
        Console::log($msg);
    }
    else
        Console::log(date("H:i:s")." ".$msg);
}

function print_p($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function validate_picture($img)
{
    if($img == '')
    {
        $img = base_url()."assets/images/no-picture.png";
    }
    return $img;
}

function createFolder($folder)
{
    if(!file_exists($folder))
    {
        mkdir($folder);
    }
       
}
function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}
function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}

function uploadImage($folder,$file_name,$input,$resize = true,$overwrite = false)
{

       
        $CI     =& get_instance();          
        $config['upload_path']      = $folder;
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']         = return_bytes(ini_get('post_max_size'));              
        $config['overwrite']        = $overwrite;             
        $config['file_name']        = $file_name;
        $r  = array();
        $CI->load->library('upload', $config);

        if ( ! $CI->upload->do_upload($input))
        {               
            $r =  strip_tags($CI->upload->display_errors());      
            return array('error' =>  $r);
        }
        else
        {
            
            $r = $CI->upload->data();   
            if($resize)
            {  
                $config['image_library']    = 'gd2';
                $config['source_image']     = $config['upload_path']."/".$r['file_name'];
                $config['create_thumb']     = FALSE;
                $config['maintain_ratio']   = TRUE;
                $config['width']            = 600;
                $config['height']           = 600;            
                $CI->load->library('image_lib', $config);           
                if (!$CI->image_lib->resize())
                {
                        echo $CI->image_lib->display_errors();
                        die();
                }
            }
            return array("image" => $r['file_name']);            
        }
}
function days2h($days)
{   
    $result = array($days);

    $sub_struct_month = ($result[0] / 30) ;
    $sub_struct_month = floor($sub_struct_month); 
    $sub_struct_days = ($result[0] % 30); 
    $sub_struct = $sub_struct_month." ".__("months")." ".$sub_struct_days." ".__("days");

    return $sub_struct;
}
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function ago($time)
{
    
    $time = strtotime($time);
   $periods = array(("second"), ("minute"), ("hour"), ("day"), ("week"), ("month"), ("year"), ("decade"));
   $lengths = array("60","60","24","7","4.35","12","10");

   $now = time();

       $difference     = $now - $time;
       $tense         = "ago";

   for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
       $difference /= $lengths[$j];
   }

   $difference = round($difference);

   if($difference != 1) {
       $periods[$j].= "s";
   }
    $periods[$j] = __($periods[$j]);

   return "$difference ".__($periods[$j]);
}

function normalizer($cadena){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        $cadena = str_ireplace("-", " ", $cadena);        
        $cadena = ltrim($cadena);
        $cadena = rtrim($cadena);
        return utf8_encode($cadena);
}

function get_header_curl($url)
{

    $ch = curl_init($url); 
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,3); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 3); //timeout in seconds
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_HEADER,true);
    curl_setopt($ch, CURLOPT_MAX_RECV_SPEED_LARGE,100000);

    //curl_setopt($ch, CURLOPT_NOBODY, true);    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);     
    curl_setopt($ch, CURLOPT_USERAGENT,getUserAgent());

    curl_exec($ch);     

    return curl_getinfo($ch, CURLINFO_CONTENT_TYPE);                
}


function remote_file_exists($url)
{
     
    $ch = curl_init($url);
//    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,5); 
    curl_setopt($ch, CURLOPT_TIMEOUT, 5); //timeout in seconds
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_MAX_RECV_SPEED_LARGE, 100000);
    curl_exec($ch);
    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);   
  
    curl_close($ch);
    if($retcode > 400)
        return 0;
    return 1;
}
function isok($code)
{
    

    if(!$code)
        return array("error" => "Key Empty");
  

    $license = json_decode(_curl("http://key.nexxuz.com?key=$code"));    
    if(!$license->date)
        return array("error" => "Key No valid");      
     $return['created_at']      = $license->date;
     $return['product_name']    = "Nexxuz: Cloud Music Engine";
     $return['license']         = $license->type." <i>(IP Address Authorized: ".$license->ipserver.")</i>";
     $return['buyer']           = $license->buyer;      
    return $return;
}


function more($string,$len=100)
{    

    $string = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $string);
    $string = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $string);
    $string = strip_tags($string);
    $string = ltrim(rtrim($string));
    if(mb_strlen($string)<$len)
        return $string;
    return ltrim(mb_substr($string, 0,$len))."...";
}


function extractKeyWords($string) {
  


    $string = html_entity_decode($string);

 
    $string = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $string);    
    $string = preg_replace('#<style(.*?)>(.*?)</style>#is', '', $string);

    $string = str_ireplace("\n", " ", $string);
    preg_match("/<body[^>]*>(.*?)<\/body>/is", $string, $matches);
    $string = preg_replace('#<[^>]+>#', ' ',$matches[0]);
     
  $stopwords = array("these","after","that","have","this","then","como","with","from","will","your","you");

  $string = preg_replace('/[\pP]/u', ' ', trim(preg_replace('/\s\s+/iu', ' ', strtolower($string))));
  


  $matchWords = array_filter(explode(' ',$string) , function ($item) use ($stopwords) { return !($item == '' || in_array($item, $stopwords) || mb_strlen($item) <= 3 || is_numeric($item));});
  $wordCountArr = array_count_values($matchWords);  
  arsort($wordCountArr);
  return (array_slice($wordCountArr, 0, 10));
}



function br2nl($string)
{
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
}  

function email($to,$subject,$message)
{   

        $CI         =& get_instance();  
        //$CI->email->clear();
        $message = $CI->load->view("emails/template",array("message" => $message),TRUE);
        $CI->email->set_newline("\r\n");
        $CI->email->to($to);
        $CI->email->from(config_item("smtp_from"),config_item("site_title"));
        $CI->email->subject($subject);
        $CI->email->message($message);
        return $CI->email->send();

}

function normalize_name($str)
{
    $str = str_replace("&","And", $str);
    $remove = array("/","+","?","&","[","]");
    $str = str_replace($remove, " ",$str);
    return $str;
}
function set_https_url($url,$force = true)
{
    if($force)
        return str_ireplace("http://", "https://",$url);
    return $url;
}

function getDaysDiff($date_start,$date_end)
{
    $days   = (strtotime($date_start)-strtotime($date_end))/86400;
    $days   = abs($days); $days = floor($days);     
    return $days;
}
function is_valid_domain_name($url)
{

    return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) && (preg_match("#^http(s)?://[a-z0-9-_.]+\.[a-z]{2,4}#i", $url));
}

function getStringBetween($string,$start,$end) {
    
    $string = " " . $string;
    
    $ini = strpos($string, $start);
    
    if ($ini == 0) return "";
    
    $ini+= strlen($start);
    
    $len = strpos($string, $end, $ini) - $ini;
    
    return substr($string, $ini, $len);
    
}
function connect($host, $port, $timeOut = 2) {
    $fp = fsockopen($host, $port, $errno, $errstr, $timeOut);
    if ($fp) {        
        fclose($fp); // we know it's listening        
        return true;
    } else {
        fclose($fp); // we know it's listening        
        return false;
    }
}

function getMetaTags($str)
{
  $pattern = '
  ~<\s*meta\s

  # using lookahead to capture type to $1
    (?=[^>]*?
    \b(?:name|property|http-equiv)\s*=\s*
    (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
    ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
  )

  # capture content to $2
  [^>]*?\bcontent\s*=\s*
    (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
    ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
  [^>]*>

  ~ix';
  
  if(preg_match_all($pattern, $str, $out))
    return array_combine($out[1], $out[2]);
  return array();
}

function get_title($str){
  
  /*if(strlen($str)>0)
  {
   // $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
    preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
    
    return strip_tags($title[1]);
    }*/
    $str = strtoupper($str);
    if(!$str)
        return "";
    $doc = new DOMDocument();
   // @$doc->loadHTML($str);
     $doc->loadHTML(mb_convert_encoding($str, 'HTML-ENTITIES', 'UTF-8'));

    $nodes = $doc->getElementsByTagName('title');
    
    return $nodes->item(0)->nodeValue;

}
  

function getMeta($html,$tag)
{
   if($tag == 'title')
    {
        return get_title($html);
    }
    else
    {
        $meta = getMetaTags($html);
        foreach ($meta as $key => $value) {
             if(strtolower($key) == strtolower($tag))
             {
                return strip_tags($value);
             }
        }
    }
    return "";



}
function getTitle($html)
{
    preg_match("/<title>(.*)</title>/", $html, $title);
    if(count($title)) {
        return strip_tags($title[1]);
    } else {
        return false;
    }
}

function getDescription($html) {    
    $matches = array();    
    preg_match('/<meta.*?name=("|\')description("|\').*?content=("|\')(.*?)("|\')/i', $html, $matches);
    if (count($matches) > 4) {
        return trim($matches[4]);
    }    
    preg_match('/<meta.*?content=("|\')(.*?)("|\').*?name=("|\')description("|\')/i', $html, $matches);
    if (count($matches) > 2) {
        return trim($matches[2]);
    }    
    return null;
}

function colorCircle($val1,$val2)
{
    if($val1>$val2)
        return "#0ACC00";
    return "#F0AD4E";
}

function getColorPdf($val1,$val2)
{
    if($val1>$val2)
        return "#15A204";
    return "#EF3A06";
}



function validateLenghtPdf($str,$limit,$min =false)
{
    

    $response['color']  = "#15A204";
    $response['icon']   = "+";
    $response['fixed']  = $str;
    $response['lenght'] = mb_strlen($str);
    $response['fixed2'] = mb_substr($str, 0,$limit);

    if(mb_strlen($str)>$limit)
    {        
        $response['color']  = "#EF3A06";
        $response['icon']   = "×";
        $response['fixed']   = mb_substr($str, 0,$limit)."<s style='color:#EF3A06'>".mb_substr($str, $limit,mb_strlen($str))."</s>";
    }

    if($min)
    {

        if(mb_strlen($str)<$min)
        {        
            $response['color']  = "#EF3A06";
            $response['icon']   = "×";
            $response['fixed']   = mb_substr($str, 0,$limit)."<s style='color:#EF3A06'>".mb_substr($str, $limit,mb_strlen($str))."</s>";
        }

    }
    if(trim($str) =='')
    {        
        $response['fixed'] = "<s style=color:'#EF3A06'>".__("NO DATA")."</s>";
        $response['fixed2'] = "";
    }

    $response['fixed'] = ($response['fixed']);
    $response['fixed2'] = ($response['fixed2']);
    return $response;

}


function getIcon($val1,$val2)
{
    if($val1>$val2)
        return "zmdi-check";
    return "zmdi-alert-triangle";
}

function getIconPdf($val1,$val2)
{
    if($val1>$val2)
        return "+";
    return "×";
}

function getColor($val1,$val2)
{
    if($val1>$val2)
        return "text-success";
    return "text-warning";
}

function getColorProgress($val1,$val2)
{
    if($val1>$val2)
        return "progress-success";
    return "progress-warning";
}



function validateLenght($str,$limit,$min =false)
{
    

    $response['color']  = "text-success";
    $response['icon']   = "zmdi-check";
    $response['fixed']  = $str;
    $response['lenght'] = mb_strlen($str);
    $response['fixed2'] = mb_substr($str, 0,$limit);

    if(mb_strlen($str)>$limit)
    {        
        $response['color']  = "text-warning";
        $response['icon']   = "zmdi-alert-triangle";
        $response['fixed']   = mb_substr($str, 0,$limit)."<span class='text-danger text-underline'>".mb_substr($str, $limit,mb_strlen($str))."</span>";
    }

    if($min)
    {

        if(mb_strlen($str)<$min)
        {        
            $response['color']  = "text-warning";
            $response['icon']   = "zmdi-alert-triangle";
            $response['fixed']   = mb_substr($str, 0,$limit)."<span class='text-danger text-underline'>".mb_substr($str, $limit,mb_strlen($str))."</span>";
        }

    }
    if(trim($str) =='')
    {        
        $response['fixed'] = "<div class='alert alert-warning'>".__("NO DATA")."</div>";
        $response['fixed2'] = "";
    }

    $response['fixed'] = badWords($response['fixed']);
    $response['fixed2'] = badWords($response['fixed2']);
    return $response;

}

function getPor($val,$total)
{
    return intval(($val*100)/$total);
}
function sanitize_output($buffer) {

    $search = array(
        '/\>[^\S ]+/s',  // strip whitespaces after tags, except space
        '/[^\S ]+\</s',  // strip whitespaces before tags, except space
        '/(\s)+/s'       // shorten multiple whitespace sequences
    );

    $replace = array(
        '> ',
        ' <',
        '\\1'
    );

    $buffer = preg_replace($search, $replace, $buffer);

    return $buffer;
}

function getAllLinks($html,$domain,$limit=15)
{
    $doc = new DOMDocument();
    $doc->loadHTML($html);
    $elements = $doc->getElementsByTagName("a");
    $x=0;
    $exist = array();
    foreach($elements as $el) {                        
        $l = $el->getAttribute("href");
        
        $ltitle = strip_tags($el->getAttribute("title"));
        if(!$ltitle)
            $ltitle = strip_tags($el->nodeValue);
        $lrel = strip_tags($el->getAttribute("rel"));
        $l = fixLink($l);
        if(!isExternal($l,$domain) AND $l != '' AND strpos($l, "mailto:") === FALSE AND strpos($l, "tel:") === FALSE  AND strpos($l, "javascript:") === FALSE   AND strpos($l, "#") === FALSE &&  !$exist[$l])
        {
            
            $exist[$l] = 1;          
            
            if(mb_substr($l, 0,1) != '/' && strpos($l, "http") === FALSE)
                $l="/".$l;

           

            if(strpos($l, $domain) === FALSE)
                $l = $domain.$l;

             if(substr($l, 0,4) != 'http')
            {
                if(substr($l, 0,2) != '//')
                    $l = "://".$l;
                $l = "http".$l;
            }

            $link[] = array("link" => $l,"title" => $ltitle,"rel" => $lrel);        
            $x++;
            if($x>=$limit)
                break;    
        }
        
        
    }
    return $link;
}

function fixLink($link)
{
    if( substr($link, 0,2) == '//')
        return "http:".$link;
    return $link;
}
function isExternal($link,$domain)
{
    

    if(strpos($link, "http") !== FALSE)
    {
        if(strpos($link, $domain) !== FALSE)
            return false;
        return true;
    }
    return false;
}

function badWords($str)
{
    $str = strip_tags($str);
    $badWords = explode(",",(config_item("bad_words")));
    return str_ireplace($badWords, "---",($str));
}

function hasbadWords($str)
{
    $badWords = explode(",",config_item("bad_words"));
    foreach ($badWords as $key => $value) {
        if(mb_strpos($str, $value) !== FALSE)
            return true;
    }
    return false;
}



function base_url_lang()
{
    $CI     =& get_instance();  
    return base_url().$CI->lang."/";
}

function shortcode($content) {

    
    $pattern = '/\[(.*?)\]/';
    $regex = '/(\w+)\s*=\s*"(.*?)"/';
    $shorcode = array();

    preg_match_all($pattern, $content, $matches);   

    foreach ($matches[1] as $key => $value) {

        preg_match_all($regex, $value, $matches2);                  
        foreach ($matches2[1] as $key2 => $value2) {

            $shorcode[$key][$value2] = $matches2[2][$key2];
        }
        if($shorcode[$key]['type'])
            $shorcode[$key]['shortcode'] = $matches[0][$key];
        
    }
    return $shorcode;
}


function processKeyWords($array)
{
    
    $total = 0;
    foreach ($array as $key => $value) {
        $total = $total + $value;
    }

    foreach ($array as $key => $value) {
        $array[$key] = round(($value*100)/$total);
    }
    return $array;
}
function rip_tags($string) { 
    
    // ----- remove HTML TAGs ----- 
    $string = preg_replace ('/<[^>]*>/', ' ', $string); 
    
    // ----- remove control characters ----- 
    $string = str_replace("\r", '', $string);    // --- replace with empty space
    $string = str_replace("\n", ' ', $string);   // --- replace with space
    $string = str_replace("\t", ' ', $string);   // --- replace with space
    
    // ----- remove multiple spaces ----- 
    $string = trim(preg_replace('/ {2,}/', ' ', $string));
    
    return $string; 

}
function getTextBetweenTags($string, $tagname){
    $d = new DOMDocument();
    $d->loadHTML($string);
    $return = array();
    foreach($d->getElementsByTagName($tagname) as $item){
        $return[] = $item->textContent;
    }
    return $return;
}

function getIPInfo($ip)
{
    
    return json_decode(_curl("http://ip-api.com/json/$ip"));
}


/**
 * get_redirect_url()
 * Gets the address that the provided URL redirects to,
 * or FALSE if there's no redirect. 
 *
 * @param string $url
 * @return string
 */
function get_redirect_url($url){
    $redirect_url = null; 

    $url_parts = @parse_url($url);
    if (!$url_parts) return false;
    if (!isset($url_parts['host'])) return false; //can't process relative URLs
    if (!isset($url_parts['path'])) $url_parts['path'] = '/';

    $sock = fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80), $errno, $errstr, 30);
    if (!$sock) return false;

    $request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1\r\n"; 
    $request .= 'Host: ' . $url_parts['host'] . "\r\n"; 
    $request .= "Connection: Close\r\n\r\n"; 
    fwrite($sock, $request);
    $response = '';
    while(!feof($sock)) $response .= fread($sock, 8192);
    fclose($sock);

    if (preg_match('/^Location: (.+?)$/m', $response, $matches)){
        if ( substr($matches[1], 0, 1) == "/" )
            return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
        else
            return trim($matches[1]);

    } else {
        return false;
    }

}

/**
 * get_all_redirects()
 * Follows and collects all redirects, in order, for the given URL. 
 *
 * @param string $url
 * @return array
 */
function get_all_redirects($url){
    $redirects = array();
    while ($newurl = get_redirect_url($url)){
        if (in_array($newurl, $redirects)){
            break;
        }
        $redirects[] = $newurl;
        $url = $newurl;
    }
    return $redirects;
}

/**
 * get_final_url()
 * Gets the address that the URL ultimately leads to. 
 * Returns $url itself if it isn't a redirect.
 *
 * @param string $url
 * @return string
 */
function get_final_url($url){
    $redirects = get_all_redirects($url);
    if (count($redirects)>0){
        return array_pop($redirects);
    } else {
        return $url;
    }
}



function getEfectiveUrl($url, $curl_loops = 0)
{

    if(!ini_get('open_basedir'))
    {
       
        $ch = curl_init();      
        curl_setopt($ch, CURLOPT_URL, $url);   
        curl_setopt($ch,CURLOPT_USERAGENT,getUserAgent());
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1); 
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);
        if($info['url'])      
            return $info['url'];
        else
            return $url;    
    }
    
        return get_final_url($url);

    if( $curl_loops >4)
        return $url;

    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, false);
    curl_setopt($ch,CURLOPT_USERAGENT,getUserAgent());
    $data = curl_exec($ch);
 
  
    list($header, $data) = explode("\n\n", $data, 2);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    
      
    if ($http_code == 301 || $http_code == 302 || $http_code == 307)
    {
            $matches = array();
            preg_match('/Location:(.*?)\n/', $header, $matches);
            $url = @parse_url(trim(array_pop($matches)));
            
            if (!$url)
            {
                //couldn't process the url to redirect to
                $curl_loops = 0;
                return false;
            }
            
            $last_url = parse_url(curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
            
            $curl_loops++;
            if (!$url['scheme'])
                $url['scheme'] = $last_url['scheme'];
            if (!$url['host'])
                $url['host'] = $last_url['host'];
            if (!$url['path'])
                $url['path'] = $last_url['path'];
            
            if(substr($url_temp, -1) != "/")
                $url_temp = $url_temp."/";
             if(substr($url['path'], -1) == "/")
                $url['path'] = substr($url['path'],0,-1);
             if(! $url['host'])
                $new_url = $url_temp . $url['path'] . ($url['query']?'?'.$url['query']:'');
            else
                $new_url = $url['scheme'] . '://' . $url['host'] . $url['path'] . ($url['query']?'?'.$url['query']:'');
            
           
            
            return getEfectiveUrl($new_url, $curl_loops);
    } else {
        $curl_loops=0;
        return $url;
    }
    

}


function redirect2refer()
{
    $CI     =& get_instance();  
    if( $CI->session->userdata('referrer_url') ) {
        //Store in a variable so that can unset the session
        $redirect_back = $CI->session->userdata('referrer_url');
        if(strpos($redirect_back, base_url()) === false)
        {
            $redirect_back= base_url();
        }
        $CI->session->unset_userdata('referrer_url');
        redirect( $redirect_back ,'location');
        exit;
    }else
    {
        redirect(base_url() ,'location');
        exit;
    }
}
function getCharset($html)
{
    $r = "/charset=\"(.+?)\"/";    
    preg_match($r,$html,$charset_a);
    if($charset_a[1])
        $charset = $charset_a[1];
    else
    {
        $r = '@content="([\\w/]+)(;\\s+charset=([^\\s"]+))?@i';
        preg_match($r,$html,$charset_a);
        
        if($charset_a[3])
            $charset = $charset_a[3];
    }
    return $charset;
}

function strBytes($str){
 // STRINGS ARE EXPECTED TO BE IN ASCII OR UTF-8 FORMAT
 
 // Number of characters in string
 $strlen_var = strlen($str);
 
 // string bytes counter
 $d = 0;
 
 /*
 * Iterate over every character in the string,
 * escaping with a slash or encoding to UTF-8 where necessary
 */
 for($c = 0; $c < $strlen_var; ++$c){
  $ord_var_c = ord($str{$c});
  switch(true){
  case(($ord_var_c >= 0x20) && ($ord_var_c <= 0x7F)):
   // characters U-00000000 - U-0000007F (same as ASCII)
   $d++;
   break;
  case(($ord_var_c & 0xE0) == 0xC0):
   // characters U-00000080 - U-000007FF, mask 110XXXXX
   $d+=2;
   break;
  case(($ord_var_c & 0xF0) == 0xE0):
   // characters U-00000800 - U-0000FFFF, mask 1110XXXX
   $d+=3;
   break;
  case(($ord_var_c & 0xF8) == 0xF0):
   // characters U-00010000 - U-001FFFFF, mask 11110XXX
   $d+=4;
   break;
  case(($ord_var_c & 0xFC) == 0xF8):
   // characters U-00200000 - U-03FFFFFF, mask 111110XX
   $d+=5;
   break;
  case(($ord_var_c & 0xFE) == 0xFC):
   // characters U-04000000 - U-7FFFFFFF, mask 1111110X
   $d+=6;
   break;
   default:
   $d++;
  };
 };
 return $d;
}