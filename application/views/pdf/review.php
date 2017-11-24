

<?php 	/** PDF REVIEW **/  ?>
<html utf8>

  <head>
    <!-- Required meta tags always come first -->
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <style>
/* PDF */
* {
		font-family: sans-serif;

}
    #watermark {
    position: fixed;
    top: 0;
    right:0;
    font-size: 13px;
    opacity: .5;
    width: 100%;
    text-align: right;
    
    
  }
    #watermark2 {
   position: fixed;
    top: 45%;
    width: 100%;
    text-align: center;
    opacity: .1;
    transform: rotate(-40deg);
    transform-origin: 50% 50%;
    z-index: -1000;
    font-size: 80px;
    font-weight: bold;
    
    
  }

      #watermark3 {
   position: fixed;
    top: 95%;
    width: 100%;
    text-align: center;
    opacity: .6;
    transform: rotate(-90deg);
    transform-origin: -30px 0%;
    z-index: -1000;
    font-size: 10px;
    font-weight: bold;
    
    
  }


    header {  border-radius: 2px; padding:20px;background-color:  #3C8DBC; color:#FFF; position: relative; top: -20px; left: 0px; right: 0px; }
    
    
a{
	text-decoration: none;
	color: #3C8DBC;
}

body.pdf {
	background-color: #FFF;
	
	color:rgba(0,0,0,.6);
	padding-top: 60px;
	font-size: 14px;

}
body.pdf #main{
	margin:0px;
	padding:0px;
	max-width:2000px;
}
body.pdf #main .row{
	margin:0px;
	padding:0px;
}

.nice-title{
	display: block;
		margin:0px;
	
	border-bottom: 4px solid #3C8DBC;
	

	font-size: 20px;
	line-height: 40px;
	color:#32749B;
	
	text-align: left;
	text-transform: uppercase;
	width: 100%;
    margin-bottom: 15px;
    
    box-sizing: border-box;
    padding-bottom: 5px;
    padding-top: 25px;
    
}

.resume
{
	width: 100%;
	padding-bottom: 12px;
	padding-top: 12px;
	display: block;
	clear: both;
	overflow: auto;
}
.resume .icon,
.resume .text,
.resume .value
{
	
	display: block;
	float: left;
	
}
.resume .icon{
	
	font-weight: bold;
	width: 20px;
	text-align: center;
}
.resume .text{
	width: 600px;
	
}
.resume .value
{
	font-weight: bold; 
}
.resume ul{
	width: 100%;
	list-style: none;
	padding-bottom: 15px;
	padding-top: 15px;
}
.resume ul li{
	display: block;
	width: 100%;
	clear: both;
}
p{
	color: rgba(0,0,0,.7);
	

	line-height: 20px;
	padding-top: 10px;
	padding-bottom: 10px;
}


.gsearch
{
	padding: 10px;
	border: 5px solid rgba(0, 0, 0, .08);
	font-size: 14px;
	border-radius: 3px;
	

}

.gsearch .title
{
	line-height: 17px;
		font-size: 16px;
    color: #00E;
    


    text-overflow: ellipsis;
    white-space: nowrap;
    overflow-x: hidden;
}
.truncate
{

    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}
.gsearch .url
{
		font-size: 13px;
		line-height: 20px;
        color: #00802A;
        font-weight: bold;
        

}
.gsearch .desc
{
	line-height: 18px;
	font-size: 13px;
	color: rgba(0, 0, 0, .8);
	

}

.clearfix:after {
  visibility: hidden;
  display: block;
  font-size: 0;
  content: " ";
  clear: both;
  height: 0;
}
.header{
	margin-bottom: 12	0px;
}
.header small{
	display: block;
	font-size: 11px;
	color: rgba(255,255,255,.5);
}
.header  .logo{
	float: right;
	height: 30px;
}
.header h1{
	padding:0px;
	margin: 0px;
	margin-bottom: 3px;
	color:#FFF;
	font-size: 22px;
}
.header strong{
	padding:0px;
	margin: 0px;
	margin-bottom: 3px;
	color:rgba(255,255,255,.7);
	
	font-weight: normal;
}
.clearfix { 
	display: inline-block;
	width: 100%;clear: both;
	 }
/* start commented backslash hack \*/
* html .clearfix { height: 1%; }
.clearfix { display: block; }
/* close commented backslash hack */

table
{
	font-size: 13px;
}
table.consistency
{
	width: 100%;
	border-radius: 3px;
}
table.consistency td{
		padding: 10px;
}
table.consistency  tr:nth-child(odd) {
  background-color: rgba(0, 0, 0, .05);
}
table.consistency .header
{
	background-color: rgba(0, 0, 0, .05);
	font-weight: bold;
	

}
.tec{
	width:100%;
	
	display: block;
	padding-left: 25px;
	height: 20px;
	box-sizing: border-box;
	position: relative;
	border:1px solid rgba(0,0,0,.05);
	margin-bottom: 10px;
}
.tec img{
	width: 20px;
	height: 20px;
	object-fit: cover;
	position: absolute;
	left: 0;
	top:0;
	background-color: #E6E6E6;
}
.tect .data{
}
 </style>


    

</head>

  <body class="pdf">
  <?php if(!removeWatermark("small")){ ?>
 <div id="watermark">
    <?php echo __("WATERMARK_HERE_ALL_PAGES"); ?>
  </div>
  <div id="watermark3">
    <?php echo __("WATERMARK_SIDE"); ?>
  </div>
  <?php } ?>
  <?php if(!removeWatermark("big")){ ?>
   <div id="watermark2">
    <?php echo __("WATERMARK_BIG"); ?>
  </div>
  <?php } ?>


    


<div class="container" id="main" >
	<div class="row">
		<header class="header">

    

			<h1><?php echo __("TITLE_PDF_HERE"); ?></h1>
			<img src="./<?php echo config_item("logo"); ?>" class="logo">
			<strong><?php echo __("SUBTITLE_PDF_HERE"); ?></strong>
			<small><?php echo date("Y-m-d H:i:s");  ?></small>
		</header>
		


		
		<h2 class="nice-title"><?php echo ($site->url); ?> </h2>
		<p><?php echo __("INTRO_PDF_HERE"); ?></p>
		<br>
		<br>
		<div class="clearfix"></div>
					
					
						
		
			
						<?php
							$stats 		= getStatsData($site,$technologies);
							$optimize 	= $stats['optimize'];
							
						?>	
						<div style="display: inline-block; text-align: center;color:#fff; padding:0px;width: 150px;border:1px solid rgba(0,0,0,.05);border-radius: 3px;background-color: #3C8DBC">
								<h2 style="padding:20px;font-size:30px;"><?php echo $site->score; ?></h2>
								<h1 style="font-size:14px;color:#FFF;width:100%;line-height: 20px;vertical-align: middle; background-color:#2D698C "><?php echo __("Score"); ?></h1>
							
							</div>

							<div style="display: inline-block; text-align: center;background-color: rgba(0,0,0,.05); color:#408000; margin-left: 25px; padding:0px;width: 150px;border:1px solid rgba(0,0,0,.05);border-radius: 3px">
								<h2 style="padding:20px;font-size:30px;"><?php echo $stats["success"]; ?>%</h2>
								<h1 style="font-size:14px;color:#FFF;width:100%;line-height: 20px;vertical-align: middle; background-color:#408000 "><?php echo __("Success"); ?></h1>
							
							</div>
						
								<div style="display: inline-block; text-align: center;background-color: rgba(0,0,0,.05); color:#FF8000; margin-left: 25px; padding:0px;width: 150px;border:1px solid rgba(0,0,0,.05);border-radius: 3px">
								<h2 style="padding:20px;font-size:30px;"><?php echo $stats["warning"]; ?>%</h2>
								<h1 style="font-size:14px;color:#FFF;width:100%;line-height: 20px;vertical-align: middle; background-color:#FF8000 "><?php echo __("Warning"); ?></h1>
							
							</div>


							
						
							<div style="display: inline-block; text-align: center;background-color: rgba(0,0,0,.05); color:#800000;  margin-left: 25px; padding:0px;width: 150px;border:1px solid rgba(0,0,0,.05);border-radius: 3px">
								<h2 style="padding:20px;font-size:30px;"><?php echo $stats["errors"]; ?>%</h2>
								<h1 style="font-size:14px;color:#FFF;width:100%;line-height: 20px;vertical-align: middle; background-color: #800000"><?php echo __("Errors"); ?></h1>
							
							</div>

						
							
		<h2 class="nice-title"><?php echo __("Meta Data"); ?> </h2>
		<p><?php echo __("INTRO_METADATA_HERE"); ?></p>
		

		<?php if($site->charset){ ?>
			<div class="resume">
				<div class="icon"><?php echo getIconPdf(4,3); ?></div>
				<div class="text"><?php echo __("Great, language/character encoding is specified"); ?></div>
				<div class="value"><?php echo mb_strtoupper($site->charset); ?></div>
			</div>
		<?php } ?>
		<?php
			$metaTitle = validateLenghtPdf($site->metaTitle,60,5);
			$metaDescription = validateLenghtPdf($site->metaDescription,150,10);
			
		?>
			<div class="resume">
				<div class="icon" style="color:<?php echo $metaTitle['color']; ?>"><?php echo $metaTitle['icon']; ?></div>
				<div class="text"><strong><?php echo __("Meta Title:"); ?></strong> <?php echo $metaTitle['fixed']; ?></div>
				<div class="value"><?php echo number_format($metaTitle['lenght']); ?> <?php echo __("Lenght"); ?></div>
			</div>
			

			<div class="resume">
				<div class="icon" style="color:<?php echo $metaDescription['color']; ?>"><?php echo $metaDescription['icon']; ?></div>
				<div class="text"><strong><?php echo __("Meta Description:"); ?></strong> <?php echo $metaDescription['fixed']; ?></div>
				<div class="value"><?php echo number_format($metaDescription['lenght']); ?> <?php echo __("Lenght"); ?></div>
			</div>
			
			<?php if($site->url_real){
			$url_real = validateLenghtPdf($site->url_real,50,1);
			 ?>
			<div class="resume">
				<div class="icon"  style="color:<?php echo getColorPdf(25,$url_real['lenght']); ?>"><?php echo getIconPdf(25,$url_real['lenght']); ?></div>
				<div class="text"><strong><?php echo __("Effective URL:"); ?></strong> <?php echo $site->url_real; ?></div>
				<div class="value"><?php echo number_format($url_real['lenght']); ?> <?php echo __("Lenght"); ?></div>
			</div>
			<?php } ?>
		


				<?php if($site->metaKeywords != ''){ ?>

					<?php
						$keywords = explode(",",$site->metaKeywords);
						$keywordsCount = count($keywords);
						if($site->metaKeywords == '')
						{
							$keywords = false;
							$keywordsCount = 0;
						}
						
						?>

					<div class="resume">
						<div class="icon"  style="color:<?php echo getColorPdf(25,$url_real['lenght']); ?>"><?php echo getIconPdf(25,$url_real['lenght']); ?></div>
						<div class="text"><strong><?php echo __("Meta Keywords"); ?></strong></div>
						<div class="value"><?php echo number_format($keywordsCount); ?></div>
						<ul>
						<?php foreach ($keywords as $key => $value) { 
									$value = rtrim(ltrim(($value)));
									if(trim($value) != ''){
									?>
										<li>+ <?php echo $value; ?></li>
								<?php } } ?>
						</ul>
					</div>

					<?php } ?>
	


				

				<?php
				$keyw = (extractKeyWords($site->body));
				if(count($keyw)>0 && $keyw != '')
				{ 
					?>
						<div class="resume">
							<div class="icon"  style="color:<?php echo getColorPdf(1,0); ?>"><?php echo getIconPdf(1,0); ?></div>
							<div class="text"><strong><?php echo __("Keywords Cloud"); ?></strong></div>
							<div class="value"></div>
							
						
					
					
						
						
					</div>
					<br>
							<p><?php echo __("INTRO_KEYWORDS_CLOUD_HERE"); ?></p>

					<br>

						<table class="consistency table">
							<tr class="header">
								<td><?php echo __("Keyword"); ?></td>
								<td style="text-align: center"><?php echo __("Freq"); ?></td>
								<td style="text-align: center"><?php echo __("Title"); ?></td>
								<td style="text-align: center"><?php echo __("Desc"); ?></td>
								<td style="text-align: center"><?php echo __("Domain"); ?></td>
								<td style="text-align: center"><?php echo __("H1"); ?></td>
								<td style="text-align: center"><?php echo __("H2"); ?></td>
							</tr>
							<?php
								foreach ($keyw as $key => $value) {
									?>
									<tr>
										<td> <?php echo more(badWords($key),20); ?></td>
										<td style="text-align: center "><?php echo $value; ?></td>
										<td style="text-align: center">
											<?php
												if(mb_strpos(mb_strtolower($site->metaTitle),mb_strtolower($key)) !== FALSE)
												{
													?>
													<?php echo getIconPdf(1,0); ?> 
													<?php

												}
												
											?>
										</td>

										<td style="text-align: center">
											<?php
												if(mb_strpos(mb_strtolower($site->metaDescription),mb_strtolower($key)) !== FALSE)
												{
													?>
													<?php echo getIconPdf(1,0); ?> 
													<?php

												}
												
											?>
										</td>

										<td style="text-align: center">
											<?php
												if(mb_strpos(mb_strtolower($site->url),mb_strtolower($key)) !== FALSE)
												{
													?>
													<?php echo getIconPdf(1,0); ?> 
													<?php

												}
												
											?>
										</td>	

										<td style="text-align: center">
											<?php
												if(inHX($site->body,$key, "h1"))
												{
													?>
													<?php echo getIconPdf(1,0); ?> 
													<?php

												}
												
											?>
										</td>	

										<td style="text-align: center">
											<?php
												if(inHX($site->body,$key, "h2"))
												{
													?>
													<?php echo getIconPdf(1,0); ?> 
													<?php

												}
												
											?>
										</td>


									</tr>
									<?php
								}
							?>
						</table>

				<?php 

				} ?>
						
		<h2 class="nice-title"><?php echo __("Speed Test"); ?> </h2>
		<p><?php echo __("INTRO_PAGESPEED_HERE"); ?></p>
		<div class="resume">
			<div class="icon" style="color:<?php echo getColorPdf($site->pageSpeed,85); ?>"><?php echo getIconPdf($site->pageSpeed,85); ?></div>
			<div class="text"><?php echo __("PageSpeed Desktop"); ?></div>
			<div class="value"><?php echo $site->pageSpeed; ?></div>
		</div>

		<div class="resume">
			<div class="icon" style="color:<?php echo getColorPdf($site->pagespeed_mobile,85); ?>"><?php echo getIconPdf($site->pagespeed_mobile,85); ?></div>
			<div class="text"><?php echo __("PageSpeed Mobile"); ?></div>
			<div class="value"><?php echo $site->pagespeed_mobile; ?></div>
		</div>

		<div class="resume">
			<div class="icon" style="color:<?php echo getColorPdf($site->pagespeed_usability,85); ?>"><?php echo getIconPdf($site->pagespeed_usability,85); ?></div>
			<div class="text"><?php echo __("Usability Mobile"); ?></div>
			<div class="value"><?php echo $site->pagespeed_usability; ?></div>
		</div>

		<div class="resume">
			<div class="icon" style="color:<?php echo getColorPdf($site->domainAuthority,50); ?>"><?php echo getIconPdf($site->domainAuthority,50); ?></div>
			<div class="text"><?php echo __("Domain Authority"); ?></div>
			<div class="value"><?php echo $site->domainAuthority; ?></div>
		</div>


			

		<h2 class="nice-title"><?php echo __("Authority"); ?> </h2>

		<p><?php echo __("INTRO_AUTHORITY_HERE"); ?></p>

		<div class="resume">
			<div class="icon" style="color:<?php echo getColorPdf($site->pageAuthority,24); ?>"><?php echo getIconPdf($site->pageAuthority,24); ?></div>
			<div class="text"><?php echo __("Page Authority"); ?></div>
			<div class="value"><?php echo number_format($site->pageAuthority); ?>/100</div>
		</div>

		<div class="resume">
			<div class="icon" style="color:<?php echo getColorPdf($site->mozRank,3); ?>"><?php echo getIconPdf($site->mozRank,3); ?></div>
			<div class="text"><?php echo __("Moz Rank"); ?></div>
			<div class="value"><?php echo number_format($site->mozRank,1); ?>/10</div>
		</div>


		<div class="resume">
			<div class="icon" style="color:<?php echo getColorPdf(30,$site->bounceRate); ?>"><?php echo getIconPdf(30,$site->bounceRate); ?></div>
			<div class="text"><?php echo __("Bounce Rate"); ?></div>
			<div class="value"><?php echo number_format($site->bounceRate); ?>%</div>
		</div>


		<h2 class="nice-title"><?php echo __("Social Networks"); ?> </h2>

		<p><?php echo __("INTRO_SOCIAL_NETWORKS_HERE"); ?></p>

		<?php
		$social = json_decode($site->social);

		foreach ($social as $key => $value) {
			
			$key = str_ireplace("google_plus", "google-plus",$key);
			?>
			
			<div class="resume">
				<div class="icon">+</div>
				<div class="text"><?php echo ucwords(__(str_ireplace("google-plus", "google plus",$key))); ?></div>
				<div class="value"><?php echo number_format($value); ?></div>
			</div>

			<?php
		}

		?>
		


		<div class="clearfix"></div>
		
				


					<h2 class="nice-title"><?php echo __("Google Preview"); ?> </h2>
						<p><?php echo __("INTRO_GOOGLE_PREVIEW_HERE"); ?></p>

					<div class="resume">
					
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


				<?php
					$detected[0] = __("File No Found");
					$detected[1] = __("File Detected");
				?>

				<div class="resume">
					<div class="icon" style="color:<?php echo getColorPdf($site->robots,0); ?>"><?php echo getIconPdf($site->robots,0); ?></div>
					<div class="text">http://<?php echo $site->url; ?>/robots.txt</div>
					<div class="value"><?php echo $detected[$site->robots]; ?></div>
				</div>

				<div class="resume">
					<div class="icon" style="color:<?php echo getColorPdf($site->sitemap,0); ?>"><?php echo getIconPdf($site->sitemap,0); ?></div>
					<div class="text">http://<?php echo $site->url; ?>/sitemap.xml</div>
					<div class="value"><?php echo $detected[$site->sitemap]; ?></div>
				</div>


				
			



		


			
			
			<h2 class="nice-title "><?php echo __("Technologies"); ?></h2>
			<p><?php echo __("INTRO_TECHNOLOGIES_HERE"); ?></p>
			
			
			<?php foreach ($technologies as $key => $value) { 
								?>
	
				
					

					<div class="resume">
						<div class="icon" style="width: 40px"><img style="height: 16px;max-width: 35px" src="./assets/images/icons/<?php echo $value->icon; ?>" ></div>
						<div class="text" style="width: 300px"><?php echo $value->name; ?></div>
						<div class="value"><?php echo __($value->tag1); ?></div>
					</div>


			<?php } ?>


			<div class="clearfix"></div>
			
			<h2 class="nice-title "><?php echo __("Google PageSpeed Insights"); ?></h2>
			
			<p><?php echo __("INTRO_GOOGLE_INSIGHTS"); ?></p>
					
				<div class="resume">
					<div class="icon" style="color:#0080FF">°</div>
					<div class="text"><?php echo __("Number Resources:"); ?></div>
					<div class="value"><?php echo number_format($site->pagespeed_numberResources); ?></div>
				</div>

				<div class="resume">
					<div class="icon" style="color:#0080FF">°</div>
					<div class="text"><?php echo __("Number Hosts:"); ?></div>
					<div class="value"><?php echo number_format($site->pagespeed_numberHosts); ?></div>
				</div>

				<div class="resume">
					<div class="icon" style="color:#0080FF">°</div>
					<div class="text"><?php echo __("Total Request:"); ?></div>
					<div class="value"><?php echo formatBytes($site->pagespeed_totalRequestBytes); ?></div>
				</div>

				<div class="resume">
					<div class="icon" style="color:#0080FF">°</div>
					<div class="text"><?php echo __("Number Static Resources:"); ?></div>
					<div class="value"><?php echo number_format($site->pagespeed_numberStaticResources); ?></div>
				</div>

				<div class="resume">
					<div class="icon" style="color:#0080FF">°</div>
					<div class="text"><?php echo __("HTML Response:"); ?></div>
					<div class="value"><?php echo formatBytes($site->pagespeed_htmlResponseBytes); ?></div>
				</div>

				<div class="resume">
					<div class="icon" style="color:#0080FF">°</div>
					<div class="text"><?php echo __("CSS Response:"); ?></div>
					<div class="value"><?php echo formatBytes($site->pagespeed_cssResponseBytes); ?></div>
				</div>
					
				<div class="resume">
					<div class="icon" style="color:#0080FF">°</div>
					<div class="text"><?php echo __("Image Response:"); ?></div>
					<div class="value"><?php echo formatBytes($site->pagespeed_imageResponseBytes); ?></div>
				</div>


				<div class="resume">
					<div class="icon" style="color:#0080FF">°</div>
					<div class="text"><?php echo __("Javascript Response:"); ?></div>
					<div class="value"><?php echo formatBytes($site->pagespeed_javascriptResponseBytes); ?></div>
				</div>

				<div class="resume">
					<div class="icon" style="color:#0080FF">°</div>
					<div class="text"><?php echo __("Other Response:"); ?></div>
					<div class="value"><?php echo formatBytes($site->pagespeed_otherResponseBytes); ?></div>
				</div>

				<div class="resume">
					<div class="icon" style="color:#0080FF">°</div>
					<div class="text"><?php echo __("Number JS Resources:"); ?></div>
					<div class="value"><?php echo number_format($site->pagespeed_numberJsResources); ?></div>
				</div>


				<div class="resume">
					<div class="icon" style="color:#0080FF">°</div>
					<div class="text"><?php echo __("Number CSS Resources:"); ?></div>
					<div class="value"><?php echo number_format($site->pagespeed_numberCssResources); ?></div>
				</div>





				<h2 class="nice-title "><?php echo __("Desktop"); ?></h2>
				<p><?php echo __("INTRO_GOOGLE_INSIGHTS_DESKTOP"); ?></p>

				
					<?php if($site->pagespeed_screenshot_d){ ?>
											<img  style="width: 300px;border:7px solid rgba(0,0,0,.1);margin:50px;margin-left: 200px" alt="<?php echo __("Desktop Screenshot"); ?>" src="<?php echo renderScreenshot($site); ?>">
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

							$icon[0] = '+';
							$icon[1] = '×';
							$icon[2] = '×';
							$icon[3] = '×';
							$icon[999] = '+';

							$color[0] = '#408000';
							$color[1] = '#FEC45A';
							$color[2] = '#FD821C';
							$color[3] = '#FC0D0B';
							$color[999] = '#408000';

					?>
							<div class="resume">
							<div class="icon" style="color:<?php echo $color[$impact] ;?>"><?php echo $icon[$impact]; ?></div>
							<div class="text"><strong><?php echo __($value->localizedRuleName); ?></strong><br> <?php echo createRecomendationGoogle($value->summary); ?></div>
							<div class="value">
							
								<?php 
								if($impact == 999)
									$impact = 0;
								for ($x=1;$x<=$impact;$x++) { ?>
										⚙
								<?php } ?>

							

								
								
							</div>
						</div>
					
					
					<?php } ?>
				
				<div class="clearfix"></div>
				<br>
				<br>
				<br>
					
				<h2 class="nice-title "><?php echo __("Mobile"); ?></h2>
				<p><?php echo __("INTRO_GOOGLE_INSIGHTS_MOBILE"); ?></p>

				
					<?php if($site->pagespeed_screenshot_m){ ?>
											<img  style="width: 300px;border:7px solid rgba(0,0,0,.1);margin:50px;margin-left: 200px" alt="<?php echo __("Mobile Screenshot"); ?>" src="<?php echo renderScreenshot($site,true); ?>">
								<?php } ?>

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

							$icon[0] = '+';
							$icon[1] = '×';
							$icon[2] = '×';
							$icon[3] = '×';
							$icon[999] = '+';

							$color[0] = '#408000';
							$color[1] = '#FEC45A';
							$color[2] = '#FD821C';
							$color[3] = '#FC0D0B';
							$color[999] = '#408000';

					?>
							<div class="resume">
							<div class="icon" style="color:<?php echo $color[$impact] ;?>"><?php echo $icon[$impact]; ?></div>
							<div class="text"><strong><?php echo __($value->localizedRuleName); ?></strong><br> <?php echo createRecomendationGoogle($value->summary); ?></div>
							<div class="value">
							
								<?php 
								if($impact == 999)
									$impact = 0;
								for ($x=1;$x<=$impact;$x++) { ?>
										⚙
								<?php } ?>

							

								
								
							</div>
						</div>
					
					
					<?php } ?>
			
			
			

	

			
				<div class="clearfix"></div>
				<br>
				<br>
			
				<h2 class="nice-title "><?php echo __("Alexa Rank"); ?></h2>

				<div class="resume">
							<div class="icon"></div>
							<div class="text"><?php echo __("Global Rank"); ?></div>
							<div class="value"><?php echo number_format($site->alexaGlobal); ?></div>
				</div>

					<div class="resume">
							<div class="icon"></div>
							<div class="text"> <?php 
								 $country = explode(",", $site->alexaLocalCountry);
								 echo $country[0]; ?></div>
							<div class="value"><?php echo number_format($site->alexaLocal); ?></div>
				</div>

				<p><?php echo __("INTRO_END_PDF"); ?></p>

			

				

			

</body>
</html>
