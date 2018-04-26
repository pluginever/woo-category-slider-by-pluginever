/**
 * woocommerce-category-slider - v1.0.0 - 2018-04-26
 * https://pluginever.com/woo-category-slider
 *
 * Copyright (c) 2018;
 * Licensed GPLv2+
 */

var imgLiquid=imgLiquid||{VER:"0.9.944"};imgLiquid.bgs_Available=!1,imgLiquid.bgs_CheckRunned=!1,imgLiquid.injectCss=".imgLiquid img {visibility:hidden}",function(n){n.fn.extend({imgLiquid:function(i){this.defaults={fill:!0,verticalAlign:"center",horizontalAlign:"center",useBackgroundSize:!0,useDataHtmlAttr:!0,responsive:!0,delay:0,fadeInTime:0,removeBoxBackground:!0,hardPixels:!0,responsiveCheckTime:500,timecheckvisibility:500,onStart:null,onFinish:null,onItemStart:null,onItemFinish:null,onItemError:null},function(){if(!imgLiquid.bgs_CheckRunned){imgLiquid.bgs_CheckRunned=!0;var e=n('<span style="background-size:cover" />');n("body").append(e),function(){var i=e[0];if(i&&window.getComputedStyle){var t=window.getComputedStyle(i,null);t&&t.backgroundSize&&(imgLiquid.bgs_Available="cover"===t.backgroundSize)}}(),e.remove()}}();var o=this;return this.options=i,this.settings=n.extend({},this.defaults,this.options),this.settings.onStart&&this.settings.onStart(),this.each(function(h){var c=o.settings,m=n(this),f=n("img:first",m);function e(){(c.responsive||f.data("imgLiquid_oldProcessed"))&&f.data("imgLiquid_settings")&&(c=f.data("imgLiquid_settings"),m.actualSize=m.get(0).offsetWidth+m.get(0).offsetHeight/1e4,m.sizeOld&&m.actualSize!==m.sizeOld&&d(),m.sizeOld=m.actualSize,setTimeout(e,c.responsiveCheckTime))}function a(){f.data("imgLiquid_error",!0),m.addClass("imgLiquid_error"),c.onItemError&&c.onItemError(h,m,f),v()}function d(){var i,t,e,a,d,o,n,s,r=0,l=0,g=m.width(),u=m.height();void 0===f.data("owidth")&&f.data("owidth",f[0].width),void 0===f.data("oheight")&&f.data("oheight",f[0].height),!c.fill&&f.data("owidth")<=g&&f.data("oheight")<=u?(t=i="auto",e=f.data("owidth"),a=f.data("oheight")):c.fill===g/u>=f.data("owidth")/f.data("oheight")?(i="100%",t="auto",e=Math.floor(g),a=Math.floor(g*(f.data("oheight")/f.data("owidth")))):(i="auto",t="100%",e=Math.floor(u*(f.data("owidth")/f.data("oheight"))),a=Math.floor(u)),n=g-e,"left"===(d=c.horizontalAlign.toLowerCase())&&(l=0),"center"===d&&(l=.5*n),"right"===d&&(l=n),-1!==d.indexOf("%")&&0<(d=parseInt(d.replace("%",""),10))&&(l=n*d*.01),s=u-a,"top"===(o=c.verticalAlign.toLowerCase())&&(r=0),"center"===o&&(r=.5*s),"bottom"===o&&(r=s),-1!==o.indexOf("%")&&0<(o=parseInt(o.replace("%",""),10))&&(r=s*o*.01),c.hardPixels&&(i=e,t=a),f.css({width:i,height:t,"margin-left":Math.floor(l),"margin-top":Math.floor(r)}),f.data("imgLiquid_oldProcessed")||(f.fadeTo(c.fadeInTime,1),f.data("imgLiquid_oldProcessed",!0),c.removeBoxBackground&&m.css("background-image","none"),m.addClass("imgLiquid_nobgSize"),m.addClass("imgLiquid_ready")),c.onItemFinish&&c.onItemFinish(h,m,f),v()}function v(){h===o.length-1&&o.settings.onFinish&&o.settings.onFinish()}f.length?(f.data("imgLiquid_settings")?(m.removeClass("imgLiquid_error").removeClass("imgLiquid_ready"),c=n.extend({},f.data("imgLiquid_settings"),o.options)):c=n.extend({},o.settings,function(){var i={};if(o.settings.useDataHtmlAttr){var t=m.attr("data-imgLiquid-fill"),e=m.attr("data-imgLiquid-horizontalAlign"),a=m.attr("data-imgLiquid-verticalAlign");"true"!==t&&"false"!==t||(i.fill=Boolean("true"===t)),void 0===e||"left"!==e&&"center"!==e&&"right"!==e&&-1===e.indexOf("%")||(i.horizontalAlign=e),void 0===a||"top"!==a&&"bottom"!==a&&"center"!==a&&-1===a.indexOf("%")||(i.verticalAlign=a)}imgLiquid.isIE&&o.settings.ieFadeInDisabled&&(i.fadeInTime=0);return i}()),f.data("imgLiquid_settings",c),c.onItemStart&&c.onItemStart(h,m,f),imgLiquid.bgs_Available&&c.useBackgroundSize?function(){-1===m.css("background-image").indexOf(encodeURI(f.attr("src")))&&m.css({"background-image":'url("'+encodeURI(f.attr("src"))+'")'});m.css({"background-size":!c.fill&&f[0].width<=m.width()&&f[0].height<=m.height()?"auto":c.fill?"cover":"contain","background-position":(c.horizontalAlign+" "+c.verticalAlign).toLowerCase(),"background-repeat":"no-repeat"}),n("a:first",m).css({display:"block",width:"100%",height:"100%"}),n("img",m).css({display:"none"}),c.onItemFinish&&c.onItemFinish(h,m,f);m.addClass("imgLiquid_bgSize"),m.addClass("imgLiquid_ready"),v()}():function i(){if(f.data("oldSrc")&&f.data("oldSrc")!==f.attr("src")){var t=f.clone().removeAttr("style");return t.data("imgLiquid_settings",f.data("imgLiquid_settings")),f.parent().prepend(t),f.remove(),(f=t)[0].width=0,void setTimeout(i,10)}if(f.data("imgLiquid_oldProcessed"))return void d();f.data("imgLiquid_oldProcessed",!1);f.data("oldSrc",f.attr("src"));n("img:not(:first)",m).css("display","none");m.css({overflow:"hidden"});f.fadeTo(0,0).removeAttr("width").removeAttr("height").css({visibility:"visible","max-width":"none","max-height":"none",width:"auto",height:"auto",display:"block"});f.on("error",a);f[0].onerror=a;!function i(){if(f.data("imgLiquid_error")||f.data("imgLiquid_loaded")||f.data("imgLiquid_oldProcessed"))return;m.is(":visible")&&f[0].complete&&0<f[0].width&&0<f[0].height?(f.data("imgLiquid_loaded",!0),setTimeout(d,h*c.delay)):setTimeout(i,c.timecheckvisibility)}();e()}()):a()})}})}(jQuery),function(){var i=imgLiquid.injectCss,t=document.getElementsByTagName("head")[0],e=document.createElement("style");e.type="text/css",e.styleSheet?e.styleSheet.cssText=i:e.appendChild(document.createTextNode(i)),t.appendChild(e)}();