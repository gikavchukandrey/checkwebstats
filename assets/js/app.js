"use strict";!function(a){a.fn.circliful=function(b,c){var d=a.extend({foregroundColor:"#3498DB",backgroundColor:"#ccc",pointColor:"none",fillColor:"none",foregroundBorderWidth:15,backgroundBorderWidth:15,pointSize:28.5,fontColor:"#aaa",percent:75,animation:1,animationStep:5,icon:"none",iconSize:"30",iconColor:"#ccc",iconPosition:"top",target:0,start:0,showPercent:1,percentageTextSize:22,textAdditionalCss:"",targetPercent:0,targetTextSize:17,targetColor:"#2980B9",text:null,textStyle:null,textColor:"#666",multiPercentage:0,percentages:null,textBelow:!1,noPercentageSign:!1,replacePercentageByText:null,halfCircle:!1,animateInView:!1},b);return this.each(function(){function y(){var a=window.setInterval(function(){r>=x?(window.clearInterval(a),t=1,"function"==typeof c&&c.call(this)):(r+=s,u+=v),r/3.6>=e&&1==t&&(r=3.6*e),u>d.target&&1==t&&(u=d.target),null==d.replacePercentageByText&&(w=d.halfCircle?parseInt(100*r/360*2):parseInt(100*r/360)),o.attr("stroke-dasharray",r+", 20000"),1==d.showPercent?p.text(w+(d.noPercentageSign||null!=d.replacePercentageByText?"":"")):p.text(u)}.bind(o),q)}function z(){var b=navigator.userAgent.toLowerCase().indexOf("webkit")!=-1?"body":"html",c=a(b).scrollTop(),d=c+a(window).height(),e=Math.round(o.offset().top),f=e+o.height();return e<d&&f>c}function A(){o.hasClass("start")||z(o)&&(o.addClass("start"),setTimeout(y,250))}var j,k,l,b=a(this),e=d.percent,f=83,g=100,h=100,i=100,m=d.backgroundBorderWidth;if(d.halfCircle?"left"==d.iconPosition?(g=80,f=100,i=117,h=100):d.halfCircle&&(f=80,h=100):"bottom"==d.iconPosition?(f=124,h=95):"left"==d.iconPosition?(g=80,f=110,i=117):"middle"==d.iconPosition?1==d.multiPercentage?"object"==typeof d.percentages?m=30:(f=110,k='<g stroke="'+("none"!=d.backgroundColor?d.backgroundColor:"#ccc")+'" ><line x1="133" y1="50" x2="140" y2="40" stroke-width="2"  /></g>',k+='<g stroke="'+("none"!=d.backgroundColor?d.backgroundColor:"#ccc")+'" ><line x1="140" y1="40" x2="200" y2="40" stroke-width="2"  /></g>',i=228,h=47):(f=110,k='<g stroke="'+("none"!=d.backgroundColor?d.backgroundColor:"#ccc")+'" ><line x1="133" y1="50" x2="140" y2="40" stroke-width="2"  /></g>',k+='<g stroke="'+("none"!=d.backgroundColor?d.backgroundColor:"#ccc")+'" ><line x1="140" y1="40" x2="200" y2="40" stroke-width="2"  /></g>',i=175,h=35):"right"==d.iconPosition&&(g=120,f=110,i=80),d.targetPercent>0&&(h=95,k='<g stroke="'+("none"!=d.backgroundColor?d.backgroundColor:"#ccc")+'" ><line x1="75" y1="101" x2="125" y2="101" stroke-width="1"  /></g>',k+='<text text-anchor="middle" x="'+i+'" y="120" style="font-size: '+d.targetTextSize+'px;" fill="'+d.targetColor+'">'+d.targetPercent+(d.noPercentageSign&&null==d.replacePercentageByText?"":"%")+"</text>",k+='<circle cx="100" cy="100" r="69" fill="none" stroke="'+d.backgroundColor+'" stroke-width="3" stroke-dasharray="450" transform="rotate(-90,100,100)" />',k+='<circle cx="100" cy="100" r="69" fill="none" stroke="'+d.targetColor+'" stroke-width="3" stroke-dasharray="'+3.6*d.targetPercent+', 20000" transform="rotate(-90,100,100)" />'),null!=d.text&&(d.halfCircle?d.textBelow?k+='<text text-anchor="middle" x="100" y="120" style="'+d.textStyle+'" fill="'+d.textColor+'">'+d.text+"</text>":0==d.multiPercentage?k+='<text text-anchor="middle" x="100" y="115" style="'+d.textStyle+'" fill="'+d.textColor+'">'+d.text+"</text>":1==d.multiPercentage&&(k+='<text text-anchor="middle" x="228" y="65" style="'+d.textStyle+'" fill="'+d.textColor+'">'+d.text+"</text>"):d.textBelow?k+='<text text-anchor="middle" x="100" y="190" style="'+d.textStyle+'" fill="'+d.textColor+'">'+d.text+"</text>":0==d.multiPercentage?k+='<text text-anchor="middle" x="100" y="115" style="'+d.textStyle+'" fill="'+d.textColor+'">'+d.text+"</text>":1==d.multiPercentage&&(k+='<text text-anchor="middle" x="228" y="65" style="'+d.textStyle+'" fill="'+d.textColor+'">'+d.text+"</text>")),"none"!=d.icon&&(l='<text text-anchor="middle" x="'+g+'" y="'+f+'" class="icon" style="font-size: '+d.iconSize+'px" fill="'+d.iconColor+'">&#x'+d.icon+"</text>"),d.halfCircle){var n='transform="rotate(-180,100,100)"';b.addClass("svg-container").append(a('<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 194 186" class="circliful">'+k+'<clipPath id="cut-off-bottom"> <rect x="100" y="0" width="100" height="200" /> </clipPath><circle cx="100" cy="100" r="57" class="border" fill="'+d.fillColor+'" stroke="'+d.backgroundColor+'" stroke-width="'+m+'" stroke-dasharray="360" clip-path="url(#cut-off-bottom)" transform="rotate(-90,100,100)" /><circle class="circle" cx="100" cy="100" r="57" class="border" fill="none" stroke="'+d.foregroundColor+'" stroke-width="'+d.foregroundBorderWidth+'" stroke-dasharray="0,20000" '+n+' /><circle cx="100" cy="100" r="'+d.pointSize+'" fill="'+d.pointColor+'" clip-path="url(#cut-off-bottom)" transform="rotate(-90,100,100)" />'+l+'<text class="timer" text-anchor="middle" x="'+i+'" y="'+h+'" style="font-size: '+d.percentageTextSize+"px; "+j+";"+d.textAdditionalCss+'" fill="'+d.fontColor+'">'+(null==d.replacePercentageByText?0:d.replacePercentageByText)+(d.noPercentageSign||null!=d.replacePercentageByText?"":"%")+"</text>"))}else b.addClass("svg-container").append(a('<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 194 186" class="circliful">'+k+'<circle cx="100" cy="100" r="57" class="border" fill="'+d.fillColor+'" stroke="'+d.backgroundColor+'" stroke-width="'+m+'" stroke-dasharray="360" transform="rotate(-90,100,100)" /><circle class="circle" cx="100" cy="100" r="57" class="border" fill="none" stroke="'+d.foregroundColor+'" stroke-width="'+d.foregroundBorderWidth+'" stroke-dasharray="0,20000" transform="rotate(-90,100,100)" /><circle cx="100" cy="100" r="'+d.pointSize+'" fill="'+d.pointColor+'" />'+l+'<text class="timer" text-anchor="middle" x="'+i+'" y="'+h+'" style="font-size: '+d.percentageTextSize+"px; "+j+";"+d.textAdditionalCss+'" fill="'+d.fontColor+'">'+(null==d.replacePercentageByText?0:d.replacePercentageByText)+(d.noPercentageSign||null!=d.replacePercentageByText?"":"%")+"</text>"));var o=b.find(".circle"),p=b.find(".timer"),q=30,r=0,s=d.animationStep,t=0,u=0,v=0,w=e,x=3.6*e;d.halfCircle&&(x=3.6*e/2),null!=d.replacePercentageByText&&(w=d.replacePercentageByText),d.start>0&&d.target>0&&(e=d.start/(d.target/100),v=d.target/100),1==d.animation?d.animateInView?a(window).scroll(function(){A()}):y():(o.attr("stroke-dasharray",x+", 20000"),1==d.showPercent?p.text(w+(d.noPercentageSign?"":"")):p.text(d.target))})}}(jQuery);
var errors = 0;

var index = 0;
var speed = 100;
var elements = false;

$(function () {
	console.info("Ready!");
	$.each($('.circle'), function(index, val) {
		var text = $(this).attr("data-text");
		var percent = $(this).attr("data-percent");
		var color = $(this).attr("data-color");
		var fbw = $(this).attr("data-fbw");
		var bbw = $(this).attr("data-bbw");
		if(!bbw)
			bbw = 8;	
		if(!fbw)
			fbw = 8;
		 $(this).circliful({
		        animationStep: 5,
		        foregroundBorderWidth: fbw,
		        backgroundBorderWidth: bbw,
		        foregroundColor: color,
		        backgroundColor: "#F3F3F3",
		        percent: percent,
		        text: text

		    });
	});

	

	try{
		//$('.lazy').Lazy();	
	}catch(e){
		console.warn("Lazy error");
	}	
	try{
		 // $("img.lazy").lazyload({ effect : "fadeIn"});
	}catch(e){
		console.warn("lazyload error");
	}
	

	setTimeout(function() {
		$(".alert-autoclose").addClass('animated bounceOut').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
      		$(this).remove();
    	});
	}, 8000); 

	$.ajaxSetup({
       data: csfrData,
        timeout: 60000 //Time in milliseconds
    });

    $(".btn-toggle-class").on('click', function(event) {
    	event.preventDefault();
    	$($(this).attr("data-target")).toggleClass($(this).attr("data-class"));
    }); 
     $(".btn-share").on('click', function(event) {
    	event.preventDefault();
    	 PopupCenter($(this).attr("data-url"), "Share",600,400);
    }); 

     $(".btn-start").on('click', function(event) {    	
    	event.preventDefault();    	    	
    	validateDomain($(".input-url[value!='']").val());
    }); 

     $(".menu-toggle").on('click', function(event) {
     	event.preventDefault();
     	$(".shortcut").toggleClass('show');
     	$("body").toggleClass('menu');
     });
	$(".shortcut ul li.hide strong").on('click', function(event) {
     	event.preventDefault();
     	$(this).parent().find("a").toggleClass('hide');
     });

     $(".hide-menu").on('click touchstart', function(event) {
     	
     	$(".shortcut").removeClass('show');
     	$("body").removeClass('menu');
     	
     }); 

     $(".shortcut-links a").on('click touchstart', function(event) {
     		var _target = $(this).attr("data-go");
     	 	$('html, body').animate({
        		scrollTop: $(_target).offset().top-170
    		}, 500);

     	//$(".shortcut").removeClass('show');
     	
     });

     if($(".dataTable").length)
     {
	     $(".dataTable").dataTable({
	        rowReorder: {
	            selector: 'td:nth-child(2)'
	        },
	        responsive: true
	    });
	 }

     if($(".input-url[value!='']").length>0)
     {
     	validateDomain($(".input-url[value!='']").val(),true);
     }
     $(document).on('click', '.btn-update', function(event) {
    
    	event.preventDefault();
    	$("i",$(this)).addClass("fa-spin");
    	$(this).attr("disabled","disabled");
    	validateDomain($(this).attr("data-domain"),true);
    }); 

    $(".btn-bookmark").on('click', function(event) {
    	event.preventDefault();
    	var idsite = $(this).attr("data-idsite");
    	var action = $(this).attr("data-action");

		$.post(base_url+"backend/bookmark", {idsite: idsite,action:action}, function(data, textStatus, xhr) {
    		if(data.error)
    		{
    			sweetAlert(data.title,data.error, "error");
    		}
    		else
    		{
    			
    			location.reload();	
    		}
    		
    	},"json");
    });

     elements = $('img.lazy');
      setTimeout(function () {
			loadImage();
		}, speed);


    $.each($('.map'), function(index, val) {
		var country = $(this).attr("data-country");
		
		jQuery(this).vectorMap(
		{
		    map: 'world_en',
		    backgroundColor: '#FFFFFF',
		    borderColor: '#FFFFFF',
		    borderOpacity: 0.25,
		    borderWidth: 1,
		    color: '#D2D2D2',
		    enableZoom: false,
		    hoverColor: '#000000',
		    hoverOpacity: null,
		    normalizeFunction: 'linear',
		    scaleColors: ['#b6d6ff', '#005ace'],
		    selectedColor: '#3C8DBC',
		    selectedRegions: [country],
		    showTooltip: true,
		    
		});
	});

  
    $(".search-me").makeSearchList();

});

function PopupCenter(url, title, w, h) {
    // Fixes dual-screen position                         Most browsers      Firefox
    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
    var top = ((height / 2) - (h / 2)) + dualScreenTop;
    var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

    // Puts focus on the newWindow
    if (window.focus) {
        newWindow.focus();
    }
}




function loadImage()
{
	if(index>$(elements).length)
		return false;
	var elm = $(elements).get(index);
    
    $(elm).attr("src",$(elm).attr("data-src"));
    index++;
    
     setTimeout(function () {
			loadImage(index);
	}, speed);
}


function validateDomain(url,manual)
{
	current = 0;
	total 	= 0;
	porc 	= 0;	
	if(!url)
		return false;

	$("body").addClass('modal-update');

	$('#mainModal').modal({
	 	backdrop: 'static',
  		keyboard: true
	});

	$(".process-website").text(url);
	$("#monitor").addClass('hide');
    var new_url =  window.location.origin;
	$.post(new_url+"/backend/validate", {url: url}, function(data, textStatus, xhr) {
		if(data.process)
		{

			if(!data.new)
			{
				$("body").addClass('modal-update');
			}
			else
			{
				$("body").removeClass('modal-update');
			}
			

			$(".process-website").text(data.domain);
			if(manual)
				start(data.domain,data.process);
			else
			{
				if(!data.new)
				{	
					$(document).trigger('scanCompleted');
					if(!noReload)
						window.location.href = base_url+data.domain;
				}
				else
					start(data.domain,data.process);
			}
		}	
		else
		{
			$(document).trigger('scanCompleted');
			if(!noReload)
			{
				if(data.redirect)
				{
						
				
					swal({
						  title: data.error,
						  text: data.domain,
						  type: "info",
						  showCancelButton: false,
						  confirmButtonColor: "#3C8DBC",
						  confirmButtonText: "OK",
						  closeOnConfirm: false
						},
						function(){
						  window.location.href =data.redirect;
						});
				}
				else
				{
						
					sweetAlert(data.error,data.domain, "error");

				}

				$('#mainModal').modal('hide');									
				$(".btn-update i").removeClass("fa-spin");
    			$(".btn-update i").removeAttr("disabled");
    		}
		}
	},"json").fail(function(e) {
		  $('#mainModal').modal('hide');		  
		  sweetAlert({title: "Error",text: e.responseText,html: true,type:"error"});
  	});

}
var current = 0;
var total 	= 0;
var porc 	= 0;	
function start(domain,processList)
{
	if(errors>=5)
	{
		sweetAlert("Error","Error", "error");			
		return false;
	}

	$(".process-value").val("5");
	total 	= processList.length;
	
	$(".modal-title").addClass('animated fadeIn');
	$(".process-msg").text(processList[current]['title']);
	$(".process-desc").text(processList[current]['description']);
	
	$.post(base_url+"backend/process", {domain: domain,action:processList[current]['action']}, function(data, textStatus, xhr) {
		$(".modal-title").removeClass('animated fadeIn');
		if(data.error && !noReload)
		{
 			sweetAlert({title: "Error",text: data.error,html: true,type:"error"}); 			
		}
		else
		{
			if(noReload && data.error)
			{
				console.warn("Error: ["+domain+"] "+data.error);
				$(document).trigger('scanCompleted');
				return false;
			}
			errors = 0;
			current++;
			porc 	= parseInt(((current+1)*100)/total);		
			$(".process-value").val(porc);			
			next(domain,processList);	
			
		}
		
	},"json").fail(function(e) {
				  
			setTimeout(function() {
				next(domain,processList);
				errors++;
			}, 2000+(errors*1500));

		 
		  
  	});
	
}

function next(domain,processList)
{
	if(errors>=3)
	{
		//sweetAlert("Error","Error", "error");			
		//return false;
		current++;	
		errors = 0;
	}
	//console.log("Current "+current);

	$(".modal-title").addClass('animated fadeIn');
	$(".process-msg").text(processList[current]['title']);	
	$(".process-desc").text(processList[current]['description']);
	$.post(base_url+"backend/process", {domain: domain,action:processList[current]['action']}, function(data, textStatus, xhr) {
		porc 	= parseInt(((current+1)*100)/total);	
		current++;	
		$(".modal-title").removeClass('animated fadeIn');
		$(".process-value").val(porc);
		if(porc >= 100)
		{
			if(!noReload)
			{
				if($("#bookmarks-list").length)
				{
					location.reload();
				}else
				{
					window.location.href =base_url+domain;	
				}
				
			}

			$(document).trigger('scanCompleted');
		}
		else
		{
			setTimeout(function() {
				next(domain,processList);
			}, 1000);
		}
	},"json").fail(function(e) {
		  	setTimeout(function() {
				next(domain,processList);
				errors++;
			}, 3000+(errors*1500));
  	});

}

jQuery.fn.makeSearchList = function() { 	
	var input = $('.search-to');		
	var list	= $(this);
    $(input)
	      .change( function () {
	        var filter = $(this).val();	        
	        if(filter) {	        	
	        $(".search-item",$(list)).hide();
	          $(".search-item:Contains(" + filter + ")",$(list)).show();
	        } else {	        	
	        	$(".search-item",$(list)).show();
	        }
	        return false;
	      })
	    .keyup( function () {	        
	        $(this).change();
	    });	  
 
	    // Creamos la pseudo-funcion Contains
	    jQuery.expr[":"].Contains = jQuery.expr.createPseudo(function(arg) {
			return function( elem ) {
				return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
			};
		});
 
};