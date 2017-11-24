<div class="col-md-12">
    <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Logs
					
                  </h3>

                  <a href="?export=paypal_log" class="pull-right btn btn-xs  btn-info">Export CSV</a>
                </div><!-- /.box-header -->
                <div class="box-body" >
                	<div class="col-md-12" style="overflow: auto;">
						 <table data-source="<?php echo base_url(); ?>admin/subscriptions/logs" class="table-ajax table table-hover table-striped table-bordered" id="usersTable">
							<thead>
							  <tr> 
							  	<?php foreach ($fields as $key => $value) {
							  		?>
							  		<th><?php echo __($value->name); ?></th>
							  		<?php
							  	}
							  	?>					    
							    						         
							  </tr>
							</thead>
						<tbody>           
						</tbody>
						</table>
					</div>
				</div>
			</div>
			<a href="https://www.paypal.com/cgi-bin/webscr?cmd=p/acc/ipn-subscriptions-outside" target="_blank" class="pull-right">Payments Variables</a>
		</div>



