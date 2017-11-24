<div class="col-md-6">
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-google"></i> Login with Google

      </h3>
      <a href="http://support.jodacame.com/knowledge-base/social-oauth-google" target="_blank" class="pull-right">Help!</a>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">
        <div class="form-group">
          <label for="google_client_id">Client ID</label>
          <input type="text" class="form-control" id="google_client_id" value="<?php echo config_item('google_client_id'); ?>" name="google_client_id" placeholder="">
        </div>
        <div class="form-group">
          <label for="google_client_secret">Client Secret</label>
          <input type="text" class="form-control" id="google_client_secret" value="<?php echo config_item('google_client_secret'); ?>" name="google_client_secret" placeholder="">
        </div>

        <div class="form-group">
          <label for="">Redirect Callback</label>
          <input type="text" class="form-control" id="" ddisabled readonly value="<?php echo base_url()."auth/google/process"; ?>" >
        </div>
        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<div class="col-md-6">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-facebook"></i>  Login with Facebook</h3>
      <a href="http://support.jodacame.com/knowledge-base/facebook-app-id-and-app-secret-oauth" target="_blank" class="pull-right">Help!</a>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">
        <div class="form-group">
          <label for="facebook_app_id">APP ID</label>
          <input type="text" class="form-control" id="facebook_app_id"  value="<?php echo config_item('facebook_app_id'); ?>" name="facebook_app_id" placeholder="">
        </div>
        <div class="form-group">
          <label for="facebook_app_secret">APP Secret</label>
          <input type="text" class="form-control" id="facebook_app_secret" value="<?php echo config_item('facebook_app_secret'); ?>" name="facebook_app_secret" placeholder="">
        </div>

           <div class="form-group">
          <label for="">Redirect Callback</label>
          <input type="text" class="form-control" id="" ddisabled readonly value="<?php echo base_url()."auth/facebook/process"; ?>" >
        </div>

        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>

<div class="col-md-6">
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-google"></i> Google reCaptcha <a href="https://www.google.com/recaptcha/admin">GET KEY</a></h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">
        <div class="form-group">
          <label for="gcaptcha_key">Key</label>
          <input  type="text" class="form-control" id="gcaptcha_key" value="<?php echo config_item('gcaptcha_key'); ?>" name="gcaptcha_key" placeholder="">
        </div>
        <div class="form-group">
          <label for="gcaptcha_secret">Secret Code</label>
          <input  type="text" class="form-control" id="gcaptcha_secret" value="<?php echo config_item('gcaptcha_secret'); ?>" name="gcaptcha_secret" placeholder="">
        </div>
        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>





<div class="col-md-6">
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-google"></i> Mozscape API (For domain authority)  <a target="_blank" href="https://moz.com/products/api/keys">GET KEY</a></h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">
        <div class="form-group">
          <label for="moz_accessID">Access ID:</label>
          <input  required type="text" class="form-control" id="moz_accessID" value="<?php echo config_item('moz_accessID'); ?>" name="moz_accessID" placeholder="">
        </div>
        <div class="form-group">
          <label for="moz_secretKey">Secret Key</label>
          <input  required type="text" class="form-control" id="moz_secretKey" value="<?php echo config_item('moz_secretKey'); ?>" name="moz_secretKey" placeholder="">
        </div>
        <div class="inline-help">
          <button type="button" class="btn-link pull-right">Help</button>
          <div class="clearfix"></div>
          <p class="text-muted hide">
            In order to access the Mozscape API, you’ll need to generate a unique set of API credentials. Don’t fret; this is pretty simple. First, sign into your SEOmoz account (or, if you don’t have one, create one) and navigate to the <a href="https://moz.com/products/api/keys" target="_blank">‘Get Started with the Mozscape API’</a> page. Follow the steps to generate your unique Secret Key. Once you’ve done this, you should see a nice green box with both your API Access ID and new Secret Key. Keep this tab open, as you’ll be using your credentials shortly.
          </p>
        </div>
        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>





<div class="col-md-6">
  <div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title"><i class="fa fa-puzzle-piece"></i> KEYS</h3>
    </div><!-- /.box-header -->
    <!-- form start -->
    <form role="form" method="POST">
      <div class="box-body">    
          
         <div class="form-group">
          <label for="yandex_key">Yandex (For auto translation) <a href="https://tech.yandex.com/translate/">GET API KEY</a></label>
          <input type="text" class="form-control" id="yandex_key" value="<?php echo config_item('yandex_key'); ?>" name="yandex_key" placeholder="">
        </div>
        <div class="form-group">
          <label for="google_page_speed_key">Google Page Speed Key <a href="http://support.jodacame.com/knowledge-base/get-google-pagespeed-api-key">GET API KEY</a></label>
          <input type="text" class="form-control" id="google_page_speed_key" value="<?php echo config_item('google_page_speed_key'); ?>" name="google_page_speed_key" placeholder="">
        </div>   

        <div class="form-group">
          <label for="4p1_key">4p1.co Key (For Analyze Technologies) <a href="http://4p1.co">GET API KEY</a></label>
          <input type="text" class="form-control" id="4p1_key" value="<?php echo config_item('4p1_key'); ?>" name="4p1_key" placeholder="">
        </div>      

        <div class="form-group">
          <label for="4p1_key">Chrome Extension ID <a target="_blank" href="https://chrome.google.com/webstore/developer/dashboard">Go dashboard chrome developer</a></label>
          <input type="text" class="form-control" id="chromeappid" value="<?php echo config_item('chromeappid'); ?>" name="chromeappid" placeholder="">
          <small class="inline-help">https://chrome.google.com/webstore/detail/<strong>[YOUR-ID]</strong></small>
        </div>      

        <div class="form-group">
          <label for="disqus_shortname">Disqus Shortname <a href="https://help.disqus.com/customer/portal/articles/466208">GET CODE</a></label>
          <input type="text" class="form-control" id="disqus_shortname" value="<?php echo config_item('disqus_shortname'); ?>" name="disqus_shortname" placeholder="">
        </div>        
        
      </div><!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>
</div>



