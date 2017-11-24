  <div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title"><strong><?php echo $user->names; ?></strong> - <i><?php echo $user->email; ?></i></h3>
      <a class="pull-right" href="<?php echo base_url(); ?>admin/users">Go to users list</a>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal" method="POST">
      <div class="box-body">
        
        <div class="col-lg-12">
        	

         


        	 <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Email</label>
	          <div class="col-sm-9">
	            	<input type="text" required  disabled class="form-control" value="<?php echo $user->email; ?>">
	          </div>
	        </div>   


	        <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Names</label>
	          <div class="col-sm-9">
	            	<input type="text" required  name="names" class="form-control" value="<?php echo $user->names; ?>">
	          </div>
	        </div>   

	         <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Registered</label>
	          <div class="col-sm-9">
	            	<input type="text" required  disabled class="form-control" value="<?php echo $user->registered; ?>">
	          </div>
	        </div> 

	        <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Is Admin?</label>
	          <div class="col-sm-9">
	            	<select class="form-control" required name="is_admin">
	            		<option value="1" <?php if($user->is_admin == '1'){echo 'selected'; } ?>>Yes</option>
	            		<option value="0" <?php if($user->is_admin == '0'){echo 'selected'; } ?>>No</option>	            		
	            	</select>
	          </div>
	        </div> 

	        <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Is Demo Account</label>
	          <div class="col-sm-9">
	            	<select class="form-control" required name="is_demo">
	            		<option value="1" <?php if($user->is_demo == '1'){echo 'selected'; } ?>>Yes</option>
	            		<option value="0" <?php if($user->is_demo == '0'){echo 'selected'; } ?>>No</option>	            		
	            	</select>
	          </div>
	        </div> 

	           <?php if($user->validation != ''){ ?>
	        <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Account</label>
	          <div class="col-sm-9">
	            	<select class="form-control" required name="validation">
	            		<option disabled value="<?php echo $user->validation; ?>" <?php if($user->validation != ''){echo 'selected'; } ?>>Email not verified</option>
	            		<option value=""  <?php if($user->validation == ''){echo 'selected'; } ?>>Verified</option>	            		
	            	</select>
	          </div>
	        </div> 
	        <?php } ?>


	        <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Plan</label>
	          <div class="col-sm-9">
	            	<select class="form-control" required name="plan">
	            		<?php for($x=1;$x<=3;$x++){ ?>
	            		<option value="<?php echo $x; ?>" <?php if($user->plan == $x){echo 'selected'; } ?>><?php echo getPlanName($x); ?></option>
						<?php } ?>	            		
	            	</select>
	          </div>
	        </div> 


	        <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Optional</label>
	          <label for="" class="col-sm-9 control-label text-left text-muted" style="text-align:left">Update Password</label>
	        
	        </div> 

	         <div class="form-group">
	          <label for="" class="col-sm-3 control-label">New Password</label>
	         <div class="col-sm-9">
	            	<input type="text"  name="password"  class="form-control" value="" placeholder="Optional">
	          </div>
	        </div> 


	       
	        </div>

        
       
       
      </div><!-- /.box-body -->
      <div class="box-footer">                    
        <button type="submit" class="btn pull-right btn-primary">Update user</button>
      </div><!-- /.box-footer -->
    </form>
  </div><!-- /.box -->
