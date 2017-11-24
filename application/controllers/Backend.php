<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends MY_Controller {

		
	public function validate()
	{



		if(config_item("only_registered") == 1 && !is_logged())
		{
			unset($json['process']);
			
			$json['redirect'] 	= base_url().config_item("slug_login");
			$json['error'] 		= __("Only registered user, can use this feature");
			
		}else
		{




				$process = PR_getProcess();

				



				$url 	= $this->input->post("url");
				$json 	= PR_validateDomain($url,$process);
				
				/*if(!$json['error'])
				{
					$site 			= $exist->row();
					$days			= getDaysDiff($site->updated,date("Y-m-d H:i:s"));
					$json['days'] 	= $days;
					if(intval($days) < intval(config_item("update_inverval")))
					{
						unset($json['process']);
						$json['error'] = str_ireplace("$day$",config_item("update_inverval"),__("You can update only every $day$ days"));
					}
				}*/

	

		}
		

		echo_json($json);
	}

	public function process()
	{	

		sleep(rand(1,2));

		$this->load->helper('seo');
		$json['ok'] 	= true;
		$action 		= $this->input->post("action");
		$domain 		= $this->input->post("domain");
		
		$json['procees'] = PR_Process($action,$domain);		
		
		if(!$json['procees'])
			$json = array("error" => __("Response empty"));

		/*if(!ping($domain_curl))
			return false;*/

		
		

		echo_json($json);
	}

	public function bookmark()
	{
		if(is_logged())
		{
			$action = intval($this->input->post("action",true));
			
			if($action == '2')
			{
				$bookmarks = $this->db->query("SELECT {PRE}sites.* from {PRE}sites,{PRE}bookmarks WHERE {PRE}bookmarks.iduser= "._user("id")." AND  {PRE}sites.id = {PRE}bookmarks.idsite order by {PRE}sites.id");
				$this->DATA['bookmarks'] = $bookmarks->result();
				if(count($this->DATA['bookmarks'])>=config_item('paypal_p'._user("plan").'_bookmark_limit'))
				{
					$messages = array("title" => __("Bookmark Error"),"error" => __("Bookmarks quota exceeded for your account"));						
					echo_json($messages);
					return false;
				}
			}

			$idsite 	= intval($this->input->post("idsite",true));
			
			$site 	=  $this->Admin->getTable("sites",array("id" => $idsite));
			if($site->num_rows() == 1)
			{
				// Add
				if($action == '2')
				{
					$this->Admin->setTable("bookmarks",array("iduser" => _user("id"),"idsite" => $idsite));
				}

				// Remove
				if($action == '1')
				{
					$this->Admin->deleteTable("bookmarks",array("iduser" => _user("id"),"idsite" => $idsite));	
				}
				echo_json(array("success" => '1'));

			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_404();
		}
	}

	public function api()
	{
		echo "a";
		echo $this->agent->referrer();
	}


	
}
