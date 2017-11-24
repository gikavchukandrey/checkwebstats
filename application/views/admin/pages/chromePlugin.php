<div class="col-md-12">
	<div class="box box-default">
		<form  class="form-horizontal" role="form" method="POST">
			<div class="box-body ">
				<div class="alert alert-info">
					<strong><i class="fa fa-chrome"></i> Google Chrome:</strong> Create your own plugin for google chrome in 1 minute or less!
				</div>

				<?php if(!is_writable(FCPATH."chrome/")){ ?>
				<div class="alert alert-error">
					<?php echo FCPATH."chrome/"; ?> not is writable! <strong>Solution: Set write permissions</strong>
				</div>
				<?php }?>


				
				<div class="col-lg-12">
					<div class="form-group">
	            		<label class="col-sm-3  control-label" for="chrome_name_plugin">Name plugin</label>
	            		<div class="col-sm-9">
	               			<input type="text" required class=" form-control" id="chrome_name_plugin" value="<?php echo config_item('chrome_name_plugin'); ?>" name="chrome_name_plugin" placeholder="Example: Prorank - SEO & Website Analysis">
	               		</div>
	   	         	</div>
	   	         </div>

	   	         <div class="col-lg-12">
					<div class="form-group">
	            		<label class="col-sm-3  control-label" for="chrome_sname_plugin">Short Name plugin</label>
	            		<div class="col-sm-9">
	               			<input type="text" required class=" form-control" id="chrome_sname_plugin" value="<?php echo config_item('chrome_sname_plugin'); ?>" name="chrome_sname_plugin" placeholder="Example: Prorank">
	               		</div>
	   	         	</div>
	   	         </div>


	   	         <div class="col-lg-12">
					<div class="form-group">
	            		<label class="col-sm-3  control-label" for="chrome_description">Description</label>
	            		<div class="col-sm-9">
	               			<input type="text" required class=" form-control" id="chrome_description" value="<?php echo config_item('chrome_description'); ?>" name="chrome_description" placeholder="Example: Use ProRank to improve your site and identify opportunities to get ahead of the competition">
	               		</div>
	   	         	</div>
	   	         </div>

	   	         <div class="col-lg-12">
					<div class="form-group">
	            		<label class="col-sm-3  control-label" for="chrome_version">Version</label>
	            		<div class="col-sm-9">
	               			<input type="text" required class=" form-control" id="chrome_version" value="<?php echo config_item('chrome_version'); ?>" name="chrome_version" placeholder="Example: 1.0.0">
	               		</div>
	   	         	</div>
	   	         </div>

	   	         <div class="col-lg-12">
					<div class="form-group">
	            		<label class="col-sm-3  control-label" for="">Default icon</label>
	            		<div class="col-sm-9">
	               			<img src="<?php echo base_url(); ?>chrome/icon.png" height="24px">
	               			<small class="text-muted"> Path: <?php echo FCPATH; ?>chrome/icon.png</small>
	               		</div>
	   	         	</div>
	   	         </div>


	   	         <div class="col-lg-12">
					<div class="form-group">
	            		<label class="col-sm-3  control-label" for="">Icon 48px</label>
	            		<div class="col-sm-9">
	               			<img src="<?php echo base_url(); ?>chrome/icon48.png" height="48px">
	               			<small class="text-muted"> Path: <?php echo FCPATH; ?>chrome/icon48.png</small>
	               		</div>
	   	         	</div>
	   	         </div>

	   	         <div class="col-lg-12">
					<div class="form-group">
	            		<label class="col-sm-3  control-label" for="">Icon 128px</label>
	            		<div class="col-sm-9">
	               			<img src="<?php echo base_url(); ?>chrome/icon128.png" height="128px">
	               			<small class="text-muted"> Path: <?php echo FCPATH; ?>chrome/icon128.png</small>
	               		</div>
	   	         	</div>
	   	         </div>


	   	         <button type="submit" class="btn-block btn btn-success">Save & Download</button>
	   	         <br>
	   	         <br>
	   	         <div class="alert alert-info">
	   	         	<strong>Help</strong><br>
	   	         	<br>
	   	         	<a href="https://developer.chrome.com/webstore/publish" target="_blank">How publish in the Chrome Web Store?</a>
	   	         	<br>
	   	         	<br>
					<strong>Important:</strong>
					<ul>
						<li>After published it, go to <a href="<?php echo base_url(); ?>admin/externalservices">external services menu</a> and fill your chrome extension app id (In keys sections)</li>
						<li>Remember check <i><strong>This item uses inline install</strong></i> in the item page on chrome developer dashboard.</li>
						<li>Replace icons on "path" folder if you want change it</li>
					</ul>
					<br>
				</div>

   	         
			</div>
		</form>
	</div>
</div>
