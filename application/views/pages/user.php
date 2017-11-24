<div class="container p-t-2">
	<div class="row">


		<div class="col-lg-3 col-md-12"></div>
		<?php if($page){ ?>
		<div class="<?php if($page == 'bookmarks'){ echo 'col-lg-12'; }else{ echo 'col-lg-6';} ?> col-md-12">
		<?php } ?>

			

				<?php
				if($message = $this->session->flashdata('update_message')){ ?>
			
				<div class="alert animated bounceIn alert-success alert-autoclose">
					<i class="zmdi zmdi-alert-circle-o"></i> <?php echo $message; ?>
				</div>
				<?php }	?>

				<?php
				if($error = $this->session->flashdata('update_error')){ ?>
			
				<div class="alert animated bounceIn alert-danger alert-autoclose">
					<i class="zmdi zmdi-alert-circle-o"></i> <?php echo $error; ?>
				</div>
				<?php }	?>


				<?php
					switch ($page) {
						case 'password':
							?>
							<h2 class="nice-title "><i class="zmdi zmdi-lock"></i><span><?php echo __("Change your password"); ?></span></h2>
							<div class="card card-block">

							<form  method="POST">
								

								<div class="form-group row">
									<label for="password" class="col-xs-3 col-form-label"><?php echo __("Password"); ?></label>
								  	<div class="col-xs-9">
								    	<input  required class="form-control" type="password"  id="password" name="password" value="">
								  	</div>
								</div>

								<div class="form-group row">
									<label for="password-r" class="col-xs-3 col-form-label"><?php echo __("Repeat Password"); ?></label>
								  	<div class="col-xs-9">
								    	<input  required class="form-control" type="password"  id="password-r" name="password-r" value="">
								  	</div>
								</div>

								

								<?php echo csrf(); ?>
								<button type="submit" class="btn btn-success pull-right"><?php echo __("Update"); ?></button>

							</form>
							</div>
							<?php
							break;			
						case 'bookmarks':
							
							?>
							<h2 class="nice-title "><i class="zmdi zmdi-bookmark"></i><span><?php echo __("Bookmarks"); ?></span></h2>
								

							<?php if(count($bookmarks) == 0)
							{
								?>
								<h2 class="light text-xs-center">
									<i class="zmdi zmdi-star-outline text-lg"></i> 
									<br>
									<?php echo __("You no have anything here yet"); ?>
								</h2>
								<?php
							}
							?>

							<div class="card p-t-3 ">
							<table class="table dataTable">
								<thead>
										<tr>
											<th width="48px"></th>
											<th><?php echo __("Website"); ?></th>
											
											<th><?php echo __("Score"); ?></th>
											<th title="<?php echo __("Pagespeed"); ?>"><i class="zmdi zmdi-desktop-mac"></i> </th>
											<th title="<?php echo __("Pagespeed"); ?>"><i class="zmdi zmdi-smartphone-android"></i> </th>
											<th><?php echo __("Usability"); ?></th>
											<th><?php echo __("Alexa"); ?></th>
											<th title="<?php echo __("Domain Authority"); ?>"><?php echo __("DA"); ?></th>
											<th><i class="zmdi zmdi-time-restore"></i></th>
										</tr>
								</thead>
								<tbody>
									<?php
									foreach ($bookmarks as $key => $value) {	?>
									<tr class="text-<?php if(intval($value->score) < 60) { echo 'warning'; }else{ echo 'default'; } ?>">
										<td><img class="hidden-md-down img-fluid" src="<?php echo renderScreenshot($value); ?>" alt="Screenshot"></td>
										<td>
										<?php echo $value->metaTitle; ?><br>
											<small><a href="<?php echo base_url(); ?><?php echo $value->url; ?>"><?php echo $value->url_real; ?></a></small>
										</td>
										
										<td><?php echo $value->score; ?></td>
										<td><?php echo $value->pageSpeed; ?></td>
										<td><?php echo $value->pagespeed_mobile; ?></td>
										<td><?php echo $value->pagespeed_usability; ?></td>
										<td><?php echo number_format($value->alexaGlobal); ?></td>
										<td><?php echo $value->domainAuthority; ?></td>
										<td nowrap>
										<span class="hide" style="display: none"><?php echo strtotime($value->updated); ?></span>
										<div data-domain="<?php echo $value->url; ?>" class="btn btn-secondary btn-small btn-sm btn-update"><i class="zmdi zmdi-refresh-alt"></i> <?php echo ago($value->updated); ?></div>
										</td>
									</tr>
									<?php } ?>		
								</tbody>
							</table>
							</div>
							
							<?php
							break;										
						default:
						if($this->input->get("first_cancel"))
						{
							?>
							<div class="alert alert-info">
							<?php echo __("For upgrade/downgrade your plan, first need cancel current plan."); ?>
							</div>
							<?php
						}
						?>
							
							<h2 class="nice-title "><i class="zmdi zmdi-lock"></i><span><?php echo __("Your Profile"); ?></span>
								<?php if(isAvailablePlan()){ ?>
 								<a class="pull-right" href="<?php echo base_url(); ?><?php echo config_item("slug_subscriptions"); ?>?cancel=1"><?php echo __("Cancel Plan"); ?></a>
 								<?php } ?>
							</h2>
	
  <div class="col-md-8">

							<div class="card card-block">
							<form  method="POST">

								<div class="form-group row text-xs-center">
									
								  	<a href="https://en.gravatar.com/" target="_blank"><img title="Gravar" class="avatar" src='<?php echo get_gravatar(_user('email')); ?>'></a>
								</div>

								<div class="form-group row">
									<label for="email" class="col-xs-3 col-form-label"><?php echo __("Email"); ?></label>
								  	<div class="col-xs-9">
								    	<input  class="form-control disabled" disabled readonly type="email" value="<?php echo _user("email"); ?>">
								  	</div>
								</div>

								<div class="form-group row">
									<label for="names" class="col-xs-3 col-form-label"><?php echo __("Names"); ?></label>
								  	<div class="col-xs-9">
								    	<input  required class="form-control" type="text"  id="names" name="names" value="<?php echo _user("names"); ?>">
								  	</div>
								</div>

								<div class="form-group row">
									<label for="email" class="col-xs-3 col-form-label"><?php echo __("Registered"); ?></label>
								  	<div class="col-xs-9">
								    	<div  class="form-control "><?php echo ago(_user("registered")); ?></div>
								  	</div>
								</div>	

								<div class="form-group row">
									<label for="email" class="col-xs-3 col-form-label"><?php echo __("Last payment"); ?></label>
								  	<div class="col-xs-9">
								    	<div  class="form-control "><?php echo (_user("last_payment")); ?></div>
								  	</div>
								</div>	



								<div class="form-group row">
									<label for="email" class="col-xs-3 col-form-label"><?php echo __("Type Account"); ?></label>
								  	<div class="col-xs-9">
								  	<?php if(isAvailablePlan()){ ?>
								  	<a class="pull-right btn btn-success" href="<?php echo base_url(); ?><?php echo config_item("slug_subscriptions"); ?>"><?php echo __("Upgrade Plan"); ?></a>
								  	<?php }else{ ?>
								  		<!--<a class="pull-right btn btn-danger" href="<?php echo base_url(); ?><?php echo config_item("slug_subscriptions"); ?>?cancel=1"><?php echo __("Cancel Plan"); ?></a>-->
								  	<?php } ?>	
								    	<div  class="form-control "><?php echo getPlanName(_user("plan")); ?>
								    		
								    	</div>
								  	</div>
								</div>


								<div class="form-group row">
									<label for="newsletter" class="col-xs-3 col-form-label"> </label>
								  	<div class="col-xs-9">
								    	<label><input name="newsletter" type="checkbox" <?php if(_user("newsletter") == '1') {echo 'checked'; } ?> value="1"> <?php echo __("Subscribe to newsletters"); ?></label>
								  	</div>
								</div>

								<?php echo csrf(); ?>
								<button type="submit" class="btn btn-success pull-right"><?php echo __("Update"); ?></button>
								 <a class="pull-left" href="<?php echo base_url().config_item("slug_user"); ?>/password" ><i class="zmdi zmdi-lock-outline"></i> <?php echo __("Change Password"); ?></a>           
								 <div class="clearfix"></div>
							</form>
							</div>
						</div>



							<div class="col-md-4">
								<?php
								$x=_user("plan");
							    $name = config_item('paypal_p'.$x.'_name');
							    $price = config_item('paypal_p'.$x.'_price_monthly');
							    
							 
							 

							    ?>
							    
							      <!-- Table #1  -->
							      <div class="col-xs-12 col-lg-12">
							        <div class="card  card-suscription text-xs-center">
							         
							          <div class="card-block">
							            <h4 class="card-title p-t-2"> 
							              <?php echo getPlanName($x); ?>
							            </h4>

							        

							            <div class="features">
							              
							              <span><?php echo __("Bookmarks limit"); ?><strong><?php echo number_format(config_item('paypal_p'.$x.'_bookmark_limit')); ?></strong></span>
							              <span><?php echo __("Historical data"); ?><i class="<?php if(config_item('paypal_p'.$x.'_historica_data') == '1'){ echo 'text-success zmdi zmdi-check-circle'; }else{ echo 'text-danger zmdi zmdi-close-circle';} ; ?>"></i></span>
							              <span><?php echo __("PDF report"); ?><i class="<?php if(config_item('paypal_p'.$x.'_pdf_repport') == '1'){ echo 'text-success zmdi zmdi-check-circle'; }else{ echo 'text-danger zmdi zmdi-close-circle';} ; ?>"></i></span>
							              <span><?php echo __("Remove PDF big watermark"); ?><i class="<?php if(config_item('paypal_p'.$x.'_pdf_big_wathermark') == '2'){ echo 'text-success zmdi zmdi-check-circle'; }else{ echo 'text-danger zmdi zmdi-close-circle';} ; ?>"></i></span>
							              <span><?php echo __("Remove PDF small watermark"); ?><i class="<?php if(config_item('paypal_p'.$x.'_pdf_small_wathermark') == '2'){ echo 'text-success zmdi zmdi-check-circle'; }else{ echo 'text-danger zmdi zmdi-close-circle';} ; ?>"></i></span>
							              
							              <?php
							              $data   = $this->Admin->getTable("settings",array("var" => 'paypal_p'.$x.'_modules'))->row_array();
							              $temp   = array();
							              $temp   = explode("|", $data['options']);
							              
							              foreach ($temp as $key => $value) 
							              { 
							                $lables     = explode(":", $value);
							                $valuel     = $lables[0];
							                if($lables[1] != '')
							                  $value = $lables[1];
							                if($valuel == '')
							                  $valuel = $value;

							                 $selected = 'text-danger zmdi zmdi-close-circle';
							                 $temp_values  = explode(",", $data['value']);
							                 if(in_array($value, $temp_values))
							                   $selected = 'text-success zmdi zmdi-check-circle"';
							                 ?>
							                 <span><?php echo __($valuel); ?><i class="<?php echo $selected ; ?>"></i></span>

							                 <?php
							               }
							              ?>
							              
							            </div>
							            
							           
							            
							          
							            
							          </div>
							        </div>
							      </div>
							      
							  </div>



							<?php
							break;
					}
				?>
				<?php if($page){ ?>
			</div>
			<?php } ?>
		
		<div class="col-lg-3 col-md-12"></div>
	</div>
</div>


	