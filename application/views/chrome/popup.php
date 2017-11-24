<html>
<head>
  <script src="jquery.min.js" charset="utf-8"></script>

  <script src="app.js" charset="utf-8"></script>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" >

</head>
<body>

      <a href="#" target="_blank" class="full-report open">
          <h2><?php echo __("We don't have information about that website"); ?></h2>
          <h2 style="display:block;padding:5px;padding-left;padding-right:20px;background-color:rgba(0,0,0,.7);color:#FFF;width:300px;border-radius:2px;margin:auto;font-size:14px;"><?php echo __("Generate it Now!"); ?></h2>
          <h4 style="color:rgba(0,0,0,.5)"><?php echo __("Oh yes! It's free"); ?></h4>
      </a>

    <ul class="tabs">
        <li data-target="#information" class="active"><i class="zmdi zmdi-info-outline"></i> <?php echo __("Information"); ?></li>
        <li data-target="#stats"><i class="zmdi zmdi-trending-up"></i> <?php echo __("Stats"); ?></li>
        <li data-target="#desktop"><i class="zmdi zmdi-google"></i> <?php echo __("Insights"); ?></li>
        <li data-target="#technologies"><i class="zmdi zmdi-code"></i> <?php echo __("Technologies"); ?></li>
        <li data-target="#server"><i class="zmdi zmdi-input-power"></i> <?php echo __("Server"); ?></li>

    </ul>

    <div class="tab active" id="information">
        <div class="card">

          <a href="#" target="_blank" class="full-report"><?php echo __("Vew Full Report"); ?></a>
            <div class="title"><?php echo __("Site:"); ?></div>
            <div class="subtitle var-url_real"></div>

            <div class="title"><?php echo __("Title:"); ?></div>
            <div class="subtitle var-metaTitle"></div>

            <div class="title"><?php echo __("Meta keywords:"); ?></div>
            <div class="subtitle var-metaKeywords"></div>

            <div class="title"><?php echo __("Meta description:"); ?></div>
            <div class="subtitle var-metaDescription"></div>

            <div class="title"><?php echo __("Domain created:"); ?></div>
            <div class="subtitle var-created_on"></div>

            <div class="title"><?php echo __("Domain expire on:"); ?></div>
            <div class="subtitle var-expires_on"></div>


            <div class="title"><?php echo __("Charset:"); ?></div>
            <div class="subtitle var-charset"></div>



            <div class="title"><?php echo __("Updated:"); ?></div>
            <div class="subtitle var-updated"></div>

            <img src="#" class="screenshot" />
        </div>
    </div>

    <div class="tab" id="stats">
        <div class="card-l social">

        </div>
        <div class="card-block card-l2">
          <div class="block">
              <span class="formatNumber var-score"></span>
              <strong><?php echo __("ProRank Score"); ?></strong>
          </div>

          <div class="block">
              <span class="formatNumber var-pagespeed"></span>
              <strong><?php echo __("Pagespeed Desktop"); ?></strong>
          </div>
          <div class="block">
              <span class="formatNumber var-pagespeed_mobile"></span>
              <strong><?php echo __("Pagespeed Mobile"); ?></strong>
          </div>

          <div class="block">
              <span class="formatNumber var-bounceRate"></span>
              <strong><?php echo __("Bounce Rate"); ?></strong>
          </div>

        </div>
        <div class="card-l">
            <div class="block">
                <span class="formatNumber var-pagespeed_usability"></span>
                <strong><?php echo __("Usability"); ?></strong>
            </div>

            <div class="block">
                <span class="formatNumber var-domainAuthority"></span>
                <strong><?php echo __("Domain Authority"); ?></strong>
            </div>

            <div class="block">
                <span class="formatNumber var-mozRank"></span>
                <strong><?php echo __("Moz Rank"); ?></strong>
            </div>
            <div class="block">
                <span class="formatNumber var-alexaLocal"></span>
                <strong class="var-alexaLocalCountry"></strong>
            </div>

            <div class="block">
                <span class="formatNumber var-alexaGlobal"></span>
                <strong ><?php echo __("Alexa Global") ; ?></strong>
            </div>





        </div>
    </div>

    <div class="tab" id="desktop">

      <ul class="rulesd rules">
          <li class="title">
            <?php echo __("Desktop"); ?>
          </li>
      </ul>

      <ul class="rulesm rules">
          <li class="title">
            <?php echo __("Mobile"); ?>
          </li>
      </ul>

    </div>


    <div class="tab" id="technologies">
      <ul class="tech">

      </ul>
    </div>

    <div class="tab" id="server">

      <div class="card">
        <a href="#" target="_blank" class="full-report"><?php echo __("Vew Full Report"); ?></a>
          <div>
            <div class="title"><?php echo __("Response Header:"); ?><br /><small style="display:block;margin-top:5px;font-weight:normal; color:rgba(0,0,0,.5)"><?php echo __("HTTP headers carry information about the client browser, the requested page and the server"); ?></small></div>
            <div class="subtitle var-headers"></div>
          </div>
          <div>
            <div class="title"><?php echo __("Ip server:"); ?><br /><small style="display:block;margin-top:5px;font-weight:normal; color:rgba(0,0,0,.5)"><?php echo __("The IP Address from server"); ?></small></div>
            <div class="subtitle var-ip"></div>
          </div>
          <div>
            <div class="title"><?php echo __("City:"); ?></div>
            <div class="subtitle var-city"></div>
          </div>
          <div>
            <div class="title"><?php echo __("Region:"); ?></div>
            <div class="subtitle var-region"></div>
          </div>
          <div>
            <div class="title"><?php echo __("Country:"); ?></div>
            <div class="subtitle var-country"></div>
          </div>
          <div>
            <div class="title"><?php echo __("ISP:"); ?></div>
            <div class="subtitle var-isp"></div>
          </div>
      </div>
    </div>

    <div class="footer">

    </div>
    <div id="loading">
        <div class="loading"></div>
    </div>

</body>
</html>
