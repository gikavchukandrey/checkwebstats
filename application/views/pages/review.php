<?php
	$noADS = hasbadWords($site->body." ".$site->metaTitle. " ".$site->metaDescription." ".$site->metaKeywords);
	$blocks = explode(",",config_item("guest_block"));
	$modules = explode(",",config_item("enable_block"));

	if(is_logged())
	{
		$temp = explode(",",config_item("paypal_p"._user("plan")."_modules"));

		$blocks= array();
		$blocks = $temp;

		/*$blocks[] ='traffic';
	    $blocks[] ='tips';
	    $blocks[] ='alexa';
	    $blocks[] ='server';
	    $blocks[] ='meta';
	    $blocks[] ='authority';
	    $blocks[] ='pagespeed';
	    $blocks[] ='pagespeed_stats';
	    $blocks[] ='technologies';*/
	}



?>
<!--<img src="data:image/jpeg;base64, <?php echo $image; ?>">-->

<?php if($cached){
?>
<div class="container">
<div class="alert alert-warning m-t-2">
<strong><i class="zmdi zmdi-alert-circle"></i> <?php echo __("Historical Data: "); ?></strong> <?php echo __("This is a cache of"); ?> <?php echo $site->url; ?>
<a class="pull-right " style="color:#FFF" href="<?php echo base_url(); ?><?php echo $site->url; ?>"><?php echo __("Go to last version"); ?></a>

</div>
</div>
<?php
}
?>
<div class="container <?php if($cached){ echo 'historical'; }?>" id="main">
	<div class="row">

		<div class="col-lg-3 col-md-4">
			<div class="card card-block score-fixed">
						<h2 class="small text-xs-center"><?php echo __("Your Website Score is"); ?></h2>

						<div class=" circle" data-color="<?php echo config_item("style_main_color"); ?>" data-text="<?php echo __("Score Rank"); ?>"  data-fbw="<?php echo config_item("chart_border_size"); ?>" data-bbw="<?php echo config_item("chart_border_size"); ?>" data-color="#4390BE" data-percent="<?php echo $site->score; ?> "></div>

						<?php
						$days			= getDaysDiff($site->updated,date("Y-m-d H:i:s"));

						if(intval($days) >= intval(config_item("update_inverval")) && !$cached)
						{
							?><button class="btn btn-secondary btn-sm btn-block btn-update " data-domain="<?php echo $site->url; ?>"><i class="zmdi zmdi-refresh-alt"></i> <?php echo __("Update"); ?></button><?php

						}
						?>


				</div>



				<?php
					if(!$noADS)
						echo get_ads("ads1","text-xs-center ads card card-block no-padding p-b-1 p-t-1");
					else
						echo  "<!-- Note: Bad words detected disable ads for security reasons -->";
				?>


			<?php if(count($similar)>1){ ?>
			<div class="card card-block hidden-sm-down">
				<h2 class="small  p-b-1"><?php echo __("Similar Ranking"); ?></h2>
				<?php foreach ($similar as $key => $value){
					if($value->id != $site->id){
					?>
				<div class="site-list">
					<div class="score"><?php echo $value->score; ?></div>
					<div class="data">
						<div class="title truncate"><?php echo badWords($value->metaTitle); ?></div>
						<a href="<?php echo base_url(); ?><?php echo $value->url; ?>" class="subtitle truncate"><?php echo badWords($value->url); ?></a>
					</div>
				</div>
				<?php } } ?>
			</div>
			<?php } ?>

			<?php if(count($historicalData)>=1){ ?>
			<div class="card card-block">
				<h2 class="small  p-b-1"><?php echo __("Historical Data"); ?></h2>
				<?php foreach ($historicalData as $key => $value){
					$old = json_decode($value->data);
					?>
				<div class="site-list <?php if($cached == date("Y-m-d",strtotime($value->created))){ echo 'active'; } ?>">
					<div class="score">
							<img src="<?php echo renderScreenshot($old); ?>">

					</div>
					<div class="data">
						<div class="title truncate"><?php echo badWords($old->metaTitle); ?></div>
						<a href="<?php echo base_url(); ?><?php echo $old->url; ?>?d=<?php echo date("Y-m-d",strtotime($value->created)); ?>" class="subtitle truncate"><?php echo date("Y-m-d",strtotime($value->created)); ?></a>
					</div>
				</div>
				<?php }  ?>
				<a class="d-block m-t-1 text-xs-center" href="<?php echo base_url(); ?><?php echo config_item("slug_historical"); ?>/<?php echo $site->url; ?>"><?php echo __("View all historical data"); ?></a>
			</div>
			<?php } ?>

			<?php if(count($recents)>1){ ?>
			<div class="card card-block hidden-sm-down">
				<h2 class="small p-b-1"><?php echo __("Latest Sites"); ?></h2>
				<?php foreach ($recents as $key => $value){
					if($value->id != $site->id){
						if(!$value->metaTitle)
							$value->metaTitle = '-';
					?>
				<div class="site-list">
					<div class="score"><?php echo $value->score; ?></div>
					<div class="data">
						<div class="title truncate"><?php echo badWords($value->metaTitle); ?></div>
						<a href="<?php echo base_url(); ?><?php echo $value->url; ?>" class="subtitle truncate"><?php echo badWords($value->url); ?></a>
					</div>
				</div>
				<?php } } ?>
			</div>
			<?php } ?>

			<?php if(count($top['technologies'])>1){ ?>
			<div class="card card-block hidden-sm-down">
				<h2 class="small p-b-1"><?php echo __("Top Technologies"); ?></h2>
				<?php foreach ($top['technologies'] as $key => $value){

					?>
				<div class="site-list">
					<div class="score">
						<img src="<?php echo base_url(); ?>assets/images/icons/<?php echo $value->icon; ?>">
					</div>
					<div class="data">
						<div class="title truncate"><?php echo ($value->name); ?></div>
						<a href="<?php echo base_url(); ?><?php echo config_item("slug_filter"); ?>/<?php echo config_item("slug_made_with"); ?>/<?php echo urlencode($value->name); ?>" class="subtitle truncate"><?php echo ($value->tag1); ?></a>
					</div>
				</div>
				<?php }  ?>
			</div>
			<?php } ?>

		</div>
		<?php
##yadore integration

function getMerchants($market){
global $allMerchants;
// Get cURL resource
$ch = curl_init();

// Set url
curl_setopt($ch, CURLOPT_URL, "https://api.Yadore.com/v1/merchant?market=$market");

// Set method
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

// Set options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Set headers
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "API-Key: Uz7HeQtJDK4BJFHyZLiVsuvhmaiOa4hiltpLmbIqHtPXsNILScRg9AquMXYIpieo",
 ]
);


// Send the request & save response to $resp
$resp = curl_exec($ch);




	if(!$resp) {
	  die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
	} else {
	  //echo "Response HTTP Status Code : " . curl_getinfo($ch, CURLINFO_HTTP_CODE);
	 // echo "\nResponse HTTP Body : " . $resp;
	 	$json = json_decode($resp);
		$market = $json->{'request'}->{'market'};
			$i = 0;
		$merchantName = $json->{'response'}->{'merchants'}[$i]->{'name'};
		while ($merchantName){
				$merchantName = $json->{'response'}->{'merchants'}[$i]->{'name'};
				$merchantId = $json->{'response'}->{'merchants'}[$i]->{'id'};
				$merchantUrl = $merchantName;
				$offerCount = $json->{'response'}->{'merchants'}[$i]->{'offerCount'};
				if ($merchantName){
					$allMerchants[$merchantUrl]['url'] = $merchantUrl;
					$allMerchants[$merchantUrl]['id'] = $merchantId;
					$allMerchants[$merchantUrl]['market'] = $market;
					$allMerchants[$merchantUrl]['offerCount'] = $offerCount;
					$j = $i +1;
					//echo "$j $merchantName <br />";
				}
			$i++;
		}
		return $allMerchants;
	}

// Close request to clear up some resources
curl_close($ch);
}

$allMerchants =  array();

$allMerchants = getMerchants("pl",$allMerchants);
$allMerchants = getMerchants("uk",$allMerchants);
$allMerchants = getMerchants("de",$allMerchants);
$allMerchants = getMerchants("fr",$allMerchants);
$allMerchants = getMerchants("it",$allMerchants);
$allMerchants = getMerchants("es",$allMerchants);
$allMerchants = getMerchants("at",$allMerchants);
$allMerchants = getMerchants("ch",$allMerchants);
$json = json_encode($allMerchants);
$merchantId = $allMerchants[$site->url]['id'];
$merchantMarket = $allMerchants[$site->url]['market'];
$offerCount = $allMerchants[$site->url]['offerCount'];


##yadore end
if ($merchantId){
	$offset = $offerCount / 20;
	$offset = floor($offset);
	$offset = $offset - 1;
	$offset = mt_rand(0,$offset);

	//getOffers

		// Get cURL resource
		$ch = curl_init();

		// Set url
		curl_setopt($ch, CURLOPT_URL, "https://api.Yadore.com/v1/offer?market=$merchantMarket&merchantId=$merchantId&offset=$offset");

		// Set method
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

		// Set options
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// Set headers
		curl_setopt($ch, CURLOPT_HTTPHEADER, [
		  "API-Key: Uz7HeQtJDK4BJFHyZLiVsuvhmaiOa4hiltpLmbIqHtPXsNILScRg9AquMXYIpieo",
		 ]
		);


		// Send the request & save response to $resp
		$resp = curl_exec($ch);

		if(!$resp) {
		  die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
		} else {
		 // echo "Response HTTP Status Code : " . curl_getinfo($ch, CURLINFO_HTTP_CODE);
		//  echo "\nResponse HTTP Body : " . $resp;
		}

		// Close request to clear up some resources
		curl_close($ch);

		$json = json_decode($resp);


			$i = 0;
		$offers = $json->{'result'}->{'offers'}[$i];

		$offerTitle = $offers->title;
		$clickUrl = $offers->clickUrl;




if ($offerTitle){


?>
		<div class="col-lg-9 col-md-8">

			<div class="card card-block">
				<div class="col-lg-12">
				<a class="small text-xs-center website" rel="nofollow external" target="_blank" href="http://<?php echo $site->url; ?> ">
				<i class="zmdi zmdi-shopping-cart"></i>
				</a><b>Products</b> - check out these products from <b><a href='<?php echo badWords($site->url); ?>' onclick="window.open('<?php echo badWords($site->url); ?>');document.location.href='<?php echo badWords($site->url); ?>';" target="_blank"><?php echo badWords($site->url); ?> </a></b>
				</div>
				<div class="col-lg-12">
					<div class='row'>
					<?php
						while ($offers && $i < 10){
							$offers = $json->{'result'}->{'offers'}[$i];
							$offerTitle = $offers->title;
							$clickUrl = $offers->clickUrl;
							$i++;
							echo "<div class='col-lg-6'>";
									echo "<a target='_blank' onclick=\"window.open('$clickUrl');\">".substr($offerTitle, 0, 45)."</a>";
									echo "</div>";
		}
	}

						?>
					</div>
				</div>
			</div>
		</div>
<?php
	}
?>
		<div class="col-lg-9 col-md-8">

			<div class="card card-block">
				<div class="col-lg-12">
				<a class="small text-xs-center website" rel="nofollow external" target="_blank" href="http://<?php echo $site->url; ?> ">
				<i class="zmdi zmdi-globe"></i>
				</a><b>Similar Websites</b> - check out these websites that are similar to <b><a href='<?php echo badWords($site->url); ?>' onclick="window.open('<?php echo badWords($site->url); ?>');document.location.href='<?php echo badWords($site->url); ?>';" target="_blank"><?php echo badWords($site->url); ?> </a></b>
				</div>
				<div class="col-lg-12">
					<?php
					error_reporting(0);
					$conn22 = mysqli_connect("checkwebstatsdb.co0ssesikagz.eu-central-1.rds.amazonaws.com", "checkwebstats", "wTjdMepaCQB0u%E", "checkwebstatsdb");
					mysqli_set_charset($conn22,"utf8");
					if (!$conn22) {
						die("Connection failed: " . mysqli_connect_error());
					}

					$domain = $site->url;

				$sql2 = "SELECT * FROM px_sites
				WHERE similarSites LIKE '%;$domain;%'
				ORDER BY RAND()
				";

				$result2 = $conn22->query($sql2);
				if ($result2->num_rows > 0) {
					$doUpdate = "no";
				} else {
					$doUpdate = "yes";

				}

								$j = 0;
								while ($row = mysql_fetch_assoc($result2)) {
									if ($j == 0){
										echo "<div class='row'>";
									}

									$url = str_replace(" ", "", $url);
									echo "<div class='col-lg-4'>";
									echo "<a target='_blank' onclick=\"window.open('http://".$row['url']."');document.location.href='".$row['url']."'\" href='http://".$row['url']."'>".substr($row['url'], 0, 30)."</a>";
									echo "</div>";

									if ($j == 2){
										echo "</div>";
										$j = 0;
									} else {
										$j++;

										}
										}


						 $simsites = $site->similarSites;
						 $simsites = explode(";", $simsites);

						 $length = count($simsites);
						 $i = 0;
						 while ($i <= $length -1){

							 if ($simsites[$i] == "none"){
								 break;
							 }

							 if ($j == 0){
										echo "<div class='row'>";
									}
							echo "<div class='col-lg-4'>";
							 echo "<a target='_blank' onclick=\"window.open('http://".$simsites[$i]."');document.location.href='".$simsites[$i]."'\" href='http://".$simsites[$i]."'>".substr($simsites[$i], 0, 30)."</a>";
							 echo "</div>";
							 $i++;

						 	if ($j == 2){
								echo "</div>";
								$j = 0;
								} else {
								$j++;
								}
						}
						 if ($length == 0 || !$length || $length == "" || $simsites[0] === NULL || $simsites[0] == ""){
							 $whereToUpdate = $site->url;
							 $xml = simplexml_load_file("http://data.alexa.com/data?cli=10&dat=snbamz&url=".$whereToUpdate);
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

							$sql3 = "UPDATE px_sites Set similarSites = '$links' WHERE url = '$whereToUpdate'";
							$conn22->query($sql3);

							echo "<script>location.reload();</script>";
						}

						if ($simsites[0] == "none"){

							 echo "No similar Websites found (yet)";
						 }


					?>

				</div>
				<div class="col-lg-12">
				<?php




				?>


				</div>
			</div>
		</div>


		<div class="col-lg-9 col-md-8">
									<h2 class="nice-title m-t-0 "><i class=""><?php echo $site->score; ?></i>
									<span><?php echo badWords($site->url); ?> </span>
									<small class="hidden-sm-down pull-lg-right m-r-2">
									<?php
									if($cached){ ?>
										 <?php echo __("It is a snapshot of the page as it appeared on"); ?> <?php echo $cached; ?>
										<?php
									}else{
										echo __("Last Updated"); ?>: <?php echo ago($site->updated); ?>

									<?php
									}
									?>


									</small></h2>

			<div class="card card-block first">
				<div class="col-lg-12">





				</div>

				<div class="col-lg-4 p-t-1">

					<div class="screen animated bounceInUp">
						<div class="m">
							<div class="web">
								<img class="img-fluid"  src="<?php echo renderScreenshot($site); ?>">
							</div>
							<div class="f">
								<div class="p"></div>
							</div>
						</div>
						<div class="f2"></div>
					</div>
				</div>
				<div class="col-lg-8 p-t-1">
					<div class="row">
						<?php
							$stats 		= getStatsData($site,$technologies);
							$optimize 	= $stats['optimize'];


						?>
						<?php

							?>

						<div class="col-lg-12">
							<strong class="text d-block"><?php echo __("Success"); ?></strong>
							<small class="text-muted"><?php echo $stats["success"]; ?>% <?php echo __("of passed verification steps"); ?></small>
							<progress class="progress progress-success progress-sm" value="<?php echo $stats["success"]; ?>" max="100"></progress>
						</div>


						<div class="col-lg-12">
							<strong class="text d-block"><?php echo __("Warning"); ?></strong>
							<small class="text-muted"><?php echo $stats["warning"]; ?>% <?php echo __("of total warning"); ?></small>
							<progress class="progress progress-warning progress-sm" value="<?php echo $stats["warning"]; ?>" max="100"></progress>
						</div>

						<div class="col-lg-12">
							<strong class="text d-block"><?php echo __("Errors"); ?></strong>
							<small class="text-muted"><?php echo $stats["errors"]; ?>% <?php echo __("of total errors, require fast action"); ?></small>
							<progress class="progress progress-danger progress-sm" value="<?php echo $stats["errors"]; ?>" max="100"></progress>
						</div>





					</div>

				</div>

				<div class="fot">
						<?php if(!$cached){ ?>
						<?php
						if(is_logged())
						{
							if(isBookmark($site->id)){
								?><div class="pull-right btn-bookmark  btn-link" data-action="1" data-idsite="<?php echo $site->id; ?>"><i class="zmdi zmdi-star"></i> <?php echo __("Remove from bookmark"); ?></div><?php
							}else
							{
								?><div class="pull-right btn-bookmark  btn-link" data-action="2"  data-idsite="<?php echo $site->id; ?>"><i class="zmdi zmdi-star-outline"></i> <?php echo __("Add to bookmark"); ?></div><?php
							}
						}
						?>

						<div class="pull-right btn-link btn-toggle-class" data-class="animated bounceIn" data-target="#share-block">
							<i class="zmdi zmdi-share"></i> <?php echo __("Share"); ?>
						</div>

							<?php if(!$cached){ ?>
							<form  class="hidden-md-down btn-link pull-xs-right" method="POST" action="<?php echo base_url(); ?>pdf/generate/<?php echo $site->url; ?>">
								<input type="hidden" value="1" name="pdf">
								<?php echo csrf(); ?>
								<button type="submit" class="  "><i class="zmdi zmdi-collection-pdf"></i> <?php echo __("Download PDF"); ?></button>
							</form>
							<?php } ?>

						<?php } ?>
					</div>

			</div>



		<div class="p-b-1" id="share-block">

			<div class="btn-group d-block " role="group" aria-label="Share">
				<?php
				$url_share =  urlencode(base_url().$site->url);
				?>
				<a href="#" data-url="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_share; ?>" class="btn btn-share btn-xs btn-facebook col-md-2 col-xs-12"><i class="zmdi zmdi-facebook"></i></a>
				<a href="#" data-url="https://twitter.com/home?status=<?php echo $url_share; ?>" class="btn btn-share btn-xs btn-twitter col-md-2 col-xs-12"><i class="zmdi zmdi-twitter"></i></a>
				<a href="#" data-url="https://plus.google.com/share?url=<?php echo $url_share; ?>" class="btn btn-share btn-xs btn-google col-md-2 col-xs-12"><i class="zmdi zmdi-google-plus"></i></a>
				<a href="#" data-url="https://www.linkedin.com/shareArticle?mini=true&title=&summary=<?php echo $url_share; ?>&source=<?php echo $url_share; ?>&url=<?php echo $url_share; ?>" class="btn btn-share btn-xs btn-linkedin col-md-2 col-xs-12"><i class="zmdi zmdi-linkedin"></i></a>
				<a href="#" data-url="https://pinterest.com/pin/create/button/?media=<?php echo $url_share; ?>&description=<?php echo $this->metaTitle; ?>&url=<?php echo $url_share; ?>" class="btn btn-share btn-xs btn-pinterest col-md-2 col-xs-12"><i class="zmdi zmdi-pinterest"></i></a>
				<a href="#" data-url="mailto:?&body=<?php echo $url_share; ?>" class="btn btn-share btn-xs btn-info col-md-2 col-xs-12"><i class="zmdi zmdi-email"></i></a>
			</div>
			<div class="clearfix"></div>
		</div>


		<?php if(in_array("pagespeed", $modules)){ ?>
			<div class="card card-block hidden-md-down" id="pagespeed">
				<?php if(in_array("pagespeed", $blocks)){ ?>
				<div class="col-md-3">
					<div class="circle" data-text="<?php echo __("PageSpeed Desktop"); ?>" data-fbw="<?php echo config_item("chart_border_size"); ?>" data-bbw="<?php echo config_item("chart_border_size"); ?>"  data-color="<?php echo colorCircle($site->pageSpeed,85); ?>" data-percent="<?php echo $site->pageSpeed; ?>"></div>
				</div>

				<div class="col-md-3">
					<div class="circle" data-text="<?php echo __("PageSpeed Mobile"); ?>" data-fbw="<?php echo config_item("chart_border_size"); ?>" data-bbw="<?php echo config_item("chart_border_size"); ?>"  data-color="<?php echo colorCircle($site->pagespeed_mobile,85); ?>" data-percent="<?php echo $site->pagespeed_mobile; ?>"></div>
				</div>

				<div class="col-md-3">
					<div class="circle" data-text="<?php echo __("Usability Mobile"); ?>"  data-fbw="<?php echo config_item("chart_border_size"); ?>" data-bbw="<?php echo config_item("chart_border_size"); ?>" data-color="<?php echo colorCircle($site->pagespeed_usability,85); ?>" data-percent="<?php echo $site->pagespeed_usability; ?>"></div>
				</div>

				<div class="col-md-3">
					<div class="circle" data-text="<?php echo __("Domain Authority"); ?>"   data-fbw="<?php echo config_item("chart_border_size"); ?>" data-bbw="<?php echo config_item("chart_border_size"); ?>" data-color="<?php echo colorCircle($site->domainAuthority,50); ?>" data-percent="<?php echo $site->domainAuthority; ?>"></div>
				</div>
				<?php } else{ show_register('pagespeed'); }?>

			</div>
			<div class="card card-block hidden-md-up" id="pagespeed">
				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi zmdi-circle <?php echo getColor($site->pageSpeed,85); ?>   check"></i> <?php echo __("PageSpeed Desktop"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo __("Score"); ?> <?php echo number_format($site->pageSpeed); ?>%</small>
					</div>
					<div class="col-lg-8">
						<progress class="progress progress-sm <?php echo getColorProgress($site->pageSpeed,85); ?>" value="<?php echo getPor($site->pageSpeed,100); ?>" max="100"></progress>
					</div>
				</div>

				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi zmdi-circle <?php echo getColor($site->pagespeed_mobile,85); ?>   check"></i> <?php echo __("pagespeed_mobile Mobile"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo __("Score"); ?> <?php echo number_format($site->pagespeed_mobile); ?>%</small>
					</div>
					<div class="col-lg-8">
						<progress class="progress progress-sm <?php echo getColorProgress($site->pagespeed_mobile,85); ?>" value="<?php echo getPor($site->pagespeed_mobile,100); ?>" max="100"></progress>
					</div>
				</div>

				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi zmdi-circle <?php echo getColor($site->domainAuthority,50); ?>   check"></i> <?php echo __("Domain Authority"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo __("Score"); ?> <?php echo number_format($site->domainAuthority); ?>%</small>
					</div>
					<div class="col-lg-8">
						<progress class="progress progress-sm <?php echo getColorProgress($site->domainAuthority,50); ?>" value="<?php echo getPor($site->domainAuthority,100); ?>" max="100"></progress>
					</div>
				</div>

				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi zmdi-circle <?php echo getColor($site->pagespeed_usability,85); ?>   check"></i> <?php echo __("Usability"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo __("Score"); ?> <?php echo number_format($site->pagespeed_usability); ?>%</small>
					</div>
					<div class="col-lg-8">
						<progress class="progress progress-sm <?php echo getColorProgress($site->pagespeed_usability,85); ?>" value="<?php echo getPor($site->pagespeed_usability,100); ?>" max="100"></progress>
					</div>
				</div>
			</div>

		<?php } ?>

			<?php
				if(!$noADS)
					echo get_ads("ads2","text-xs-center ads card card-block p-b-1");
				else
					echo  "<!-- Note: Bad words detected disable ads for security reasons -->";

				?>

		<?php if(in_array("authority", $modules)){ ?>
			<div class="card card-block" id="authority">

				<?php if(in_array("authority", $blocks)){ ?>
				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi zmdi-circle <?php echo getColor($site->pageAuthority,24); ?>   check"></i> <?php echo __("Page Authority"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo __("Authority"); ?> <?php echo number_format($site->pageAuthority); ?>%</small>
					</div>
					<div class="col-lg-8">
						<progress class="progress progress-sm <?php echo getColorProgress($site->pageAuthority,24); ?>" value="<?php echo getPor($site->pageAuthority,100); ?>" max="100"></progress>
					</div>
				</div>


				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi zmdi-circle <?php echo getColor($site->mozRank,3); ?>   check"></i> <?php echo __("Moz Rank"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo number_format($site->mozRank,1); ?>/10</small>
					</div>
					<div class="col-lg-8">
						<progress class="progress progress-sm <?php echo getColorProgress($site->mozRank,3); ?>" value="<?php echo getPor($site->mozRank,10); ?>" max="100"></progress>
					</div>
				</div>


				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi zmdi-trending-up  <?php echo getColor(30,$site->bounceRate); ?> check"></i> <?php echo __("Bounce Rate"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo __("Rate"); ?> <?php echo number_format($site->bounceRate); ?>%</small>
					</div>
					<div class="col-lg-8">
						<progress class="progress progress-sm <?php echo getColorProgress(30,$site->bounceRate); ?>" value="<?php echo getPor($site->bounceRate,100); ?>" max="100"></progress>
					</div>
				</div>




				<?php } else{ show_register('authority'); }?>






			</div>

			<?php } ?>


			<?php if(in_array("meta", $modules)){ ?>

			<div class="card card-block" id="meta">
				<?php if(in_array("meta", $blocks)){ ?>
					<?php if($site->charset){ ?>
					<div class="row p-t-2 ">
						<div class="col-lg-4">

							<strong><i class="zmdi zmdi-dot-circle  check"></i> <?php echo __("Charset"); ?></strong>
							<small class="text-muted d-block subtitle"><?php echo  __("Encoding"); ?></small>
						</div>
						<div class="col-lg-8 text-muted">
							<?php echo __("Great, language/character encoding is specified:"); ?>  <strong><i class="zmdi zmdi-check"></i> <?php echo mb_strtoupper($site->charset); ?></strong>
						</div>
					</div>
					<?php } ?>


				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<?php
							$metaTitle = validateLenght($site->metaTitle,60,5);
						?>
						<strong><i class="zmdi <?php echo $metaTitle['icon']; ?> <?php echo $metaTitle['color']; ?> check"></i> <?php echo __("Title Tag"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo number_format($metaTitle['lenght']); ?> <?php echo __("Characters"); ?></small>
					</div>
					<div class="col-lg-8 text-muted">
						<?php echo $metaTitle['fixed']; ?>
					</div>
				</div>

				<div class="row  p-t-2">
					<div class="col-lg-4">

						<?php
							$metaDescription = validateLenght($site->metaDescription,150,10);
						?>

						<strong><i class="zmdi <?php echo $metaDescription['icon']; ?> <?php echo $metaDescription['color']; ?> check"></i> <?php echo __("Meta Description"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo number_format($metaDescription['lenght']); ?> <?php echo __("Characters"); ?></small>
					</div>
					<div class="col-lg-8 text-muted">
						<?php echo $metaDescription['fixed']; ?>

					</div>
				</div>


					<?php if($site->url_real){ ?>
				<div class="row p-t-2 ">
					<div class="col-lg-4 ">
						<?php
							$url_real = validateLenght($site->url_real,50,1);
						?>
						<strong><i class="zmdi zmdi-dot-circle  check"></i> <?php echo __("Effective URL"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo number_format($url_real['lenght']); ?> <?php echo __("Characters"); ?></small>
					</div>
					<div class="col-lg-8 text-muted">
						<?php echo $site->url_real; ?>
					</div>
				</div>
				<?php } ?>


				<?php
					$body_excerpt = badWords(more($site->body,250));
					if(strlen($body_excerpt)<20)
						$body_excerpt = false;
				?>
				<?php if($body_excerpt){ ?>
				<div class="row  p-t-2">
					<div class="col-lg-4">


						<strong><i class="zmdi  zmdi-dot-circle  check"></i> <?php echo __("Excerpt"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo __("Page content"); ?></small>
					</div>
					<div class="col-lg-8 text-muted">
						<?php echo $body_excerpt; ?>

					</div>
				</div>
				<?php } ?>



				<?php if($site->metaKeywords != ''){ ?>
				<div class="row  p-t-2">
					<div class="col-lg-4">
						<?php
						$keywords = explode(",",$site->metaKeywords);
						$keywordsCount = count($keywords);
						if($site->metaKeywords == '')
						{
							$keywords = false;
							$keywordsCount = 0;
						}

						?>
						<strong><i class="zmdi zmdi-tag text-muted check"></i> <?php echo __("Meta Keywords"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo ($keywordsCount); ?> <?php echo __("Detected"); ?></small>
					</div>
					<div class="col-lg-8">
						<?php foreach ($keywords as $key => $value) {
							$value = rtrim(ltrim(badWords($value)));
							if(trim($value) != ''){
							?>
							<a  class="keyword" href="<?php echo base_url(); ?><?php echo config_item("slug_filter"); ?>/tag/<?php echo urlencode($value); ?>"><?php echo $value; ?></a>
						<?php } } ?>


					</div>
				</div>
				<?php } ?>

				<?php
				$keyw = (extractKeyWords($site->body));
				if(count($keyw)>0 && $keyw != ''){ ?>
				<div class="row  p-t-2 hidden-md-down">
					<div class="col-lg-4">
						<?php



						?>
						<strong><i class="zmdi zmdi-tag text-muted check"></i> <?php echo __("Keywords Cloud"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo __("Density"); ?></small>
					</div>
					<div class="col-lg-8">
						<?php foreach ($keyw as $key => $value) {
							$key = badWords($key);
							if(trim($key) != ''){
							?>
							<span  class="keyword-cloud"><?php echo more($key,30); ?><span class="value animated zoomIn"><?php echo $value; ?></span></span>
						<?php } } ?>


					</div>
				</div>


				<div class="row  p-t-2 hidden-md-down">
					<div class="col-lg-4">
						<?php
						$keyw = (extractKeyWords($site->body));


						?>
						<strong><i class="zmdi zmdi-badge-check text-muted check"></i> <?php echo __("Keyword Consistency"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo __("Keyword density is one of the main terms in SEO"); ?></small>
					</div>
					<div class="col-lg-8">
						<table class="consistency table">
							<tr class="header">
								<td><?php echo __("Keyword"); ?></td>
								<td class="text-xs-center"><?php echo __("Freq"); ?></td>
								<td class="text-xs-center"><?php echo __("Title"); ?></td>
								<td class="text-xs-center"><?php echo __("Desc"); ?></td>
								<td class="text-xs-center"><?php echo __("Domain"); ?></td>
								<td class="text-xs-center"><?php echo __("H1"); ?></td>
								<td class="text-xs-center"><?php echo __("H2"); ?></td>
							</tr>
							<?php
								foreach ($keyw as $key => $value) {
									?>
									<tr>
										<td><i class="zmdi zmdi-tag text-muted check"></i> <?php echo more(badWords($key),20); ?></td>
										<td class="text-xs-center "><?php echo $value; ?></td>
										<td class="text-xs-center">
											<?php
												if(mb_strpos(strtolower($site->metaTitle),strtolower($key)) !== FALSE)
												{
													?>
													<i class="zmdi zmdi-check text-success"></i>
													<?php

												}
												else
												{
													?>
													<i class="zmdi zmdi-close text-danger"></i>
													<?php
												}
											?>
										</td>

										<td class="text-xs-center">
											<?php
												if(mb_strpos(strtolower($site->metaDescription),strtolower($key)) !== FALSE)
												{
													?>
													<i class="zmdi zmdi-check text-success"></i>
													<?php

												}
												else
												{
													?>
													<i class="zmdi zmdi-close text-danger"></i>
													<?php
												}
											?>
										</td>

										<td class="text-xs-center">
											<?php
												if(mb_strpos(strtolower($site->url),strtolower($key)) !== FALSE)
												{
													?>
													<i class="zmdi zmdi-check text-success"></i>
													<?php

												}
												else
												{
													?>
													<i class="zmdi zmdi-close text-danger"></i>
													<?php
												}
											?>
										</td>

										<td class="text-xs-center">
											<?php
												if(inHX($site->body,$key, "h1"))
												{
													?>
													<i class="zmdi zmdi-check text-success"></i>
													<?php

												}
												else
												{
													?>
													<i class="zmdi zmdi-close text-danger"></i>
													<?php
												}
											?>
										</td>

										<td class="text-xs-center">
											<?php
												if(inHX($site->body,$key, "h2"))
												{
													?>
													<i class="zmdi zmdi-check text-success"></i>
													<?php

												}
												else
												{
													?>
													<i class="zmdi zmdi-close text-danger"></i>
													<?php
												}
											?>
										</td>


									</tr>
									<?php
								}
							?>
						</table>


					</div>
				</div>

				<?php } ?>
				<div class="row  p-t-2">
					<div class="col-lg-4">
						<strong><i class="zmdi zmdi-eye text-muted check"></i> <?php echo __("Google Preview"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo __("Your look like this in google search result "); ?></small>
					</div>
					<div class="col-lg-8">
						<div class="gsearch">
							<div class="title"><?php
							if($metaTitle['fixed2'])
							{
								echo $metaTitle['fixed2'];
							}
							else
							{
								echo badWords($site->url);
							}

							?></div>
							<?php
							$site_url = $site->url;
							if($site->url_real)
								$site_url = $site->url_real;
							?>
							<div class="url"><?php echo badWords($site_url); ?></div>
							<div class="desc">
							<?php if($metaDescription['fixed2']){
									echo $metaDescription['fixed2'];
								}else{
									echo $body_excerpt;
									} ?>
							</div>
						</div>

					</div>
				</div>

				<?php
					$detected[0] = __("File No Found");
					$detected[1] = __("File Detected");
				?>
				<div class="row  p-t-2">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo getIcon($site->robots,0); ?> <?php echo getColor($site->robots,0); ?> check"></i> <?php echo __("Robots.txt"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo $detected[$site->robots]; ?></small>
					</div>
					<div class="col-lg-8">
						<a href="#">http://<?php echo $site->url; ?>/robots.txt</a>
					</div>
				</div>


				<div class="row  p-t-2">
					<div class="col-lg-4">
						<strong><i class="zmdi  <?php echo getIcon($site->sitemap,0); ?> <?php echo getColor($site->sitemap,0); ?> check"></i> <?php echo __("Sitemap.xml"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo $detected[$site->sitemap]; ?></small>
					</div>
					<div class="col-lg-8">
						<a href="#">http://<?php echo $site->url; ?>/sitemap.xml</a>

					</div>
				</div>
				<?php

				if($site->created_on && $site->created_on != '0000-00-00'){
						$expires_on = getDaysDiff($site->expires_on,date("Y-m-d H:i:s"));
						$created_on = getDaysDiff($site->created_on,date("Y-m-d H:i:s"));
					?>

				<div class="row  p-t-2">
					<div class="col-lg-4">
						<strong><i class="zmdi  <?php echo getIcon($created_on,360); ?> <?php echo getColor($created_on,360); ?> check"></i> <?php echo __("Domain Age"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo __("Domain creation info"); ?></small>
					</div>
					<div class="col-lg-8">
						<div class="text-muted text-small p-t-0">
							<div class="truncate"><i class="zmdi <?php echo getIcon($created_on,360); ?> <?php echo getColor($created_on,360); ?>  check"></i> <?php echo __("Create on:"); ?> <?php echo ($site->created_on); ?> / <?php echo ago($site->created_on); ?></div>
							<?php if($site->expires_on && $site->expires_on != '0000-00-00'){ ?>
							<div class="truncate"><i class="zmdi <?php echo getIcon($expires_on,90); ?> <?php echo getColor($expires_on,90); ?> check"></i> <?php echo __("Expires on:"); ?> <?php echo ($site->expires_on); ?>  / <?php echo days2h($expires_on); ?></div>
							<?php } ?>

						</div>

					</div>
				</div>


				<?php } ?>

					<?php

					$document_size	= strBytes($site->body);
					$text_size 	= strBytes(strip_tags($site->body));
					$code_size 	= $document_size-$text_size;
					$text_ratio  = (($text_size *100)/$document_size);
				?>
				<div class="row  p-t-2">
					<div class="col-lg-4">
						<strong><i class="zmdi  <?php echo getIcon($text_ratio,20); ?> <?php echo  getColor($text_ratio,20); ?> check"></i> <?php echo __("Page Size"); ?></strong>
						<small class="text-muted d-block subtitle"><?php echo __("Code & Text Ratio"); ?></small>
						<small class="text-muted d-block subtitle">
							<progress class="progress <?php echo getColorProgress($text_ratio,20); ?> 	progress-sm" value="<?php echo $text_ratio; ?>" max="100"></progress>
						</small>
					</div>
					<div class="col-lg-8">
						<div class="text-muted text-small p-t-0">
							<div class="truncate"><i class="zmdi <?php echo getIcon(2000000,$document_size); ?> <?php echo getColor(2000000,$document_size); ?>  check"></i> <?php echo __("Document Size:"); ?> ~<?php echo formatBytes($document_size); ?></div>
							<div class="truncate"><i class="zmdi <?php echo getIcon($code_size,20); ?> <?php echo getColor($code_size,20); ?>  check"></i> <?php echo __("Code Size:"); ?> ~<?php echo formatBytes($code_size); ?></div>
							<div class="truncate"><i class="zmdi <?php echo getIcon($text_ratio,20); ?> <?php echo getColor($text_ratio,20); ?>  check"></i> <?php echo __("Text Size:"); ?> ~<?php echo formatBytes($text_size); ?> <strong class=""><?php echo __("Ratio:"); ?> <?php echo number_format($text_ratio,2); ?>%</strong></div>


						</div>

					</div>
				</div>


					<?php } else{ show_register('meta'); }?>


			</div>

			<?php } ?>


			<?php if(in_array("social", $modules)){ ?>

				<h2 class="nice-title "><i class="zmdi zmdi-share"></i><span><?php echo __("Social Data"); ?></span></h2>

			<div class="card card-block" id="social">

				<?php if(in_array("social", $blocks)){
						$social = json_decode($site->social);

						$total = 0;
						foreach ($social as $key => $value) {
							$total = $total+$value;
						}
						foreach ($social as $key => $value) {
							$porc = floatval(($value*100)/$total);
							$key = str_ireplace("google_plus", "google-plus",$key);
							?>
							<div class="row p-t-2 " title="<?php echo number_format($porc,2); ?>%">
								<div class="col-lg-4">
									<strong><i class="fa fa-<?php echo $key; ?> <?php echo getColor($value,1000); ?>   check"></i> <?php echo ucwords(__(str_ireplace("google-plus", "google plus",$key))); ?></strong>
									<small class="text-muted d-block subtitle"><?php echo __("Total: "); ?> <?php echo number_format($value); ?></small>
								</div>
								<div class="col-lg-8">
									<progress class="progress progress-sm <?php echo getColorProgress($value,1000); ?>" value="<?php echo $porc; ?>" max="100"></progress>
								</div>
							</div>
							<?php
						}
					?>








				<?php } else{ show_register('social'); }?>






			</div>

			<?php } ?>


			<?php if(in_array("traffic", $modules)){ ?>


			<h2 class="nice-title "><i class="zmdi zmdi-traffic"></i><span><?php echo __("Estimation Traffic and Earnings"); ?></span></h2>

			<div class="card card-block" id="traffic">
				<?php if(in_array("traffic", $blocks)){ ?>
				<div class="row">
					<div class="col-lg-4">
						<div class="box-info blue">
							<div class="value"><?php echo number_format($site->uniqueVisitsDaily); ?> </div>
							<div class="title"><?php echo __("Unique Visits"); ?></div>
							<div class="subtitle"><?php echo __("Daily"); ?></div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="box-info orange">
							<div class="value"><?php echo number_format($site->pagesViewsDaily); ?></div>
							<div class="title"><?php echo __("Pages Views"); ?></div>
							<div class="subtitle"><?php echo __("Daily"); ?></div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="box-info green">
							<div class="value">$<?php echo number_format($site->IncomeDaily); ?></div>
							<div class="title"><?php echo __("Income"); ?></div>
							<div class="subtitle"><?php echo __("Daily"); ?></div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-lg-4">
						<div class="box-info blue">
							<div class="value"><?php echo number_format($site->uniqueVisitsDaily*28); ?></div>
							<div class="title"><?php echo __("Unique Visits"); ?></div>
							<div class="subtitle"><?php echo __("Monthly"); ?></div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="box-info orange">
							<div class="value"><?php echo number_format($site->pagesViewsDaily*28.5); ?></div>
							<div class="title"><?php echo __("Pages Views"); ?></div>
							<div class="subtitle"><?php echo __("Monthly"); ?></div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="box-info green">
							<div class="value">$<?php echo number_format($site->IncomeDaily*25); ?></div>
							<div class="title"><?php echo __("Income"); ?></div>
							<div class="subtitle"><?php echo __("Monthly"); ?></div>
						</div>
					</div>
				</div>


				<div class="row">
					<div class="col-lg-4">
						<div class="box-info blue">
							<div class="value"><?php echo number_format(($site->uniqueVisitsDaily*27)*12); ?></div>
							<div class="title"><?php echo __("Unique Visits"); ?></div>
							<div class="subtitle"><?php echo __("Yearly"); ?></div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="box-info orange">
							<div class="value"><?php echo number_format(($site->pagesViewsDaily*28)*12); ?></div>
							<div class="title"><?php echo __("Pages Views"); ?></div>
							<div class="subtitle"><?php echo __("Yearly"); ?></div>
						</div>
					</div>

					<div class="col-lg-4">
						<div class="box-info green">
							<div class="value">$<?php echo number_format(($site->IncomeDaily*22)*12); ?></div>
							<div class="title"><?php echo __("Income"); ?></div>
							<div class="subtitle"><?php echo __("Yearly"); ?></div>
						</div>
					</div>
				</div>
				<?php } else{ show_register('traffic'); }?>
			</div>

			<?php } ?>

			<?php
			if(!$noADS)
				echo get_ads("ads3","ads card card-block p-b-1");
			else
				echo  "<!-- Note: Bad words detected disable ads for security reasons -->";
			?>


			<?php if(count($technologies)>0 && in_array("technologies", $modules)){ ?>

			<h2 class="nice-title "><i class="zmdi zmdi-code-setting"></i><span><?php echo __("Technologies"); ?></span></h2>

			<div class="card card-block">
			<?php if(in_array("technologies", $blocks)){ ?>
			<?php foreach ($technologies as $key => $value) {
								?>

				<div class="col-md-6 p-b-2 p-t-1" id="technologies">
					<a class="media text-muted" href="<?php echo base_url(); ?><?php echo config_item("slug_filter"); ?>/<?php echo config_item("slug_made_with"); ?>/<?php echo urlencode($value->name); ?>">
					  <span class="media-left">
					    <img class="media-object tec-img" src="<?php echo base_url(); ?>assets/images/icons/<?php echo $value->icon; ?>" alt="<?php echo $value->name; ?>">
					  </span>
					  <div class="media-body">
					    <h4 class="media-heading"><strong><?php echo $value->name; ?></strong></h4>
					    <div class="text-muted"><?php echo __($value->tag1); ?></div>
					  </div>
					</a>
				</div>

			<?php } ?>

			<?php } else{ show_register('technologies'); }?>

			</div>

			<?php } ?>


			<?php if(in_array("pagespeed_stats", $modules) && $site->pagespeed_rules){ ?>

			<h2 class="nice-title "><i class="zmdi zmdi-google"></i><span><?php echo __("Google PageSpeed Insights"); ?></span></h2>
			<div class="card card-block" id="pagespeed_stats">
				<?php if(in_array("pagespeed_stats", $blocks)){ ?>


					<div class="row  p-t-2">
						<div class="col-lg-4">
							<strong><i class="zmdi zmdi-google check"></i> <?php echo __("Google Stats"); ?></strong>
							<small class="text-muted d-block subtitle"><?php echo __("This test checks to see if a page has applied common performance best practices."); ?></small>

						</div>




						<div class="col-lg-8">
							<div class=" p-t-0">


								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Number Resources:"); ?> <span class="text-muted"><?php echo number_format($site->pagespeed_numberResources); ?></span><br>
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Number Hosts:"); ?> <span class="text-muted"><?php echo number_format($site->pagespeed_numberHosts); ?></span><br>
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Total Request:"); ?> <span class="text-muted"><?php echo formatBytes($site->pagespeed_totalRequestBytes); ?></span><br>
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Number Static Resources:"); ?> <span class="text-muted"><?php echo number_format($site->pagespeed_numberStaticResources); ?></span><br>
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("HTML Response:"); ?> <span class="text-muted"><?php echo formatBytes($site->pagespeed_htmlResponseBytes); ?></span><br>
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("CSS Response:"); ?> <span class="text-muted"><?php echo formatBytes($site->pagespeed_cssResponseBytes); ?></span><br>
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Image Response:"); ?> <span class="text-muted"><?php echo formatBytes($site->pagespeed_imageResponseBytes); ?></span><br>
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Javascript Response:"); ?> <span class="text-muted"><?php echo formatBytes($site->pagespeed_javascriptResponseBytes); ?></span><br>
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Other Response:"); ?> <span class="text-muted"><?php echo formatBytes($site->pagespeed_otherResponseBytes); ?></span><br>
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Number JS Resources:"); ?> <span class="text-muted"><?php echo number_format($site->pagespeed_numberJsResources); ?></span><br>
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Number CSS Resources:"); ?> <span class="text-muted"><?php echo number_format($site->pagespeed_numberCssResources); ?></span><br>




							</div>

						</div>
					</div>
				</div>


				<h2 class="nice-title "><i class="zmdi zmdi-desktop-mac"></i><span><?php echo __("Desktop"); ?></span></h2>

					<div class="card card-block ">
					<?php if($site->pagespeed_screenshot_d){ ?>
											<img class="text-xs-center hidden-sm-down card screenshot-desktop" alt="<?php echo __("Desktop Screenshot"); ?>" src="<?php echo renderScreenshot($site); ?>">
								<?php } ?>

					<?php
					$google_rules = json_decode($site->pagespeed_rules);


					foreach ($google_rules->ruleResults as $key => $value) {
							if(isset($value->ruleImpact))
							{
								$impact = round($value->ruleImpact);
								if($impact>3)
									$impact = 3;
							}
							else
							{
								$impact = 999;
							}

							$icon[0] = 'check-circle';
							$icon[1] = 'alert-circle-o';
							$icon[2] = 'alert-octagon';
							$icon[3] = 'alert-triangle';
							$icon[999] = 'check-circle';

							$color[0] = 'success';
							$color[1] = 'warning';
							$color[2] = 'warning';
							$color[3] = 'error';
							$color[999] = 'success';

					?>
					<div class="row p-t-2 ">
						<div class="col-lg-6 truncate">
							<strong class="truncate"><i class="zmdi zmdi-<?php echo $icon[$impact]; ;?> text-<?php echo $color[$impact] ;?> check"></i> <?php echo __($value->localizedRuleName); ?></strong>
							<small class="d-block subtitle">
								<?php
								if($impact == 999)
									$impact = 0;
								for ($x=1;$x<=$impact;$x++) { ?>
									<i class="zmdi zmdi-dot-circle"></i>
								<?php } ?>

								<?php for ($x=3;$x>$impact;$x--) { ?>
									<i class="zmdi zmdi-circle-o	 text-muted"></i>
								<?php } ?>



							</small>
						</div>
						<div class="col-lg-6">
							<?php echo __(createRecomendationGoogle($value->summary)); ?>
						</div>
					</div>
					<?php } ?>
					</div>

					<h2 class="nice-title "><i class="zmdi zmdi-smartphone-android"></i><span><?php echo __("Mobile"); ?></span></h2>
					<div class="card card-block ">
						<?php if($site->pagespeed_screenshot_m){ ?>
						<img alt="<?php echo __("Mobile Screenshot"); ?>" class="text-xs-center hidden-sm-down card screenshot-mobile" src="<?php echo renderScreenshot($site,true); ?>">
						<?php } ?>
					<?php
					$google_rules = json_decode($site->pagespeed_rules_mobile);


					foreach ($google_rules->ruleResults as $key => $value) {
							if(isset($value->ruleImpact))
							{
								$impact = round($value->ruleImpact);
								if($impact>3)
									$impact = 3;
							}
							else
							{
								$impact = 999;
							}

							$icon[0] = 'check-circle';
							$icon[1] = 'alert-circle-o';
							$icon[2] = 'alert-octagon';
							$icon[3] = 'alert-triangle';
							$icon[999] = 'check-circle';

							$color[0] = 'success';
							$color[1] = 'warning';
							$color[2] = 'warning';
							$color[3] = 'error';
							$color[999] = 'success';

					?>
					<div class="row p-t-2 ">
						<div class="col-lg-6 truncate">
							<strong class="truncate"><i class="zmdi zmdi-<?php echo $icon[$impact]; ;?> text-<?php echo $color[$impact] ;?> check"></i> <?php echo __($value->localizedRuleName); ?></strong>
							<small class="d-block subtitle">
								<?php
								if($impact == 999)
									$impact = 0;
								for ($x=1;$x<=$impact;$x++) { ?>
									<i class="zmdi zmdi-dot-circle"></i>
								<?php } ?>

								<?php for ($x=3;$x>$impact;$x--) { ?>
									<i class="zmdi zmdi-circle-o	 text-muted"></i>
								<?php } ?>



							</small>
						</div>
						<div class="col-lg-6">
							<?php echo createRecomendationGoogle($value->summary); ?>
						</div>
					</div>
					<?php } ?>


				<?php } else{ show_register('pagespeed_stats'); }?>
			</div>
			<?php } ?>

			<?php if(in_array("tips", $modules)){ ?>

			<h2 class="nice-title "><i class="zmdi zmdi-help"></i><span><?php echo __("Speed And Optimization Tips"); ?></span></h2>
			<div class="card card-block" id="tips">
				<?php if(in_array("tips", $blocks)){ ?>
				<div class="text-muted">
				<?php echo __("Website speed has a huge impact on performance, affecting user experience, conversion rates and even rankings. ‪‬‬By reducing page load-times, users are less likely to get distracted and the search engines are more likely to reward you by ranking your pages higher in the SERPs."); ?>
				</div>

				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['title']); ?> text-<?php echo $optimize['title']; ?> check"></i> <?php echo __("Title Website"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>
					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['title'],'success',__("Congratulations! Your title is optimized"),__("Warning! Your title is not optimized")); ?>
					</div>
				</div>

				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['description']); ?> text-<?php echo $optimize['description']; ?> check"></i> <?php echo __("Description Website"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>
					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['description'],'success',__("Congratulations! Your description is optimized"),__("Warning! Your description is not optimized")); ?>
					</div>
				</div>




				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['robots']); ?> text-<?php echo $optimize['robots']; ?> check"></i> <?php echo __("Robots.txt"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>
					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['robots'],'success',__("Congratulations! Your site have a robots.txt file"),__("Warning! Your site not have a robots.txt file")); ?>
					</div>
				</div>

				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['sitemap']); ?> text-<?php echo $optimize['sitemap']; ?> check"></i> <?php echo __("sitemap.xml"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>
					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['sitemap'],'success',__("Congratulations! We've found a sitemap file for your website"),__("Warning! Not found a sitemap file for your website")); ?>
					</div>
				</div>

				<!--<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['googleIndex']); ?> text-<?php echo $optimize['googleIndex']; ?> check"></i> <?php echo __("Google Links"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>
					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['googleIndex'],'success',__("Congratulations! You are indexed by google"),__("Warning! Your website not have indexed by google")); ?>
					</div>
				</div> -->


				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['https']); ?> text-<?php echo $optimize['https']; ?> check"></i> <?php echo __("SSL Secure"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>
					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['https'],'success',__("Congratulations! Your site have Support to HTTPS"),__("Warning! Your website is not SSL secured (HTTPS).")); ?>
					</div>
				</div>

				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['pageSpeed']); ?> text-<?php echo $optimize['pageSpeed']; ?> check"></i> <?php echo __("Pagespeed"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>
					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['pageSpeed'],'success',__("Congratulations! Your site load very fast on desktop devices"),__("Warning! Your site load very slow on Desktop devices. need improve this")); ?>
					</div>
				</div>


				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['pagespeed_mobile']); ?> text-<?php echo $optimize['pagespeed_mobile']; ?> check"></i> <?php echo __("Pagespeed Mobile"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>
					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['pagespeed_mobile'],'success',__("Congratulations! Your site load very fast on mobile devices"),__("Warning! Your site load very slow on mobiles devices. need improve this")); ?>
					</div>
				</div>



				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['headers']); ?> text-<?php echo $optimize['headers']; ?> check"></i> <?php echo __("Headings"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>
					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['headers'],'success',__("Congratulations! You are using your H1 and H2 tags in your site"),__("Warning! Your page not contain any H1 and H2 headings. H1 and H2 headings help indicate the important topics of your page to search engines")); ?>
					</div>
				</div>

				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['google_safe']); ?> text-<?php echo $optimize['google_safe']; ?> check"></i> <?php echo __("Blacklist"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>
					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['google_safe'],'success',__("Congratulations! Your site is not listed in a blacklist"),__("Error! Your site is listed in a blacklist")); ?>
					</div>
				</div>

				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['w3c']); ?> text-<?php echo $optimize['w3c']; ?> check"></i> <?php echo __("W3C Validator"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>
					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['w3c'],'success',__("Congratulations! Your site not have errors W3C"),__("Warning! Your site have errors W3C")); ?>
					</div>
				</div>


				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['hasAMP']); ?> text-<?php echo $optimize['hasAMP']; ?> check"></i> <?php echo __("Accelerated Mobile Pages (AMP)"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>
					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['hasAMP'],'success',__("Congratulations! Your site have AMP Version"),__("Warning! Your site not have AMP Version")); ?>
					</div>
				</div>

				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['domainAuthority']); ?> text-<?php echo $optimize['domainAuthority']; ?> check"></i> <?php echo __("Domain Authority"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>
					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['domainAuthority'],'success',__("Congratulations! Your Domain Authority is good"),__("Warning! Domain Authority of your website is slow. It is good to have domain authority more than 25.")); ?>
					</div>
				</div>

				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['gzip']); ?> text-<?php echo $optimize['gzip']; ?> check"></i> <?php echo __("GZIP Compress"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>

					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['gzip'],'success',__("Congratulations! Your website is compressed"),__("Warning! Your site not  is compressed, this can make slower response for the visitors")); ?>
					</div>
				</div>


				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['favicon']); ?> text-<?php echo $optimize['favicon']; ?> check"></i> <?php echo __("Favicon"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle text-muted"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>

					<div class="col-lg-8">
						<?php echo createRecomendation($optimize['favicon'],'success',__("Congratulations! Your website appears to have a favicon."),__("Warning!  Your site not have a favicon" )); ?>
					</div>
				</div>

				<div class="row p-t-2 ">
					<div class="col-lg-4">
						<strong><i class="zmdi <?php echo converTypeToIcon($optimize['links']); ?> text-<?php echo $optimize['links']; ?> check"></i> <?php echo __("Broken Links"); ?></strong>
						<small class="d-block subtitle">
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle"></i>
							<i class="zmdi zmdi-dot-circle text-muted"></i>
						</small>
					</div>

					<div class="col-lg-8">
						<?php
						$links = json_decode($site->links);

						echo createRecomendation($optimize['links'],'success',__("Congratulations! You not have broken links"),__("Warning!  You have broken links")); ?>
												<span class="cursor-pointer btn-link btn-toggle-class" data-target=".list-links" data-class="show" ><?php echo __("View links"); ?></span>

					</div>
					<div class="col-lg-12  list-links">

						<div class="text-muted text-small p-t-1">
						<table class=" table" width="100%">
									<tr class="header">
										<td class=""><strong><?php echo str_ireplace("%count%", count($links), __("First %count% Links")); ?> </strong></td>
										<td class="text-xs-center"><strong><?php echo __("Relationship"); ?> </strong></td>
										<td class="text-xs-center"><strong><?php echo __("HTTP Status"); ?></strong></td>
									</tr>

						<?php

						foreach ($links as $key => $value) {


							$icon =  '<i class="zmdi zmdi-check text-success check"></i>';
							if(intval($value->response) == 0 || intval($value->response) == 404 || intval($value->response) == 500)
							{
								$icon = '<i class="zmdi zmdi-close text-danger check"></i>';
							}
							if($value->link){
								if(trim($value->title) == '')
									$value->title = $value->link;
								if(trim($value->rel) == '')
									$value->rel = __("Internal Link");
							?>
							<tr>
								<td class="truncate" style="max-width: 300px">
								<a rel="nofollow external" target="_blank" href="<?php echo $value->link; ?>"><i class="zmdi zmdi-link check"></i>
								<?php echo badWords($value->title); ?>
								</td>
								<td class="text-xs-center"><?php echo $value->rel; ?></td>
								<td class="text-xs-center"><?php echo $icon; ?> <?php echo $value->response; ?></td>
							</tr>

							<?php
							}
						}
						?>
						</table>
						</div>

					</div>
				</div>







				<?php } else{ show_register('tips'); }?>





			</div>

			<?php } ?>

			<?php if(in_array("alexa", $modules)){ ?>


				<h2 class="nice-title "><i class="zmdi zmdi-chart"></i><span><?php echo __("Alexa Rank"); ?></span></h2>
				<div class="card card-block" id="alexa">
					<?php if(in_array("alexa", $blocks)){ ?>
					<div class="row p-t-2 ">
						<div class="col-lg-6 text-xs-center ">
							<h2><?php echo number_format($site->alexaGlobal); ?></h2>
							<small class="d-block text-muted">
								 <?php echo __("Global Rank"); ?>
							</small>
						</div>
						<div class="col-lg-6 text-xs-center ">
							<h2><?php echo number_format($site->alexaLocal); ?></h2>
							<small class="d-block text-muted">
								 <?php
								 $country = explode(",", $site->alexaLocalCountry);
								 echo $country[0]; ?>
							</small>
						</div>
						<?php if($country[1]){ ?>
						<div class="col-lg-12 text-xs-center p-t-2 ">
							<div id="map" class="map" data-country="<?php echo $country[1]; ?>" style="height:300px;width: 100%"></div>
						</div>
						<?php } ?>
					</div>

					<?php if(!$cached){ ?>
					<div class="row p-t-2 ">
						<div class="col-lg-6 img-alexa">
							<strong><?php echo __("Traffic"); ?></strong>
							<img class="img-fluid" src="https://traffic.alexa.com/graph?o=lt&y=t&b=ffffff&n=666666&f=999999&r=1y&t=2&z=30&c=1&h=300&w=500&u=<?php echo $site->url; ?>">
						</div>
						<div class="col-lg-6 img-alexa">
							<strong><?php echo __("Search"); ?></strong>
							<img class="img-fluid" src="https://traffic.alexa.com/graph?o=lt&y=q&b=ffffff&n=666666&f=999999&r=1y&t=2&z=30&c=1&h=300&w=500&u=<?php echo $site->url; ?>">
						</div>

					</div>
					<?php } ?>

					<?php } else{ show_register('alexa'); }?>
				</div>

			<?php } ?>

			<?php if(in_array("domain_available", $modules) && !$cached){ ?>


				<h2 class="nice-title "><i class="zmdi zmdi-link"></i><span><?php echo __("Domain Available"); ?></span></h2>
				<div class="card card-block" id="domain_available">
					<?php if(in_array("domain_available", $blocks)){
						$domains = json_decode($site->available_domain);

						?>
					<table class="table table-hover table-striped">
						<thead>
							<tr>
								<th><strong><?php echo __("Domain (TDL) and Typo"); ?></strong></th>
								<th width="200px"><strong><?php echo __("Status"); ?></strong></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($domains as $key => $value) {
							if($value->domain){
								$available = __("Already Registered").' <a href="'.base_url().$value->domain.'"><i class="zmdi zmdi-open-in-new"></i></a>';
								if($value->registered != '1')
								{
									$available = __("Available");
									if(config_item("affiliate_service_domain"))
										$available = $available.' <a target="_blank" rel="nofollow external" href="'.str_ireplace("{domain}", strtolower($value->domain), config_item("affiliate_service_domain")).'"><small><i class="zmdi zmdi-open-in-new"></i> '.__("Buy Now!").' </small></a>';

								}
							?>
							<tr>
								<td><?php echo strtolower($value->domain); ?></td>
								<td <?php if($value->registered != '1'){ echo 'class="text-success"'; }else{echo 'class="text-danger"';} ?>><?php echo  $available ; ?></td>
							</tr>
							<?php
							}
						}
						?>
						</thead>

						<?php

						?>
						</tbody>
						</table>





					<?php } else{ show_register('alexa'); }?>
				</div>

			<?php } ?>


			<?php if(in_array("server", $modules)){ ?>

				<h2 class="nice-title "><i class="zmdi zmdi-device-hub"></i><span><?php echo __("Information Server"); ?></span></h2>
				<div class="card card-block" id="server">
					<?php if(in_array("server", $blocks)){ ?>
					<div class="row p-t-2 ">
						<div class="col-lg-4">
							<strong><i class="zmdi zmdi-code check"></i> <?php echo __("Response Header"); ?></strong>
							<small class="text-muted d-block subtitle">
								<?php echo __("HTTP headers carry information about the client browser, the requested page and the server"); ?>
							</small>
						</div>

						<div class="col-lg-8">
								<pre><?php echo  strip_tags(rtrim(ltrim($site->headers)),"<br>"); ?></pre>

						</div>
					</div>
						<?php
						$ips = explode(";",$site->ip);


						if($ips[0] && $ips[0] != '127.0.0.1'){

							?>
					<div class="row p-t-2 ">
						<div class="col-lg-4">
							<strong><i class="zmdi zmdi-globe check"></i> <?php echo __("IP Server"); ?></strong>
							<small class="text-muted d-block subtitle">
								<?php echo __("The IP Address from server"); ?>
							</small>
						</div>

						<div class="col-lg-8">
								<?php
								foreach ($ips as $key => $value) {
									if($value != ''){
									?><i class="zmdi zmdi-laptop-chromebook check"></i> <a class="text-muted" href="<?php echo base_url(); ?><?php echo config_item("slug_filter"); ?>/ip/<?php echo urlencode($value); ?>"><?php echo $value; ?></a><br><?php
									}
								}

								?>
						</div>


					</div>
					<?php if( $site->city){ ?>
					<div class="row p-t-2 ">
						<div class="col-lg-4">
							<strong><i class="zmdi zmdi-info check"></i> <?php echo __("IP Details"); ?></strong>
							<small class="text-muted d-block subtitle">
								<?php echo __("Information for IP address"); ?>
							</small>
						</div>

						<div class="col-lg-8">
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("City:"); ?> <a class="text-muted" href="<?php echo base_url(); ?><?php echo config_item("slug_filter"); ?>/city/<?php echo urlencode($site->city); ?>"><?php echo $site->city; ?></a><br>
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Country:"); ?> <a class="text-muted" href="<?php echo base_url(); ?><?php echo config_item("slug_filter"); ?>/country/<?php echo urlencode($site->country); ?>"><?php echo $site->country; ?></a><br>
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Region:"); ?> <a class="text-muted" href="<?php echo base_url(); ?><?php echo config_item("slug_filter"); ?>/region/<?php echo urlencode($site->region); ?>"><?php echo $site->region; ?></a><br>
								<i class="zmdi zmdi-info-outline check"></i> <?php echo __("ISP:"); ?> <a class="text-muted" href="<?php echo base_url(); ?><?php echo config_item("slug_filter"); ?>/isp/<?php echo urlencode($site->isp); ?>"><?php echo $site->isp; ?></a><br>



						</div>
					</div>
					<?php } ?>

						<?php }
						$result = (array) json_decode($site->dns_record);

						if(count($result)>1){
						?>


					<div class="row  p-t-2 hidden-md-down">
						<div class="col-lg-4">
							<strong><i class="zmdi zmdi-info check"></i> <?php echo __("DNS Records"); ?></strong>
							<small class="text-muted d-block subtitle">
								 <?php echo __("DNS Resource Records associated with a hostname"); ?>
							</small>
						</div>
						<div class="col-md-8 m-t-2">
							<span class="cursor-pointer btn-link btn-toggle-class " data-class="show" data-target=".list-links"><?php echo __("View DNS Records"); ?></span>
						</div>
						<div class="col-lg-12 list-links m-t-2">
								<table class="consistency table" >
									<tr class="header">
										<td class="text-xs-"><?php echo __("Type"); ?></td>
										<td class="text-xs-"><?php echo __("Name"); ?></td>

										<td class="text-xs-center"><?php echo __("Value"); ?></td>


										<td class="text-xs-center"><?php echo __("Class"); ?></td>
										<td class="text-xs-center"><?php echo __("TTL"); ?></td>
									</tr>
								<?php

								foreach ($result as $key => $value) {
									$value =  (array) $value;

									if(!$value['target'])
										$value['target'] = $value['txt'];
									if(!$value['target'])
										$value['target'] = $value['ip'];
									if(!$value['target'])
										$value['target'] = $value['ipv6'];
									if(!$value['target'])
										$value['target'] = $value['mname'];
									$name = $value['host'];


									?>
									<tr>
										<td><?php echo $value['type']; ?></td>

										<td class="text-xs-center "><?php echo $name; ?></td>
										<td class="text-xs-center "><?php echo $value['target']; ?></td>


										<td class="text-xs-center text-muted"><?php echo $value['class']; ?></td>
										<td class="text-xs-center "><?php echo $value['ttl']; ?></td>
									</tr>
									<?php
								}
								?>
								</table>




						</div>




					</div>
					<?php } ?>



						<?php
						$curl_info = json_decode($site->curl_info);

						if($curl_info){
							?>
							<div class="row p-t-2 ">
								<div class="col-lg-4">
									<strong><i class="zmdi zmdi-developer-board check"></i> <?php echo __("Response Server"); ?></strong>
									<small class="text-muted d-block subtitle"><?php echo __("Information regarding a specific transfer"); ?></small>
								</div>

								<div class="col-lg-8">
										<i class="zmdi zmdi-info-outline check"></i> <?php echo __("URL:"); ?> <span class="text-muted"><?php echo $curl_info->url; ?></span><br>
										<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Content Type:"); ?> <span class="text-muted" title="<?php echo __("Content-Type: of the requested document. NULL indicates server did not send valid Content-Type: header"); ?>"><?php echo $curl_info->content_type; ?></span><br>
										<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Http Code:"); ?> <span class="text-muted" title="<?php echo __("The last response code"); ?>"><?php echo $curl_info->http_code; ?></span><br>
										<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Header Size:"); ?> <span class="text-muted" title="<?php echo __("Total size of all headers received"); ?>"><?php echo formatBytes($curl_info->header_size); ?></span><br>
										<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Request Size:"); ?> <span class="text-muted" title="<?php echo __("Total size of issued requests, currently only for HTTP requests"); ?>"><?php echo formatBytes($curl_info->request_size); ?></span><br>
										<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Total Time:"); ?> <span class="text-muted" title="<?php echo __("Total transaction time in seconds for last transfer"); ?>"><?php echo ($curl_info->total_time); ?> <?php echo __("Seconds"); ?></span><br>
										<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Name Lookup Time:"); ?> <span class="text-muted" title="<?php echo __("Time in seconds until name resolving was complete"); ?>"><?php echo ($curl_info->namelookup_time); ?> <?php echo __("Seconds"); ?></span><br>
										<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Pretransfer Time:"); ?> <span class="text-muted" title="<?php echo __("Time in seconds from start until just before file transfer begins"); ?>"><?php echo ($curl_info->pretransfer_time); ?> <?php echo __("Seconds"); ?></span><br>
										<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Download Size:"); ?> <span class="text-muted" title="<?php echo __("Total number of bytes downloaded"); ?>"><?php echo formatBytes($curl_info->size_download); ?></span><br>
										<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Speed Download:"); ?> <span class="text-muted" title="<?php echo __("Average download speed"); ?>"><?php echo formatBytes($curl_info->speed_download); ?> <?php echo __("Per seconds"); ?></span><br>
										<i class="zmdi zmdi-info-outline check"></i> <?php echo __("Start Rransfer Time:"); ?> <span class="text-muted" title="<?php echo __("Time in seconds until the first byte is about to be transferred"); ?>"><?php echo ($curl_info->starttransfer_time); ?> <?php echo __("Seconds"); ?></span><br>




								</div>
							</div>
						<?php
						}
						?>

					<?php } else{ show_register('server'); }?>
				</div>

			<?php } ?>

			<?php if(config_item("disqus_shortname") && !$cached){ ?>

				<h2 class="nice-title "><i class="zmdi zmdi-comment-alt-text"></i><span><?php echo __("Comments"); ?></span></h2>
				<div class="card card-block">

					<div class="row p-t-2 ">
						<div class="col-lg-12 text-xs-center ">

									<div class="card card-block">
										<div id="disqus_thread"></div>
										<script type="text/javascript">
											var disqus_shortname = '<?php echo config_item("disqus_shortname"); ?>';
											(function() {
											var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
											dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
											(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
											})();
										</script>
									</div>

						</div>
					</div>



				</div>

<?php } ?>

			</div>
		</div>

	</div>
</div>
