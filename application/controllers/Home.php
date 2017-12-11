<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {


	public function index($seg1 = false,$seg2 = false , $seg3=false,$seg4=false)
	{		
		
		refreshDataUser();

		$pages= array(
				config_item("slug_login"),
				config_item("slug_logout"),
				config_item("slug_user"),
				config_item("slug_register"),
				config_item("slug_pages"),				
				config_item("slug_contact"),				
				config_item("slug_last"),				
				config_item("slug_filter"),				
				config_item("slug_subscriptions"),				
				config_item("slug_historical"),				
				config_item("slug_top")				
			);

		if(is_logged()){
			$bookmarks = $this->db->query("SELECT {PRE}sites.* from {PRE}sites,{PRE}bookmarks WHERE {PRE}bookmarks.iduser= "._user("id")." AND  {PRE}sites.id = {PRE}bookmarks.idsite order by {PRE}sites.id");
			$this->DATA['bookmarks'] = $bookmarks->result();
		}
		if(!$seg1)
		{
			$recent 				= $this->Admin->getTable("sites",array("completed" => 1),"updated desc",false,false,18);    
			 $this->DATA['recents'] 	= $recent->result();

			 if(config_item("show_top_tech") == '1')
			 {
				$limit = intval(config_item("limit_top"));
				$this->DATA['technologies'] = $this->db->query("SELECT count(name) as total,name,icon,tag1 FROM `{PRE}technologies` WHERE tag1 !='Compress' group by name,icon,tag1  order by total desc limit $limit")->result();
				$this->DATA['technologiesw'] = $this->db->query("SELECT count(name) as total,name,icon,tag1 FROM `{PRE}technologies` WHERE tag1 ='Web Servers' group by name,icon,tag1  order by total desc limit $limit")->result();			
				$this->DATA['technologiesf'] = $this->db->query("SELECT count(name) as total,name,icon,tag1 FROM `{PRE}technologies` WHERE tag1 ='Web Frameworks' group by name,icon,tag1  order by total desc limit $limit")->result();
			}



			 $action = "home";		
		}			
		else	
		{
			if(in_array($seg1, $pages))
				$action = $seg1;
			else
				$action = 'review';
		}

		switch ($action) {
			case  config_item("slug_logout"):	
				$action = 'logout';				
				$this->session->sess_destroy();	
				delete_cookie("ix");			 	
				redirect(base_url(),'location');				
				exit;
				break;						
			case  config_item("slug_register"):		
				$action = 'register';							
				if($this->input->get("v"))
				{
					$this->validateAccount($this->input->get("v"));		
				}		

				$this->DATA['SEO']["title"] 		= __("Register");
			 	$this->DATA['SEO']["description"]  	= __("Create a FREE account.");

				break;			
			case  config_item("slug_login"):			
				$this->DATA['SEO']["title"] 		= __("Login");
			 	$this->DATA['SEO']["description"]  	= __("Login into your account.");	
			 	$action = 'login';									
				if($this->input->get("r") == '1')
				{
					$this->DATA['SEO']["title"] 		= __("Recovery Password");
			 		$this->DATA['SEO']["description"]  	= __("Recovery Your Password");	
					$action = 'recovery';
				}		
				   	$this->load->library('user_agent');
    				$this->session->set_userdata('referrer_url', $this->agent->referrer() ); 					
				break;						

			case  config_item("slug_pages"):					
				$page = $this->Admin->getTable("pages",array("slug" => $seg2));
				if($page->num_rows() == 0)
				{
					show_404();
				}
				$this->DATA['page'] = $page->row();
				$recent 				= $this->Admin->getTable("sites",array("completed" => 1),"updated desc",false,false,7);    
				 $this->DATA['recents'] 	= $recent->result();

				$this->DATA['SEO']["title"] 		= $this->DATA['page']->title;
			 	$this->DATA['SEO']["description"]  	= more(strip_tags($this->DATA['page']->text),200);

				$action = 'page';
				break;			
			
			case  config_item("slug_last"):					
				
				$data 				= $this->Admin->getTable("sites",array("completed" => 1),"updated desc",false,false,18);    
				$this->DATA['list'] 	= $data->result();
				$this->DATA['SEO']["title"] 		= __("Latest Updated Sites");
				$this->DATA['title']				= __("Latest Updated Sites");
				$top 				= $this->Admin->getTable("sites",array("completed" => 1),"score desc",false,false,7);    
				$this->DATA['top'] 	= $top->result();

			 	

				$action = 'list';
				break;


			

			case  config_item("slug_top"):					
				
				$data 				= $this->Admin->getTable("sites",array("completed" => 1),"score desc",false,false,18);    
				$this->DATA['list'] 	= $data->result();
				$this->DATA['SEO']["title"] 		= __("Top Sites");
				$this->DATA['title']				= __("Top Sites");

				$recents 				= $this->Admin->getTable("sites",array("completed" => 1),"updated desc",false,false,7);    
				$this->DATA['recents'] 	= $recents->result();

			 	

				$action = 'list';
				break;	
			case  config_item("slug_subscriptions"):					
				
				if(!is_logged())
				{
					redirect(base_url().config_item("slug_login"),'location');	
					exit;
				}
				if(!isAvailablePlan())
				{
					redirect(base_url().config_item("slug_user"),'location');	
					exit;	
				}
				
				$this->DATA['SEO']["title"] 		= __("Subscriptions");
				$this->DATA['title']				= __("Subscriptions");

				
				$action = 'subscriptions';
				if(intval($this->input->get("select"))<=3 && intval($this->input->get("select"))>0)
				{
					$plan =intval($this->input->get("select"));
					$this->DATA['plan']['id'] = intval($this->input->get("select"));
					if($this->DATA['plan']['id'] == 0)
					{
						show_404();
						exit;
					}
					$this->DATA['plan']['name'] = config_item('paypal_p'.$plan.'_name');
					$this->DATA['plan']['price'] = config_item('paypal_p'.$plan.'_price_monthly');
					$this->DATA['plan']['cycle'] = 'M';
					$this->DATA['plan']['billing'] = array("M" => __("Monthly"),"Y" => __("Yearly"));
					if($this->input->get("y"))
					{
						$this->DATA['plan']['price'] = config_item('paypal_p'.$plan.'_price_yearly');
						$this->DATA['plan']['cycle'] = 'Y';
					}
					
					$action = 'pay';
				}
			 	

				
				break;		

			case  config_item("slug_historical"):					
				if(!is_logged())
				{
					redirect(base_url().config_item("slug_login"),'location');	
					exit;
				}
				if(!canSeeHistoricalData())
				{
					redirect(base_url().config_item("slug_subscriptions"),'location');

				}
				$this->DATA['SEO']["title"] 		= __("Historical Data");
				$this->DATA['title']				= __("Historical Data");




				$this->DATA['historicalData'] 			= $this->Admin->getTable("site_history",array("url" => $seg2),"created desc",false,0,50)->result();
				if(count($this->DATA['historicalData']) == 0)
				{
					show_404();
					exit;
				}
				
					$recents 				= $this->Admin->getTable("sites",array("completed" => 1),"updated desc",false,false,7);    
				$this->DATA['recents'] 	= $recents->result();
				
				
				
				$top 				= $this->Admin->getTable("sites",array("completed" => 1),"score desc",false,false,7);    
				$this->DATA['top'] 	= $top->result();

			 	

				$action = 'historical';
				break;	

			case  config_item("slug_filter"):	
						
				
				$seg2 = preg_replace('/^(.*)$/', '\L$1',$seg2);
				
				if($seg3 == '')
				{
					redirect(base_url(),'location');
					exit();
				}

				$filter = array("tag","ip","city","country","region","isp",config_item('slug_made_with'));
				if(!in_array($seg2, $filter))
				{

					show_404();
					die();
				}
				$page = intval($seg4);

				$limit = 13;
				if(intval($page)==0)
					$page = 1;	

				$offset = ($page - 1) * $limit;

				$currentPage = $page;



				$this->DATA['offset'] = $offset;
				$this->DATA['currentPage'] = $currentPage;
				$this->DATA['filter'] = $seg2;
				$this->DATA['search'] = _clean_string(urldecode($seg3));
			
				$seg2_text 	= __(urldecode($seg2));
				$seg3 		= urldecode($seg3);

				if($seg2 == config_item('slug_made_with'))
				{

					$seg3 = _clean_string(urldecode($seg3));
					$seg3 = urldecode($seg3);
					$seg2_text = __("Made With");
					$data 				= $this->db->query("SELECT {PRE}sites.*,{PRE}technologies.icon FROM {PRE}sites,{PRE}technologies WHERE {PRE}sites.url = {PRE}technologies.url AND {PRE}technologies.name = '$seg3' AND {PRE}sites.completed = 1 ORDER BY {PRE}sites.metaTitle ASC LIMIT $limit OFFSET $offset");    
					$this->DATA['list'] 	= $data->result();
					$this->DATA['title']		= __("Filter sites by ").__(ucfirst(preg_replace('/^(.*)$/', '\L$1',$seg2_text))).": <img  style='vertical-align: text-top ;height:40px;' src='".base_url()."assets/images/icons/".$this->DATA['list'][0]->icon."'> ".$seg3." - ".__("Page ").$seg4;

				}
				else
				{

					if($seg2 == 'ip' || $seg2 == 'tag')
					{
						
						if($seg2== 'tag')
						{
							$seg3 = addslashes(_clean_string(urldecode($seg3)));
							$seg3 = str_ireplace("-", "", $seg3);
							$field = "REPLACE({PRE}sites.metaKeywords,'-','')";
						}
						else
						{
							$field = "{PRE}sites.ip";
							$seg3 = _clean_ip(urldecode($seg3));
						}
						
						$data 				= $this->db->query("SELECT {PRE}sites.* FROM {PRE}sites WHERE  $field  LIKE '%$seg3%'  AND {PRE}sites.completed = 1 ORDER BY {PRE}sites.metaTitle ASC LIMIT $limit OFFSET $offset");    

					}
					else
					{
						
						
						$data 				= $this->Admin->getTable("sites",array("completed" => 1,$seg2 => urldecode($seg3)),"metaTitle asc",false,$offset,$limit);    
					}
					$this->DATA['list'] 	= $data->result();
					$this->DATA['title'] 		= __("Filter sites by ").__(ucfirst(preg_replace('/^(.*)$/', '\L$1',$seg2_text))).": ".$seg3." - ".__("Page ").$seg4;	

				}

				$this->DATA['SEO']["title"] 		= __("Filter sites by ").__(ucfirst(preg_replace('/^(.*)$/', '\L$1',$seg2_text))).": ".$seg3." - ".__("Page ").$seg4;		
				

				$recents 				= $this->Admin->getTable("sites",array("completed" => 1),"updated desc",false,false,7);    
				$this->DATA['recents'] 	= $recents->result();

				if(count($this->DATA['list'] ) == 0)
				{
					redirect(base_url(),'location',301);
					exit;
				}

				$action = 'list';
				break;			
		

			case  config_item("slug_contact"):					
					if($this->input->post())
					{
						if(validateCaptcha($this->input->post("g-recaptcha-response")))
            			{     
            				$subject 	 	= $this->input->post("subject");
            				$message 	 	= $this->input->post("message");
            				$names 	 		= $this->input->post("names");
            				$email 	 		= $this->input->post("email");
							$email_admin 	= get_email_admin();
							if($subject && $message && $names && $email)
							{
								$message2 = "<strong>Names:</strong><br>$names <br>";
								$message2 .= "<strong>Email:</strong><br>$email <br>";
								$message2 .= "<strong>Message:</strong><br>$message <br>";
								$message2 .= "<br><br>---- Contact Form";
								if(email($email_admin,$subject,$message2))
								{
									$this->session->set_flashdata('contact_message', __("Message Sent"));
				                	redirect(base_url().config_item("slug_contact"),'location');
				                	exit; 
				                }
							}

						}
						else
						{
							$this->session->set_flashdata('contact_error', __("Captcha Error"));
			                redirect(base_url().config_item("slug_contact"),'location');
			                exit;  
						}
					}
				$action = 'contact';									
				break;			
			
			
			case  config_item("slug_user"):	

			
				if(!is_logged())  
		        {            
		            redirect(base_url().config_item("slug_login"),'location');
		            exit;
		        }

		      if(is_demo() && ($this->input->post() || $this->input->get()))
              {
                  show_error("Not available in demo account",403);
                  exit();
              }


		        //$bookmarks = $this->db->query("SELECT {PRE}sites.* from {PRE}sites,{PRE}bookmarks WHERE {PRE}bookmarks.iduser= "._user("id")." AND {PRE}sites.id = {PRE}bookmarks.idsite ORDER BY score DESC");
				$this->DATA['page'] = $seg2;
				//$this->DATA['bookmarks'] = $bookmarks->result();
				$this->DATA['_SCRIPTS'] = '<!-- DataTables -->
											<link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/dataTables.bootstrap4.min.css">

											<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.1.1/css/responsive.dataTables.min.css">
											<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
											<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap4.min.js"></script>

											<script src="https://cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>';
				 if($this->input->post("names"))
				 {
				 	$this->Admin->updateTable("users",array("newsletter" => intval($this->input->post("newsletter")),"names" => _clean_special($this->input->post("names"))),array("id" => _user("id")));
				 } 

				 if($this->input->post("password"))
				 {
				 	$password   = $this->input->post("password",TRUE);
            		$password2  = $this->input->post("password-r",TRUE);
            		if($password == $password2)
	                {
	                    if(strlen($password) >=5)
	                    {
	                    	$this->Admin->updateTable("users",array("password" => sha1($this->input->post("password"))),array("id" => _user("id")));	
	                    }
	                    else
	                    {
	                    	$this->session->set_flashdata('update_error', __("The password length is very short, please add more than 5 characters"));                        	
	                    	$error = true;
	                    }
	                }
	                else
	                {
	                   	$this->session->set_flashdata('update_error', __("Password doesn't match"));                        	
	                	$error = true;
	                }

				 	
				 }

				if($this->input->post())
				{
					if(!$error)
					{
						$user       = $this->Admin->getTable("users",array("id" => _user("id")));                    
                    	$data_user = $user->row_array();
						$this->session->set_userdata("user",$data_user);
                    	$this->session->set_flashdata('update_message', __("Your account has been updated successfully"));
                    }
                	redirect(base_url().config_item("slug_user")."/".$seg2,'location');
                	exit;    
                }
                $action = 'user';
				break;			
			
			

			case  "review":		

				if(!canSeeHistoricalData() && $this->input->get("d"))
				{
					redirect(base_url().config_item("slug_subscriptions"),'location');
					exit;
				}



				$this->load->helper('seo');				
				 $site 					= $this->Admin->getTable("sites",array("url" => $seg1));
				 if($site->num_rows() == 0)
				 {
				 	$action 			= 'home';
				 	$this->DATA['scan_url'] 	= $seg1;
				 }
				 else
				 {

					 $site_data = $site->row();
					if(!$this->input->get("d"))
					{
						if($site_data->screenshot == 'assets/images/no-picture.jpg')
						{	

							$save['screenshot'] = getScreenshot($site_data->url);

							if($save['screenshot'] != 'assets/images/no-picture.jpg')
							{
								$this->Admin->updateTable("sites",$save,array("url" => $site_data->url));
								redirect(base_url().$site_data->url,'location');				
								exit();
							}
								
						}


						 if(intval($site_data->score) <=0)
						 {

						 	$action 			= 'home';
						 	$this->DATA['scan_url'] 	= $seg1;
						 	$this->Admin->updateTable("sites",array("score" => '0'),array("url" => $site_data->url));
						 	$site 					= $this->Admin->getTable("sites",array("url" =>$site_data->url));
						 	$site_data = $site->row();
						 }
					}



					if($this->input->get("d"))
					{
						$date = date("Y-m-d",strtotime(urldecode($this->input->get("d"))));
						$this->DATA['cached'] = $date;
						$site 	= $this->db->query("SELECT * FROM {PRE}site_history WHERE created between '".$date." 00:00:00' AND '".$date." 23:59:59' AND url='".$site_data->url."'")->row();
						$site_data = json_decode($site->data);
						$technologies = json_decode($site->technologies);

						$this->DATA['historicalData'] 			= $this->Admin->getTable("site_history",array("url" => $seg1),"created desc",false,0,5)->result();

					}
					else
					{
						$technologies 			= $this->Admin->getTable("technologies",array("url" => $seg1))->result(); 

					}
					 $score1				= $site_data->score-20;
					 $score2				= $site_data->score;
					
					 if(canSeeHistoricalData())  
					 {
					 		 $this->DATA['historicalData'] 			= $this->Admin->getTable("site_history",array("url" => $seg1),"created desc",false,0,5)->result();
					 }
					 	
					 
					if(!$this->input->get("d"))
					{
						 $recent 				= $this->Admin->getTable("sites",array("completed" => 1),"updated desc",false,false,7)->result();    
						 $similar 				= $this->db->query("SELECT * FROM {PRE}sites WHERE score BETWEEN $score1 AND $score2 AND completed = 1 ORDER BY score DESC LIMIT 7")->result();    
						 $this->DATA['top']['technologies'] = $this->db->query("SELECT count(name) as total,name,icon,tag1 FROM `{PRE}technologies` WHERE tag1 !='Compress' group by name,icon,tag1  order by total desc limit 10")->result();
					}

					if(!$site_data)
					{
						show_404();
						exit;
					}
					 	
					 

					 $this->DATA['SEO']["title"] 		= ucfirst(preg_replace('/^(.*)$/', '\L$1',$site_data->url))." ".__("- SEO Checker - Website Review");
					 $this->DATA['SEO']["description"]  = ucfirst(preg_replace('/^(.*)$/', '\L$1',$site_data->url))." ".__(" - Website Review, SEO, Estimation Traffic and Earnings And Speed And Optimization Tips ");
					 $this->DATA['site'] 		= $site_data;
					 $this->DATA['recents'] 	= $recent;
					 $this->DATA['shortcut'] = true;
					 $this->DATA['_SCRIPTS'] = '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jqvmap.css" /> 
					 							<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jquery.vmap.min.js"  ></script>
    											<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/maps/jquery.vmap.world.js"  ></script> ';
					 $this->DATA['similar'] 	= $similar;
					 $this->DATA['technologies'] 	= $technologies;
			 			

				}

			default:
				# code...
				break;
		}
		if(!$this->DATA['SEO']["title"])
			$this->DATA['SEO']["title"] 		= config_item("site_title");

		if(!$this->DATA['SEO']["description"])
			$this->DATA['SEO']["description"] 		= config_item("site_description");

		$pages = $this->Admin->getTable("pages",false,"title");
		$this->DATA['pages'] = $pages->result();
		$this->DATA['totalSites'] 		= $this->Admin->getCountTable("sites");
		$this->show($action);

	}

	
}
