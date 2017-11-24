
	<div class="col-md-12">
 		<div class="box box-warning">
 			<form method="POST">
	            <div class="box-header">
	              <h3 class="box-title">Add website</h3>           
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body pad">
	              	
	              	
	                <textarea  name="bulk" class="textarea editor" id="editor" required  placeholder="Enter up to 10,000 domain names. Each name must be on a separate line" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $this->session->flashdata('sites'); ?></textarea>
	                
	              	   <?php
				if($messages = $this->session->flashdata('messages')){ 
					?><?php
					foreach ($messages as $key => $value) {
						?>
							<div class="text-<?php echo $value['type']; ?>">
								<?php echo $value['msg']; ?>
							</div>
						<?php
					}							
					?><?php
				}	
				?>
	            </div>

	         

	            <div class="box-footer">
	            <button type="submit" class="btn btn-success">Process</button>
	            
	            </div>
	         </form>
         </div>
    </div>


  	<div class="col-md-12 hide">
 		<div class="box box-warning">
 			<form method="POST">
	            <div class="box-header">
	              <h3 class="box-title">Incomplete websites scan</h3>           
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body pad">
	              	

				    <div class="col-md-3">
				      <div class="info-box">
				        <span class="info-box-icon bg-red"><i class="fa fa-globe"></i></span>
				        <div class="info-box-content">
				          <span class="info-box-text">Incomplete</span>
				          <span class="info-box-number uncompleted">Wait...</span>
				           <button type="button" class="btn btn-sm btn-success btn-process-now">Process Now</button>
				        </div><!-- /.info-box-content -->
				      </div><!-- /.info-box -->
				    </div><!-- /.col -->


	              	
	            </div>

	         

	          
	         </form>

	         

         </div>

    </div>


	<script>
	
	$(function () {

		var placeholder = 'Enter up to 10,000 domain names.\nEach name must be on a separate line.\n\nExamples:\nexample.com\nexample.net';
		if($('#editor').val() == '')
			$('#editor').val(placeholder);

		$('#editor').on('focus', function(event) {			
		    if($(this).val() === placeholder){
		        $(this).val("");
		    }
		});

		$('#editor').on('blur', function(event) {
		    if($(this).val() ===''){
		       $(this).val(placeholder);
		    }    
		})
		getUncompleted();

		$(".btn-process-now").on('click', function(event) {
			event.preventDefault();
			$(this).remove();
			getUncompletedNext();
		});
		$(document).on('scanCompleted', function(event) {
			event.preventDefault();
			getUncompletedNext();
		});
	});
	

	<?php if(!is_demo()){ ?>
	function getUncompleted()
	{
		$.getJSON("<?php echo base_url(); ?>admin/getUncompleted", false, function(json, textStatus) {
			$(".uncompleted").text(json.n)
		});
	}

	function getUncompletedNext()
	{

		$.getJSON("<?php echo base_url(); ?>admin/getUncompleted/1", false, function(json, textStatus) {
			getUncompleted();
			if(!json.error)
			{
				$(".domain-msg").text(json.url);
				validateDomain(json.url);			
			}
		});
	}
	<?php }else{ ?>
		function getUncompleted()
		{

			alert("Not available in demo account");
		}	
		function getUncompletedNext()
		{

			alert("Not available in demo account");
		}
	<?php } ?>
	
	
	</script>
	<script src="<?php echo base_url(); ?>assets/js/app.js"></script>


   <div class="modal fade" id="mainModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">            
            <h4 class="modal-title"><i class="fa fa-spinner fa-pulse"></i> <?php echo __("Processing..."); ?> <span class='pull-right'><span class='uncompleted'></span> Left</span></h4>

             <!--<div id="monitor">
                  <div class="scan">                
                  </div>
                <div class="glass">
                  <img src="#">
                </div>
              </div>-->

          </div>
          <div class="modal-body">

           

            <h3 class="domain-msg"></h3>
            <div class="text-muted process-msg"><?php echo __("Please wait..."); ?></div>            
            <progress class="progress progress-success progress-sm process-value" style="width:100%" value="0" max="100"></progress>
            <br>
            <div class="alert alert-warning">
            	<strong>Do not close this site</strong>, the processing of all sites take some time to complete
            </div>
          </div>          
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" /> 

    <style>
    progress[value]::-webkit-progress-bar {
		  background-color: #eee;
		  border-radius: 2px;
		  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.25) inset;
		}
		progress[value]::-webkit-progress-value {
 		background-color: #3C8DBC;
    	border-radius: 2px; 
   
			}

	</style>