<nav class="navbar navbar-fixed-top navbar-dark bg-blue-dark">
        

 


    <div class="container-fluid">
        <div class="" >
           
                
                <a class="navbar-brand menu-toggle" href="#">
                    <?php if(is_logged()){ ?>
                        <img class="avatar-hide  animated rotateIn avatar" src='<?php echo get_gravatar(_user('email')); ?>'>
                        
                        <span class="avatar-hide plan"><?php echo getPlanName(_user("plan")); ?></span>
                        
                        <i class="zmdi zmdi-close animated rotateIn pull-xs-left"></i> 
                    <?php }else{ ?> 
                    <i class="zmdi zmdi-menu animated rotateIn pull-xs-left"></i> 
                    <?php } ?>
            </a>

            <a class="navbar-brand  hidden-md-down " href="<?php echo base_url(); ?>">
                 <img  class="logo" alt="<?php echo config_item("site_title"); ?>" title="<?php echo config_item("site_title"); ?>" src="<?php echo base_url(); ?><?php echo config_item("logo"); ?>">
            </a>
            <?php if($page == 'home' && !is_logged()){ ?>
<!--             <a class="animated bounceIn btn btn-secondary pull-xs-right hidden-md-down" href="<?php echo base_url(); ?><?php echo config_item("slug_login"); ?>"><?php echo __("Login/Register"); ?></a> -->

            
            </a>
            <?php } ?>
            
            <?php if($page != 'home'){ ?>
                <form class="  form-inline pull-xs-right form-url ">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="zmdi zmdi-globe"></i></span>
                        <input class="form-control input-url" required type="text" placeholder="<?php echo __("Website URL to review"); ?>" />
                        <button class="btn hidden-md-down btn-start" type="submit"><?php echo __("Review"); ?></button>
                    </div>
                </form>
            <?php }else{ ?>
             <a class="navbar-brand hidden-md-up" href="<?php echo base_url(); ?>">
                 <img  class="logo" alt="<?php echo config_item("site_title"); ?>" title="<?php echo config_item("site_title"); ?>" src="<?php echo base_url(); ?><?php echo config_item("logo"); ?>">
            </a>

            <?php } ?>
<!--
            <ul class="nav navbar-nav pull-md-right ">
               

                 <?php if(config_item("page_contact_form") == '1')
                 {
                    ?><li class="nav-item"><a class="nav-link" href="<?php echo base_url(); ?><?php echo config_item("slug_contact"); ?>"><?php echo __("Contact"); ?></a></li><?php
                 }
                 ?>              
                 


               
                <li class="nav-item">
                <?php if(!is_logged())
                {
                    ?><a class="nav-link" href="<?php echo base_url(); ?><?php echo config_item("slug_login"); ?>"><?php echo __("Login/Register"); ?></a><?php
                }
                else
                {
                    ?>
                    <div class="btn-group">
                        <a class="nav-link dropdown-toggle active"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  href="#" title="<?php echo _user("email"); ?>"><?php echo _user("names"); ?></a>
                        <div class="dropdown-menu">
                        <?php if(is_sadmin()){ ?>
                        <a class="dropdown-item" href="<?php echo base_url(); ?>admin/dashboard"><?php echo __("Administrator"); ?></a>          
                        <?php } ?>
                        <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo config_item("slug_user"); ?>"><?php echo __("My Profile"); ?></a>          
                        <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo config_item("slug_user"); ?>/bookmarks"><?php echo __("Bookmarks"); ?></a>          
                        <a class="dropdown-item" href="<?php echo base_url(); ?><?php echo config_item("slug_logout"); ?>"><?php echo __("Logout"); ?></a>
                      </div>

                    </div>
                     <?php   
                }
                ?>
                </li>

                
                <li class="nav-item btn-group ">
                        <a class="nav-link dropdown-toggle text-uppercase"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  href="#"><?php echo get_cookie("lang"); ?></a>
                        <div class="dropdown-menu">
                        <?php foreach (config_item("langs") as $key => $value) {
                            ?>
                            <a class="dropdown-item" href="?lang=<?php echo $value["code"]; ?>"><?php echo $value["name"]; ?></a>          
                            <?php
                        }
                        ?>  
                      </div>

                </li>
            </ul>
        </div>

            -->

    </div>
</nav>
