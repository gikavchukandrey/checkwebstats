<?
	$url = "cnn.com";
	$xml = simplexml_load_file("http://data.alexa.com/data?cli=10&dat=snbamz&url=".$url);
    $count = count($xml->RLS->RL);
    $i = 0;
    $links = "";
    while ($i < $count){
    $link = $xml->RLS->RL[$i]->attributes('')->HREF;
    $link = substr("$link", 0, -1);
    $link = str_replace("www.", "", $link);
    //mysql_query("INSERT INTO cme_sites (url) VALUES ('$link')");
    $links = $link.";".$links;
    $i++;
    }
	if ($count == 0){
		$links = "none";
	}
	if ($links != "none"){
	$links = substr("$links", 0, -1);
	}
	print_r($links);
	exit();
	return $links;
	
	?>