  <div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Edit Site - <a href="<?php echo base_url().$site->url; ?>"><?php echo $site->url; ?></a></h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form class="form-horizontal" method="POST">
      <div class="box-body">
        
        <div class="col-lg-12">

        	<div class="form-group">
	          <label for="" class="col-sm-3 control-label">Screenshot</label>
	          <div class="col-sm-9">
	          		          		<input type="text"  disabled class="disabled form-control" value="<?php echo base_url().$site->screenshot; ?>">

	          		<div class="thumbnail" style="width:300px;margin-top:10px">
	          			<img src="<?php echo base_url().$site->screenshot; ?>">
	          			
				      

	          		</div>
	          </div>
	        </div>	


           	<div class="form-group">
	          <label for="" class="col-sm-3 control-label">URL</label>
	          <div class="col-sm-9">
	            	<input type="text"  disabled class="disabled form-control" value="<?php echo $site->url; ?>">
	          </div>
	        </div>	




	        <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Meta Title</label>
	          <div class="col-sm-9">
	            	<input type="text" required  name="metaTitle" class="form-control" value="<?php echo $site->metaTitle; ?>">
	          </div>
	        </div>   

	        <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Meta Keywords</label>
	          <div class="col-sm-9">
	            	<input type="text"  name="metaKeywords" class="form-control" value="<?php echo $site->metaKeywords; ?>">
	          </div>
	        </div> 

	        <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Meta Description</label>
	          <div class="col-sm-9">
	            	<textarea  name="metaDescription" class="form-control"><?php echo $site->metaDescription; ?></textarea>
	          </div>
	        </div>


	         <div class="form-group">
	          <label for="" class="col-sm-3 control-label">IP</label>
	          <div class="col-sm-9">
	            	<input type="text"   name="ip" class="form-control" value="<?php echo $site->ip; ?>">
	          </div>
	        </div> 


	         <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Country</label>
	          <div class="col-sm-9">
	            	<input type="text"   name="country" class="form-control" value="<?php echo $site->country; ?>">
	          </div>
	        </div> 


	        <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Region</label>
	          <div class="col-sm-9">
	            	<input type="text"   name="region" class="form-control" value="<?php echo $site->region; ?>">
	          </div>
	        </div> 
 			
 			<div class="form-group">
	          <label for="" class="col-sm-3 control-label">City</label>
	          <div class="col-sm-9">
	            	<input type="text"   name="city" class="form-control" value="<?php echo $site->city; ?>">
	          </div>
	        </div> 

	         <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Created Date</label>
	          <div class="col-sm-9">
	            	<input type="text"  disabled class="disabled form-control" value="<?php echo $site->registered; ?>">
	          </div>
	        </div>

	         <div class="form-group">
	          <label for="" class="col-sm-3 control-label">Updated Date</label>
	          <div class="col-sm-9">
	            	<input type="text"  disabled class="disabled form-control" value="<?php echo $site->updated; ?>">
	          </div>
	        </div>

        </div>
       
       
      </div><!-- /.box-body -->
      <div class="box-footer">                    
        <button type="submit" class="btn pull-right btn-primary">Update Information</button>
      </div><!-- /.box-footer -->
    </form>
  </div><!-- /.box -->
