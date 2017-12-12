<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panel extends MY_Controller {
	

	public function index()
	{
		show_404();

	}

	public function dashboard()
	{
		$this->DATA['menu'] 	= 'dashboard';	
		$this->DATA['title'] 	= 'Dashboard';	
		
		
			

		$limit = intval(config_item("limit_top"));
		
		$this->DATA['users'] 		= $this->Admin->getCountTable("users");
		$this->DATA['bookmarks'] 	= $this->Admin->getCountTable("bookmarks");
		$this->DATA['sites'] 		= $this->Admin->getCountTable("sites");
		$this->DATA['completed'] 	= $this->Admin->getCountTable("sites",array("completed" => '0'));
		$this->DATA['technologies'] = $this->db->query("SELECT count(name) as total,name,icon,tag1 FROM `{PRE}technologies` WHERE tag1 !='Compress' group by name,icon,tag1  order by total desc limit $limit");
		$this->DATA['technologiesw'] = $this->db->query("SELECT count(name) as total,name,icon,tag1 FROM `{PRE}technologies` WHERE tag1 ='Web Servers' group by name,icon,tag1  order by total desc limit $limit");
		$this->DATA['technologiespl'] = $this->db->query("SELECT count(name) as total,name,icon,tag1 FROM `{PRE}technologies` WHERE tag1 ='Programming Languages' group by name,icon,tag1  order by total desc limit $limit");
		$this->DATA['technologiesf'] = $this->db->query("SELECT count(name) as total,name,icon,tag1 FROM `{PRE}technologies` WHERE tag1 ='Web Frameworks' group by name,icon,tag1  order by total desc limit $limit");
		$this->DATA['isp'] 			= $this->db->query("SELECT count(isp) as total,isp,country FROM `{PRE}sites` WHERE completed ='1' and isp != '' group by isp,country  order by total desc limit $limit");
		$this->DATA['topsites'] 	= $this->db->query("SELECT metaTitle,url FROM `{PRE}sites` WHERE completed ='1' order by score desc limit $limit");
		$this->DATA['topsitesAMP'] 	= $this->db->query("SELECT metaTitle,url FROM `{PRE}sites` WHERE completed ='1' and hasAMP=1 order by score desc limit $limit");
		$this->DATA['topsitespsd'] 	= $this->db->query("SELECT metaTitle,url,pagespeed FROM `{PRE}sites` WHERE completed ='1' order by pagespeed desc limit $limit");
		$this->DATA['topsitespsm'] 	= $this->db->query("SELECT metaTitle,url,pagespeed_mobile FROM `{PRE}sites` WHERE completed ='1' order by pagespeed_mobile desc limit $limit");
		$this->DATA['topsitesal'] 	= $this->db->query("SELECT metaTitle,url,alexaGlobal FROM `{PRE}sites` WHERE completed ='1' order by alexaGlobal asc limit $limit");
		
		if(is_demo())
		{
			$this->DATA['earnt'] =  json_decode(json_encode(array("total" => ((intval(date("y"))/100)+intval(date("H"))))));	
			$this->DATA['earnm'] =  json_decode(json_encode(array("total" => intval($this->DATA['earnt']->total)*intval(date("d")))));
			$this->DATA['earny'] =  json_decode(json_encode(array("total" => intval($this->DATA['earnt']->total)*intval(date("d"))+421.7)));

		}
		else
		{
			$this->DATA['earnt'] 	= $this->db->query("select sum(mc_gross) as total from {PRE}paypal_log  where txn_type='subscr_payment' AND created between '".date("Y-m-d")." 00:00:00' and '".date("Y-m-d")." 23:59:59'")->row();
			$this->DATA['earnm'] 	= $this->db->query("select sum(mc_gross) as total from {PRE}paypal_log  where txn_type='subscr_payment' AND created between '".date("Y-m")."-01 00:00:00' and '".date("Y-m-d")." 23:59:59'")->row();
			$this->DATA['earny'] 	= $this->db->query("select sum(mc_gross) as total from {PRE}paypal_log  where txn_type='subscr_payment' AND created between '".date("Y")."-01-01 00:00:00' and '".date("Y-m-d")." 23:59:59'")->row();
		}
		
		
		$this->DATA['registered'] 	= $this->Admin->getRegisteredUsersByMonth();
		
		$this->show("dashboard");
	}	


	public function externalservices()
	{

		if(!is_sadmin())
			show_404();
		if($this->input->post())
		{
			$this->save_settings();
			redirect(base_url()."admin/externalservices");
		}

		$this->DATA['menu'] 	= 'externalservices';	
		$this->DATA['title'] 	= 'External Services';	
		if(is_demo())
			$this->show("demo");
		else
			$this->show("externalservices");
	}	

	public function about()
	{

		if(!is_sadmin())
			show_404();
	
		$this->DATA['title'] 	= 'About';	
		$this->DATA['changelog'] 	= file_get_contents("./update/changelog.txt");
		$this->DATA['menu'] 	= 'about';	
		$this->show("about");
	}


	public function jobs()
	{

		if(!is_sadmin())
			show_404();


		if(is_ajax())
		{
			$this->table_logs();
			return false;
		}
		if($this->input->post('truncate')){
			$this->db->truncate('logs');
			redirect(base_url()."admin/jobs");
			exit;
		}
		if($this->input->post()){
			$this->save_settings();
			redirect(base_url()."admin/jobs");
			exit;
		}
	
		$this->DATA['title'] 	= 'Cron Jobs';	
		$this->DATA['logs']['process'] 	= $this->Admin->getTable("logs",array("groupid" => 'process'),"dateevent DESC",false,0,1000)->result();	
		
		$this->DATA['menu'] 	= 'cronjobs';	
		$this->show("jobs");
	}

	public function chromePlugin(){

		if($this->input->post()){
			$this->save_settings();
			redirect(base_url()."admin/chromePlugin?download=1");
			exit;
		}

		if($this->input->get("download") == '1')
		{

			$this->load->helper('file');

			$manifest 	= $this->load->view("chrome/manifest",false,true);
			$popup 		= $this->load->view("chrome/popup",false,true);
			$appjs 		= $this->load->view("chrome/app",false,true);


			write_file('./chrome/manifest.json', $manifest);
			write_file('./chrome/popup.html', $popup);
			write_file('./chrome/app.js', $appjs);

			$this->load->library('zip');



			
			$this->zip->read_dir('./chrome',FALSE); 
			
			$this->zip->download("chromePlugin-".config_item("chrome_version").".zip");
			

			
			
			unlink("./chrome/chromePlugin-".config_item("chrome_version").".zip");
			unlink("./chrome/manifest.json");
			unlink("./chrome/popup.html");
			unlink("./chrome/app.js");

			redirect(base_url()."admin/chromePlugin");
			exit;
		}

		$this->DATA['title'] 	= 'Chrome Plugin';
		$this->DATA['menu'] 	= 'chromePlugin';	
		$this->show("chromePlugin");
	}

	public function sitemap()
	{

		if(!is_sadmin())
			show_404();
	
	

		if($this->input->post("clearcache")){
			$files = glob('./cache/sitemap/*'); // get all file names
			foreach($files as $file){ // iterate files
			  if(is_file($file))
			    unlink($file); // delete file
			}
			redirect(base_url()."admin/sitemap");
			exit;
		}
			
		if($this->input->post()){
			$this->save_settings();
			redirect(base_url()."admin/sitemap");
			exit;
		}

		$this->DATA['title'] 	= 'Sitemap';	
		$ext = ".xml.gz";
		if(config_item("compress_sitemap") == '2')
			$ext = ".xml";
	

		$sites 	= $this->db->query("SELECT count(id) as total from {PRE}sites WHERE completed = 1")->row();
		
		for($x=1;$x<=ceil(($sites)/30000);$x++)
		{
			$sitemaps = array();
			$sitemaps['id']  = $x;
			$sitemaps['file']  = "sitemap-$x".$ext;
			$sitemap_name = "./cache/sitemap/".$sitemaps['file'];
			if(file_exists($sitemap_name))
			{
				$sitemaps['size']  = formatBytes(filesize($sitemap_name));	
				$sitemaps['updated']  = date("Y-m-d H:i:s",filemtime($sitemap_name));
				$sitemaps['cache']  = true;
				if(config_item("compress_sitemap") == '2')
					$xml = simplexml_load_string((file_get_contents($sitemap_name)));
				else
					$xml = simplexml_load_string(gzdecode(file_get_contents($sitemap_name)));
				$sitemaps['links']  = count($xml->url);
			}
			else
			{
				$sitemaps['size']  = 0;
				$sitemaps['updated']  = '0000-00-00 00:00:00';
				$sitemaps['cache']  = false;
				$sitemaps['links']  = 0;
			}
			
			
			
			$this->DATA['sitemaps'][] = $sitemaps;
		}

		$this->DATA['menu'] 	= 'sitemap';	
		$this->show("sitemap");


	}	



	public function bulk()
	{
		$this->DATA['title'] 	= 'Bulk';	
		if(!is_sadmin())
			show_404();
		if($sites = $this->input->post("bulk"))
		{
			$this->session->set_flashdata('sites', $sites);
			$site = explode("\n",$sites);
			//if(count($site)<=10000)
			//{	
				$added = 0;
				foreach ($site as $key => $url) {				
					$url 		= trim($url);
					$url 		= str_ireplace("\n","",$url);
					$url 		= str_ireplace("\r","",$url);

					if(preg_match("#https?://#", $url) === 0)
						$url = 'http://' . $url;
					$data 	= parse_url($url);
					$url = $data['host'];			
					$url = str_ireplace("www.", "",$url);
					$url = strtolower($url);	
					$response 	= false;
					if($url)
						$response 	= $this->Admin->setTable("sites",array("url" => $url));
				
					if($response)				
						$added++;
				}
				$messages[] = array("type" => "success","msg" => '<strong>'.number_format($added).'</strong> Domains added successfully');						
				$messages[] = array("type" => "danger","msg" => '<strong>'.number_format(count($site)-$added).'</strong> Domains already exists');						
				

			//}
			//else
			//{
			//	$messages[] = array("type" => "danger","msg" => "Max 10000 sites");
			//}
			
			$this->session->set_flashdata('messages', $messages);
			
			redirect(base_url()."admin/bulk");
		}

		$this->DATA['menu'] 	= 'bulk_sites';	
		$this->show("bulk");
	}	

	public function getUncompleted($next =false)
	{
		if($next)
		{
			$domain 	= $this->Admin->getTable("sites",array("completed" => 0),"registered DESC",'url',1,0)->row();	
			if($domain->num_rows == 0)
				$json['url'] = $domain->url;
			else
				$json['error'] = true;

			$this->Admin->deleteTable("sites",array("id" => $domain->id));		

		}
		else
		{
			$json['n'] = $this->Admin->getCountTable("sites",array("completed" =>0));		
		}
		
		echo_json($json);
	}

	public function translation()
	{	
		$this->DATA['title'] 	= 'Tanslations';	
		if($this->input->post("code"))
		{

			$this->Admin->setTable("languages",array("name" => $this->input->post("name"),"code" => strtolower(trim($this->input->post("code")))));			
			redirect(base_url()."admin/translation/?languages=".strtolower(trim($this->input->post("code"))));
			exit;
		}
		$lang = "en";
		if($this->input->get("language"))
			$lang = $this->input->get("language");

	
		if($this->input->post("r") && $lang != 'en')
		{
			$this->Admin->deleteTable("translation",array("code_lang" =>$lang));
			$this->Admin->deleteTable("languages",array("code" =>$lang));
			redirect(base_url()."admin/translation/");
			exit;
		}
		if($this->input->post() && !$this->input->post("r"))
		{
			foreach ($this->input->post() as $key => $value) {
				$save['code'] 			= $key;
				$save['translation'] 	= $value;
				$save['code_lang'] 		= $lang;
				$data[] = $save;
			}
			$this->Admin->setTable("translation",$data,true);
			foreach ($data as $key => $value) {
				$this->Admin->updateTable("translation",$value,array("code" => $value['code'],"code_lang" => $value['code_lang']));
			}
		}
		
		/*$temp 							= $this->Admin->getTable("translation",array("code_lang" => $lang));		
		if($temp->num_rows() == 0)
		{
			$temp 							= $this->Admin->getTable("translation",array("code_lang" => "en"));		
			foreach ($temp->result_array() as $key => $value) 
			{
				$t[]	 = array("code" => $value['code'],"translation" => '',"helper" => $value['translation']);
			}
			$this->DATA['translation'] 		= $t;
		}
		else
			$this->DATA['translation'] 		= $temp->result_array();*/

		$trans 							= $this->Admin->getTable("translation",array("code_lang" => $lang));		
		
		$temp 							= $this->Admin->getTable("translation",array("code_lang" => "en"));		

		$obj_t = array();
		foreach ($trans->result_array() as $key => $value) 
		{	
			$t[$value['code']] = array(
					"translation" => $value['translation']					
				);
		}
		
		foreach ($temp->result_array() as $key => $value) 
		{
			$t[$value['code']]['helper'] = $value['translation'];
		}
	
	
		$this->DATA['translation'] 		= $t;
		
	
		$complteted = 0;
		foreach ($this->DATA['translation']  as $key => $value) {
			if($value['translation'] != '')
				$complteted++;
		}

		$this->DATA['current'] = $this->Admin->getTable("languages",array("code" => $lang))->row_array();


		$this->DATA['porc'] 			= ceil(($complteted*100)/$temp->num_rows());
		$temp 							= $this->Admin->getTable("languages");	
		$this->DATA['languages'] 		= $temp->result_array();		
		$this->DATA['menu'] 			= 'translation';	
		$this->DATA['lang'] 			= $lang;	
		$this->show("translation");
	}
	
	public function users()
	{	
		if($this->input->get("export"))
		{
			 $this->load->dbutil();
	        $this->load->helper('file');
	        $this->load->helper('download');
	        $delimiter = ",";
	        $newline = "\r\n";
	        $filename = "users.csv";
	        $query = "SELECT names,registered,email,is_admin,avatar FROM {PRE}users limit 10000";
	        $result = $this->db->query($query);
	        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
	        force_download($filename, $data);
		}
		$this->DATA['title'] 	= 'Users';	
		if(is_ajax())
		{
			$this->table_users();
			return false;
		}
		
		$this->DATA['menu'] 	= 'users';	

		if(intval($this->input->get("edit"))>0)
		{
			if($this->input->post())
			{
				$user = $this->Admin->getTable("users",array("id" =>  intval($this->input->get("edit"))))->row();	
				$update = $this->input->post();
				if(trim($update['password']) != '')
					$update['password'] = sha1($update['password']);
				else
					unset($update['password']);
				$this->Admin->updateTable("users",$update,array("id" =>  intval($this->input->get("edit"))));
				$this->DATA['alert'] = array("type" => 'success','text' => "User <strong>".$user->names."</strong> updated!");
			}
			$this->DATA['user'] 	= $this->Admin->getTable("users",array("id" =>  intval($this->input->get("edit"))))->row();	

			$this->show("user_edit");
		}
		else
		{
			if(is_demo())
				$this->show("demo");
			else
				$this->show("users");
		}


		
	}	

	public function sites()
	{	
		if($this->input->get("export"))
		{
			 $this->load->dbutil();
	        $this->load->helper('file');
	        $this->load->helper('download');
	        $delimiter = ",";
	        $newline = "\r\n";
	        $filename = "sites.csv";
	        $query = "SELECT url,metaTitle as title,score FROM {PRE}sites WHERE completed = 1 limit 50000";
	        $result = $this->db->query($query);
	        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
	        force_download($filename, $data);
		}

		$this->DATA['title'] 	= 'Sites';	
		if(is_ajax())
		{
			$this->table_sites();
			return false;
		}

		if(intval($this->input->get("remove"))>0)
		{
			$id = intval($this->input->get("remove"));
			$this->Admin->deleteTable("sites",array("id" => $id));
			redirect(base_url()."admin/sites",'refresh');
		}
		
		$this->DATA['menu'] 	= 'sites';	
		if(intval($this->input->get("edit"))>0)
		{
			if($this->input->post())
			{
				$site = $this->Admin->getTable("sites",array("id" =>  intval($this->input->get("edit"))))->row();	
				$update = $this->input->post();

				$update['screenshot'] = getScreenshot($site->url,true);
				$this->Admin->updateTable("sites",$update,array("id" =>  intval($this->input->get("edit"))));
				$this->DATA['alert'] = array("type" => 'success','text' => "Site <strong>".$site->url."</strong> updated!");
			}
			$this->DATA['site'] 	= $this->Admin->getTable("sites",array("id" =>  intval($this->input->get("edit"))))->row();	

			$this->show("site_edit");
		}
		else
		{
			$this->show("sites");
		}
	}	



	public function pages()
	{	
		$this->DATA['title'] 	= 'Pages';	
		if(intval($this->input->get("delete")))
		{
			$this->Admin->deleteTable("pages",array("idpage"=> intval($this->input->get("delete"))));
			redirect(base_url()."admin/pages/");
			exit;
		}
		
		if($this->input->post("page_last_sites"))
		{
			$this->save_settings();
			redirect(base_url()."admin/pages/");
			exit;
		}
		if($this->input->post("text"))
		{
			// Update
			if($this->input->post("idpage"))
			{
				$update = $this->input->post();
				$update['slug'] = url_title($update['title'],"-",TRUE);
				unset($update['_wysihtml5_mode']);
				unset($update['files']);
				$id = intval($update['idpage']);
				unset($update['idpage']);
				$this->Admin->updateTable("pages",$update,array("idpage" => $id));
				
			}
			else
			{
				$save = $this->input->post();
				$save['slug'] = url_title($save['title'],"-",TRUE);
				unset($save['idpage']);
				unset($save['_wysihtml5_mode']);
				unset($save['files']);
				$this->Admin->setTable("pages",$save);
				redirect(base_url()."admin/pages");
			}
		}
		$this->DATA['page'] 	= $this->Admin->getTable("pages",array("idpage" =>  intval($this->input->get("idpage"))))->row_array();	
		$this->DATA['pages'] 	= $this->Admin->getTable("pages",false,"updated DESC")->result_array();
		$this->DATA['menu'] 	= 'pages';	
		$this->show("pages");
	}

	


	public function settings($module = 'website')
	{		
		$this->DATA['title'] 	= 'Settings - '. $module;	
		if(!is_sadmin())
			show_404();
		if($module == 'apperance')
		{
			$this->apperance();
			return false;
		}
		if($module == 'emailservice' && is_demo())
		{
			$this->DATA['menu'] 	= 'settings';		
			$this->DATA['submenu'] 	= $module;		
			$this->show("demo");
			return false;
		
		}
		if(!$module)
			$module = 'website';
		if($this->input->post())
		{
			$this->save_settings();
			redirect(base_url()."admin/settings/".$module);
		}

		$this->DATA['menu'] 	= 'settings';		
		$this->DATA['submenu'] 	= $module;		
		$this->DATA['fields']	 = $this->Admin->getTable("settings",array("module" => $module),"order");		
		$this->show("settings");
	}

	protected function apperance()
	{
		if($this->input->post())
		{
			if($this->input->post("save"))
			{
				
				createFolder("uploads");
				$upload = uploadImage('./uploads/',sha1($this->input->post('name')),'image');				
				if($upload['image'])
				{	
					$this->Admin->updateTable("settings",array("value" => "uploads/".$upload['image']),array("var" => 'logo'));
				}	

				$upload = array();
				$upload = uploadImage('./uploads/',"home_background",'background_home',false,true);				
				
				if($upload['image'])
				{	
					$this->Admin->updateTable("settings",array("value" => "uploads/".$upload['image']),array("var" => 'background_home'));
				}


				$upload = array();
				$upload = uploadImage('./uploads/',"background_modal",'background_modal',false,true);				
				
				if($upload['image'])
				{	
					$this->Admin->updateTable("settings",array("value" => "uploads/".$upload['image']),array("var" => 'background_modal'));
				}

				
				$this->save_settings();
			
				redirect(base_url()."admin/settings/apperance");
			}else
			{
				$this->save_settings();
				redirect(base_url()."admin/settings/apperance");
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

		$this->DATA['langs'] 	= $langs->result();	
		$this->DATA['menu'] 	= 'settings';	
		$this->DATA['submenu'] 	= 'apperance';	
		$this->show("apperance");

		

	}
	protected function save_settings()
	{
		if($this->input->post())
		{
			foreach ($this->input->post() as $key => $value) {
				if(is_array($value))
				{
					//print_p($value);					
					$value = implode(",",$value);
				}
				$this->Admin->setTableIgnore("settings",array("value" => $value,"var" => $key));
				$this->Admin->updateTable("settings",array("value" => $value),array("var" => $key));
				$this->config->set_item($key, $value);  
			}
		}
	}
	
	protected function table_users()
	{
		
	/*
	* Ordering
	*/	$sOrder = false;
		if ($this->input->get('iSortCol_0') || 1==1)
		{
			$columns[0] = 'id';
			$columns[1] = 'avatar';			
			$columns[2] = 'email';						
			$columns[3] = 'names';						
			$columns[4] = 'registered';														
			$columns[5] = 'is_admin';														
			$columns[6] = 'plan';														
			$sOrder = $columns[$this->input->get('iSortCol_0')]." ".$this->input->get('sSortDir_0');			
		}
		$like= false;
		if ($this->input->get('sSearch') != "" )
		{
			foreach ($columns as $key => $value) {
				$like[$value]	= $this->input->get('sSearch');
			}
			
		}
		$users 				= $this->Admin->getTable("users",false,$sOrder,'id,avatar,username,email,names,registered,is_admin,plan,is_demo',$this->input->get('iDisplayLength'),$this->input->get('iDisplayStart'),$like);	
		
		$total 					= $this->Admin->getTable("users",false,$sOrder,'id,avatar,username,email,names,registered,is_admin,plan,is_demo',false,false,$like);	
		$total 					= $total->num_rows();
		$output = array(
		"sEcho" => intval($this->input->get('sEcho')),
		"iTotalRecords" => $total,
		"iTotalDisplayRecords" => $total,
		"aaData" => array()
		);

		$plan[1] = "label label-info";
		$plan[2] = "label label-warning";
		$plan[3] = "label label-danger";
		foreach ($users->result_array() as $key => $value) {
			$row = array();		
			
			$row[] = $value['id'];
			$row[] = "<img src='".avatar($value['avatar'])."' style='height:30px'>";						
			$row[] = $value['email'];			
			$row[] = $value['names'];			
			$row[] = "<span title='".$value['registered']."'>".ago(($value['registered']))."</span>";			
			if($value['is_admin'] == '1')
			{
				if($value['is_demo'] == '1')
					$row[] = '<small class="label label-danger">ADMIN</small> <small class="label label-success">DEMO</small>';			
				else
					$row[] = '<small class="label label-danger">ADMIN</small>';			
			}
			else
				$row[] = '<small class="label label-info">NORMAL</small>';
			
			$row[] = '<small class="'.$plan[$value['plan']].'">'.getPlanName($value['plan']).'</small>';		

			$row[] = '<a href="?edit='.$value['id'].'" class="btn btn-warning btn-xs" title="Edit user"><i class="zmdi zmdi-edit"></i> Edit</a>';
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}

	protected function table_logs()
	{
		
	/*
	* Ordering
	*/	$sOrder = false;
		if ($this->input->get('iSortCol_0') || 1==1)
		{
			$columns[0] = 'level';
			$columns[1] = 'dateevent';			
			$columns[2] = 'log';						
																
			$sOrder = $columns[$this->input->get('iSortCol_0')]." ".$this->input->get('sSortDir_0');			
		}
		$like= false;
		if ($this->input->get('sSearch') != "" )
		{
			foreach ($columns as $key => $value) {
				$like[$value]	= $this->input->get('sSearch');
			}
				
			
		}
		$users 				= $this->Admin->getTable("logs",array("groupid" => $this->input->get("groupid")),$sOrder,'level,dateevent,log',$this->input->get('iDisplayLength'),$this->input->get('iDisplayStart'),$like);	
		
		$total 					= $this->Admin->getTable("logs",array("groupid" => $this->input->get("groupid")),$sOrder,'level,dateevent,log',false,false,$like);	
		$total 					= $total->num_rows();
		$output = array(
		"sEcho" => intval($this->input->get('sEcho')),
		"iTotalRecords" => $total,
		"iTotalDisplayRecords" => $total,
		"aaData" => array()
		);
		foreach ($users->result_array() as $key => $value) {
			$row = array();		
			$level['error'] = 'danger';
			$level['success'] = 'success';
			$row[] = "<span class='text-".$level[$value['level']]."'>".strtoupper($value['level'])."</span>";
			$row[] = "<span class='text-".$level[$value['level']]."'>".$value['dateevent']."</span>";
			$row[] = "<span class='text-".$level[$value['level']]."'>".$value['log']."</span>";
			
			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}




	protected function table_sites()
	{
		
	/*
	* Ordering
	*/	$sOrder = false;
		if ($this->input->get('iSortCol_0') || 1==1)
		{
			$columns[] = 'score';
			$columns[] = 'id';			
			$columns[] = 'url';			
			$columns[] = 'metaTitle';						
			$columns[] = 'registered';						
			$columns[] = 'alexaGlobal';						
			$columns[] = 'pageSpeed';						
			$columns[] = 'pagespeed_mobile';						
			$columns[] = 'domainAuthority';						
			$columns[] = 'pageAuthority';						
			$columns[] = 'mozRank';									
			$columns[] = 'isp';						
			$columns[] = 'country';						
			$columns[] = 'completed';						
															
			$sOrder = $columns[$this->input->get('iSortCol_0')]." ".$this->input->get('sSortDir_0');			
		}
		$like= false;
		if ($this->input->get('sSearch') != "" )
		{
			foreach ($columns as $key => $value) {
				$like[$value]	= $this->input->get('sSearch');
			}
			
		}
		
		$sites 				= $this->Admin->getTable("sites",false,$sOrder,implode(",", $columns),$this->input->get('iDisplayLength'),$this->input->get('iDisplayStart'),$like);	
		
		$total 					= $this->Admin->getTable("sites",false,$sOrder,implode(",", $columns),false,false,$like);	
		$total 					= $total->num_rows();
		$output = array(
		"sEcho" => intval($this->input->get('sEcho')),
		"iTotalRecords" => $total,
		"iTotalDisplayRecords" => $total,
		"aaData" => array()
		);
		foreach ($sites->result_array() as $key => $value) {
			$row = array();		
			$row  = array_values($value);
			
			$row[count($row)] = "<a class='btn btn-danger btn-small btn-xs' href='?remove=".$row[1]."'> <i class='fa fa-times'></i> Remove</a> <a class='btn btn-info btn-small btn-xs' href='?edit=".$row[1]."'> <i class='fa fa-edit'></i> Edit</a>";
			$row[1] = '<img  style="height:20px;" src="https://www.google.com/s2/favicons?domain='.$row[2].'"></td>';
			if($row[count($row)-2] == 1)
				$row[count($row)-2] = '<span class="label label-success">Analized</span>';
			else
				$row[count($row)-2] = '<span class="label label-warning">No Analyzed</span>';

			$row[2] = '<a target="_blank" href="'.base_url().$row[2].'">'.$row[2].'</a>';
			$output['aaData'][] = $row ;
		}
		
		echo json_encode( $output );
	}
	protected function table_paypal_logs()
	{
		
		$field = $this->db->field_data('paypal_log');
	/*
	* Ordering
	*/	$sOrder = false;
		if ($this->input->get('iSortCol_0') || 1==1)
		{
			foreach ($field  as $key => $value) {
				$columns[] = $value->name;
			}
							
															
			$sOrder = $columns[$this->input->get('iSortCol_0')]." ".$this->input->get('sSortDir_0');			
		}
		$like= false;
		if ($this->input->get('sSearch') != "" )
		{
			foreach ($columns as $key => $value) {
				$like[$value]	= $this->input->get('sSearch');
			}
			
		}
		
		$obj 				= $this->Admin->getTable("paypal_log",false,$sOrder,implode(",", $columns),$this->input->get('iDisplayLength'),$this->input->get('iDisplayStart'),$like);	
		
		$total 					= $this->Admin->getTable("paypal_log",false,$sOrder,implode(",", $columns),false,false,$like);	
		$total 					= $total->num_rows();
		$output = array(
		"sEcho" => intval($this->input->get('sEcho')),
		"iTotalRecords" => $total,
		"iTotalDisplayRecords" => $total,
		"aaData" => array()
		);
		foreach ($obj->result_array() as $key => $value) {
			$row = array();		
			$row  = array_values($value);
			
			
			$output['aaData'][] = $row ;
		}
		
		echo json_encode( $output );
	}

	

	public function update()
	{		
		$DATA 				= array();
		
		if($this->input->post("uploading"))
		{			
			if(!file_exists('./uploads/'))
			{
				mkdir('./uploads/');
			}
			$config['upload_path'] 		= './uploads/';
			$config['allowed_types'] 	= 'zip';
			$config['overwrite'] 		=  true;
			$cupload onfig['remove_spaces']	=  true;
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('upload'))
			{
				$DATA['upload'] = array('error' => $this->upload->display_errors());				
			}
			else
			{
				$DATA['upload'] = array('upload_data' => $this->upload->data());
				$this->load->library('unzip');
				$file = './uploads/'.$DATA['upload']['upload_data']['file_name'];
				if(file_exists($file))
				{					
					$this->unzip->extract($file, './');	
					$errorZip = strip_tags($this->unzip->error_string());
					if($errorZip != '')
						$DATA['upload'] = $errorZip;
					@unlink($file);
					$this->validate_update();
				}
				else
				{
					$DATA['upload'] = array('error' =>'File '.$file." not exist");	
				}
				
				
			}
		}
			
		
		$this->DATA['menu'] 	= 'update';	
		$this->DATA['upload']  = $DATA['upload'];
		if(is_demo())
			$this->show("demo");
		else
			$this->show("update");
	}

	public function subscriptions($module = false)
	{
		if(!$module)
		{
			show_404();
		}


		if($this->input->post())
		{
			$this->save_settings();
			redirect(base_url()."admin/subscriptions/".$module);
			exit;
		}

		$submenu = $module;
		if($submenu == "settings")
			$submenu = 'sub_settings';

		if($this->input->get("export"))
		{
			if(is_demo())
				show_404();
			$this->load->dbutil();
	        $this->load->helper('file');
	        $this->load->helper('download');
	        $delimiter = ",";
	        $newline = "\r\n";
	        $filename = $this->input->get("export").".csv";
	        $query = "SELECT * FROM {PRE}".$this->input->get("export")." order by 1 desc limit 10000 ";

	        $result = $this->db->query($query);
	        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
	        force_download($filename, $data);
		}

		if($submenu == "logs")
		{
			if(is_ajax())
			{
				$this->table_paypal_logs();
				return false;
			}
			$this->DATA['fields'] =  $this->db->field_data('paypal_log');
			if(is_demo())
					$module = "../demo";
		}

		$this->DATA['menu'] 	= 'subscriptions';		
		$this->DATA['submenu'] 	= $submenu;		
		
		
		
			$this->show("subscriptions/".$module);


	}

}