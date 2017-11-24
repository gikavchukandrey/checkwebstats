<?php
$secret_bash = config_item("secret_bash");
if(is_demo())
	$secret_bash = '1234567890987654321';

?>
     
<div class="col-md-8">
		<div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li class="active"><a href="#tab_1-1a" data-toggle="tab" aria-expanded="true">Bash <small>(Recommended)</small></a></li>
              <li class=""><a href="#tab_2-2a" data-toggle="tab" aria-expanded="false">Curl</a></li>
              
              <li class="pull-left header">Background Process
              
              </li>

            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1-1a">
                             	
	            	<strong>Process all websites incomplete</strong>
				    <pre><?php echo FCPATH; ?>index.php background process</pre>
				    <br>
				    <strong>Process websites on bookmark and send email report</strong>
				    <pre><?php echo FCPATH; ?>index.php background report</pre>
				    <br>
				    <strong>Process old websites</strong>
				    <pre><?php echo FCPATH; ?>index.php background update</pre>
				   
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2-2a">
          	<strong>Process all websites incomplete</strong>
				    <pre><?php echo base_url(); ?>background/process?secret=<?php echo $secret_bash; ?></pre>
				    <br>
				    <strong>Process websites on bookmark and send email report</strong>
				    <pre><?php echo base_url(); ?>background/report?secret=<?php echo $secret_bash; ?></pre>

				    <br>
				    <strong>Process old websites</strong>
				    <pre><?php echo base_url(); ?>background/update?secret=<?php echo $secret_bash; ?></pre>

              </div>
              
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
    </div>




     
 	<div class="col-md-4">
 		<div class="box box-default">
 			<form method="POST">
	            <div class="box-header">
	              <h3 class="box-title">Settings</h3>           
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	             	
	             	<table class="table">
	             		<tr>
	             			<td valign="absmiddle"><strong>Process limit</strong></td>
	             			<td><input type="number" required class="form-control" min="1" max="1000" step="1" value="<?php echo intval(config_item("process_limit")); ?>" name="process_limit"></td>
	             		</tr>

	             		<tr>
	             			<td valign="absmiddle"><strong>Update limit</strong></td>
	             			<td><input type="number" required class="form-control" min="1" max="1000" step="1" value="<?php echo intval(config_item("update_limit")); ?>" name="update_limit"></td>
	             		</tr>


	             		<tr>
	             			<td valign="absmiddle"><strong>Record Logs</strong></td>
	             			<td>
	             					<select class="form-control"  required  style="width:100%" name="process_log">
									<option <?php if(config_item("process_log") == '1') { echo 'selected'; } ?> value="1">Yes</option>
									<option <?php if(config_item("process_log") == '2') { echo 'selected'; } ?> value="2">No</option>
								</select>
	             			</td>
	             		</tr>

	             	</table>
	             		
	             		
	             	
	              	
	            </div>

	            <div class="box-footer">                    
			        <button type="submit" class="btn pull-right btn-primary">Save</button>
			      </div><!-- /.box-footer -->


	         
</form>
	          
	     
	         
	     

         </div>

    </div>

<div class="col-md-12">
<div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li class="active"><a href="#tab_1-1" data-toggle="tab" aria-expanded="true">Process</a></li>
              <li class=""><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Report</a></li>
              
              <li class="pull-left header">History Logs
              <form onsubmit="return confirm('Are you sure?');" method="POST" class="pull-right" style="margin-left: 10px">
              	<input type="hidden" name="truncate" value="1">
              	<button  type="submit" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i> Empty</button>
              </form>
              </li>

            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1-1">
               <table data-source="<?php echo base_url(); ?>admin/jobs?groupid=process" class="table-ajax table table-hover table-striped table-bordered" id="usersJobs">
	            	<thead>
	            		<tr>
	            			<th>Level</th>
	            			<th>Date</th>
	            			<th>Log</th>
	            		</tr>
	            	</thead>
	            	<tbody>
	            	
	            	
	            	</tbody>
	            </table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2-2">
                <table data-source="<?php echo base_url(); ?>admin/jobs?groupid=report" class="table-ajax table table-hover table-striped table-bordered" id="usersJobs2">
	            	<thead>
	            		<tr>
	            			<th>Level</th>
	            			<th>Date</th>
	            			<th>Log</th>
	            		</tr>
	            	</thead>
	            	<tbody>
	            	
	            	
	            	</tbody>
	            </table>
              </div>
              
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
    </div>

  

	