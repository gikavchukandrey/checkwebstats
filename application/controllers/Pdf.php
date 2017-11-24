<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf extends MY_Controller {

	
	public function generate($domain)
	{

		
		if(!is_logged())
		{
			redirect(base_url().config_item("slug_login"),'location');
			exit;
		}else
		{
			if(!canDownloadPdf())
			{
				redirect(base_url().config_item("slug_subscriptions"),'location');
			}

			
		}
		
		$this->load->helper('seo');
	    
	    $this->load->library('pdfgenerator');
	   	
	   

	   	
	   	
	  		$site 					= $this->Admin->getTable("sites",array("completed" => 1,"url" =>$domain));
	  		$technologies 			= $this->Admin->getTable("technologies",array("url" => $domain));    

			$site_data = $site->row();
			if(!$site_data || !$this->input->post("pdf"))
				show_404();
			
			$save['site'] 		= $site_data;
			$save['technologies'] 	= $technologies->result();

			$save['document'] = $this->load->view('pdf/review', $save,true);;
	  		
	  		
			$this->pdfgenerator->generate($save['document'], $domain, TRUE,  'A4', "portrait");


	  	
			/*
		    if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

		    // get the file mime type using the file extension
		    $this->load->helper('file');


		    $mime = get_mime_by_extension($save['file_pdf']);

		    // Build the headers to push out the file properly.
		    header('Pragma: public');     // required
		    header('Expires: 0');         // no cache
		    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		    header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($save['file_pdf'])).' GMT');
		    header('Cache-Control: private',false);
		    header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
		 //   header('Content-Disposition: attachment; filename="'.basename($save['file_pdf']).'"');  // Add the file name
		 //   header('Content-Transfer-Encoding: binary');
		    header('Content-Length: '.filesize($save['file_pdf'])); // provide file size
		    header('Connection: close');
		    readfile($save['file_pdf']); // push it out
		  
	  
	   	
	   	
	   	 unlink($save['file_pdf']);
	   	   exit();*/
		
	}
}