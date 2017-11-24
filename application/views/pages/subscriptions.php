<div class="container">
  <div class="row p-b-3 m-b-3  flex-items-xs-middle flex-items-xs-center">



<?php 
if($this->input->get("plan") == 'monthly' || !$this->input->get("plan"))
  {
    ?>
      <h2 class="nice-title "><i class="zmdi zmdi-star"></i> <span><?php echo __("Monthly Plans "); ?></span>
         <a class="pull-right" href="?plan=anual"><?php echo __("Annual Plans, Save up to 25%"); ?></a>

    </h2>
    <?php
  for($x=1;$x<=3;$x++){ 
    $name = config_item('paypal_p'.$x.'_name');
    $price = config_item('paypal_p'.$x.'_price_monthly');
    $temp = explode(".", number_format($price,2));
    if($x== 1)
    {
      $price = 0;
      $price_yearly = 0;
      $name = __("Free");
    }
    $col = 4;
    if(config_item('paypal_p2_enable') == 2 || config_item('paypal_p3_enable') == 2)
      $col = 6;
    if(config_item('paypal_p2_enable') == 2 && config_item('paypal_p3_enable') == 2)
      $col = 12;

    if(config_item('paypal_p'.$x.'_enable') == 1 || $x==1){ ?>
    
      <!-- Table #1  -->
      <div class="col-xs-12 col-lg-<?php echo $col; ?>">
        <div class="card  card-suscription text-xs-center">
          <div class="card-header">
            <h3 class="display-2"><span class="currency">$</span><?php echo $temp[0]; ?><span class="period">.<?php echo $temp[1]; ?> <?php echo __("/month"); ?></span></h3>
          </div>
          <div class="card-block">
            <h4 class="card-title"> 
              <?php echo $name; ?>
            </h4>

               <?php if(_user("plan") == $x){
              ?><strong  class="btn selected btn-gradient mt-2"><?php echo __("Actived"); ?></strong><?php
            }
            else
            {
              ?><a href="?select=<?php echo $x; ?>" class="btn btn-gradient mt-2"><?php echo __("Choose Plan"); ?></a><?php
            }
            ?>

            <div class="features">
              
              <span><?php echo __("Bookmarks limit"); ?><strong><?php echo number_format(config_item('paypal_p'.$x.'_bookmark_limit')); ?></strong></span>
              <span><?php echo __("Historical data"); ?><i class="<?php if(config_item('paypal_p'.$x.'_historica_data') == '1'){ echo 'text-success zmdi zmdi-check-circle'; }else{ echo 'text-danger zmdi zmdi-close-circle';} ; ?>"></i></span>
              <span><?php echo __("PDF report"); ?><i class="<?php if(config_item('paypal_p'.$x.'_pdf_repport') == '1'){ echo 'text-success zmdi zmdi-check-circle'; }else{ echo 'text-danger zmdi zmdi-close-circle';} ; ?>"></i></span>
              <span><?php echo __("Remove PDF big watermark"); ?><i class="<?php if(config_item('paypal_p'.$x.'_pdf_big_wathermark') == '2'){ echo 'text-success zmdi zmdi-check-circle'; }else{ echo 'text-danger zmdi zmdi-close-circle';} ; ?>"></i></span>
              <span><?php echo __("Remove PDF small watermark"); ?><i class="<?php if(config_item('paypal_p'.$x.'_pdf_small_wathermark') == '2'){ echo 'text-success zmdi zmdi-check-circle'; }else{ echo 'text-danger zmdi zmdi-close-circle';} ; ?>"></i></span>
              <span class="title"><?php echo __("Modules"); ?></span>
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
            <p><?php echo __("DESCRIPTION_SUBSCRIPTION_MONTHLY_".$x); ?></p>
            <?php if(_user("plan") == $x){
              ?><strong class="btn selected btn-gradient mt-2"><?php echo __("Actived"); ?></strong><?php
            }
            else
            {
              ?><a href="?select=<?php echo $x; ?>" class="btn btn-gradient mt-2"><?php echo __("Choose Plan"); ?></a><?php
            }
            ?>
            
          </div>
        </div>
      </div>
      <?php } ?>
  <?php } ?>
<?php }else{ ?>
   

     <h2 class="nice-title "><i class="zmdi zmdi-star"></i> <span><?php echo __("Annual Plans"); ?></span>
     <a class="pull-right" href="?plan=monthly"><?php echo __("Monthly Plans"); ?></a>
     </h2>


<?php for($x=1;$x<=3;$x++){ 
  $name = config_item('paypal_p'.$x.'_name');
  
  $price = config_item('paypal_p'.$x.'_price_yearly');
  $temp = explode(".", number_format($price,2));
  if($x== 1)
  {
    $price = 0;
    $price_yearly = 0;
    $name = __("Free");
  }
  $col = 4;
  if(config_item('paypal_p2_enable') == 2 || config_item('paypal_p3_enable') == 2)
    $col = 6;
  if(config_item('paypal_p2_enable') == 2 && config_item('paypal_p3_enable') == 2)
    $col = 12;

  if(config_item('paypal_p'.$x.'_enable') == 1 || $x==1){ ?>
  
    <!-- Table #1  -->
    <div class="col-xs-12 col-lg-<?php echo $col; ?>">
      <div class="card  card-suscription text-xs-center">
        <div class="card-header">
          <h3 class="display-2"><span class="currency">$</span><?php echo $temp[0]; ?><span class="period">.<?php echo $temp[1]; ?> <?php echo __("/annual"); ?></span></h3>
        </div>
        <div class="card-block">
          <h4 class="card-title"> 
            <?php echo $name; ?>
          </h4>

             <?php if(_user("plan") == $x){
            ?><strong  class="btn selected btn-gradient mt-2"><?php echo __("Actived"); ?></strong><?php
          }
          else
          {
            ?><a href="?select=<?php echo $x; ?>&y=1" class="btn btn-gradient mt-2"><?php echo __("Choose Plan"); ?></a><?php
          }
          ?>

          <div class="features">
            
            <span><?php echo __("Bookmarks limit"); ?><strong><?php echo number_format(config_item('paypal_p'.$x.'_bookmark_limit')); ?></strong></span>
            <span><?php echo __("Historical data"); ?><i class="<?php if(config_item('paypal_p'.$x.'_historica_data') == '1'){ echo 'text-success zmdi zmdi-check-circle'; }else{ echo 'text-danger zmdi zmdi-close-circle';} ; ?>"></i></span>
            <span><?php echo __("PDF report"); ?><i class="<?php if(config_item('paypal_p'.$x.'_pdf_repport') == '1'){ echo 'text-success zmdi zmdi-check-circle'; }else{ echo 'text-danger zmdi zmdi-close-circle';} ; ?>"></i></span>
            <span><?php echo __("Remove PDF big watermark"); ?><i class="<?php if(config_item('paypal_p'.$x.'_pdf_big_wathermark') == '2'){ echo 'text-success zmdi zmdi-check-circle'; }else{ echo 'text-danger zmdi zmdi-close-circle';} ; ?>"></i></span>
            <span><?php echo __("Remove PDF small watermark"); ?><i class="<?php if(config_item('paypal_p'.$x.'_pdf_small_wathermark') == '2'){ echo 'text-success zmdi zmdi-check-circle'; }else{ echo 'text-danger zmdi zmdi-close-circle';} ; ?>"></i></span>
                          <span class="title"><?php echo __("Modules"); ?></span>

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
          <p><?php echo __("DESCRIPTION_SUBSCRIPTION_YEARLY_".$x); ?></p>
          <?php if(_user("plan") == $x){
            ?><strong class="btn selected btn-gradient mt-2"><?php echo __("Actived"); ?></strong><?php
          }
          else
          {
            ?><a href="?select=<?php echo $x; ?>&y=1" class="btn btn-gradient mt-2"><?php echo __("Choose Plan"); ?></a><?php
          }
          ?>
          
        </div>
      </div>
    </div>
    <?php } ?>
<?php } ?>
<?php } ?>



  </div>
</div>