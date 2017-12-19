 <div class="container-fluid p-b-3  p-t-3 footer-c">
  <div class="container">
<!--
    <div class="col-md-6">
            <h2 class="light "><?php echo __("About Us"); ?></h2>

      <span><?php echo config_item("company_about"); ?></span>
      
    </div>
-->

<!--
    <div class="col-md-3">
            <h2 class="light "><?php echo __("Contact Info"); ?></h2>
             <?php if(config_item("company_name")){ ?>
            <div class="item-info"><i class="fa fa-building-o" aria-hidden="true" class="m-r-1"></i> <span><?php echo config_item("company_name"); ?></span></div>
            <?php } ?> 
            <?php if(config_item("company_address")){ ?>
            <div class="item-info"><i class="fa fa-map-marker" aria-hidden="true" class="m-r-1"></i> <span><?php echo config_item("company_address"); ?></span></div>
            <?php } ?> 
            <?php if(config_item("company_city_country")){ ?>
            <div class="item-info"><i class="fa fa-globe" aria-hidden="true" class="m-r-1"></i> <span><?php echo config_item("company_city_country"); ?></span></div>
            <?php } ?>
            <?php if(config_item("company_phone1")){ ?>
            <div class="item-info"><i class="fa fa-phone" aria-hidden="true" class="m-r-1"></i> <span><?php echo config_item("company_phone1"); ?></span></div>
            <?php } ?>
            <?php if(config_item("company_phone2")){ ?>
            <div class="item-info"><i class="fa fa-phone" aria-hidden="true" class="m-r-1"></i> <span><?php echo config_item("company_phone2"); ?></span></div>
            <?php } ?>
             <?php if(config_item("company_email")){ ?>
            <div class="item-info"><i class="fa fa-envelope-o" aria-hidden="true" class="m-r-1"></i> <span><?php echo config_item("company_email"); ?></span></div>
            <?php } ?>
    </div>
-->

   
<!--
    <div class="col-md-3">
            <h2 class="light "><?php echo __("Follow Us"); ?></h2>
            <?php if(config_item("company_twitter")){ ?>
            <div class="item-info"><i class="fa fa-twitter-square" aria-hidden="true" class="m-r-1"></i> <span><a href="<?php echo config_item("company_twitter"); ?>">Twitter</a></span></div>
            <?php } ?>

            <?php if(config_item("company_facebook")){ ?>
            <div class="item-info"><i class="fa fa-facebook-square" aria-hidden="true" class="m-r-1"></i> <span><a href="<?php echo config_item("company_facebook"); ?>">Facebook</a></span></div>
            <?php } ?> 
            
            <?php if(config_item("company_gplus")){ ?>
            <div class="item-info"><i class="fa fa-google-plus" aria-hidden="true" class="m-r-1"></i> <span><a href="<?php echo config_item("company_gplus"); ?>">Google Plus</a></span></div>
            <?php } ?>
            <?php if(config_item("company_linkedin")){ ?>
            <div class="item-info"><i class="fa fa-linkedin" aria-hidden="true" class="m-r-1"></i> <span><a href="<?php echo config_item("company_linkedin"); ?>">Linkedin</a></span></div>
            <?php } ?>
             <?php if(config_item("company_instagram")){ ?>
            <div class="item-info"><i class="fa fa-instagram" aria-hidden="true" class="m-r-1"></i> <span><a href="<?php echo config_item("company_instagram"); ?>">Instagram</a></span></div>
            <?php } ?>
    </div>
-->

 
    <div class="col-md-12">
    <hr>
      <div class="copyright"><?php echo config_item("footer"); ?></div>
    </div>


<!--
       <div class="col-md-12 text-xs-right">
         <strong><?php echo __("Languages"); ?></strong> | 

                        
                        <?php foreach (config_item("langs") as $key => $value) {
                            ?>
                            <a <?php if(get_cookie("lang") == $value["code"]) { echo 'class="active"'; } ?> href="?lang=<?php echo $value["code"]; ?>"><i class="zmdi zmdi-translate"></i> <?php echo $value["name"]; ?></a> 
                            <?php
                        }
                        ?>  
    </div>
   
  </div>
-->

    
</div>


<?php if(config_item("ga")){ ?>
<script>
var _gaq=[["_setAccount","<?php echo config_item("ga"); ?>"],["_trackPageview"]];
(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
g.src=("https:"==location.protocol?"//ssl":"//www")+".google-analytics.com/ga.js";
s.parentNode.insertBefore(g,s)}(document,"script"));
</script>
<?php } ?>

<div class="shortcut">
   <ul class=" ">
               
                <?php if(!is_logged())
                {
                    ?> <li class="register-login"><a class="" href="<?php echo base_url(); ?><?php echo config_item("slug_login"); ?>"><?php echo __("Login/Register"); ?></a></li> <?php
                }
                else
                {
                    ?>
                    
                        <li class="profile">
                            <div>
                           <img class="avatar" src='<?php echo get_gravatar(_user('email')); ?>'>
                           <span class="truncate name">
                           <?php echo _user("names"); ?>
                           </span>

                            <span class="truncate email"><?php echo _user("email"); ?></span>  
                            
                            <a class="setting" title="<?php echo __("My Profile"); ?>" href="<?php echo base_url(); ?><?php echo config_item("slug_user"); ?>"><i class="zmdi zmdi-settings"></i></a>          
                            <a class="logout" title="<?php echo __("Logout"); ?>" href="<?php echo base_url(); ?><?php echo config_item("slug_logout"); ?>"><i class="zmdi zmdi-power"></i> </a>
                             <a title="<?php echo __("Bookmarks"); ?>" class="bookmarks" href="<?php echo base_url(); ?><?php echo config_item("slug_user"); ?>/bookmarks"><i class="zmdi zmdi-bookmark"></i>
                             <span class="count"><?php echo count($bookmarks); ?></span>
                             </a>          

                            


                            </div>
                           
                        
                        <?php if(is_sadmin()){ ?>
                              <a  class="administrator" href="<?php echo base_url(); ?>admin/dashboard"><i class="zmdi zmdi-settings-square"></i> <?php echo __("Go to Administrator"); ?></a>          
                        <?php } ?> 

                        <?php if(isAvailablePlan()){ ?>
                          <a class="upgradePlan" href="<?php echo base_url(); ?><?php echo config_item("slug_subscriptions"); ?>"><i class="zmdi zmdi-mood"></i> <?php echo __("Upgrade Plan"); ?></a>
                        <?php } ?>
                        </li>

                    
                     <?php   
                }
                ?>
                <?php if($shortcut){ ?>
                <li class="hide shortcut-links">
                <strong><?php echo __("Shortcuts"); ?></strong>
                <?php
                $modules = explode(",",config_item("enable_block"));
                foreach ($modules as $key => $value) {
                  ?>
                     <a class="truncate" href="#" data-go="#<?php echo $value; ?>"><i class="zmdi zmdi-chevron-right"></i> <?php echo __("Shortcut ".$value); ?></a>

                    <?php
                }
                ?>
                </li>
                <?php } ?>
                

                       <?php if(config_item("page_contact_form") == '1')
                 {
                    ?><li class="hide">
                        <strong><?php echo __("Pages"); ?></strong>
                             <?php foreach ($pages as $key => $value) {
                              ?>
                              <a class="truncate" href="<?php echo base_url(); ?><?php echo config_item("slug_pages"); ?>/<?php echo $value->slug; ?>"><i class="zmdi zmdi-google-pages"></i> <?php echo $value->title; ?></a>
                              <?php
                           }
                           ?>

                           <?php if(config_item("page_contact_form") == '1')
                              {
                                 ?><a href="<?php echo base_url(); ?><?php echo config_item("slug_contact"); ?>"><i class="zmdi zmdi-email"></i> <?php echo __("Contact"); ?></a><?php
                              }
                              ?>
                              <?php if(config_item("page_last_sites") == '1')
                              {
                                 ?><a href="<?php echo base_url(); ?><?php echo config_item("slug_last"); ?>"><i class="zmdi zmdi-calendar-check"></i> <?php echo __("Latest Updated Sites"); ?></a><?php
                              }
                              ?> 
                              <?php if(config_item("page_top_sites") == '1')
                              {
                                 ?><a href="<?php echo base_url(); ?><?php echo config_item("slug_top"); ?>"><i class="zmdi zmdi-folder-star-alt"></i> <?php echo __("Top Sites"); ?></a><?php
                              }
                              ?>

                        </li>
                     <?php
                 }
                 ?>     
                  <?php if(count($bookmarks) >0){ ?>

                        <li class="hide truncate">
                           <strong><?php echo __("Bookmarks"); ?></strong>

                        
                        <?php foreach ($bookmarks as $key => $value) {
                          if($key <=5){
                            ?>
                            <a class="truncate" href="<?php echo base_url(); ?><?php echo $value->url; ?>"><i class="zmdi zmdi-globe"></i> <?php echo $value->url_real; ?></a>          
                            <?php
                            }
                        }
                        ?>  
                        <a class="truncate" href="<?php echo base_url(); ?><?php echo config_item("slug_user"); ?>/bookmarks"><i class="zmdi zmdi-bookmark"></i> <?php echo __("View all bookmarks"); ?></a>          


                     </li>
                     <?php } ?>
                 
                        <li class="hide">
                           <strong><?php echo __("Languages"); ?></strong>

                        
                        <?php foreach (config_item("langs") as $key => $value) {
                            ?>
                            <a <?php if(get_cookie("lang") == $value["code"]) { echo 'class="active"'; } ?> href="?lang=<?php echo $value["code"]; ?>"><i class="zmdi zmdi-translate"></i> <?php echo $value["name"]; ?></a>          
                            <?php
                        }
                        ?>  
                      

                     </li>

                    


            </ul>
            </div>


     <script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
     <script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"></script>
     <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js"></script>
     <script src="/assets/js/app.js?v=<?php echo config_item("version"); ?>"></script>

     <script async type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

     <!-- integration YieldKit -->
    <script type='text/javascript'>
         (function () {
             var scriptProto = 'https:' == document.location.protocol ? 'https://' : 'http://';
             var script = document.createElement('script');
             script.type = 'text/javascript';
             script.async = true;
             script.src = scriptProto+'js.srvtrck.com/v1/js?api_key=7599d8cfef58c65376a858a4af02c1bb&site_id=39f9a10de67848739f22548bd044c56d';
             (document.getElementsByTagName('head')[0] || document.body).appendChild(script);
         })();
     </script>
