<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sitemap extends MY_Controller {
 function __construct()
    {    
        parent::__construct();        
        header('Content-Type: application/xml; charset=utf-8');
        $this->output->set_content_type('text/xml');
        $this->load->helper('file');
    }   

	public function index()
	{
		$page = intval($this->input->get("p"))-1;		


		if($page <= 0)	
			$page = 0;

		$offset = $page*30000;




		ini_set('memory_limit','128M');
		$this->_get_cache("sitemap-".($page+1).".xml.gz");					

		$data['sites']  	= $this->Admin->getTable("sites",array("completed" => 1),false,"url",$offset,30000);
		$data['pages']  	= $this->Admin->getTable("pages");			
		$file = $this->load->view("sitemap/sitemap",$data,true);
		$this->_set_cache("sitemap-".($page+1).".xml.gz",$file);
		echo $file;
	}




	protected function _get_cache($file)
	{	
		if(config_item("compress_sitemap") == '2')
			$file = str_ireplace(".gz", "", $file);

		$file_cache = "cache/sitemap/$file";
		if(file_exists($file_cache) && is_readable($file_cache))
		{		
			if (time()-filemtime($file_cache) > intval(config_item("rebuild_sitemap")) * 3600) {
			  // file older than 24 hours
				@unlink($file_cache);
			}		
			if(file_exists($file_cache))
			{
				/*header('Content-Type: application/xml; charset=utf-8');
				echo read_file($file_cache).$this->_set_benchmark();
				exit;*/
				redirect(base_url().$file_cache,301);
				die();
			}
			else
			{
				return false;
			}

		}
		return false;
	}

	protected function _set_cache($file,$xml)
	{	
		if(config_item("compress_sitemap") == '2')
			$file = str_ireplace(".gz", "", $file);
		

		
		if(!file_exists("cache/sitemap/"))
			mkdir("cache/sitemap/",0777,TRUE);
		if(!is_writable("cache/sitemap/"))
		{
			header('Content-Type: text/html; charset=utf-8');
			die("Please set permissions to folder cache/sitemap");
		}
		$file_cache = "cache/sitemap/$file";		

		if(config_item("compress_sitemap") == '1')
			$xml = gzencode($xml, 9);
		write_file($file_cache, $xml);


	}

	protected function _set_benchmark()
	{		
		return "<!-- Cache -->";
	}



}