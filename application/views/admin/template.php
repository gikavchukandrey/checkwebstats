<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo config_item("site_title"); ?> - Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.1.2/css/material-design-iconic-font.min.css">
    <!-- Ionicons -->
<!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/admin/js/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/skins/_all-skins.min.css">
  

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/js/plugins/select2/select2.min.css">


     <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/js/plugins/datatables/dataTables.bootstrap.css">
     
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/admin/css/MBTools.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    
    <script>
    var noReload = true;
    var base_url = '<?php echo base_url(); ?>';
    
   
       var csfrData = {};
       csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
     </script>
      <link rel="icon" type="image/png" href="<?php echo base_url(); ?>assets/images/favicon.png">
  </head>
  <body class="hold-transition skin-blue sidebar-mini fixed">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><?php echo mb_strtoupper(mb_substr(config_item("site_title"),0,3)); ?></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><?php echo mb_substr(config_item("site_title"),0,20); ?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
             
              
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo avatar(_user('avatar')); ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo _user('username'); ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="<?php echo avatar(_user('avatar')); ?>" class="img-circle" alt="User Image">
                    <p>
                      <?php echo _user('username'); ?>
                      <small><?php echo _user('email'); ?></small>
                    </p>
                  </li>
                 
                  <!-- Menu Footer-->
                  <li class="user-footer">                   
                    <div class="pull-left">
                      <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              
              
            </ul>
          </div>
        </nav>
      </header>

      <!-- =============================================== -->

      <!-- Left side column. contains the sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <form action="#" method="get" class="sidebar-form hide">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>


          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <?php foreach ($_MENU as $key => $value) {              
              ?>
              <li class="<?php if($menu == $value['idunique']) { echo "active"; } ?>">
                <a href="<?php echo base_url(); ?><?php echo $value['target']; ?>">
                  <i class="<?php echo $value['icon']; ?>"></i> <span><?php echo $value['title']; ?></span>
                  <?php if($value['submenu']){ ?>
                  <i class="fa fa-angle-left pull-right"></i>
                  <?php } ?>

                </a>
                <?php if($value['submenu']){ ?>
                    <ul class="treeview-menu menu-close" >
                    <?php foreach ($value['submenu'] as $key2 => $value2) {
                      ?>
                          <li class="<?php if($submenu == $value2['idunique']) { echo "active"; } ?>">
                            <a href="<?php echo base_url(); ?><?php echo $value2['target']; ?>">
                                <i class="<?php echo $value2['icon']; ?>"></i> <span><?php echo $value2['title']; ?></span>
                              </a>
                          </li>                          
                       
                      <?php
                      }
                      ?>                                     
                      </ul>
                    <?php
                    }
                    ?>
              </li>
              <?php
            }
            ?>
            <li class="<?php if($menu == 'about') { echo "active"; } ?>">
                <a href="<?php echo base_url(); ?>admin/about">
                  <i class="fa fa-question-circle"></i> <span>About</span>
                </a>
            </li>     

            <li class="">
                <a href="https://codecanyon.net/item/prorank-analyzer-stats-website/18722377/support?ref=jodacame" target="_blank">
                  <strong><i class="fa fa-ambulance"></i> <span>Need Support?</span></strong>
                </a>
            </li>

            

          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
            <small><?php echo $subtitle; ?></small>
          </h1>         
        </section>

        <!-- Main content -->
        <section class="content">
              <div class="row">
                <?php if(is_demo()){ ?>
                  <div class="row-fluid">
                    <div class="col-md-12">
                      <div class="alert alert-info">
                        You are using <strong>DEMO ACCOUNT</strong>
                      </div>
                    </div>
                  </div>
                <?php } ?>
                <?php
                 if(ini_get('open_basedir') || ini_get('safe_mode') ){ ?>
                   <div class="row-fluid">
                    <div class="col-md-12">
                      <div class="alert alert-warning">
                        <i class="zmdi zmdi-alert-triangle"></i> <strong>CURLOPT_FOLLOWLOCATION</strong> cannot be activated when in safe_mode or an open_basedir is set. Some sites require this disabled for get redirect location. (Please contact to your hosting support)
                      </div>
                    </div>
                  </div>
                  <?php
                 }
                 ?>
                  <?php if($alert){ ?>
                  <div class="row-fluid">
                    <div class="col-md-12">
                      <div class="alert alert-<?php echo $alert['type']; ?>">
                        <?php echo $alert['text']; ?>
                      </div>
                    </div>
                  </div>
                <?php } ?>


                <?php echo $_PAGE; ?>
              </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> <?php echo config_item("version"); ?>
        </div>
        <strong>Copyright &copy; <?php echo date("Y"); ?> <a href="https://codecanyon.net/user/jodacame?ref=jodacame" target="_blank">Jodacame </a> </strong>
      </footer>

      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="<?php echo base_url(); ?>assets/admin/js/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>assets/admin/js/plugins/fastclick/fastclick.min.js"></script>

    <!-- DataTables -->
    <script src="<?php echo base_url(); ?>assets/admin/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/plugins/datatables/dataTables.bootstrap.min.js"></script>

    <!-- Select2 -->
    <script src="<?php echo base_url(); ?>assets/admin/js/plugins/select2/select2.full.min.js"></script>

    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/admin/js/app.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url(); ?>assets/admin/js/demo.js"></script>
  </body>
</html>
