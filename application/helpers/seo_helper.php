<?php
function getAlexaRank($domain) {
	
	$xml = simplexml_load_string(_curl('http://data.alexa.com/data?cli=10&dat=snbamz&url='.$domain));
	$rank['local']['country'] 	= '-';
	$rank['local']['rank'] 		= '99999999';
	$rank['global']['rank'] 	= '99999999';
	if($xml->SD[1]) {	
		$rank['local']['country']	= (String)$xml->SD[1]->COUNTRY->attributes()->NAME.",".(String)$xml->SD[1]->COUNTRY->attributes()->CODE;
		$rank['local']['rank'] 	 	= (int)$xml->SD[1]->COUNTRY->attributes()->RANK;
		$rank['global']['rank']  	= (int)$xml->SD[1]->POPULARITY->attributes()->TEXT;
		if(!$rank['local']['rank'] || $rank['local']['rank'] == 0)
		{
			$rank['local']['rank']	 	= $rank['global']['rank'];
			$rank['local']['country']	= 'Global';
		}
	}
	return $rank;
}
function getAlexaBounceRate($domain) {

	$html_alexa = _curl('http://www.alexa.com/siteinfo/' . $domain);
	
	$document_alexa = new DOMDocument();
	
	$document_alexa->loadHTML($html_alexa);
	
	$selector_alexa = new DOMXPath($document_alexa);
	
	$content_alexa_bounce = $selector_alexa->query('/html/body//strong[@class="metrics-data align-vmiddle"]');
	$x=1;
	foreach($content_alexa_bounce as $node) {
		
		$doc = new DOMDocument();
		
		foreach ($node->childNodes as $child) {
		
			$doc->appendChild($doc->importNode($child, true));
			
		}
		
		$bounce_rate = $doc->saveHTML();		

		
		if(strpos($bounce_rate, "%") !== FALSE)
			break;
		$x++;
		
		
	}
	
	$bounce_rate = trim(str_replace('%','', $bounce_rate));
	
	if(is_numeric($bounce_rate))
	return $bounce_rate;
	
	return 0;
}
function getGoogleCount($domain) {
	$api_url = "http://www.google.ca/search?q=site%3A".$domain;
	$content = _curl($api_url); 
    if (empty($content))         
        return intval(0);        
    if (!strpos($content, 'results')) return intval(0);
    $match_expression = '/About (.*?) results/sim'; 
    preg_match($match_expression,$content,$matches); 
    if (empty($matches)) return intval(0);
    	return intval(str_replace(",", "", $matches[1]));			
}

function getYahooCount($domain) {
		
	$results = trim(getStringBetween(_curl("http://search.yahoo.com/search;_ylt=?p=site:" . $domain),'Next</a><span>',' results</span>'));

	$results= str_replace(",","",$results);

	if($results=="")
		return 0;
	return $results;
}

function getBingCount($domain) {

	$html_bing_results = _curl("http://www.bing.com/search?q=site:" . $domain . "&FORM=QBRE&mkt=en-US");
	
	$document = new DOMDocument(); 
	
	$document->loadHTML($html_bing_results);
	
	$selector = new DOMXPath($document);
	
	$anchors = $selector->query('/html/body//span[@class="sb_count"]');
	
	foreach ($anchors as $node) 
	{
	
		$doc = new DOMDocument();
		
		foreach ($node->childNodes as $child) {
		
			$doc->appendChild($doc->importNode($child, true));
			
		}
		
		$bing_results = $doc->saveHTML();		
	
	}
	
	$bing_results = str_replace("results","",$bing_results);
	
	$bing_results = str_replace(",","",$bing_results);
	
	if(trim($bing_results)!="") return $bing_results;
		return 0;
	
}


function getSpeedData($key,$domain,$strategy='desktop',$rules =false) {


	
	//$contents = _curl("https://www.googleapis.com/pagespeedonline/v1/runPagespeed?fields=score&key=$key&strategy=$strategy&url=http://$domain",false,false,false,false,false,40);  
	$domain = urlencode($domain);
	$lang = 'en';
	$contents = _curl("https://www.googleapis.com/pagespeedonline/v2/runPagespeed?locale=$lang&key=$key&screenshot=true&strategy=$strategy&url=$domain",false,false,false,false,false,40);  
	
	$json = json_decode($contents);
	


	
	if($json->responseCode == 200)
	{
		if(!$rules)
			return $json->ruleGroups->SPEED;
		return $json;
	}
	else
		return 0;
	
}

function domainAuthority3($domain) {		

	$url = 'https://seotools.iamsujoy.com/?route=bulktool';
	$fields = array(
		'getStatus' => "1",
		'sitelink' => $domain,
		'siteID' => "1",
		'da' => "1"
	);
	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	//open connection
	$ch = curl_init();
	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,10); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds

	//execute post
	$result = explode("td",curl_exec($ch));
	$da = str_ireplace("</","",$result[5]);
	$da = str_ireplace(">","",$da);
	//close connection
	curl_close($ch);
	return  intval($da);
}
function domainAuthority($domain) 
{	
	// Get your access id and secret key here: https://moz.com/products/api/keys
	$accessID = config_item("moz_accessID");
	$secretKey = config_item("moz_secretKey");
	if(!$accessID || !$secretKey)
		return 0;
	// Set your expires times for several minutes into the future.
	// An expires time excessively far in the future will not be honored by the Mozscape API.
	$expires = time() + 300;

	// Put each parameter on a new line.
	$stringToSign = $accessID."\n".$expires;

	// Get the "raw" or binary output of the hmac hash.
	$binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);

	// Base64-encode it and then url-encode that.
	$urlSafeSignature = urlencode(base64_encode($binarySignature));

	// Specify the URL that you want link metrics for.
	$objectURL = $domain;

	// Add up all the bit flags you want returned.
	// Learn more here: https://moz.com/help/guides/moz-api/mozscape/api-reference/url-metrics
	$cols = "103079231492";

	// Put it all together and you get your request URL.
	// This example uses the Mozscape URL Metrics API.
	$requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($objectURL)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;

	// Use Curl to send off your request.
	$options = array(
		CURLOPT_RETURNTRANSFER => true
		);

	$ch = curl_init($requestUrl);
	curl_setopt_array($ch, $options);
	$content = json_decode(curl_exec($ch));
	
	curl_close($ch);	
	return $content;
}

function domainAuthority4($domain) {		

	$url = 'http://99traffictools.com/?route=ajax';
	$fields = array(
		'mozAuthority' => "1",
		'sitelink' => $domain,		
		'domainAuthority' => "1"
	);
	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	//open connection
	$ch = curl_init();
	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,10); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds

	//execute post
	$da = curl_exec($ch);	
	//close connection
	curl_close($ch);
	return  intval($da);
}


function domainAuthorityBK($domain) {		

	$url = 'http://www.seoweather.com/wp-admin/admin-ajax.php';
	$fields = array(
		'action' => "getData",
		'linkz' => $domain,
		'divid' => "1"
	);
	//url-ify the data for the POST
	foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
	rtrim($fields_string, '&');
	//open connection
	$ch = curl_init();
	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, count($fields));
	curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,10); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 10); //timeout in seconds

	//execute post
	$result = explode("td",curl_exec($ch));
	foreach ($result as $key => $value) {
		if(strpos($value,"dar") !== FALSE)
		{
			$da = $value;
			$da = strip_tags("<div ".stripslashes($da)."</div>");
		}
	}
	//close connection
	curl_close($ch);
	return  intval($da);
}

function getW3C($url)
{
	$json = _curl("https://validator.w3.org/nu/?doc=http://$url&out=json&level=error");
	$w3c=json_decode($json);
	return count($w3c->messages);
	
}
function getBuiltWith($key,$url)
{
	$json = _curl("https://builtwith.4p1.co/?url=$url&apikey=$key",false,false,false,false,false,15);	
	return json_decode($json);	
	
}
function getWhois($key,$url)
{	
	$json = _curl("https://whois.4p1.co/?method=domain&domain=$url&apikey=$key",false,false,false,false,false,8);	
	
	return json_decode($json);	
	
}
function googleSafe($domain) {
	
		$results = _curl("http://www.google.com/safebrowsing/diagnostic?site=" . $domain);		
		if (strpos($results,'This site is not currently listed as suspicious') !== FALSE)
			return false;		
	return true;	
}

function getStatsData($site,$technologies)
{	

	
	
	$total 		= 15;
	$warning 	= 0;
	$errors 	= 0;
	// Title
	$optimize['title'] = 'success';
	if(mb_strlen($site->metaTitle) >0 && (mb_strlen($site->metaTitle)<8 || mb_strlen($site->metaTitle)>60))	
	{
		$optimize['title'] = 'warning';
		$warning++;
	}
	if(mb_strlen($site->metaTitle) == 0)	
	{
		$optimize['title'] = 'error';
		$errors++;
	}


	// Description
	$optimize['description'] = 'success';
	if(mb_strlen($site->metaDescription) >0 && (mb_strlen($site->metaDescription)<10 || mb_strlen($site->metaDescription)>150))	
	{
		$optimize['description'] = 'warning';
		$warning++;
	}
	if(mb_strlen($site->metaDescription) == 0)	
	{
		$optimize['description'] = 'error';
		$errors++;
	}


	// Robots
	$optimize['robots'] = 'success';
	if(!$site->robots)
	{
		$optimize['robots'] = 'warning';
		$warning++;
	}

	//Sitemap
	$optimize['sitemap'] = 'success';
	if(!$site->sitemap)
	{
		$optimize['sitemap'] = 'error';
		$errors++;
	}

	//Google Indexed
	/*$optimize['googleIndex'] = 'success';
	if($site->googleIndex<100 && $site->googleIndex >=5)
	{
		$optimize['googleIndex'] = 'warning';
		$warning++;
	}
	if($site->googleIndex<5)
	{
		$optimize['googleIndex'] = 'error';
		$errors++;
	}*/

	//SSL
	$optimize['https'] = 'success';
	if(!$site->https)
	{
		$optimize['https'] = 'warning';
		$warning++;
	}

	// hasAMP
	$optimize['hasAMP'] = 'success';
	if(!$site->hasAMP)
	{
		$optimize['hasAMP'] = 'warning';
		$warning++;
	}

	
	//Page Speed
	$optimize['pageSpeed'] = 'success';
	if($site->pageSpeed < 85 && $site->pageSpeed > 50)
	{
		$optimize['pageSpeed'] = 'warning';
		$warning++;
	}
	if($site->pageSpeed < 50)
	{
		$optimize['pageSpeed'] = 'error';
		$errors++;
	}


	//Page Speed Mobiles
	$optimize['pagespeed_mobile'] = 'success';
	if($site->pagespeed_mobile < 88 && $site->pagespeed_mobile > 50)
	{
		$optimize['pagespeed_mobile'] = 'warning';
		$warning++;
	}
	if($site->pagespeed_mobile < 50)
	{
		$optimize['pagespeed_mobile'] = 'error';
		$errors++;
	}


	// Headers
	$optimize['headers'] = 'success';
	if($site->metaH1 <1 && $site->metaH2 <1)
	{
		$optimize['headers'] = 'error';
		$errors++;
	}
	if($site->metaH1 >1 && $site->metaH2 < 1)
	{
		$optimize['headers'] = 'warning';
		$warning++;
	}

	//Google Safe Browsing
	$optimize['google_safe'] = 'success';
	if(!$site->google_safe)
	{
		$optimize['google_safe'] = 'error';
		$errors++;
	}

	//W3C
	$optimize['w3c'] = 'success';
	if($site->w3c <5 && $site->w3c > 0)
	{
		$optimize['w3c'] = 'warning';
		$warning++;
	}
	if($site->w3c > 5)
	{
		$optimize['w3c'] = 'error';
		$errors++;
	}


	//Domain Authority
	$optimize['domainAuthority'] = 'success';
	if($site->domainAuthority > 10 && $site->domainAuthority < 25)
	{
		$optimize['domainAuthority'] = 'warning';
		$warning++;
	}
	if($site->domainAuthority < 10)
	{
		$optimize['domainAuthority'] = 'error';
		$errors++;
	}

	$optimize['gzip'] = 'error';
	$errors++;
	foreach ($technologies as $key => $value) {
			if(preg_replace('/^(.*)$/', '\L$1',$value->name)  == 'gzip')
			{
				$optimize['gzip'] = 'success';
				$errors--;				
			}	

	}

	$optimize['favicon'] = 'success';
	if(trim($site->favicon) == '')
	{
		$optimize['favicon'] = 'warning';
		$warning++;
	}

	$optimize['links'] = 'success';
	$temp = json_decode($site->links);
	foreach ($temp as $key => $value) {
		if($value->error == '1')
		{
			$optimize['links'] = 'error';
			$errors++;
			break;
		}
	}
		







	$response['errors'] 		= intval(($errors*100)/$total);
	$response['warning']	 	= intval(($warning*100)/$total);
	$response['success'] 		= 100-($response['errors']+$response['warning']);
	$response['optimize'] 		= $optimize;
	
	return $response;
	
	
}


function getFavIcon($html)
{	
	if($html == '')
		return false;

		$doc = new DOMDocument();	
		if(!$doc->loadHTML($html))
			return false;
		
		
		$xml = simplexml_import_dom($doc);
		if(!$xml)
			return false;
		$arr = $xml->xpath('//link[@rel="shortcut icon"]');
		if(!$arr[0]['href'])
		{
			$arr = $xml->xpath('//link[@rel="icon"]');
		}
		if(!$arr[0]['href'])
		{
			$arr = $xml->xpath('//link[@rel="icon shortcut"]');
		}
		return (String)$arr[0]['href'];
	
}
function hasAMP($html)
{	

	if($html == '')
		return false;


	if(mb_strpos($html,"<html ⚡>") !== FALSE)
		return true;
	if(mb_strpos($html,"<html &#9889;>") !== FALSE)
		return true;
	if(mb_strpos($html,"<html amp>") !== FALSE)
		return true;
	if(mb_strpos($html,"<style amp-custom>") !== FALSE)
		return true;
	
	try{
		$doc = new DOMDocument();	
		$doc->loadHTML($html);
		$xml = simplexml_import_dom($doc);
		if(!$xml)
			return false;
		$arr = $xml->xpath('//link[@rel="amphtml"]');
		if($arr[0]['href'])
			return true;
		return false;
	}
	catch(Exception $e)
	{
		return false;
	}
}

function getFacebookCount($url)
{
	/*$html = _curl("https://www.facebook.com/v2.5/plugins/like.php?locale=en_US&href=".urlencode($url));
    
    preg_match("/and (.*?) others/", $html, $match);
    
    $likes =  $match[1];
	return $likes;*/

	$json = json_decode(_curl("https://graph.facebook.com/?id=".urlencode($url)));
    return intval($json->share->share_count);
	
}
function getLinkedInCount($url)
{
	$json = json_decode(_curl("https://www.linkedin.com/countserv/count/share?url=".urlencode($url)."&format=json"));
    return intval($json->count);
}
function getPinterestCount($url)
{
	$json = json_decode(_curl("http://api.pinterest.com/v1/urls/count.json?callback=receiveCount&url=".urlencode($url)));
    return intval($json->receiveCount->count);
}
function getStumbleuponCount($url)
{
	$json = json_decode(_curl("http://www.stumbleupon.com/services/1.01/badge.getinfo?url=".urlencode($url)));
    return intval($json->result->views);
}
function getGooglePlusCount($url)
{
		$post ='[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]';
		$json = json_decode(_curl("https://clients6.google.com/rpc?key=AIzaSyCKSbrvQasunBoV16zDH9R33D88CeLr9gQ",$post,false,true));

		return intval($json[0]->result->metadata->globalCounts->count);

}
function inHX($html,$string,$hx = "h1")
{
    $h1 = getTextBetweenTags(preg_replace('/^(.*)$/', '\L$1',$html),$hx);
    
    foreach ($h1 as $key => $value) {
        if(mb_strpos($value, $string) !== FALSE)
            return true;
    }
    return false;
    
}
