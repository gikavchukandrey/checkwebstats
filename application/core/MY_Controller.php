<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
    public $DATA  = Array();
    public $_THEME  = '';
    public $_PANEL  = false;
    public $_is_home	= false;
	public function __construct()
    {
        
        parent::__construct();    

        if($this->input->get("remote"))
        {
          redirect(urldecode($this->input->get("remote")),'location');
          exit;
        }
        $this->load->helper('prorank');   
        $this->load->library('user_agent');  
    	 $this->load->database();    	
        $this->set_settings();  

        logginWithCookies();  	    	
        $only_offline = array(config_item('slug_login'),config_item('slug_register'));
          if(is_logged() && in_array($this->uri->segments[1], $only_offline))  
          {            
              redirect(base_url(),'location',302);
              exit;
          }
      
          if(strtolower($this->router->fetch_class() =='backend'))
          {
            
            if(!is_ajax())
            {
              show_404();
            }
          }
          $this->validate_update();
          if(strtolower($this->router->fetch_class() =='panel'))
          {

              if(is_demo() && ($this->input->post() || $this->input->get()) && !$this->input->get("sEcho"))
              {
                  show_error("Not available in demo account",403);
                  exit();
              }
             //$this->validate_update();
              if(!is_admin())
              {
                redirect(base_url()."login",'location');
              }
              else
              {
                  $this->generate_menu();
                  $this->_PANEL = true; 
                  $this->_THEME = "admin/";  

              }
              
          }

      
   	}

      public function debug_post(){

        foreach ($_GET as $key => $value) {
            $len = strlen($value);
            $value = more($value,100);
            log_message('debug', 'GET found  (lenght: '.$len.'): ' . $key . '  --> ' . $value);

        }

        foreach ($_POST as $key => $value) {
            $len = strlen($value);
            $value = more($value,100);
            log_message('debug', 'POST found  (lenght: '.$len.'): ' . $key . '  --> ' . $value);

        }
      }


   	protected function show($page)
   	{
        if(is_sadmin() && !is_demo())
            $this->output->enable_profiler(TRUE);
        
        if($this->_is_home)
   		     $this->DATA['SEO']['title']     =  _clean_string(config_item('site_title'));
         else
          $this->DATA['SEO']['title']      =  urldecode($this->DATA['SEO']['title']);
   		 
      foreach ($this->DATA['SEO'] as $key => $value) {
       $this->DATA['SEO'][$key]  = badWords($value);
      }
        
      if($this->input->is_ajax_request())
   		{ 
            if($this->agent->is_mobile() && file_exists(APPPATH."views/".$this->_THEME."pages/mobile/".$page.".php"))
            {             
                $this->load->view($this->_THEME."pages/mobile/".$page,$this->DATA);  
            }
            else
   			  $this->load->view($this->_THEME.$page,$this->DATA);	        
            
            $this->output->append_output($this->load->view('_common/ajax',$this->DATA,TRUE));
   		}
   		else
   		{
            if(!file_exists(APPPATH."views/".$this->_THEME."pages/$page.php"))
            {
                show_error("Error 404: ".$this->_THEME."pages/$page",404);
            }
        
            if($this->agent->is_mobile() && file_exists(APPPATH."views/".$this->_THEME."pages/mobile/".$page.".php"))
            {             
                $this->DATA["_PAGE"] = $this->load->view($this->_THEME."pages/mobile/".$page,$this->DATA,true);  
            }
            else
                $this->DATA["_PAGE"] = $this->load->view($this->_THEME."pages/$page",$this->DATA,true);  
   			$this->DATA["page"] = $page;	
            $this->generate_template();
   			$this->load->view($this->_THEME.'template',$this->DATA);	       

   		}
   		
   	}
  protected function generate_template()
	{
    
    if($this->_PANEL)
      return false;		
		$this->DATA['_SIDEBAR'] = $this->load->view($this->custom_common('sidebar'),$this->DATA,TRUE);		
		$this->DATA['_NAVBAR'] 	= $this->load->view($this->custom_common('navbar'),$this->DATA,TRUE);
		$this->DATA['_FOOTER'] 	= $this->load->view($this->custom_common('footer'),$this->DATA,TRUE);
		$this->DATA['_MODALS'] 	= $this->load->view($this->custom_common('modals'),$this->DATA,TRUE);
	}
  protected function custom_common($view)
  {
    if(file_exists(APPPATH."views/".$this->_THEME.$view.".php"))
    {
        return $this->_THEME.$view;
    }
    else
    {
      return "_common/".$view;
    }
    
  }
	protected function set_settings()
	{

    
    

    
    // Compatiblity
    $version = phpversion();
    if(intval($version[0]) >= 7)
    {

      $this->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");    
    }

    
    $this->load->helper('cookie');
    if($this->input->get("lang"))
    {
      set_cookie("lang",$this->input->get("lang"),999999999);      
      redirect($_SERVER['HTTP_REFERER'], 'location'); 
    }


    


		$this->load->model("settings");
	   $settings         = $this->settings->get();

    foreach ($settings->result_array() as $row) 
    {   
       
      $this->config->set_item($row['var'], $row['value']);  
    }	
    if(is_logged())
    {
      $this->config->set_item("update_inverval",config_item("update_inverval_registered"));  
      
    }
    if(config_item('color_theme'))
    {
      $themes  				= $this->settings->themes(config_item('color_theme'));
  		$theme          = $themes->row_array();
      foreach ($theme as $key => $row) {
        $this->config->set_item($key, $row);  
      }
  		
  	}	

    $langs  = $this->db->query("
      SELECT {PRE}languages.* FROM 
      {PRE}languages,
      {PRE}translation
      WHERE
      {PRE}languages.code = {PRE}translation.code_lang
      GROUP BY {PRE}languages.name
      ORDER BY {PRE}languages.name
      ");    

     $this->config->set_item("langs",$langs->result_array());

    // Load Lang

    $lang_user = get_cookie("lang");

    if($lang_user == '' || $this->input->get("lang"))
    {
      $lang_user = config_item("default_lang");

      $temp_lang = getLang();
      if($this->input->get("lang"))

        $temp_lang = preg_replace('/^(.*)$/', '\L$1', $this->input->get("lang"));
      foreach ($langs->result_array() as $key => $value) {
        if($temp_lang == $value['code'])
          $lang_user = $temp_lang;
      }
      
    }

    set_cookie("lang",$lang_user,999999999);

    if(is_logged())
    {
      $this->Admin->updateTable("users",array("lang" => $lang_user),array("id" => _user("id")));
    }
    
    $lang_obj   = $this->settings->get_lang($lang_user);
    foreach ($lang_obj->result() as $row) 
    {   
      $lang[$row->code] = $row->translation;
    }
    
    $this->config->set_item('translation', $lang);  




   


      $config = Array(
            'protocol' => 'smtp',                         
            'smtp_crypto' => $this->config->item("smtp_crypto"),
            'smtp_host' =>$this->config->item("smtp_host"),
            'smtp_port' =>$this->config->item("smtp_port"),
            'smtp_user' => $this->config->item("smtp_user"), // change it to yours
            'smtp_pass' => $this->config->item("smtp_password"), // change it to yours
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE,
            'newline' => "\r\n"
      );
     $this->load->library('email',$config);  

    

	}
  protected function generate_menu()
  {
      $menus        = $this->Admin->getTable("admin_menus");
      $array        = array();
      foreach ($menus->result_array() as $key => $value) 
      {
        $value['idunique'] = $value['idunique'];
        if($value['idparent'] == '')
          $array[$value['idunique']] = $value;
        else
          $array[$value['idparent']]['submenu'][] = $value;

        $info_menu[$value['idunique']] = $value;
        
      }          
      $this->DATA['_MENU']  = $array;
      $this->DATA['_MENU_INFO']  = $info_menu;

  }
  protected function validate_update()
  {
      
      if(file_exists("update/update.sql"))
      {
        $MD5 = md5_file("update/update.sql");
        if($this->config->item("update_hash") != $MD5)
        {

          $this->db->query("UPDATE {PRE}settings SET value = '".base_url()."' WHERE var='domain';");                                              
          $version = explode(".",config_item("version"));          

          $sql  = file_get_contents("update/update.sql");
          $sqls   = explode(";\n",$sql);          
          foreach ($sqls as $key => $value) 
          {               
            if($value != '')
            {
              $this->db->query($value);                                           
            }           
          } 
          $this->db->query("UPDATE {PRE}settings SET value = '$MD5' WHERE var='update_hash';");                                   
          
        }
         
        
      }
     
  }

  protected function validateAccount($code)
  {
      $code = trim($code);
      $account = $this->Admin->getTable("users",array("validation" => $code));
      if($account->num_rows() == 1)
      {
          $user = $account->row_array();
          $this->Admin->updateTable("users",array("validation" => ""),array("validation" => $code));
          $this->session->set_flashdata('login_message', __("Your account has been successfully verified."));
          redirect(base_url().config_item("slug_login"),'location');
      }
      else
      {
          $this->session->set_flashdata('login_error', __("The verification link is not valid"));
          redirect(base_url().config_item("slug_login"),'location');
      }
  }
}
?>