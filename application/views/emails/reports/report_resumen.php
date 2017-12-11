<?php echo __("Hi"); ?> <strong><?php echo $user->names; ?></strong><br><br>
<?php echo __("Your sites has been updated, and now can see the full report. Only need make click over the url and get instant full report from your site"); ?>
<br>
<br>
<br>
<table class="table dataTable"  cellspacing="0" cellpadding="5" style="width:100%;font-size: 13px;text-align: left;border:1px solid #FFF">
								<thead>
										<tr style="background-color: <?php echo config_item("style_main_color"); ?>;color:#FFF">
											<th width="48px"></th>
											<th><?php echo __("Website"); ?></th>
											
											
											<th style="text-align: center;" title="<?php echo __("Pagespeed Desktop"); ?>"><?php echo __("PSD"); ?> </th>
											<th style="text-align: center;" title="<?php echo __("Pagespeed Movil"); ?>"><?php echo __("PSM"); ?> </th>
											<th style="text-align: center;"><?php echo __("Usability"); ?></th>
											<th style="text-align: center;"><?php echo __("Alexa"); ?></th>
											<th style="text-align: center;" title="<?php echo __("Domain Authority"); ?>"><?php echo __("DA"); ?></th>
											<th style="text-align: center;"><?php echo __("Score"); ?></th>
											
										</tr>
								</thead>
								<tbody>
									<?php
									foreach ($site as $key => $value) {	
										if(!$value->metaTitle)
											$value->metaTitle = ' --- ';
										$value->metaTitle = str_ireplace(".", "<span>.</span>", $value->metaTitle);
										if(intval($value->alexaLocal) == 0)
											$value->alexaLocal = '---';
										?>
									<tr style="border:1px solid #E6E6E6;color:<?php if(intval($value->score) < 60) { echo '#FF8000'; }else{ echo '#333333'; } ?>">
										<td style="border-bottom:1pt solid #E6E6E6;text-align: center;"><img class="hidden-md-down img-fluid" src="https://www.google.com/s2/favicons?domain=<?php echo $value->url; ?>" alt="Screenshot"></td>
										<td style="border-bottom:1pt solid #E6E6E6;">
										<?php echo $value->metaTitle; ?><br>
											<small><a href="<?php echo config_item("domain"); ?><?php echo $value->url; ?>"><?php echo $value->url_real; ?></a></small>
										</td>
										
										
										<td style="text-align: center;border-bottom:1pt solid #E6E6E6;"><?php echo $value->pageSpeed; ?></td>
										<td style="text-align: center;border-bottom:1pt solid #E6E6E6;"><?php echo $value->pagespeed_mobile; ?></td>
										<td style="text-align: center;border-bottom:1pt solid #E6E6E6;"><?php echo $value->pagespeed_usability; ?></td>
										<td style="text-align: center;border-bottom:1pt solid #E6E6E6;"><?php echo number_format($value->alexaLocal); ?><br><small><?php echo (preg_replace('/^(.*)$/', '\L$1', $value->alexaLocalCountry)); ?></small></td>
										<td style="text-align: center;border-bottom:1pt solid #E6E6E6;"><?php echo $value->domainAuthority; ?></td>
										<td style="text-align: center; border-bottom:1pt solid #E6E6E6;font-size: 20px;background-color: #F1F4F4"><strong><?php echo $value->score; ?></strong></td>
										
									</tr>
									<?php } ?>		
								</tbody>
							</table>