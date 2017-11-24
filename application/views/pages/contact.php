<div class="container p-t-2">

	<div class="row">
		<div class="col-lg-3 col-md-4">		
							<?php echo get_ads("ads1","ads card card-block no-padding p-b-1 p-t-1"); ?>


			

		</div>
		<div class="col-lg-9 col-md-8">		
			
						<h2 class="nice-title "><i class="zmdi zmdi-email"></i><span><?php echo __("Contact"); ?></span></h2>

			
			<div class="card card-block">
					<?php
				if($error = $this->session->flashdata('contact_error')){ ?>
			
				<div class="alert animated bounceIn alert-danger alert-autoclose">
					<i class="zmdi zmdi-alert-circle-o"></i> <?php echo $error; ?>
				</div>
				<?php }	?>
				<?php
				if($message = $this->session->flashdata('contact_message')){ ?>
			
				<div class="alert animated bounceIn alert-success alert-autoclose">
					<i class="zmdi zmdi-alert-circle-o"></i> <?php echo $message; ?>
				</div>
				<?php }	?>



				<form method="POST">
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
						<label for="subject" class="col-xs-12 col-form-label"><?php echo __("Subject"); ?></label>
					  	<div class="col-xs-12">
					    	<input  required class="form-control" type="text" value="" id="subject" name="subject">
					  	</div>
					</div>

					<div class="form-group row">
						<label for="message" class="col-xs-12 col-form-label"><?php echo __("Message"); ?></label>
					  	<div class="col-xs-12">
					    	<textarea  required class="form-control"  value="" id="message" name="message"></textarea>
					  	</div>
					</div>



					<?php echo csrf(); ?>

					<?php if(config_item("gcaptcha_secret")){ ?>
					<div class="text-xs-center">
						<div class="g-recaptcha" data-sitekey="<?php echo config_item("gcaptcha_key"); ?>"></div>
					</div>
					<?php } ?>
					<button class="btn btn-success btn-block"><?php echo __("Send"); ?></button>
				</form>

			</div>

			

		</div>
		

	</div>
</div>