/**
 jqVideoBox 1.5.3 is released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
 - Jquery version required: 1.2.x - 1.6.x
 - SWFObject version required: v2.x
*/

/* Main idea and concept mootools plugin videbox <http://videobox-lb.sourceforge.net/> */

/*
 * width               - Width of the lightbox
 * height              - Height of the lightbox
 * animateCaption      - Enable/Disable caption animation
 * defaultOverLayFade  - Default overlay fade value
 * flvplayer          - Path to default flash player
 * getimage		 	       - Get image from service
 * navigation          - Activate navigation
 * thumblin            - fetch thumbnails from thumbl.in service (getimage need to be active, activated by default)
 */

jQuery( function ($) {
  var curstack = null;
  var curelement = 0;
  $.fn.jqvideobox = function (opt) {
    var stack = this;
    return this.each( function() {
      function init() {
        if ($("#lbOverlay").length == 0) {
          var _overlay = $(document.createElement("div")).attr({"id": "lbOverlay"}).click(closeMe);
          var _center = $(document.createElement("div")).attr({"id": "lbCenter"}).css({'width': options.initialWidth+'px','height': options.initialHeight+'px', 'display': 'none'});
          var _bottomContainer = $(document.createElement("div")).attr({"id": "lbBottomContainer"}).css('display', 'none');
          var _bottom = $(document.createElement("div")).attr('id', 'lbBottom');
          var _close = $(document.createElement("a")).attr({id: 'lbCloseLink',href: '#'}).click(closeMe);
          var _caption = $(document.createElement("div")).attr('id', 'lbCaption');
          var _number = $(document.createElement("div")).attr('id', 'lbNumber');
          var _clear = $(document.createElement("div")).css('clear', 'both');
          var _prevlink = $('<a href="#" id="lbPrevLink"></a>').click(prevVideo);
          var _nextlink = $('<a href="#" id="lbNextLink"></a>').click(nextVideo);

          _bottom.append(_close).append(_caption).append(_number).append(_clear);
          _bottomContainer.append(_bottom);

          $("body").append(_overlay).append(_center).append(_bottomContainer);
          if (!options.navigation) {
            _prevlink.hide();
            _nextlink.hide();
          }
          _overlay.append(_prevlink).append(_nextlink);
        }

        overlay = $("#lbOverlay");
        center = $("#lbCenter");
        caption = $("#lbCaption");
        bottomContainer = $("#lbBottomContainer");
        prevlink = $("#lbPrevLink");
        nextlink = $("#lbNextLink");
        element.click(activate);
        if (options.getimage) {
          getImage();
        }
      }

      function getImage() {
        var href = element.attr('href');
        var path = title = '';

        if (options.thumblin) {
          var content = '<img src="http://www.thumbl.in/api/url/?url=' + href + '" style="width:100px; height:100px;">';
          element.html(content);
          return;
        }

        switch (getType(href)) {
          case 'youtube':
            var videoId = href.split('=');
            path = 'http://i2.ytimg.com/vi/'+videoId[1]+'/default.jpg';
            break;

          case 'youtu.be':
            var videoId = href.split('=');
            path = 'http://i2.ytimg.com/vi/'+videoId[3]+'/default.jpg';
            break;

          case 'vevo':
            var videoId = href.split('/');
            path = 'http://img.cache.vevo.com/Content/VevoImages/video/'+videoId[3]+'.jpg';
            break;

          case 'metacafe':
            var videoId = href.split('/');
            path = 'http://gen.metacafe.com/thumb/'+videoId[4]+'/0/0/0/0/'+videoId[5]+'.jpg';
            break;

          case 'revver':
            var videoId = href.split('/');
            path = 'http://frame.revver.com/frame/120x90/'+videoId[4]+'.jpg';
            break;

          default:
            title = element.text();
            path = 'css/video_icon.png';
            break;
        }

        if (path) {
          var content = '<img src="' + path + '" style="width:100px; height:100px;">';
          if (title)  {
            element.css('position', 'relative');
            content += '<span class="lbImageCaption">'+title+'</span>';
          }
          element.html(content);
        }
      }

      function prevVideo() {
        curelement = curelement - 1;
        if (curelement < 0 ) {
          curelement = 0;
        }
        closeMe();
        setTimeout(function() {$(curstack[curelement]).click();}, 1);
        return false;
      }

      function nextVideo() {
        curelement = curelement + 1;
        if (curelement ==  curstack.length ) {
          curelement = curstack.length - 1;
        }
        closeMe();
        setTimeout(function() {$(curstack[curelement]).click();}, 1);
        return false;
      }

      function getType(href) {
        var type = '';
        if (href.match(/youtube\.com\/watch/i)) {
          type = 'youtube';
        }
        else if (href.match(/youtu\.be/i)) {
          type = 'youtu.be';
        }
        else if (href.match(/vevo\.com\/watch/i)) {
          type = 'vevo';
        }
        else if (href.match(/metacafe\.com\/watch/i)) {
          type = 'metacafe';
        }
        else if (href.match(/google\.com\/videoplay/i)) {
          type = 'google';
        }
        else if (href.match(/dailymotion\.com\/video/i)) {
          type = 'dailymotion';
        }
        else if (href.match(/blip\.tv\/play/i)) {
          type = 'blip';
        }
        else if (href.match(/myspace\.com\/video/i)) {
          type = 'myspace';
        }
        else if (href.match(/hulu\.com\/watch/i)) {
          type = 'hulu';
        }
        else if (href.match(/revver\.com\/video/i)) {
          type = 'revver';
        }
        else if (href.match(/veoh\.com\/watch/i)) {
          type = 'veoh';
        }
        else if (href.match(/vimeo\.com\//i)) {
          type = 'vimeo';
        }
        else if (href.match(/smotri\.com\/video\/view/i)) {
          type = 'smotri';
        }
        else if (href.match(/vkontakte\.ru\/video/i)) {
          type = 'vkontakte';
        }
        else if (href.match(/rutube\.ru\/tracks/i)) {
          type = 'rutube';
        }
        else if (href.match(/video\.mail\.ru\/inbox/i)) {
          type = 'mailru';
        }
        else if (href.match(/video\.qip\.ru\/video/i)) {
          type = 'qipru';
        }
        else if (href.match(/gametrailers\.com\/user-movie/i) || href.match(/gametrailers\.com\/video/i)) {
          type = 'gametrailers';
        }
        else if (href.match(/myvideo\.de\/watch/i)) {
          type = 'myvideode';
        }
        else if (href.match(/collegehumor\.com\/video/i)) {
          type = 'collegehumor';
        }
        else if (href.match(/sevenload\.com\/shows/i)) {
          type = 'sevenload';
        }
        else if (href.match(/facebook\.com\/v\//i)) {
          type = 'facebook';
        }
        else if (href.match(/facebook\.com\/video\/video\.php/i)) {
          type = 'facebook-page';
        }
        else if (href.match(/\.mov/i)) {
          type = 'mov_file';
        }
        else if (href.match(/\.wmv/i) || href.match(/\.asx/i)) {
          type = 'wmv_file';
        }
        else if (href.match(/\.flv/i)) {
          type = 'flv_file';
        }
        return type;
      }

      function closeMe() {
        overlay.hide();
        center.hide();
        bottomContainer.hide();
        prevlink.hide();
        nextlink.hide();
        center.html('');
        return false;
      }

      function activate() {
        curstack = stack;
        $.each(curstack, function (i, elem) {
          if (element.index(elem) == 0) {
            curelement = i;
          }
        });
        var object = setup(href);
        top = (($(window).height() / 2) - (options.height / 2));
        left= (($(window).width() / 2) - (options.width / 2));
        center.css({'top': top + 'px','left':  left + 'px','display': 'none','background': '#fff url(css/loading.gif) no-repeat center','height': options.contentsHeight,'width': options.contentsWidth});
        overlay.css('display','block').fadeTo("fast",options.defaultOverLayFade);
        caption.html(title);
        center.fadeIn("slow", function() {insert(object.attributes, object.params);});
        return false;
      }

      function insert(attributes, params) {
        center.css('background','#fff');
        if (flash) {
          center.append('<div id="lbCenter_wraper"></div>');
          var attr = {'id': attributes.id, 'name': attributes.id};
          var flashvars = false;
          swfobject.embedSWF(attributes.src, 'lbCenter_wraper', attributes.width, attributes.height, "9.0.0", "expressInstall.swf", flashvars, params, attributes);
        }
        else {
          center.html(other);
        }
        bottomContainer.css({'top': (top + center.height() + 10) + "px",'left': center.css('left'),'width': options.contentsWidth+'px'});
        if (options.animateCaption) {
          bottomContainer.slideDown('slow');
        } else {
          bottomContainer.css('display','block');
        }
        if (options.navigation) {
          if (curelement != 0) {
            prevlink.css({'top': (top + (options.height /2 )) + "px", 'display': 'block', 'left':  (parseInt(center.css('left'),10) - 53) + 'px'});
          }
          if ((curelement + 1) != curstack.length) {
            nextlink.css({'top': (top + (options.height /2 )) + "px", 'display': 'block', 'left':  (parseInt(center.css('left'),10) + options.width) + 'px'});
          }
        }
      }

      function setup(href) {
        var aDim;
        if (typeof (rel) != 'undefined') {
          aDim = rel.match(/[0-9]+/g);
        }
        overlay.css({
          'height': $(window).height()+'px'
        });
        options.contentsWidth = (aDim && (aDim[0] > 0)) ? aDim[0] : options.width;
        options.contentsHeight = (aDim && (aDim[1] > 0)) ? aDim[1] : options.height;

        var attributes = {'width': options.contentsWidth, 'height': options.contentsHeight, 'id': 'flvvideo'};
        var params = {'wmode': 'transparent'};
        var  type = getType(href);
        switch (type) {
          case 'facebook':
          case 'facebook-page':
            flash = false;
              if (type == 'facebook-page') {
                var videoId = href.split('=');
                videoId = videoId[1];
              } else {
                var videoId = href.split('/');
                videoId = videoId[4];
              }
              other = '<iframe frameborder="0" width="' + options.contentsWidth + '" height="' + options.contentsHeight + '" src="http://www.facebook.com/v/' + videoId + '"></iframe>';
            break;
          case 'youtube':
              flash = false;
              var videoId = href.split('=');
              other = '<iframe frameborder="0" width="' + options.contentsWidth + '" height="' + options.contentsHeight + '" src="http://www.youtube.com/embed/' + videoId[1] + '"></iframe>';
            break;

          case 'youtu.be':
              flash = false;
              var videoId = href.split('/');
              other = '<iframe frameborder="0" width="' + options.contentsWidth + '" height="' + options.contentsHeight + '" src="http://www.youtube.com/embed/' + videoId[3] + '"></iframe>';
            break;

          case 'vevo':
              flash = false;
              var videoId = href.split('=');
              other = '<object width="' + options.contentsWidth + '" height="' + options.contentsHeight + '"><param name="movie" value="http://videoplayer.vevo.com/embed/Embedded?videoId=' + videoId[3] + '&playlist=false&autoplay=0&playerId=62FF0A5C-0D9E-4AC1-AF04-1D9E97EE3961&playerType=embedded&env=0&cultureName=en-US&cultureIsRTL=False"></param><param name="wmode" value="transparent"></param><param name="bgcolor" value="#000000"></param><param name="allowFullScreen" value="true"></param><param name="allowScriptAccess" value="always"></param><embed src="http://videoplayer.vevo.com/embed/Embedded?videoId=' + videoId[3] + '&playlist=false&autoplay=0&playerId=62FF0A5C-0D9E-4AC1-AF04-1D9E97EE3961 &playerType=embedded&env=0&cultureName=en-US&cultureIsRTL=False" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="' + options.contentsWidth + '" height="' + options.contentsHeight + '" bgcolor="#000000" wmode="transparent"></embed></object>';
              attributes.src = "http://videoplayer.vevo.com/embed/Embedded?videoId='+ videoId[3] +'&playlist=false&autoplay=0&playerId=62FF0A5C-0D9E-4AC1-AF04-1D9E97EE3961&playerType=embedded&env=0&cultureName=en-US&cultureIsRTL=False";
            break;

          case 'metacafe':
              flash = true;
              var videoId = href.split('/');
              attributes.src = "http://www.metacafe.com/fplayer/" + videoId[4] + "/.swf";
            break;

          case 'google':
            flash = true;
            var videoId = href.split('=');
            attributes.src = "http://video.google.com/googleplayer.swf?docId=" + videoId[1] + "&hl=en";
            break;

          case 'dailymotion':
            flash = false;
            var videoId = href.replace(/(.*)video\/(.*?)_(.*)/, '$2');
            other = '<iframe frameborder="0" width="' + options.contentsWidth + '" height="' + options.contentsHeight + '" src="http://www.dailymotion.com/embed/video/' + videoId + '?theme=none&wmode=transparent"></iframe>';
            break;

          case 'smotri':
            flash = true;
            var videoId = href.split('=');
            attributes.src = 'http://pics.smotri.com/player.swf?file='+videoId[1]+'&bufferTime=3&autoStart=false&str_lang=rus&xmlsource=http%3A%2F%2Fpics.smotri.com%2Fcskins%2Fblue%2Fskin_color.xml&xmldatasource=http%3A%2F%2Fpics.smotri.com%2Fskin_ng.xml';
            break;

          case 'vkontakte':
            flash = false;
            var videoId = /video(.*?)_(.*?)($|\?)/ig.exec(href);
            var hash = /hash=(.*?)($|&)/ig.exec(href);
            other = '<iframe frameborder="0" width="' + options.contentsWidth + '" height="' + options.contentsHeight + '" src="http://vkontakte.ru/video_ext.php?oid=' + videoId[1] + '&id=' + videoId[2] + '&hash=' + hash[1] + '&hd=1"></iframe>';
            break;

          case 'revver':
            flash = true;
            var videoId = href.split('/');
            attributes.src = "http://flash.revver.com/player/1.0/player.swf?mediaId=" + videoId[4];
            break;

          case 'veoh':
            flash = true;
            var videoId = href.split('/');
            attributes.src = "http://www.veoh.com/static/swf/veoh/MediaPlayerWrapper.swf?permalinkId=" + videoId[4];
            break;

          case 'vimeo':
            flash = false;
            var videoId = href.split('/');
            other = '<iframe frameborder="0" width="' + options.contentsWidth + '" height="' + options.contentsHeight + '" src="http://player.vimeo.com/video/' + videoId[3] + '?title=0&byline=0&portrait=0"></iframe>';
            break;

          case 'rutube':
            flash = true;
            var videoId = href.split('=');
            attributes.src = "http://video.rutube.ru/" + videoId[1];
            break;

          case 'mailru':
            flash = true;
            var videoId = href.split('/');
            var number = videoId[6].split('.');
            params.flashvars = 'movieSrc=inbox/' + videoId[4] + '/'+ videoId[5] + '/' + number[0];
            attributes.src = attributes.data = params.movie = "http://img.mail.ru/r/video2/player_v2.swf";
            break;

          case 'qipru':
            flash = true;
            var videoId = href.split('=');
            attributes.src = 'http://pics.video.qip.ru/player.swf?file=' + videoId[1] + '&bufferTime=3&autoStart=false&str_lang=rus&xmlsource=http%3A%2F%2Fpics.video.qip.ru%2Fcskins%2Fqip%2Fskin_color.xml&xmldatasource=http%3A%2F%2Fpics.video.qip.ru%2Fskin_ng.xml';
            break;

          case 'gametrailers':
            flash = true;
            var videoId = href.split('/');
            if (videoId[3] == 'video') {
              attributes.src = 'http://media.mtvnservices.com/mgid:moses:video:gametrailers.com:' + videoId[5];
            }
            else {
              attributes.src = 'http://media.mtvnservices.com/mgid:moses:usermovie:gametrailers.com:' + parseInt(videoId[5], 10);
            }
            break;

          case 'myvideode':
            flash = true;
            var videoId = href.split('/');
            attributes.src = 'http://www.myvideo.de/movie/' + videoId[4];
            break;

          case 'collegehumor':
            flash = true;
            var videoId = href.split('/');
            attributes.src = 'http://www.collegehumor.com/moogaloop/moogaloop.swf?clip_id=' + videoId[4] + '&use_node_id=true&fullscreen=1';
            break;

          case 'sevenload':
            flash = true;
            var videoId = href.split('/');
            var id = videoId[6].replace(/(.*?)-(.*)/,'$1');
            params.flashvars = 'configPath=http%3A%2F%2Fflash.sevenload.com%2Fplayer%3FportalId%3Den%26autoplay%3D0%26mute%3D0%26itemId%3D' + id + '&locale=en_US&autoplay=0&environment=';
            attributes.src = attributes.data = params.movie = "http://static.sevenload.net/swf/player/player.swf?v=142";
            break;

          case 'mov_file':
            flash = false;
            if (navigator.plugins && navigator.plugins.length) {
              other ='<object id="qtboxMovie" type="video/quicktime" codebase="http://www.apple.com/qtactivex/qtplugin.cab" data="'+href+'" width="'+options.contentsWidth+'" height="'+options.contentsHeight+'"><param name="src" value="'+href+'" /><param name="scale" value="aspect" /><param name="controller" value="true" /><param name="autoplay" value="true" /><param name="bgcolor" value="#000000" /><param name="enablejavascript" value="true" /></object>';
            } else {
              other = '<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" width="'+options.contentsWidth+'" height="'+options.contentsHeight+'" id="qtboxMovie"><param name="src" value="'+href+'" /><param name="scale" value="aspect" /><param name="controller" value="true" /><param name="autoplay" value="true" /><param name="bgcolor" value="#000000" /><param name="enablejavascript" value="true" /></object>';
            }
            break;

          case 'wmv_file':
            flash = false;
            other = '<object NAME="Player" WIDTH="'+options.contentsWidth+'" HEIGHT="'+options.contentsHeight+'" align="left" hspace="0" type="application/x-oleobject" CLASSID="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6"><param NAME="URL" VALUE="'+href+'"><param><param NAME="AUTOSTART" VALUE="false"></param><param name="showControls" value="true"></param><embed WIDTH="'+options.contentsWidth+'" HEIGHT="'+options.contentsHeight+'" align="left" hspace="0" SRC="'+href+'" TYPE="application/x-oleobject" AUTOSTART="false"></embed></object>';
            break;

          case 'flv_file':
            flash = true;
            attributes.src = options.flvplayer+"?file="+href;
            break;

          default:
            flash = true;
            attributes.src = href;
            break;
        }
        return {'attributes' : attributes, 'params' : params};
      }

      var options = $.extend({
        width: 425,		// Default width of the box (px)
        height: 350,	// Default height of the box (px)
        animateCaption: true,	// Enable/Disable caption animation
        defaultOverLayFade: 0.8,	//Default overlay fade value
        getimage: false,
        navigation: false,
        thumblin: true,
        flvplayer: 'swf/flvplayer.swf'
      }, opt);

      //system vars
      var overlay, center, caption, bottomContainer, so, flash, videoID, other, top;
      var element = $(this);
      var href = element.attr("href");
      var title = element.attr("title");
      var rel = element.attr("rel");
      //lets start it
      init();
    });
  }
}
);
