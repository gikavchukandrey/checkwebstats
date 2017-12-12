<?php
function PR_getProcess()
{

    $process[] = array('title' => __("Crawling website"), 'action' => 'crawl','description' => __('Downloading website content to analyze and evaluate.'));
    $process[] = array('title' => __("Calculating Traffics"), 'action' => 'traffic','description' => __('We strive to provide useful information for website owners, buyers, competitors and anyone else looking for estimated visitor quantities and web analytics'));
    $process[] = array('title' => __("Counting Social Data"), 'action' => 'social','description' => __('Fetching all social networks (Facebook, Google Plus, StumbleUpOn, LinkedIn, More...)'));
    $process[] = array('title' => __("Analyzing Technologies"), 'action' => 'technologies','description' => __('Covers 20,000+ internet technologies which include analytics, advertising, hosting, CMS and many more'));
    $process[] = array('title' => __("Google Pagespeed Desktop"), 'action' => 'pagespeed','description' => __('We built this Website (Desktop) Speed Test to help you analyze the load speed of your websites and learn how to make them faster'));
    $process[] = array('title' => __("Google Pagespeed Mobile"), 'action' => 'pagespeedm','description' => __('We built this Website (Mobile) Speed Test to help you analyze the load speed of your websites and learn how to make them faster'));
    $process[] = array('title' => __("Bounce Rate"), 'action' => 'bouncerate','description' => __('Bounce rates can be used to help determine the effectiveness or performance of an entry page at generating the interest of visitors. An entry page with a low bounce rate means that the page effectively causes visitors to view more pages and continue on deeper into the web site.'));
    $process[] = array('title' => __("Availablea Domains (TDL)"), 'action' => 'available_domain','description' => __('Checking if are available similar names domains'));
    $process[] = array('title' => __("Domain Authority"), 'action' => 'da','description' => __('Domain Authority is a score (on a 100-ing/point scale) developed by Moz that predicts how well a website will rank on search engines.'));
    $process[] = array('title' => __("Validating W3C"), 'action' => 'w3c','description' => __('W3C standards define an Open Web Platform for application development that has the unprecedented potential to enable developers to build rich interactive experiences, powered by vast data stores, that are available on any device'));
    $process[] = array('title' => __("Checking Blacklist Domain"), 'action' => 'google_safe','description' => __("Safe Browsing is a Google service that lets client applications check URLs against Google's constantly updated lists of unsafe web resources"));
    $process[] = array('title' => __("Searching For Broken Links"), 'action' => 'internalLinks','description' => __("Dead hyperlinks on websites are not just annoying – their existence may cause some real damage to your online business as well as to your reputation in the Internet!"));
    $process[] = array('title' => __("Getting Server Information"), 'action' => 'serverInfo','description' => __("Find out which web server is running a specific site. See information like web dedicated server name, operating system, available modules, etc."));
    $process[] = array('title' => __("DNS Records"), 'action' => 'dnsrecords','description' => __("The DNS is crucial system for today's Internet. Incorrectly set up DNS records cause many different problems to administrators of web servers and company infrastructure."));
    $process[] = array('title' => __("Server Response Details"), 'action' => 'serverresponse','description' => __("Get information regarding a specific transfer."));
    $process[] = array('title' => __("Getting whois data"), 'action' => 'whois','description' => __("Domain name lookup service to search the whois database for domain name registration information."));
    $process[] = array('title' => __("Calculating Score"), 'action' => 'score','description' => __("The score is a dynamic grade on a 100-point scale that represents your Internet Marketing Effectiveness at a given time."));
    return $process;
}

function PR_validateDomain($url,$process,$timeout = 8)
{

    $url = trim($url);
    $url = str_ireplace("\n", "",$url);
    $url = str_ireplace("\r", "",$url);

    $CI     =& get_instance();
    if(preg_match("#https?://#", $url) === 0)
        $url = 'http://' . $url;

    $data 	= parse_url($url);
    $domain = $data['host'];

    $domain = str_ireplace("www.", "",$domain);
    $domain = mb_strtolower( $domain);
    $domain_curl = "http://".$domain;
    if($data['scheme'])
        $domain_curl = $data['scheme']."://".$domain;


    $json['domain'] = $domain;
    $json['new'] 	= TRUE;
    if(hasbadWords($domain))
    {
        unset($json['process']);
        $json['error'] = __("The domain name contains forbidden words");
    }
    else
    {

        $domain_curl = mb_strtolower( $domain_curl);
        print_r($domain_curl);

        if(is_valid_domain_name($domain_curl))
        {
            $ret = ping($domain_curl,$timeout);
            if($ret !== 404 && $ret !== 500 && $ret !== 0 && $ret !== 403)
            {
                $exist = $CI->Admin->getTable("sites",array("url" => $domain));
                if($exist->num_rows() == 1)
                    $json['new'] = FALSE;
                $json['process'] = $process;
                $CI->Admin->setTableIgnore("sites",array("url" => $domain,"registered" => date("Y-m-d H:i:s")));

            }
            else
            {
                $CI->Admin->deleteTable("sites",array("url" => $domain));
                $json['error'] = __("Your website is down or not is valid");
            }

        }
        else
        {
            $CI->Admin->deleteTable("sites",array("url" => $domain));
            $json['error'] = __("Domain not is valid");
        }
    }

    if(config_item("email_new_site") == '1')
    {
        if(!$json['error'] && $json['new'])
        {
            $ip = $CI->input->ip_address();
            $user = 'Guest';
            if(is_logged())
                $user = _user("names")." - "._user("email");
            $message2 = "New domain registration on your site <br><br><strong>Domain: </strong>$domain<br><strong>User: </strong>$user<br><strong>IP Address: </strong>$ip";
            email(get_email_admin(),__("New domain registration"),$message2);
        }

    }
    return $json;

}

function PR_Process($action,$domain)
{
    $domain = trim($domain);
    $CI     =& get_instance();
    $domain_curl 	= "http://".$domain;
    if(!is_valid_domain_name($domain_curl))
        return array("error" => __("Your website is down or not is valid"));


    switch ($action) {
        case 'crawl':
            /*if(ping($domain_curl,8))
            {
                return array("error" => __("Your website is down or not is valid"));
            }*/



            $temp_d 					= $domain_curl;
            $domain_curl 				= getEfectiveUrl($domain_curl);


            if(substr($domain_curl, -1) == '/')
                $domain_curl = substr($domain_curl,0,-1);



            if(!$domain_curl || $domain_curl == '://')
                $domain_curl 			= $temp_d;
            $save['body'] 				= (_curl($domain_curl));
            $save['charset'] 			= getCharset($save['body']);

            if(mb_strtolower( $save['charset']) != 'utf-8' && $save['charset'] != '')
                $save['body'] 				= iconv($save['charset'],'UTF-8',$save['body']);
            //$save['body'] 				= mb_convert_encoding($save['body'], 'utf-8', $save['charset']);


            //$save['body'] 				= $save['body'];
            $save['headers'] 			= _curl_headers($domain_curl);

            $save['metaTitle'] 			= getMeta($save['body'],"title");
            $save['metaDescription'] 	= getMeta($save['body'],"description");
            $save['metaKeywords'] 		= getMeta($save['body'],"keywords");
            $save['metaH1'] 			= mb_substr_count($save['body'], "<h1");
            $save['metaH2'] 			= mb_substr_count($save['body'], "<h2");
            $save['metaH3'] 			= mb_substr_count($save['body'], "<h3");
            $save['metaH4'] 			= mb_substr_count($save['body'], "<h4");
            $save['favicon'] 			= getFavIcon($save['body']);
            $save['hasAMP'] 			= hasAMP($save['body']);

            $save["robots"] 			= remote_file_exists($domain_curl."/robots.txt");
            $save["sitemap"] 			= remote_file_exists($domain_curl."/sitemap.xml");

            $save['url_real'] 			= $domain_curl;



            //$domain_curl 				= trim($domain_curl);

            /*if(substr($domain_curl,-1) != '/')
                $domain_curl = $domain_curl."/";*/

            if(!$save['body'])
            {
                $save['completed'] = '1';
                $save['score'] = '1';
                $CI->Admin->updateTable("sites",$save,array("url" => $domain));
                $CI->db->query("UPDATE {PRE}sites SET url=LOWER(url) WHERE url = '$domain'");
                $return['error'] = __("Body empty!");
            }else
            {
                $CI->Admin->updateTable("sites",$save,array("url" => $domain));
                $CI->db->query("UPDATE {PRE}sites SET url=LOWER(url) WHERE url = '$domain'");
                $return['message'] = __("Done!");
            }


            //unset($save['body']);
            break;
        case 'traffic':
            $alexa 						= getAlexaRank($domain);
            $save['alexaLocal'] 		= $alexa['local']['rank'];
            $save['alexaLocalCountry'] 	= $alexa['local']['country'];
            $save['alexaGlobal'] 		= $alexa['global']['rank'];
            $save['uniqueVisitsDaily'] 	= (int)(pow($alexa['local']['rank'],-0.732)*6000000);
            $save['pagesViewsDaily'] 	= (int)($save['uniqueVisitsDaily']*1.85);
            $CI->Admin->updateTable("sites",$save,array("url" => $domain));
            $CI->db->query("UPDATE {PRE}sites SET IncomeDaily=((uniqueVisitsDaily*0.017)*0.07) WHERE  url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET IncomeDaily=(IncomeDaily*1.5) WHERE alexaLocal <= 1000 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET IncomeDaily=(IncomeDaily*2) WHERE alexaLocal <= 100 AND url='$domain'");
            $return['message'] = __("Done!");
            break;
        case 'social':
            $site 	= $CI->Admin->getTable("sites",array("url" => $domain))->row();
            $social['facebook'] = getFacebookCount($site->url_real);
            $social['linkedin'] = getLinkedInCount($site->url_real);
            $social['pinterest'] = getPinterestCount($site->url_real);
            $social['stumbleupon'] = getStumbleuponCount($site->url);
            $social['google_plus'] = getGooglePlusCount($site->url_real);

            $CI->db->query("UPDATE {PRE}sites SET social='".json_encode($social)."' WHERE url='$domain'");
            $return['message'] = __("Done!");
            break;
        case 'whois':
            $site 	= $CI->Admin->getTable("sites",array("url" => $domain))->row();
            if(config_item("4p1_key"))
            {
                $days		= getDaysDiff($site->updated,date("Y-m-d H:i:s"));
                if($days>=0)
                {
                    $whois 						= getWhois(config_item("4p1_key"),$domain);

                    $save = array();
                    $save['created_on'] = $whois->created_on;
                    $save['expires_on'] = $whois->expires_on;

                    if($whois->created_on)
                        $CI->Admin->updateTable("sites",$save,array("url" => $domain));
                }
            }
            $return['message'] = __("Done!");
            break;
        case 'technologies':



            if(config_item("4p1_key"))
            {

                $site_obj 	= $CI->Admin->getTable("sites",array("url" => $domain));
                $site_t 	= $CI->Admin->getTable("technologies",array("url" => $domain));
                $site 		= $site_obj->row();
                //$domain 	= $site->url_real;
                $days		= getDaysDiff($site->updated,date("Y-m-d H:i:s"));
                if($days>0 || $site_t->num_rows() == 0)
                {
                    $technologies 		= getBuiltWith(config_item("4p1_key"),$domain);
                    if($technologies->results->technologies)
                    {
                        $CI->Admin->deleteTable("technologies",array("url" => $domain));
                        $save 			= array();
                        foreach ($technologies->results->technologies as $key => $value) {

                            $save[$key]["url"] 		= $site->url;
                            $save[$key]["name"] 	= $value->name;
                            $save[$key]["icon"] 	= $value->icon_name;
                            $save[$key]["tag1"] 	= $value->tags[0];
                            $save[$key]["tag2"] 	= $value->tags[1];

                        }
                        $CI->Admin->setTable("technologies",$save,true);
                        $return['message'] = __("Done!");
                    }
                    else
                    {
                        $return['error'] = __("Empty response");
                    }
                }
                else
                {
                    $return['message'] = __("Done!");
                }



            }else
            {
                $return['error'] = __("4p1.co key no found!");
            }
            break;
        case 'engine':
            $save["googleIndex"] 	= intval(getGoogleCount($domain));
            $save["yahooIndex"] 	= intval(getYahooCount($domain));
            $save["bingIndex"] 		= intval(getBingCount($domain));


            $CI->Admin->updateTable("sites",$save,array("url" => $domain));
            break;

        case 'pagespeedm':
            $key = config_item("google_page_speed_key");
            if($key)
            {

                $site_obj 	= $CI->Admin->getTable("sites",array("url" => $domain));
                $site 		= $site_obj->row();
                if($site->url_real)
                    $domain_real 	= $site->url_real;


                $dataM 					= getSpeedData($key,$domain_real,'mobile',true);


                if($dataM)
                {
                    $save['pagespeed_mobile'] 	= intval($dataM->ruleGroups->SPEED->score);
                    $save['pagespeed_screenshot_m'] 	= "data:".$dataM->screenshot->mime_type.";base64, ".str_ireplace(array("_","-"), array("/","+"), $dataM->screenshot->data);

                    $save['pagespeed_usability'] 	= intval($dataM->ruleGroups->USABILITY->score);
                    $save['pagespeed_rules_mobile'] 	= json_encode($dataM->formattedResults);
                    $return['message'] = __("Done!");
                }
                else
                {
                    $return['error'] = __("Mobile Response empty!");
                }

                if(config_item("google_screenshot") != '1')
                {
                    unset($save['pagespeed_screenshot_m']);
                }

                if($save['pagespeed_mobile'] == 0)
                    unset($save['pagespeed_mobile']);
                if($save)
                    $CI->Admin->updateTable("sites",$save,array("url" => $domain));


                unset($save['pagespeed_screenshot_m']);
                unset($save['pagespeed_rules_mobile']);
                unset($save['pagespeed_rules']);
                unset($save['pagespeed_screenshot_d']);
            }
            else{
                $return['error'] = __("Google pagespeed key no found!");
            }
            break;

        case 'pagespeed':
            $key = config_item("google_page_speed_key");
            if($key)
            {

                $site_obj 	= $CI->Admin->getTable("sites",array("url" => $domain));
                $site 		= $site_obj->row();
                if($site->url_real)
                    $domain_real 	= $site->url_real;

                $data 					= getSpeedData($key,$domain_real,'desktop',true);


                if($data)
                {
                    if($data->title)
                    {
                        $save['metaTitle'] = $data->title;
                    }
                    $save['pageSpeed'] 			= intval($data->ruleGroups->SPEED->score);
                    $save['pagespeed_rules'] 	= json_encode($data->formattedResults);
                    $save['pagespeed_screenshot_d'] 	= "data:".$data->screenshot->mime_type.";base64, ".str_ireplace(array("_","-"), array("/","+"), $data->screenshot->data);
                    $save['pagespeed_numberResources'] 	= intval($data->pageStats->numberResources);
                    $save['pagespeed_numberHosts'] 	= intval($data->pageStats->numberHosts);
                    $save['pagespeed_totalRequestBytes'] 	= intval($data->pageStats->totalRequestBytes);
                    $save['pagespeed_numberStaticResources'] 	= intval($data->pageStats->numberStaticResources);
                    $save['pagespeed_htmlResponseBytes'] 	= intval($data->pageStats->htmlResponseBytes);
                    $save['pagespeed_cssResponseBytes'] 	= intval($data->pageStats->cssResponseBytes);
                    $save['pagespeed_imageResponseBytes'] 	= intval($data->pageStats->imageResponseBytes);
                    $save['pagespeed_javascriptResponseBytes'] 	= intval($data->pageStats->javascriptResponseBytes);
                    $save['pagespeed_otherResponseBytes'] 	= intval($data->pageStats->otherResponseBytes);
                    $save['pagespeed_numberJsResources'] 	= intval($data->pageStats->numberJsResources);
                    $save['pagespeed_numberCssResources'] 	= intval($data->pageStats->numberCssResources);

                    $return['message'] = __("Done!");


                }
                else
                {
                    $return['error'] = __("Desktop Response empty!");
                }

                if(config_item("google_screenshot") != '1')
                {
                    unset($save['pagespeed_screenshot_m']);
                    unset($save['pagespeed_screenshot_d']);
                }


                if($save['pageSpeed'] == 0)
                {
                    unset($save['pageSpeed']);
                }

                if($save)
                    $CI->Admin->updateTable("sites",$save,array("url" => $domain));


                unset($save['pagespeed_screenshot_m']);
                unset($save['pagespeed_rules_mobile']);
                unset($save['pagespeed_rules']);
                unset($save['pagespeed_screenshot_d']);
            }
            else{
                $return['error'] = __("Google pagespeed key no found!");
            }
            break;

        case 'bouncerate':
            $save['bounceRate'] 		= intval(getAlexaBounceRate($domain));
            $CI->Admin->updateTable("sites",$save,array("url" => $domain));
            $return['message'] = __("Done!");
            break;

        case 'da':

            $site_obj 	= $CI->Admin->getTable("sites",array("url" => $domain));
            $site 		= $site_obj->row();
            $days		= getDaysDiff($site->updated,date("Y-m-d H:i:s"));
            if($days>=1 || $site->pageAuthority == 0 || 1==1)
            {
                $moz = domainAuthority($domain);
                if(!$moz->status)
                {
                    $save['domainAuthority'] 		= intval($moz->pda);
                    $save['pageAuthority'] 			= intval($moz->upa);
                    $save['mozRank'] 				= ($moz->umrp);

                    if($save['domainAuthority']>0)
                        $CI->Admin->updateTable("sites",$save,array("url" => $domain));
                    $return['message'] = 'Done!';
                }
                else
                {
                    $save['error'] = $moz;
                    $return['error'] = $moz;
                }
            }
            else
            {
                $return['message'] = 'Done!';
            }
            break;
        case 'w3c':
            $save['w3c'] 		= intval(getW3C($domain));
            if(connect($domain, 443))
                $save['https'] = '1';
            $CI->Admin->updateTable("sites",$save,array("url" => $domain));
            $return['message'] = 'Done!';
            break;
        case 'google_safe':
            $site_obj 	= $CI->Admin->getTable("sites",array("url" => $domain));
            $site 		= $site_obj->row();
            $save['google_safe'] 		= googleSafe($domain);
            $CI->Admin->updateTable("sites",$save,array("url" => $domain));
            //ValidateTDL($site);
            $return['message'] = 'Done!';
            break;
        case 'dnsrecords':
            $site_obj 	= $CI->Admin->getTable("sites",array("url" => $domain));
            $site 		= $site_obj->row();
            $dns = dns_get_record($site->url,DNS_A+DNS_CNAME+DNS_MX+DNS_NS+DNS_TXT+DNS_AAAA);
            $CI->Admin->updateTable("sites",array("dns_record" => json_encode($dns)),array("url" => $domain));


            $return['message'] = 'Done!';
            break;
        case 'serverresponse':
            $site_obj 	= $CI->Admin->getTable("sites",array("url" => $domain));
            $site 		= $site_obj->row();
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $site->url_real);


            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3); //timeout in seconds
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch, CURLOPT_ENCODING,'gzip');
            //curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_HEADER,true);
            curl_setopt($ch, CURLOPT_MAX_RECV_SPEED_LARGE,100000);
            curl_exec($ch);

            if (!curl_errno($ch)) {
                $info = curl_getinfo($ch);
                $CI->Admin->updateTable("sites",array("curl_info" => json_encode($info)),array("url" => $domain));

            }


            curl_close($ch);

            $return['message'] = 'Done!';
            break;
        case 'available_domain':
            $site_obj 	= $CI->Admin->getTable("sites",array("url" => $domain));
            $site 		= $site_obj->row();
            ValidateTDL($site);
            $return['message'] = 'Done!';
            break;
        case 'internalLinks':
            $site_obj 	= $CI->Admin->getTable("sites",array("url" => $domain));
            $site 		= $site_obj->row();
            $links 		= getAllLinks($site->body,$domain,20);
            foreach ($links as $key => $value)
            {

                $ret = ping($value['link'],5);
                $error = 0;
                if($ret == 404 || $ret == 500 || $ret == 0)
                    $error = 1;
                //$links_raw .= $value['link'].'|'.$value['title']."|".$ret."|".$value['rel']."|".$error.";;";
                $links_raw[] = array("link" => $value['link'],"title" => $value['title'],"response" => $ret,"error" => $error,"rel" => $rel);
            }
            $save['links'] 		= json_encode($links_raw);
            $CI->Admin->updateTable("sites",$save,array("url" => $domain));
            $return['message'] = 'Done!';
            break;

        case 'serverInfo':
            $site_obj 			= $CI->Admin->getTable("sites",array("url" => $domain));
            $site 				= $site_obj->row();
            $ips 				= gethostbynamel($domain);
            $save['ip'] 		= implode(";",$ips);
            if($site->ip != $save['ip'] || $site->city == '')
            {
                $ipInfo 			= getIPInfo($ips[0]);
                $save['city']		= $ipInfo->city;
                $save['country']	= $ipInfo->country;
                $save['region']		= $ipInfo->regionName;
                $save['isp']		= $ipInfo->isp;
            }








            $return['message'] = 'Done!';

            break;
        case 'score':

            $CI->db->query("UPDATE {PRE}sites SET completed=0,score=0 WHERE  url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+7 WHERE  https = 1 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+10 WHERE  pageSpeed > 50 AND pageSpeed <= 80 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+20 WHERE  pageSpeed > 80 AND pageSpeed <= 85 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+25 WHERE  pageSpeed > 85 AND pageSpeed <= 91 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+38 WHERE  pageSpeed > 91 AND pageSpeed <= 98 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+50 WHERE  pageSpeed > 98 AND url='$domain'");




            $CI->db->query("UPDATE {PRE}sites SET score=score+10 WHERE  pagespeed_mobile > 91 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+15 WHERE  pagespeed_mobile > 95 AND url='$domain'");

            $CI->db->query("UPDATE {PRE}sites SET score=score-5 WHERE  pagespeed_mobile < 91 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score-10 WHERE  pagespeed_mobile < 80 AND url='$domain'");


            $CI->db->query("UPDATE {PRE}sites SET score=score+12 WHERE  w3c > 0 AND w3c <=5 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+27 WHERE  w3c = 0 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+20 WHERE  (metaH1 > 0 OR metaH2 > 0) AND url='$domain'");


            // Bonus google_safe
            $CI->db->query("UPDATE {PRE}sites SET score=score+9 WHERE  google_safe = 1 AND url='$domain'");

            // Penalty google_safe
            $CI->db->query("UPDATE {PRE}sites SET score=score-50 WHERE  google_safe = 0 AND url='$domain'");

            // Bonus domainAuthority
            $CI->db->query("UPDATE {PRE}sites SET score=score+(domainAuthority/2) WHERE  domainAuthority >=50 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+(domainAuthority/3) WHERE  domainAuthority >=20  AND domainAuthority < 50 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+(domainAuthority/4) WHERE  domainAuthority >=10  AND domainAuthority < 20 AND url='$domain'");

            // Bonuns AMP
            $CI->db->query("UPDATE {PRE}sites SET score=score+10 WHERE  hasAMP = 1 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score-2 WHERE  hasAMP = 0 AND url='$domain'");




            // Penalty Title and Description
            $CI->db->query("UPDATE {PRE}sites SET score=score-5 WHERE  (CHAR_LENGTH(metaTitle)>180 OR CHAR_LENGTH(metaTitle)<5) AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score-5 WHERE  (CHAR_LENGTH(metaDescription)>250 OR CHAR_LENGTH(metaDescription)<5) AND url='$domain'");

            // Bonus Alexa
            $CI->db->query("UPDATE {PRE}sites SET score=score+10 WHERE  score<85 AND alexaGlobal < 800 AND alexaGlobal > 0 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+10 WHERE  score<85 AND alexaGlobal < 100 AND alexaGlobal > 0 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+10 WHERE  score<85 AND alexaLocal < 100 AND alexaLocal > 0 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score+10 WHERE  alexaLocal < 10 AND alexaLocal > 0 AND url='$domain'");


            // Fixed Value
            $CI->db->query("UPDATE {PRE}sites SET score=domainAuthority-2 WHERE  domainAuthority >85 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=0 WHERE  score < 0 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=99 WHERE  (score >99 OR domainAuthority > 99) AND url='$domain'");





            // Penalty domainAuthority
            $CI->db->query("UPDATE {PRE}sites SET score=score-5 WHERE  score>90 AND domainAuthority < 80 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score-5 WHERE  score>90 AND domainAuthority < 90 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=score-10 WHERE  score>80 AND domainAuthority < 10 AND url='$domain'");


            // Penalty Index Google
            //$CI->db->query("UPDATE {PRE}sites SET score=score-10 WHERE  googleIndex < 10 AND url='$domain'");


            // Fixed Value
            $CI->db->query("UPDATE {PRE}sites SET score=2+(domainAuthority/2) WHERE  score <= 0 AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET score=99 WHERE  (score >99 OR domainAuthority > 99) AND url='$domain'");
            $CI->db->query("UPDATE {PRE}sites SET url_real=url WHERE  url_real = '' AND url='$domain'");



            // Completed
            $CI->db->query("UPDATE {PRE}sites SET completed=1 WHERE url='$domain'");


            // Save history
            if(config_item("save_historical") == '1')
            {
                $site_obj 	= $CI->db->query("SELECT COUNT(*) AS total FROM {PRE}site_history WHERE created between '".date("Y-m-d")." 00:00:00' AND '".date("Y-m-d")." 23:59:59' AND url='$domain'")->row();
                if($site_obj->total == 0)
                {
                    $site_obj 	= $CI->Admin->getTable("sites",array("url" => $domain))->row();
                    $site_t 	= $CI->Admin->getTable("technologies",array("url" => $domain))->result();
                    $save = array();
                    $save['url'] = $domain;
                    $save['data'] = json_encode($site_obj);
                    $save['technologies'] = json_encode($site_t);
                    $CI->Admin->setTableIgnore("site_history",$save);
                    unset($save);
                }
            }


            if(config_item("email_update_site") == '1')
            {

                $ip = $CI->input->ip_address();
                $user = 'Guest';
                if(is_logged())
                    $user = _user("names")." - "._user("email");
                $message2 = "New domain updated on your site <br><br><strong>Domain: </strong>$domain<br><strong>User: </strong>$user<br><strong>IP Address: </strong>$ip";
                email(get_email_admin(),__("New domain updated"),$message2);


            }



            $return['message'] = 'Done!';

            break;

        default:
            # code...
            break;
    }

    return $return;
}

function ValidateTDL($site)
{
    $CI     =& get_instance();
    $tdl = array("co","us","com","info","org","net","info");
    $temp =explode(".", $site->url);
    unset($temp[count($temp)-1]);
    $domain = '';
    $domain = implode(".",$temp);

    foreach ($tdl as $key => $value) {
        $domain_OK = $domain.".".$value;

        $domains_list[] = $domain_OK;


    }


    $order=array('q','a','z','w','s','x','e','d','c','r','f','v','t','g','b','y','h','n','u','j','m','i','k','o','l','p');

    $domain = substr($site->url,1);

    foreach ($order as $key => $value) {
        if($value == $site->url[0])
        {

            $order2[] = $order[$key-3];
            $order2[] = $order[$key-2];
            $order2[] = $order[$key-1];
            $order2[] = $order[$key+1];
            $order2[] = $order[$key+2];
            $order2[] = $order[$key+3];

        }
    }


    $domainSplit = str_split($site->url);
    unset($domainSplit[1]);
    $domain_OK = implode("", $domainSplit);

    $domains_list[] = $domain_OK;




    foreach ($order2 as $key => $value) {
        if($value)
        {
            $domain_OK = $value.$domain;
            $domains_list[] = $domain_OK;


        }
    }

    foreach ($domains_list as $key => $value) {
        $whois[] 	= getWhois(config_item("4p1_key"),$value);
    }


    $CI->Admin->updateTable("sites",array("available_domain" => json_encode($whois)),array("url" => $site->url));





}
?>
