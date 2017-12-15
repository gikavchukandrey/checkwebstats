<!DOCTYPE html>
<html lang="<?php echo get_cookie("lang"); ?>">
  <head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo $SEO['title']; ?></title>
    <meta name="description" content="<?php echo ((strip_tags($SEO['description']))); ?>">
    <meta name="google-site-verification" content="<?php echo config_item("gwt"); ?>" />
    <?php if(config_item("chromeappid")){?>
    <link rel="chrome-webstore-item" href="//chrome.google.com/webstore/detail/<?php echo config_item("chromeappid"); ?>">
    <?php } ?>



    <?php if(!$image){ ?>
     <meta property="og:image" content="<?php echo base_url(); ?>assets/images/facebook_banner.jpg">
    <?php } ?>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css" />

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css?v=<?php echo config_item("version"); ?>">


    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
    <style>
    @import '//fonts.googleapis.com/css?family=<?php echo config_item("default_font"); ?>:300,400';
    body{
      background-color: <?php echo config_item("style_body_color"); ?>;
      color: <?php echo config_item("style_main_text_color"); ?>;
      font-family: '<?php echo config_item("default_font"); ?>', sans-serif;
    }
    .text-muted{
      color: <?php echo config_item("style_secondary_text_color"); ?> !important;
    }
    .bg-home,
    .shortcut ul li.profile div
    {
      color: #FFF;
      background: #272728 url("<?php echo config_item("background_home"); ?>") center bottom no-repeat;
      background-size: cover;
      background-attachment: fixed;
    }

    #mainModal .modal-header
    {

      background: #272728 url("<?php echo config_item("background_modal"); ?>") center center no-repeat;
      background-size: cover;

    }
    a,
    .btn-link,
    a.page-link,
    .card.first .fot form button{
      color:<?php echo config_item("style_link_color"); ?> !important;
    }

    .page-item.active .page-link, .page-item.active .page-link:focus, .page-item.active .page-link:hover
    {
      background-color: <?php echo config_item("style_main_color"); ?> !important;
      border-color: <?php echo config_item("style_main_color"); ?> !important;
    }
    .bg-blue-dark,
    .keyword-cloud .value,
    .btn-success,
    .btn-blue,
    span.score,
    .register-user a,
    .shortcut ul li.register-login  a,
    h2.nice-title span,
    .card .features span.title,
    .btn-gradient.selected,
    .btn-gradient:hover
    {
      background-color: <?php echo config_item("style_main_color"); ?> !important;
    }
    .btn-success,
    .shortcut ul li.register-login  a
    {
      border-left: 8px solid <?php echo config_item("style_secondary_color"); ?> !important;
    }
    .shortcut ul li  a{
      color: <?php echo config_item("style_link_sidebar_color"); ?> !important;
    }
    .btn-success:hover,
    .btn-success:active,
    .btn-success:focus{
      background-color: <?php echo config_item("style_secondary_color"); ?> !important;
    border-color: <?php echo config_item("style_secondary_color"); ?> !important;
    border-left: 8px solid <?php echo config_item("style_secondary_color"); ?> !important;

   }
   .bg-register,
   h2.nice-title i,
   .menu-toggle .plan
   {
    background-color: <?php echo config_item("style_secondary_color"); ?> !important;
   }
   .footer-c{
    background-color: <?php echo config_item("style_footer_color"); ?> ;
    color: <?php echo config_item("style_footer_text_color"); ?> ;
  }
  .footer-c h2,
  .footer-c a
  {
    color: <?php echo config_item("style_footer_text_color"); ?> !important;
  }

  .progress-main::-webkit-progress-value {
  border-radius: 3px;
  box-shadow: inset 0 1px 1px 0 rgba(255, 255, 255, 0.4);
  background:
    -webkit-linear-gradient(45deg, transparent, transparent 33%, rgba(0, 0, 0, 0.1) 33%, rgba(0, 0, 0, 0.1) 66%, transparent 66%),
    -webkit-linear-gradient(top, rgba(255, 255, 255, 0.25), rgba(0, 0, 0, 0.2)),
    -webkit-linear-gradient(left, <?php echo config_item("style_main_color"); ?>, <?php echo config_item("style_secondary_color"); ?>);

  /* Looks great, now animating it */
  background-size: 50px 30px, 100% 100%, 100% 100%;
  -webkit-animation: move 5s linear 0 infinite;
}


    <?php echo config_item("custom_css"); ?>

    </style>
    <?php echo config_item("custom_code_header"); ?>


      <script>
    var noReload = false;
    var base_url = '<?php echo base_url(); ?>';
     var csfrData = {};
     csfrData['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
   </script>

</head>
  <body>


    <?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
     ?>
    <?php echo $_NAVBAR; ?>
    <div class="hide-menu">

           <?php
        if($messages = $this->session->flashdata('messages')){
          ?><?php
          foreach ($messages as $key => $value) {
            ?>
              <div class="text-<?php echo $value['type']; ?> animated bounceIn alert-autoclose">
                <?php echo $value['msg']; ?>
              </div>
            <?php
          }
          ?><?php
        }
        ?>


    <?php echo $_PAGE; ?>
    </div>
    <?php echo $_FOOTER; ?>



    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" />

    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" >
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />







    <script src="//ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.4/js/bootstrap.min.js"></script>
    <script src="/assets/js/app.js?v=<?php echo config_item("version"); ?>"></script>

    <script async type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
















    <?php if(config_item("gcaptcha_secret")){ ?>
    <script src='//www.google.com/recaptcha/api.js'></script>
    <?php } ?>

  



   <div class="modal fade" id="mainModal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header"> 
          <i class="fa fa-spinner fa-pulse"></i>            
            <div class="modal-title">
                 <div class="process-website"><?php echo __("..."); ?></div>
                <div class="process-msg "><?php echo __("Please wait"); ?></div> 
                <div class="process-desc m-t-1 m-b-1"><?php echo __("Starting process..."); ?></div> 
            </div>

             <!--<div id="monitor">
                  <div class="scan">                
                  </div>
                <div class="glass">
                  <img src="#">
                </div>
              </div>-->

          </div>
          <div class="modal-body">

           

            
            <progress class="m-t-1 progress progress-success progress-main process-value" value="0" max="100"></progress>
            
          </div>   

       
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->





  </body>
</html>