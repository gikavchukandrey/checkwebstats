<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Background extends MY_Controller {
	
	public function process()
	{		
		set_time_limit(0);
		if(!$this->input->is_cli_request())
		{
			if($this->input->get("secret") != config_item("secret_bash"))
		    { 	    
		     	show_error("Secret key not valid",403);
		       exit;
		    }
		}

	    $log["groupid"] = 'process';
	
	    
	    
			$domain 	= $this->Admin->getTable("sites",array("completed" => 0),"registered DESC",'url,id',0,intval(config_item("process_limit")))->result();	
			$process 	= PR_getProcess();
			
			
		    $log["dateevent"] = date("Y-m-d H:i:s");
		    $log["log"] = "Start process (".number_format(count($domain))." Records)";
		    $log["level"] 	= 'success';
		    $this->record_log($log);

			foreach ($domain as $key => $value) {
				$this->Admin->deleteTable("sites",array("id" => $value->id));
				$response = PR_validateDomain($value->url,$process);
				$db_error = $this->db->error();
			
				if($db_error['message'])
				{
					$log["dateevent"] = date("Y-m-d H:i:s");
		    		$log["log"] = $db_error['message'];
		    		$log["level"] 	= 'error';
		    		$this->record_log($log);		
				}else
				{
					if($response['error'])
					{
						$log["dateevent"] = date("Y-m-d H:i:s");
			    		$log["log"] =$response['error'];
			    		$log["level"] 	= 'error';
			    		$this->record_log($log);		
					
					}else
					{
						
				    	$log["dateevent"] = date("Y-m-d H:i:s");
				    	$log["log"] = "Procesing ".$value->url;
				    	$log["level"] 	= 'success';
				    	$this->record_log($log);

						
						foreach ($process as $key2 => $pr) {
						
							$this->load->helper('seo');
							$response = PR_Process($pr['action'],$value->url);	
							
							if($response['error'])
							{
								$log["log"] = $value->url." -> ".$pr['title']." -> ".$response['error'];
								$log["level"] 	= 'error';
							}else
							{
								$log["log"] = $value->url." -> ".$pr['title']." -> ".$response['message'];
								$log["level"] 	= 'success';
							}

							
							$log["dateevent"] = date("Y-m-d H:i:s");
							$this->record_log($log);
						}
					}
				}
				//sleep(rand(1,5));
			}
		
	}


	public function update()
	{		

		set_time_limit(0);
		if(!$this->input->is_cli_request())
		{
			if($this->input->get("secret") != config_item("secret_bash"))
		    { 	    
		     	show_error("Secret key not valid",403);
		       exit;
		    }
		}
	    	$log["groupid"] = 'process';
	
	    
	    
			$domain 	= $this->db->query("SELECT * FROM {PRE}sites WHERE completed=1 AND updated < NOW() - INTERVAL 1 MONTH order by updated ASC limit ".intval(config_item("update_limit")))->result();	
			$process 	= PR_getProcess();
			
			
		    $log["dateevent"] = date("Y-m-d H:i:s");
		    $log["log"] = "Start update  (".number_format(count($domain))." Records)";
		    $log["level"] 	= 'success';
		    $this->record_log($log);

			foreach ($domain as $key => $value) {
				$this->Admin->deleteTable("sites",array("id" => $value->id));
				$response = PR_validateDomain($value->url,$process);
				$db_error = $this->db->error();
			
				if($db_error['message'])
				{
					$log["dateevent"] = date("Y-m-d H:i:s");
		    		$log["log"] = $db_error['message'];
		    		$log["level"] 	= 'error';
		    		$this->record_log($log);		
				}else
				{
					if($response['error'])
					{
						$log["dateevent"] = date("Y-m-d H:i:s");
			    		$log["log"] =$response['error'];
			    		$log["level"] 	= 'error';
			    		$this->record_log($log);		
					
					}else
					{
						
				    	$log["dateevent"] = date("Y-m-d H:i:s");
				    	$log["log"] = "Procesing ".$value->url;
				    	$log["level"] 	= 'success';
				    	$this->record_log($log);

						
						foreach ($process as $key2 => $pr) {
						
							$this->load->helper('seo');
							$response = PR_Process($pr['action'],$value->url);	
							
							if($response['error'])
							{
								$log["log"] = $value->url." -> ".$pr['title']." -> ".$response['error'];
								$log["level"] 	= 'error';
							}else
							{
								$log["log"] = $value->url." -> ".$pr['title']." -> ".$response['message'];
								$log["level"] 	= 'success';
							}

							
							$log["dateevent"] = date("Y-m-d H:i:s");
							$this->record_log($log);
						}
					}
				}
				//sleep(rand(1,5));
			}
		
	}


	


	public function report()
	{
		set_time_limit(0);
		if(!$this->input->is_cli_request())
		{
			if($this->input->get("secret") != config_item("secret_bash"))
		    { 	    
		     	show_error("Secret key not valid",403);
		       exit;
		    }
		}
	
		 $log["groupid"] = 'report';
		$bookmarks = $this->db->query("SELECT {PRE}sites.url,{PRE}sites.updated,{PRE}users.* from {PRE}users,{PRE}sites,{PRE}bookmarks WHERE {PRE}users.newsletter = TRUE AND {PRE}bookmarks.iduser= {PRE}users.id AND {PRE}sites.id = {PRE}bookmarks.idsite ORDER BY iduser,score DESC")->result();
		$log["dateevent"] = date("Y-m-d H:i:s");
	    $log["log"] = "Start process (".number_format(count($bookmarks))." Bookmarks)";
	    $log["level"] 	= 'success';
	 	foreach ($bookmarks as $key => $value) 
	 	{	 		

	 		
	 		$current_user 	= $value->id;
	 		$lang_user 		= $value->lang;	 	
		 	$lang_obj   	= $this->settings->get_lang($lang_user);
		    foreach ($lang_obj->result() as $row) 
		    {   
		     	$lang[$row->code] = $row->translation;
		    }	    
		    $this->config->set_item('translation', $lang); 

		    $process 	= PR_getProcess();

		    echo "\n";
			echo "\n".$value->url;

			$updated = date("Y-m-d",strtotime($value->updated));
			
			if($updated != date("Y-m-d"))
			{
			    foreach ($process as $key2 => $pr) {
					echo "\n".date("Y-m-d H:i:s")."\t".$pr['title'];
					$this->load->helper('seo');
					$response = PR_Process($pr['action'],$value->url);		
					if($response['error'])
					{
						$log["log"] = $value->url." -> ".$pr['title']." -> ".$response['error'];
						$log["level"] 	= 'error';
					}else
					{
						$log["log"] = $value->url." -> ".$pr['title']." -> ".$response['message'];
						$log["level"] 	= 'success';
					}

					
					$log["dateevent"] = date("Y-m-d H:i:s");
					$this->record_log($log);

				}
			}
			$data['sites'][$value->id]['user'] = $value;
			$data['sites'][$value->id]['site'][] = $this->Admin->getTable("sites",array("url" => $value->url))->row();

		
								


		}

		//print_p($data);
		foreach ($data['sites'] as $key => $value) {
	
	 			//print_p($value);
	 			
	 			if(count($value['site'])>0)
	 			{
	 				$log["dateevent"] = date("Y-m-d H:i:s");
	    			$log["log"] = number_format(count($value['site']))." Sites -> Email To: ".$value['user']->email;
	    			$log["level"] 	= 'success';
	    			$this->record_log($log);
	 				
					$report = $this->load->view("emails/reports/".config_item("template_report"), $value, true);	
	 				email($value['user']->email,__("Your site report is ready!"),$report);
	 			}
	 			unset($data['sites'][$key]);
	 			
	 		}
	
	}

	protected function record_log($data)
	{
		echo "\n";
		echo $data['groupid']."\t".$data['dateevent'];
		echo "\n";
		echo "[".mb_strtoupper($data['level'])."] ".$data['log'];
		echo "\n";
		if(intval(config_item("process_log")) == 2)
		{
			return false;
		}
		$domain 	= $this->Admin->setTable("logs",$data);

	}
}