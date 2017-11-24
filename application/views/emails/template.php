<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title></title>
        <style>
           @import url(http://fonts.googleapis.com/css?family=Roboto);
           table
           {
            font-family: Roboto, Arial, sans-serif;   color: #454545;   font-size: 17px;   line-height: 20px;
           }
           body{
            font-family: Roboto, Arial, sans-serif;   color: #454545;   font-size: 17px;   line-height: 20px;
           }
      
        </style>
    </head>
    <body style="background-color:#F0F0F0">
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="background-color:#F0F0F0;padding-top:25px">
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellpadding="0" cellspacing="0" width="700" id="emailContainer" style="background-color:#FFFFFF;border:1px #EBEBEB solid">                        
                          <tr>
                              <td align="center" style="background-color: <?php echo config_item("style_main_color"); ?>;padding: 50px;">
                                  <img style="width:200px"  class="logo" src="<?php echo config_item("domain"); ?><?php echo config_item("logo"); ?>">
                              </td>
                          </tr>
                        <tr>
                            <td align="left" valign="top" style="padding:20px;">
                              <?php echo $message; ?>                                
                            </td>
                        </tr>                        
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" style="font-size:12px;color:#9D9D9D;padding-top:15px;padding-bottom:20px">
                  <br>
                  <br>

                  <?php echo __("You were sent this email because you choose to receive updates. If you don't want these updates anymore, you can unsubscribe in your profile"); ?> 
                  <a  style="font-size:12px;color:#9D9D9D;;text-decoration: none" href="<?php echo config_item("domain"); ?><?php echo config_item("slug_user"); ?>"><strong><?php echo __("My profile"); ?></strong></a>
                  <br>
                  <br>

                    <a style="font-size:12px;color:#9D9D9D;;text-decoration: none" href="<?php echo config_item("domain"); ?>"><?php echo config_item("site_title"); ?></a>

                </td>
            </tr>            
        </table>
    </body>    
</html>