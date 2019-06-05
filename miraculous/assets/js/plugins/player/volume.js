!function(e){"use strict";e.event.special.drag={setup:function(){var t=e(this),a=null,r=e(document),o=function(e){e.pageX=e.pageX||e.layerX,e.pageY=e.pageY||e.layerY,e.speedX=e.pageX-a.pageX,e.speedY=e.pageY-a.pageY,e.deltaX=e.speedX+a.deltaX,e.deltaY=e.speedY+a.deltaY,t.trigger("drag",e),a=e},n=function(e){r.off("mouseup"),r.off("mousemove"),e.pageX=e.pageX||e.layerX,e.pageY=e.pageY||e.layerY,e.speedX=e.pageX-a.pageX,e.speedY=e.pageY-a.pageY,e.deltaX=e.deltaX+a.deltaX,e.deltaY=e.deltaY+a.deltaY,t.trigger("dragend",e)},s=function(e){e.preventDefault(),e.offsetX=e.pageX-d(e.target).left,e.offsetY=e.pageY-d(e.target).top,e.speedX=e.pageX-a.pageX,e.speedY=e.pageY-a.pageY,e.deltaX=e.deltaX+a.deltaX,e.deltaY=e.deltaY+a.deltaY,t.trigger("dragend",e)};function d(e){var t=0,a=0;do{isNaN(e.offsetLeft)||(t+=e.offsetLeft),isNaN(e.offsetTop)||(a+=e.offsetTop)}while(e=e.offsetParent);return{left:t,top:a}}t.on("touchstart.drag mousedown.drag",function(e){e.preventDefault(),e.originalEvent.changedTouches||(r.on("mousemove",o),r.on("mouseup",n)),e.pageX=e.pageX||e.layerX||e.originalEvent.changedTouches[0].pageX,e.pageY=e.pageY||e.layerY||e.originalEvent.changedTouches[0].pageY,e.offsetX=e.offsetX||e.pageX-d(e.target).left,e.offsetY=e.offsetY||e.pageY-d(e.target).top,e.speedX=0,e.speedY=0,e.deltaX=0,e.deltaY=0,t.trigger("draginit",e),a=e}),t.on("touchmove.drag",function(e){e.preventDefault(),e.pageX=e.pageX||e.layerX||e.originalEvent.changedTouches[0].pageX,e.pageY=e.pageY||e.layerY||e.originalEvent.changedTouches[0].pageY,e.offsetX=e.pageX-d(e.target).left,e.offsetY=e.pageY-d(e.target).top,e.speedX=e.pageX-a.pageX,e.speedY=e.pageY-a.pageY,e.deltaX=e.speedX+a.deltaX,e.deltaY=e.speedY+a.deltaY,e.originalEvent.targetTouches.length>1||(t.trigger("drag",e),a=e)}),t.on("touchend.drag",s),t.on("touchcancel.drag",s)},teardown:function(){var t=e(this);t.off("touchstart.drag"),t.off("touchmove.drag"),t.off("touchend.drag"),t.off("touchcancel.drag"),t.off("mousedown.drag"),t.off("mouseup.drag")}};!function(){var t=e(".widgetvolume"),a=t.find(".knob-wrapper"),r=t.find(".knob"),o=t.find(".handle"),n=t.find("input"),s=0,d=1;r.rotation=0;var g=0,l=0;a.on("draginit",function(a,n){var i=n.target.clientWidth,p=n.target.clientHeight,c=n.offsetX-i/2,X=n.offsetY-p/2,Y=180*Math.atan2(-X,-c)/Math.PI+45,h=Y<-90?Y+360:Y;h=f(h=Y>-90&&Y<-45?270:h,[0,270]),g=c,l=X,r[0].setAttribute("style","transform:rotateZ("+h+"deg)"),o[0].setAttribute("style","transform:rotateZ("+h+"deg)"),r.rotation=h,h>180?r.addClass("d3"):h>90?r.removeClass("d3").addClass("d2"):r.removeClass("d3 d2");var m=u(h,[0,270],[s,d]);t.trigger("sync"),t.showValue(m),r.rotation,0==h?e(".knob-mask").addClass("mute"):(e(".knob-mask").removeClass("mute"),e("#jquery_jplayer_1").jPlayer("unmute"))}),a.on("drag",function(e,a){a.target.clientWidth,a.target.clientHeight;var n=a.deltaX+g,i=a.deltaY+l,p=180*Math.atan2(-i,-n)/Math.PI+45,c=p<-90?p+360:p;c=f(c=p>-90&&p<-45?270:c,[0,270]),r[0].setAttribute("style","transform:rotateZ("+c+"deg)"),o[0].setAttribute("style","transform:rotateZ("+c+"deg)"),r.rotation=c,c>180?r.addClass("d3"):c>90?r.removeClass("d3").addClass("d2"):r.removeClass("d3 d2");var X=u(c,[0,270],[s,d]);t.trigger("sync"),t.showValue(X)}),t.getValue=function(){return u(r.rotation,[0,270],[s,d])},t.setValue=function(a,n,g){var l=u(a,[s,d],[0,270]);r.rotation=l,l>180?r.addClass("d3"):l>90?r.removeClass("d3").addClass("d2"):r.removeClass("d3 d2"),r[0].setAttribute("style","transform:rotateZ("+l+"deg)"),o[0].setAttribute("style","transform:rotateZ("+l+"deg)"),a=t.getValue()||a,t.showValue(a),g&&t.trigger("sync"),0==l?e(".knob-mask").addClass("mute"):(e(".knob-mask").removeClass("mute"),e("#jquery_jplayer_1").jPlayer("unmute"))},t.showValue=function(e){n.val(e)},n.change(function(){t.setValue(n.val(),!0,!0)});var f=function(e,t){var a=Math.max,r=Math.min;return e=parseFloat(e),isNaN(e)&&(e=t[0]),a(r(t[0],t[1]),r(parseFloat(e),a(t[0],t[1])))},u=function(e,t,a,r){var o=Math.max,n=Math.min,s=Math.round;return e=((e=f(e,[t[0],t[1]]))-t[0])/(t[1]-t[0])*(a[1]-a[0])+a[0],r&&(e=o(a[0],a[1])+n(a[0],a[1])-e),e=s(100*(e=o(n(a[0],a[1]),n(e,o(a[0],a[1])))))/100}}()}(jQuery);