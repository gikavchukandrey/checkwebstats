<div class="containter">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 text-xs-center m-t-3 m-b-3">
            <h2 class="nice-title "><i class="zmdi zmdi-paypal"></i><span><?php echo __("Purchase Summary"); ?></span></h2>

            <div class="card card-block">
                <table class="table table-hover text-xs-left m-b-3">
                    <tr>
                        <td><strong><?php echo __("Account Type"); ?></strong></td>
                        <td><?php echo $plan['name']; ?></td>
                    </tr> 
                    <tr>
                        <td><strong><?php echo __("Billing"); ?></strong></td>
                        <td><?php echo $plan['billing'][$plan['cycle']]; ?></td>
                    </tr>  
                    <tr>
                        <td><strong><?php echo __("Starting Date"); ?></strong></td>
                        <td><?php echo date("Y-m-d"); ?></td>
                    </tr> 
                    <tr>
                        <td><strong><?php echo __("Price"); ?></strong></td>
                        <td><?php echo number_format($plan['price'],2); ?></td>
                    </tr> 
                    <tr>
                        <td colspan="2"><strong><?php echo __("Your account information"); ?></strong></td>
                        
                    </tr>
                     <tr>
                        <td><strong><?php echo __("Names"); ?></strong></td>
                        <td><?php echo _user("names"); ?></td>
                    </tr>
                      <tr>
                        <td><strong><?php echo __("Email"); ?></strong></td>
                        <td><?php echo _user("email"); ?></td>
                    </tr>  
                  
                </table>

                <?php if($plan['id'] > 1 && $plan['id'] <=3){ ?>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">

                    <!-- Identify your business so that you can collect the payments. -->
                    <input type="hidden" name="business" value="<?php echo config_item("paypal_email"); ?>">

                    <!-- Specify a Subscribe button. -->
                    <input type="hidden" name="cmd" value="_xclick-subscriptions">
                    <!-- Identify the subscription. -->
                    <input type="hidden" name="item_name" value="<?php echo $plan['name']; ?>">
                    <input type="hidden" name="item_number" value="<?php echo $plan['id']; ?>">
                    <input type="hidden" name="custom" value="<?php echo _user("email");?>">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="rm" value="0">
                    <input type="hidden" name="image_url" value="<?php echo base_url(); ?><?php echo config_item("logo"); ?>">
                    <input type="hidden" name="return" value="<?php echo base_url(); ?><?php echo config_item("slug_user"); ?>">

                    <!-- Set the terms of the regular subscription. -->
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="hidden" name="a3" value="<?php echo floatval($plan['price']); ?>">
                    <input type="hidden" name="p3" value="1">
                    <input type="hidden" name="t3" value="<?php echo $plan['cycle']; ?>">
                    <input type="hidden" name="notify_url" value="<?php echo base_url(); ?>paypal/process">
                    <!-- Upgrade -->
                    <?php if(intval(_user("plan") > 1))
                    {
                        ?><input type="hidden" name="modify" value="2"><?php
                    }
                    ?>
                    
                    <!-- Set recurring payments until canceled. -->
                    <input type="hidden" name="src" value="1">

                    <!-- Display the payment button. -->
                    <button type="submit" class="btn btn-success">
                        <?php echo __("Place the Order"); ?>
                    </button>
                    <img alt="" width="1" height="1"
                    src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
                </form>
                <?php }else{ ?>
                
                <div class="alert alert-info">
                    <?php echo __("For change plan to FREE need go to your paypal account and cancel your preapproved payment subscriptions"); ?>
                </div>
                
                <?php } ?>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
