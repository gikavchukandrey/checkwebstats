
	<?php for($x=1;$x<=3;$x++){ ?>
	 <div class="col-md-4">
		  <!-- Horizontal Form -->
		  <div class="box box-info">
		    <div class="box-header with-border">
		      <h3 class="box-title">
		      <?php 
		      if(!config_item('paypal_p'.$x.'_name')){
		      	if($x > 1)
		      		echo "Subscription #".$x; 
		      	else
		      		echo "Free"; 
		      }
		      else
		      {
		      	if($x > 1)
		      		echo config_item('paypal_p'.$x.'_name'); 
		      	else
		      		echo 'Free';
		      } 
		      ?></h3>
		     </div>
			    <form class="" method="POST">
			        <div class="box-body ">
			        	<table class="table">
			        		<tr>
			        			<td>Enable</td>
			        		</tr>
			        		<tr>
			        			<td>
			        				<select <?php if($x ==1){ echo 'disabled readonly';  } ?>  class="form-control" required name="paypal_p<?php echo $x; ?>_enable">
										<option value="1" <?php if(config_item("paypal_p".$x."_enable") == '1' || $x==1){echo 'selected'; } ?>>Yes</option>
					            		<option value="2" <?php if((config_item("paypal_p".$x."_enable") == '2' || config_item("paypal_p".$x."_enable") == '') && $x > 1){echo 'selected'; } ?>>No</option>	            		
					            	</select>
			        			</td>
			        		</tr>
			        		<tr>
			        			<td>Name</td>
			        		</tr>
			        		<tr>
			        			<td><input type="text" class="form-control" <?php if($x ==1){ echo 'disabled readonly';  } ?> required  value="<?php if($x>1){echo config_item('paypal_p'.$x.'_name'); }else{echo 'Free'; } ?>" name="paypal_p<?php echo $x; ?>_name" ></td>
			        		</tr>

			        		<tr>
			        			<td>Price Monthly (USD)</td>
			        		</tr>
			        		<tr>
			        			<td><input  <?php if($x ==1){ echo 'disabled readonly';  } ?>  type="text" class="form-control" min="1" max="9999999"  required  value="<?php if($x>1){echo config_item('paypal_p'.$x.'_price_monthly'); }else{echo '0'; } ?>" name="paypal_p<?php echo $x; ?>_price_monthly" ></td>
			        		</tr>

			        		<tr>
			        			<td>Price Yearly (USD)</td>
			        		</tr>
			        		<tr>
			        			<td><input  <?php if($x ==1){ echo 'disabled readonly';  } ?>  type="text" class="form-control" min="1" max="9999999" stpe="1" required  value="<?php if($x>1){echo config_item('paypal_p'.$x.'_price_yearly'); }else{echo '0'; } ?>" name="paypal_p<?php echo $x; ?>_price_yearly" ></td>
			        		</tr>

			        		
			        		<tr>
			        			<td>Bookmarks limit</td>
			        		</tr>
			        		<tr>
			        			<td><input type="text" class="form-control" min="1" max="99999" stpe="1" required  value="<?php echo config_item('paypal_p'.$x.'_bookmark_limit'); ?>" name="paypal_p<?php echo $x; ?>_bookmark_limit" ></td>
			        		</tr>
			        		<tr>
			        			<td>Historical data</td>
			        		</tr>
			        		<tr>
			        			<td>
			        				<select class="form-control" required name="paypal_p<?php echo $x; ?>_historica_data">
					            		<option value="2" <?php if(config_item("paypal_p".$x."_historica_data") == '2'){echo 'selected'; } ?>>No</option>	            		
					            		<option value="1" <?php if(config_item("paypal_p".$x."_historica_data") == '1'){echo 'selected'; } ?>>Yes</option>
					            	</select>
			        			</td>
			        		</tr>

			        		<tr>
			        			<td>PDF Report</td>
			        		</tr>
			        		<tr>
			        			<td>
			        				<select class="form-control" required name="paypal_p<?php echo $x; ?>_pdf_repport">
					            		<option value="2" <?php if(config_item("paypal_p".$x."_pdf_repport") == '2'){echo 'selected'; } ?>>No</option>	            		
					            		<option value="1" <?php if(config_item("paypal_p".$x."_pdf_repport") == '1'){echo 'selected'; } ?>>Yes</option>
					            	</select>
			        			</td>
			        		</tr>

			        		<tr>
			        			<td>PDF Big Watermark</td>
			        		</tr>
			        		<tr>
			        			<td>
			        				<select class="form-control" required name="paypal_p<?php echo $x; ?>_pdf_big_wathermark">
					            		<option value="1" <?php if(config_item("paypal_p".$x."_pdf_big_wathermark") == '1'){echo 'selected'; } ?>>Yes</option>
					            		<option value="2" <?php if(config_item("paypal_p".$x."_pdf_big_wathermark") == '2'){echo 'selected'; } ?>>No</option>	            		
					            		
					            	</select>
			        			</td>
			        		</tr>

			        		<tr>
			        			<td>PDF Small Watermark</td>
			        		</tr>
			        		<tr>
			        			<td>
			        				<select class="form-control" required name="paypal_p<?php echo $x; ?>_pdf_small_wathermark">
					            		<option value="1" <?php if(config_item("paypal_p".$x."_pdf_small_wathermark") == '1'){echo 'selected'; } ?>>Yes</option>
										<option value="2" <?php if(config_item("paypal_p".$x."_pdf_small_wathermark") == '2'){echo 'selected'; } ?>>No</option>	            		

					            	</select>
			        			</td>
			        		</tr>

			        		<tr>
			        			<td>Modules</td>
			        		</tr>
			        		<tr>
			        			<td>
			        				
			        					<?php
			        						$data = $this->Admin->getTable("settings",array("var" => 'paypal_p'.$x.'_modules'))->row_array();
			        							$temp  = array();
						        	 		 $temp = explode("|", $data['options']);
  											$options = '';
										      foreach ($temp as $key => $value) 
										      { 
										        $lables     = explode(":", $value);
										        $valuel     = $lables[0];
										        if($lables[1] != '')
										          $value = $lables[1];
										        if($valuel == '')
										          $valuel = $value;

										         $selected = '';
										         $temp_values  = explode(",", $data['value']);
										         if(in_array($value, $temp_values))
										           $selected = 'selected="selected"';
										          if($value != '')
										            $options .= "<option  $selected value='".$value."'>".$valuel."</option>";
										      }
										      
										      $input = '<select multiple="multiple" class="form-control select2"  name="'.$data['var'].'[]" id="'.$data['var'].'">'.$options.'</select>';
										  echo $input;
						        		?>
					            	
			        			</td>
			        		</tr>
			        		
			        	</table>
			            
			        
			  

			    
			        </div><!-- /.box-body -->
		        <div class="box-footer">          
		             <button type="submit" name="submit" class="btn btn-primary pull-right">Save</button>
		        </div>
		      </form>
		    
		   </div>
		</div>
	<?php } ?>
