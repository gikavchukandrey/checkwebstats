<div class="container">
	<div class="row">
		<div class="col-lg-3"></div>
		<form class="login col-lg-6" method="POST" action="<?php echo base_url(); ?>auth/login/register">

				
				<?php
				if($error = $this->session->flashdata('register_error')){ ?>
			
				<div class="alert animated bounceIn alert-danger alert-autoclose">
					<i class="zmdi zmdi-alert-circle-o"></i> <?php echo $error; ?>
				</div>
				<?php }	?>
				<?php
				if($message = $this->session->flashdata('register_message')){ ?>
			
				<div class="alert animated bounceIn alert-success alert-autoclose">
					<i class="zmdi zmdi-alert-circle-o"></i> <?php echo $message; ?>
				</div>
				<?php }	?>

			<div class="card card-block">
				
				<h2 class="text-xs-left">
					<i class="zmdi zmdi-lock-open"></i> <?php echo __("Sign Up"); ?>
				</h2>
				<strong class="text-muted"><?php echo __("Fill in the form below to get instant access"); ?></strong>

				
				<hr>
			

				<div class="form-group row">
					<label for="names" class="col-xs-12 col-form-label"><?php echo __("Names"); ?></label>
				  	<div class="col-xs-12">
				    	<input  required class="form-control" type="text" value="" id="names" name="names">
				  	</div>
				</div>

				<div class="form-group row">
					<label for="email" class="col-xs-12 col-form-label"><?php echo __("Email"); ?></label>
				  	<div class="col-xs-12">
				    	<input  required class="form-control" type="email" value="" id="email" name="email">
				  	</div>
				</div>


				<div class="form-group row">
					<label for="password" class="col-xs-12 col-form-label"><?php echo __("Password"); ?></label>
				  	<div class="col-xs-12">
				    	<input  required class="form-control" type="password" value="" id="password" name="password">
				    	
				  	</div>
				</div>

				<div class="form-group row">
					<label for="password" class="col-xs-12 col-form-label"><?php echo __("Repeat Password"); ?></label>
				  	<div class="col-xs-12">
				    	<input  required class="form-control" type="password" value="" id="password-r" name="password-r">
				    	
				  	</div>
				</div>

				<?php if(config_item("gcaptcha_secret")){ ?>
				<div class="text-xs-center">
					<div class="g-recaptcha" data-sitekey="<?php echo config_item("gcaptcha_key"); ?>"></div>
				</div>
				<?php } ?>
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
				<button class="btn btn-success btn-block" type="submit"><?php echo __("Sign Up"); ?></button>

			</div>	

			<div class="text-xs-center p-t-1 p-b-1">
				<h2 class="small"><?php echo __("...or login with"); ?></h2>
			</div>
			
			<div class="p-b-2">				
				<?php if(config_item("facebook_app_secret")){ ?>
					<a class="btn btn-primary btn-block " href="<?php echo base_url(); ?>auth/facebook/login"><i class="zmdi zmdi-facebook"></i> Facebook</a>
				<?php } ?>
				<?php if(config_item("google_client_secret")){ ?>
					<a class="btn btn-danger btn-block " href="<?php echo base_url(); ?>auth/google/login"><i class="zmdi zmdi-google"></i> Google</a>
				<?php } ?>
			</div>
			<div class="text-xs-center">
				<a  class="text-muted" href="<?php echo base_url(); ?><?php echo config_item("slug_login"); ?>"><?php echo __("Already have an account? Log in here."); ?></a>
			</div>
		</div>
		<div class="col-lg-3"></div>
	</form>
</div>