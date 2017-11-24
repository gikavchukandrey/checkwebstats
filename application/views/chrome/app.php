var base_url = '<?php echo base_url(); ?>';

try {
  chrome.tabs.getSelected(null, function (tab) {
    getScore(tab);
  });
} catch (e) {
  console.error(e);
} finally {

}
$(document).ready(function() {



  $(document).on('click', 'ul.tabs li', function(event) {
    event.preventDefault();
    $(".tabs li.active").removeClass('active');
    $(".tab.active").removeClass('active');
    var _target = $(this).attr("data-target");
    $(this).addClass('active');
    $(_target).addClass('active');
  });
});


function getScore(tab)
{
    //chrome.browserAction.setBadgeBackgroundColor({color: "#3C8DBC"});
    var url = new URL(tab.url)
    var domain = url.hostname;

//    chrome.browserAction.setBadgeText({text: '...'});
    $.getJSON(base_url+"api/get", {domain: domain}, function(json, textStatus) {
      if(parseFloat(json.score)>0){
        $(".full-report").attr("href",base_url+json.url);
        $.each(json,function(index, el) {

          $(".var-"+index).html(el);
        });
        $("img.screenshot").attr("src",json.pagespeed_screenshot_d);
        $("#loading").fadeOut(300, function() {
            $("#loading").remove();
        });
        var social = JSON.parse(json.social);
        var pagespeed_rules = JSON.parse(json.pagespeed_rules);
        var pagespeed_rules_mobile = JSON.parse(json.pagespeed_rules_mobile);

        $.each(social,function(index, el) {
          $(".social").append("<div class='block'><span>"+parseFloat(el).toLocaleString()+" <i class='fa fa-"+index.replace("_","-")+"'></i></span><strong>"+index.replace("_"," ")+"</strong></div>");
        });

        $.each(json.technologies,function(index, el) {

          $(".tech").append("<li class='block'><img src='"+base_url+"assets/images/icons/"+el.icon+"'><strong class='name'>"+el.name+"</strong><strong class='tag'>"+el.tag1+"</strong></li>");
        });
        if(pagespeed_rules.ruleResults){
          $.each(pagespeed_rules.ruleResults,function(index, el) {
            var clasx="success";
            if(el.ruleImpact >0)
              clasx="warning";
              $("ul.rulesd").append("<li class='item "+clasx+"'><span>"+el.localizedRuleName+"</span>");
          });
        }
        if(pagespeed_rules_mobile.ruleResults){
          $.each(pagespeed_rules_mobile.ruleResults,function(index, el) {
             clasx="success";
            if(el.ruleImpact >0)
              clasx="warning";
              $("ul.rulesm").append("<li class='item "+clasx+"'><span>"+el.localizedRuleName+"</span>");
          });
        }


        if(parseFloat(json.score)>0)
        {

          $(".open.full-report").hide();
          //chrome.browserAction.setBadgeText({text: " "+json.score+" "}); // We have 10+ unread items.
        }
        else{
          $(".open.full-report").show();
          //chrome.browserAction.setBadgeText({text: '?'}); // We have 10+ unread items.
        }


          $.each($(".formatNumber"),function(index, el) {

            $(this).text(parseFloat($(this).text()).toLocaleString());
          });
      }
      else {

        $("#loading").fadeOut(300, function() {
            $("#loading").remove();
        });
        //chrome.browserAction.setBadgeText({text: '?'});
        $(".open.full-report").show();
        $(".full-report").attr("href",base_url+domain);
      }

    });


}
