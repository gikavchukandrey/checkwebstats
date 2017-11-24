<div class="col-md-8">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Aparence</h3>
                <form role="form" method="POST" enctype="multipart/form-data">
                <div class="box-body">
                    
                    <div class="form-group">
                        <label>Logo</label>   
                        <span class="inline-help">Recommendation image size: 406 x 70 pixels</span>
                        <div class="text-center"  style="width:200px;background-color:#3C8DBC;padding:20px;;margin:20px 0 20px 0;">
                            <img style="width:100%" src="<?php echo base_url(); ?><?php echo config_item("logo"); ?>">
                        </div>
                    </div>
                    <input type="file" class="form-control"  name="image">
                    <input type="hidden" class="form-control hide" value="1"  name="save">
                    <span class="inline-help">Max file size: <?php echo (ini_get('post_max_size')); ?></span>
          

                    <div class="form-group">
                        <label>Home image</label> <br>  
                        <small class="text-muted"><?php echo config_item("background_home"); ?></small>
                        <div class="text-center"  style="width:200px;background-color:#E6E6E6;padding:20px;;margin:20px 0 20px 0;">
                            <img style="width:100%" src="<?php echo base_url(); ?><?php echo config_item("background_home"); ?>">
                        </div>
                    </div>
                    <input type="file" class="form-control"  name="background_home">



                    <div class="form-group">
                        <br>
                        <label>Modal Background</label> <br>  
                        <small class="text-muted"><?php echo config_item("background_modal"); ?></small>
                        <div class="text-center"  style="width:200px;background-color:#E6E6E6;padding:20px;;margin:20px 0 20px 0;">
                            <img style="width:100%" src="<?php echo base_url(); ?><?php echo config_item("background_modal"); ?>">
                        </div>
                    </div>
                    <input type="file" class="form-control"  name="background_modal">

                    <span class="inline-help">Max file size: <?php echo (ini_get('post_max_size')); ?></span>
                </div>  
                <div class="box-footer">          
                    <button type="submit" name="submit" class="btn btn-primary pull-right">Save</button>
                </div>
            </form>
        </div><!-- /.box-header -->
   </div>
</div>





<div class="col-md-4">
  <form role="form" method="POST" enctype="multipart/form-data">
      <div class="box box-info">
        <div class="box-header with-border">
          
           <form role="form" method="POST" enctype="multipart/form-data">
            <div class="box-body">
            

            <div class="form-group">
               <label>Default Language</label>   
              <select required class="select2" style="width:100%" name="default_lang">
                <?php foreach ($langs as $key => $value) {
                  ?>
                  <option <?php if($value->code == config_item("default_lang")){ echo 'selected'; } ?> value="<?php echo $value->code; ?>"><?php echo $value->name; ?></option>
                  <?php
                }
                ?>
              </select>
              </div>  

              <div class="form-group">
               <label>Template Report Email</label>   
              <select required class="select2" style="width:100%" name="template_report">
                <?php 
                $this->load->helper('directory');
                $this->load->helper('file');
                $templates = directory_map('./application/views/emails/reports/');
                
                foreach ($templates as $key => $file) {
                    $file  = str_ireplace(".php","",$file);
                  ?>
                  <option <?php if($file == config_item("template_report")){ echo 'selected'; } ?> value="<?php echo $file; ?>"><?php echo ucwords(str_replace("_", " ", $file)); ?></option>
                  <?php
                }
                ?>
              </select>
              </div>

            <div class="form-group">
              <label for="chart_border_size">Chart border size (Default: 5)</label>
              <input type="number"  min="5" max="30" step="1" class="form-control" id="chart_border_size"  value="<?php echo config_item('chart_border_size'); ?>" name="chart_border_size" placeholder="">
            </div>

            <div class="form-group">
              <label for="style_body_color">Body Background Color</label>
              <input type="color"  class="form-control" id="style_body_color"  value="<?php echo config_item('style_body_color'); ?>" name="style_body_color" placeholder="">
            </div>  

            <div class="form-group">
              <label for="style_link_color">Link Color</label>
              <input type="color"  class="form-control" id="style_link_color"  value="<?php echo config_item('style_link_color'); ?>" name="style_link_color" placeholder="">
            </div> 
          <div class="form-group">
              <label for="style_link_sidebar_color">Link Color Sidebar</label>
              <input type="color"  class="form-control" id="style_link_sidebar_color"  value="<?php echo config_item('style_link_sidebar_color'); ?>" name="style_link_sidebar_color" placeholder="">
            </div> 

            <div class="form-group">
              <label for="style_main_color">Main Color</label>
              <input type="color"  class="form-control" id="style_main_color"  value="<?php echo config_item('style_main_color'); ?>" name="style_main_color" placeholder="">
            </div>  

            <div class="form-group">
              <label for="style_main_text_color">Main Text Color</label>
              <input type="color"  class="form-control" id="style_main_text_color"  value="<?php echo config_item('style_main_text_color'); ?>" name="style_main_text_color" placeholder="">
            </div>  

            <div class="form-group">
              <label for="style_secondary_text_color">Secondary Text Color</label>
              <input type="color"  class="form-control" id="style_secondary_text_color"  value="<?php echo config_item('style_secondary_text_color'); ?>" name="style_secondary_text_color" placeholder="">
            </div> 

            <div class="form-group">
              <label for="style_secondary_color">Secondary Color</label>
              <input type="color"  class="form-control" id="style_secondary_color"  value="<?php echo config_item('style_secondary_color'); ?>" name="style_secondary_color" placeholder="">
            </div>

            <div class="form-group">
              <label for="style_footer_color">Footer Background Color</label>
              <input type="color"  class="form-control" id="style_footer_color"  value="<?php echo config_item('style_footer_color'); ?>" name="style_footer_color" placeholder="">
            </div>

            <div class="form-group">
              <label for="style_footer_text_color">Footer Text Color</label>
              <input type="color"  class="form-control" id="style_footer_text_color"  value="<?php echo config_item('style_footer_text_color'); ?>" name="style_footer_text_color" placeholder="">
            </div>

         

            <?php

                $curl = curl_init();

                curl_setopt_array($curl, array(
                  CURLOPT_URL => "https://fonts.google.com/metadata/fonts",
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => "",
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 30,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => "GET"
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);

                curl_close($curl);
                
                $fonts = json_decode(str_ireplace(")]}'", "",$response));
                if($fonts)
                    write_file('./cache/fonts.json', json_encode($fonts));
                else{
                    if(file_exists('./cache/fonts.json'))
                    {
                       $fonts = json_decode(file_get_contents("./cache/fonts.json")); 
                    }
                }

              ?>

               <?php if($fonts){ ?>
                 <div class="form-group">
               
               <label>Font Family </label>   
               <a href="https://fonts.google.com" target="_blank" class="pull-right">Google Fonts</a>
              <select required class="select2" style="width:100%" name="default_font">
                <?php foreach ($fonts->familyMetadataList as $key => $value) {
                  ?>
                  <option <?php if($value->family == config_item("default_font")){ echo 'selected'; } ?> value="<?php echo $value->family; ?>"><?php echo $value->family; ?></option>
                  <?php
                }
                ?>
              </select>
              </div>
              <?php } ?>
            </div><!-- /.box-body -->
            <div class="box-footer">          
                 <button type="submit" name="submit" class="btn btn-primary pull-right">Save</button>
            </div>
          </form>
        </div>
      </div>
    </form>
</div>



<div class="row-fluid">
 <div class="col-md-6">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Custom CSS</h3>
       <form role="form" method="POST" enctype="multipart/form-data">
        <div class="box-body">
              
        
  
             <textarea name="custom_css" class="coder"><?php echo config_item("custom_css"); ?></textarea>

    
        </div><!-- /.box-body -->
        <div class="box-footer">          
             <button type="submit" name="submit" class="btn btn-primary pull-right">Save</button>
        </div>
      </form>
    </div><!-- /.box-header -->
   </div>
</div>

 <div class="col-md-6">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Custom Code Header</h3>
       <form role="form" method="POST" enctype="multipart/form-data">
        <div class="box-body">
     
        
     
             <textarea name="custom_code_header" class="coder"><?php echo config_item("custom_code_header"); ?></textarea>

        
        </div><!-- /.box-body -->
        <div class="box-footer">          
             <button type="submit" name="submit" class="btn btn-primary pull-right">Save</button>
        </div>
      </form>
    </div><!-- /.box-header -->
   </div>
</div>

</div>




