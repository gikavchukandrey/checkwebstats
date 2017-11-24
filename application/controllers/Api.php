<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends MY_Controller {

		


	public function get()
	{
		if(!config_item("chromeappid"))
		{
			show_404();
			return false;
		}
		$origin = $this->input->get_request_header("Origin",true);
		if(!$origin)
		{
			$origin = "chrome-extension://".config_item("chromeappid");
		}
		$domain = PR_validateDomain($this->input->get("domain",true));
		if(($origin == "chrome-extension://".config_item("chromeappid") && !$domain['error']))
		{
			
			$site 	=  $this->Admin->getTable("sites",array("url" => $domain['domain']));
			$site_t 	= $this->Admin->getTable("technologies",array("url" => $domain['domain']));

			$json = $site->row_array();
			$json['technologies'] = $site_t->result_array();
			unset($json['body']);
			unset($json['pagespeed_screenshot_m']);
			echo_json($json);
		}else
		{
			if(!$domain['error'])
			{
				$json['error'] = "Request not allowed";
				
			}
			else
			{
				$json['error'] = $domain['error'];
			}
			echo_json($json);
		}
	}


	
}
