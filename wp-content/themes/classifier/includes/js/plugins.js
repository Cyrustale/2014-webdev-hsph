/**
 * ImagesLoaded
 */
(function(c,n){var k="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";c.fn.imagesLoaded=function(l){function m(){var b=c(h),a=c(g);d&&(g.length?d.reject(e,b,a):d.resolve(e));c.isFunction(l)&&l.call(f,e,b,a)}function i(b,a){b.src===k||-1!==c.inArray(b,j)||(j.push(b),a?g.push(b):h.push(b),c.data(b,"imagesLoaded",{isBroken:a,src:b.src}),o&&d.notifyWith(c(b),[a,e,c(h),c(g)]),e.length===j.length&&(setTimeout(m),e.unbind(".imagesLoaded")))}var f=this,d=c.isFunction(c.Deferred)?c.Deferred():
0,o=c.isFunction(d.notify),e=f.find("img").add(f.filter("img")),j=[],h=[],g=[];e.length?e.bind("load.imagesLoaded error.imagesLoaded",function(b){i(b.target,"error"===b.type)}).each(function(b,a){var e=a.src,d=c.data(a,"imagesLoaded");if(d&&d.src===e)i(a,d.isBroken);else if(a.complete&&a.naturalWidth!==n)i(a,0===a.naturalWidth||0===a.naturalHeight);else if(a.readyState||a.complete)a.src=k,a.src=e}):m();return d?d.promise(f):f}})(jQuery);


/*
 * Superfish v1.4.8 - jQuery menu widget
 * Copyright (c) 2008 Joel Birch
 *
 * Dual licensed under the MIT and GPL licenses:
 *  http://www.opensource.org/licenses/mit-license.php
 *  http://www.gnu.org/licenses/gpl.html
 *
 * CHANGELOG: http://users.tpg.com.au/j_birch/plugins/superfish/changelog.txt
 */

(function($){$.fn.superfish=function(op){var sf=$.fn.superfish,c=sf.c,$arrow=$(['<span class="',c.arrowClass,'"> &#187;</span>'].join("")),over=function(){var $$=$(this),menu=getMenu($$);clearTimeout(menu.sfTimer);$$.showSuperfishUl().siblings().hideSuperfishUl()},out=function(){var $$=$(this),menu=getMenu($$),o=sf.op;clearTimeout(menu.sfTimer);menu.sfTimer=setTimeout(function(){o.retainPath=$.inArray($$[0],o.$path)>-1;$$.hideSuperfishUl();if(o.$path.length&&$$.parents(["li.",o.hoverClass].join("")).length<
1)over.call(o.$path)},o.delay)},getMenu=function($menu){var menu=$menu.parents(["ul.",c.menuClass,":first"].join(""))[0];sf.op=sf.o[menu.serial];return menu},addArrow=function($a){$a.addClass(c.anchorClass).append($arrow.clone())};return this.each(function(){var s=this.serial=sf.o.length;var o=$.extend({},sf.defaults,op);o.$path=$("li."+o.pathClass,this).slice(0,o.pathLevels).each(function(){$(this).addClass([o.hoverClass,c.bcClass].join(" ")).filter("li:has(ul)").removeClass(o.pathClass)});sf.o[s]=
sf.op=o;$("li:has(ul)",this)[$.fn.hoverIntent&&!o.disableHI?"hoverIntent":"hover"](over,out).each(function(){if(o.autoArrows)addArrow($(">a:first-child",this))}).not("."+c.bcClass).hideSuperfishUl();var $a=$("a",this);$a.each(function(i){var $li=$a.eq(i).parents("li");$a.eq(i).focus(function(){over.call($li)}).blur(function(){out.call($li)})});o.onInit.call(this)}).each(function(){var menuClasses=[c.menuClass];if(sf.op.dropShadows&&!($.browser.msie&&$.browser.version<7))menuClasses.push(c.shadowClass);
$(this).addClass(menuClasses.join(" "))})};var sf=$.fn.superfish;sf.o=[];sf.op={};sf.IE7fix=function(){var o=sf.op;if($.browser.msie&&$.browser.version>6&&o.dropShadows&&o.animation.opacity!=undefined)this.toggleClass(sf.c.shadowClass+"-off")};sf.c={bcClass:"sf-breadcrumb",menuClass:"sf-js-enabled",anchorClass:"sf-with-ul",arrowClass:"sf-sub-indicator",shadowClass:"sf-shadow"};sf.defaults={hoverClass:"sfHover",pathClass:"overideThisToUse",pathLevels:1,delay:800,animation:{opacity:"show"},speed:"normal",
autoArrows:true,dropShadows:true,disableHI:false,onInit:function(){},onBeforeShow:function(){},onShow:function(){},onHide:function(){}};$.fn.extend({hideSuperfishUl:function(){var o=sf.op,not=o.retainPath===true?o.$path:"";o.retainPath=false;var $ul=$(["li.",o.hoverClass].join(""),this).add(this).not(not).removeClass(o.hoverClass).find(">ul").hide().css("visibility","hidden");o.onHide.call($ul);return this},showSuperfishUl:function(){var o=sf.op,sh=sf.c.shadowClass+"-off",$ul=this.addClass(o.hoverClass).find(">ul:hidden").css("visibility",
"visible");sf.IE7fix.call($ul);o.onBeforeShow.call($ul);$ul.animate(o.animation,o.speed,function(){sf.IE7fix.call($ul);o.onShow.call($ul)});return this}})})(jQuery);


/**
 * DropKick
 *
 * Highly customizable <select> lists
 * https://github.com/JamieLottering/DropKick
 *
 * &copy; 2011 Jamie Lottering <http://github.com/JamieLottering>
 *                        <http://twitter.com/JamieLottering>
 * 
 */
/**
 * DropKick
 *
 * Highly customizable <select> lists
 * https://github.com/JamieLottering/DropKick
 *
 * &copy; 2011 Jamie Lottering <http://github.com/JamieLottering>
 *                        <http://twitter.com/JamieLottering>
 * 
 */
(function ($, window, document) {

  var ie6 = false;

  // Help prevent flashes of unstyled content
  if ($.browser.msie && $.browser.version.substr(0, 1) < 7) {
    ie6 = true;
  } else {
    document.documentElement.className = document.documentElement.className + ' dk_fouc';
  }
  
  var
    // Public methods exposed to $.fn.dropkick()
    methods = {},

    // Cache every <select> element that gets dropkicked
    lists   = [],

    // Convenience keys for keyboard navigation
    keyMap = {
      'left'  : 37,
      'up'    : 38,
      'right' : 39,
      'down'  : 40,
      'enter' : 13
    },

    // HTML template for the dropdowns
    dropdownTemplate = [
      '<div class="dk_container" id="dk_container_{{ id }}" tabindex="{{ tabindex }}">',
        '<a class="dk_toggle">',
          '<span class="dk_label">{{ label }}</span>',
        '</a>',
        '<div class="dk_options">',
          '<ul class="dk_options_inner">',
          '</ul>',
        '</div>',
      '</div>'
    ].join(''),

    // HTML template for dropdown options
    optionTemplate = '<li class="{{ current }}"><a data-dk-dropdown-value="{{ value }}">{{ text }} {{ count }}</a></li>',

    // Some nice default values
    defaults = {
      startSpeed : 1000,  // I recommend a high value here, I feel it makes the changes less noticeable to the user
      theme  : false,
      change : false
    },

    // Make sure we only bind keydown on the document once
    keysBound = false
  ;

  // Called by using $('foo').dropkick();
  methods.init = function (settings) {
    settings = $.extend({}, defaults, settings);

    return this.each(function () {
      var
        // The current <select> element
        $select = $(this),

        // Store a reference to the originally selected <option> element
        $original = $select.find(':selected').first(),

        // Save all of the <option> elements
        $options = $select.find('option'),

        // We store lots of great stuff using jQuery data
        data = $select.data('dropkick') || {},

        // This gets applied to the 'dk_container' element
        id = $select.attr('id') || $select.attr('name'),

        // This gets updated to be equal to the longest <option> element
        width  = settings.width || $select.outerWidth(),

        // Check if we have a tabindex set or not
        tabindex  = $select.attr('tabindex') ? $select.attr('tabindex') : '',

        // The completed dk_container element
        $dk = false,

        theme
      ;

      // Dont do anything if we've already setup dropkick on this element
      if (data.id) {
        return $select;
      } else {
        data.settings  = settings;
        data.tabindex  = tabindex;
        data.id        = id;
        data.$original = $original;
        data.$select   = $select;
        data.value     = _notBlank($select.val()) || _notBlank($original.attr('value'));
        data.label     = $original.text();
        data.options   = $options;
      }

      // Build the dropdown HTML
      $dk = _build(dropdownTemplate, data);

      // Make the dropdown fixed width if desired
      $dk.find('.dk_toggle').css({
        'width' : width + 'px'
      });

      // Hide the <select> list and place our new one in front of it
      $select.before($dk);

      // Update the reference to $dk
      $dk = $('#dk_container_' + id).fadeIn(settings.startSpeed);

      // Save the current theme
      theme = settings.theme ? settings.theme : 'default';
      $dk.addClass('dk_theme_' + theme);
      data.theme = theme;

      // Save the updated $dk reference into our data object
      data.$dk = $dk;

      // Save the dropkick data onto the <select> element
      $select.data('dropkick', data);

      // Do the same for the dropdown, but add a few helpers
      $dk.data('dropkick', data);

      lists[lists.length] = $select;

      // Focus events
      if( !$.browser.msie ) {
        $dk.bind('focus.dropkick', function (e) {
          $dk.addClass('dk_focus');
        }).bind('blur.dropkick', function (e) {
          $dk.removeClass('dk_open dk_focus');
        });
      } else {
        $('body').click(function(event) {
            if (!$(event.target).parents('.dk_container').length || $(event.target).parent().attr('id') != $dk.attr('id')) {
            _closeDropdown($dk);
          }
        });
      }

      setTimeout(function () {
        $select.hide();
      }, 0);
    });
  };

  // Allows dynamic theme changes
  methods.theme = function (newTheme) {
    var
      $select   = $(this),
      list      = $select.data('dropkick'),
      $dk       = list.$dk,
      oldtheme  = 'dk_theme_' + list.theme
    ;

    $dk.removeClass(oldtheme).addClass('dk_theme_' + newTheme);

    list.theme = newTheme;
  };

  // Reset all <selects and dropdowns in our lists array
  methods.reset = function () {
    for (var i = 0, l = lists.length; i < l; i++) {
      var
        listData  = lists[i].data('dropkick'),
        $dk       = listData.$dk,
        $current  = $dk.find('li').first()
      ;

      $dk.find('.dk_label').text(listData.label);
      $dk.find('.dk_options_inner').animate({ scrollTop: 0 }, 0);

      _setCurrent($current, $dk);
      _updateFields($current, $dk, true);
    }
  };

  // Expose the plugin
  $.fn.dropkick = function (method) {
    if (!ie6) {
      if (methods[method]) {
        return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
      } else if (typeof method === 'object' || ! method) {
        return methods.init.apply(this, arguments);
      }
    }
  };

  // private
  function _handleKeyBoardNav(e, $dk) {
    var
      code     = e.keyCode,
      data     = $dk.data('dropkick'),
      options  = $dk.find('.dk_options'),
      open     = $dk.hasClass('dk_open'),
      current  = $dk.find('.dk_option_current'),
      first    = options.find('li').first(),
      last     = options.find('li').last(),
      next,
      prev
    ;

    switch (code) {
      case keyMap.enter:
        if (open) {
          _updateFields(current.find('a'), $dk);
          _closeDropdown($dk);
        } else {
          _openDropdown($dk);
        }
        e.preventDefault();
      break;

      case keyMap.up:
        prev = current.prev('li');
        if (open) {
          if (prev.length) {
            _setCurrent(prev, $dk);
          } else {
            _setCurrent(last, $dk);
          }
        } else {
          _openDropdown($dk);
        }
        e.preventDefault();
      break;

      case keyMap.down:
        if (open) {
          next = current.next('li').first();
          if (next.length) {
            _setCurrent(next, $dk);
          } else {
            _setCurrent(first, $dk);
          }
        } else {
          _openDropdown($dk);
        }
        e.preventDefault();
      break;

      default:
      break;
    }
  }

  // Update the <select> value, and the dropdown label
  function _updateFields(option, $dk, reset) {
    var value, label, data;

    value = option.attr('data-dk-dropdown-value');
    label = option.text();
    data  = $dk.data('dropkick');

    $select = data.$select;
    $select.val(value);

    $dk.find('.dk_label').text(label);

    reset = reset || false;

    if (data.settings.change && !reset) {
      data.settings.change.call($select, value, label);
    }
  }

  // Set the currently selected option
  function _setCurrent($current, $dk) {
    $dk.find('.dk_option_current').removeClass('dk_option_current');
    $current.addClass('dk_option_current');

    _setScrollPos($dk, $current);
  }

  function _setScrollPos($dk, anchor) {
    var height = anchor.prevAll('li').outerHeight() * anchor.prevAll('li').length;
    $dk.find('.dk_options_inner').animate({ scrollTop: height + 'px' }, 0);
  }

  // Close a dropdown
  function _closeDropdown($dk) {
    $dk.removeClass('dk_open');
  }

  // Open a dropdown
  function _openDropdown($dk) {
    var data = $dk.data('dropkick');
    $dk.find('.dk_options').css({ top : $dk.find('.dk_toggle').outerHeight() - 1 });
    $dk.toggleClass('dk_open');

  }

  /**
   * Turn the dropdownTemplate into a jQuery object and fill in the variables.
   */
  function _build (tpl, view) {
    var
      // Template for the dropdown
      template  = tpl,
      // Holder of the dropdowns options
      options   = [],
      $dk
    ;

    template = template.replace('{{ id }}', view.id);
    template = template.replace('{{ label }}', view.label);
    template = template.replace('{{ tabindex }}', view.tabindex);

    if (view.options && view.options.length) {
      for (var i = 0, l = view.options.length; i < l; i++) {
        var
          $option   = $(view.options[i]),
          current   = 'dk_option_current',
          oTemplate = optionTemplate
        ;

        oTemplate = oTemplate.replace('{{ value }}', $option.val());
        oTemplate = oTemplate.replace('{{ current }}', (_notBlank($option.val()) === view.value) ? current : '');
        oTemplate = oTemplate.replace('{{ text }}', $option.text());
        if( typeof $option.data('count') !== 'undefined' ) {
          oTemplate = oTemplate.replace('{{ count }}', '<span>'+ $option.data('count') +'</span>');
        } else {
          oTemplate = oTemplate.replace('{{ count }}', '');
        }

        options[options.length] = oTemplate;
      }
    }

    $dk = $(template);
    $dk.find('.dk_options_inner').html(options.join(''));

    return $dk;
  }

  function _notBlank(text) {
    return ($.trim(text).length > 0) ? text : false;
  }

  $(function () {

    // Handle click events on the dropdown toggler
    $('.dk_toggle').live('click', function (e) {
      var $dk  = $(this).parents('.dk_container').first();

      _openDropdown($dk);

      if ("ontouchstart" in window) {
        $dk.addClass('dk_touch');
        $dk.find('.dk_options_inner').addClass('scrollable vertical');
      }

      e.preventDefault();
      return false;
    });

    // Handle click events on individual dropdown options
    $('.dk_options a').live(($.browser.msie ? 'mousedown' : 'click'), function (e) {
      var
        $option = $(this),
        $dk     = $option.parents('.dk_container').first(),
        data    = $dk.data('dropkick')
      ;
    
      _closeDropdown($dk);
      _updateFields($option, $dk);
      _setCurrent($option.parent(), $dk);
    
      e.preventDefault();
      return false;
    });

    // Setup keyboard nav
    $(document).bind('keydown.dk_nav', function (e) {
      var
        // Look for an open dropdown...
        $open    = $('.dk_container.dk_open'),

        // Look for a focused dropdown
        $focused = $('.dk_container.dk_focus'),

        // Will be either $open, $focused, or null
        $dk = null
      ;

      // If we have an open dropdown, key events should get sent to that one
      if ($open.length) {
        $dk = $open;
      } else if ($focused.length && !$open.length) {
        // But if we have no open dropdowns, use the focused dropdown instead
        $dk = $focused;
      }

      if ($dk) {
        _handleKeyBoardNav(e, $dk);
      }
    });
  });
})(jQuery, window, document);


/*  
 *  jQuery carouFredSel 5.5.5
 *  Demo's and documentation:
 *  caroufredsel.frebsite.nl
 *  
 *  Copyright (c) 2012 Fred Heusschen
 *  www.frebsite.nl
 *
 *  Dual licensed under the MIT and GPL licenses.
 *  http://en.wikipedia.org/wiki/MIT_License
 *  http://en.wikipedia.org/wiki/GNU_General_Public_License
 */
eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('(I($){8($.1P.1J)J;$.1P.1J=I(y,z){8(1h.W==0){1c(M,\'5q 4p 6t 1m "\'+1h.3U+\'".\');J 1h}8(1h.W>1){J 1h.1Q(I(){$(1h).1J(y,z)})}F A=1h,$19=1h[0];8(A.1q(\'4q\')){F B=A.1A(\'5r\');A.X(\'5s\',M)}Q{F B=O}A.3V=I(o,b,c){o=3W($19,o);8(o.1c){H.1c=o.1c;1c(H,\'6u "1c" 6v 6w 6x 6y 3u 5t 6z 4r-1j.\')}F e=[\'G\',\'1n\',\'T\',\'17\',\'1a\',\'1b\'];1m(F a=0,l=e.W;a<l;a++){o[e[a]]=3W($19,o[e[a]])}8(K o.1n==\'14\'){8(o.1n<=50)o.1n={\'G\':o.1n};Q o.1n={\'1k\':o.1n}}Q{8(K o.1n==\'1l\')o.1n={\'1G\':o.1n}}8(K o.G==\'14\')o.G={\'P\':o.G};Q 8(o.G==\'1e\')o.G={\'P\':o.G,\'S\':o.G,\'1s\':o.G};8(K o.G!=\'1j\')o.G={};8(b)2u=$.25(M,{},$.1P.1J.4s,o);7=$.25(M,{},$.1P.1J.4s,o);8(K 7.G.12!=\'1j\')7.G.12={};8(7.G.2I==0&&K c==\'14\'){7.G.2I=c}C.4t=(7.2J);C.2k=(7.2k==\'4u\'||7.2k==\'1t\')?\'1a\':\'17\';F f=[[\'S\',\'34\',\'26\',\'1s\',\'5u\',\'2K\',\'1t\',\'2L\',\'1E\',0,1,2,3],[\'1s\',\'5u\',\'2K\',\'S\',\'34\',\'26\',\'2L\',\'1t\',\'3X\',3,2,1,0]];F g=f[0].W,5v=(7.2k==\'2M\'||7.2k==\'1t\')?0:1;7.d={};1m(F d=0;d<g;d++){7.d[f[0][d]]=f[5v][d]}F h=A.Z();1x(K 7.G.P){V\'1j\':7.G.12.2N=7.G.P.2N;7.G.12.27=7.G.P.27;7.G.P=O;18;V\'1l\':8(7.G.P==\'1e\'){7.G.12.1e=M}Q{7.G.12.2l=7.G.P}7.G.P=O;18;V\'I\':7.G.12.2l=7.G.P;7.G.P=O;18}8(K 7.G.1v==\'1y\'){7.G.1v=(h.1v(\':2O\').W>0)?\':P\':\'*\'}8(7[7.d[\'S\']]==\'T\'){7[7.d[\'S\']]=3v(h,7,\'26\')}8(3Y(7[7.d[\'S\']])&&!7.2J){7[7.d[\'S\']]=3Z(35($1B.36(),7,\'34\'),7[7.d[\'S\']]);C.4t=M}8(7[7.d[\'1s\']]==\'T\'){7[7.d[\'1s\']]=3v(h,7,\'2K\')}8(!7.G[7.d[\'S\']]){8(7.2J){1c(M,\'5w a \'+7.d[\'S\']+\' 1m 5t G!\');7.G[7.d[\'S\']]=3v(h,7,\'26\')}Q{7.G[7.d[\'S\']]=(4v(h,7,\'26\'))?\'1e\':h[7.d[\'26\']](M)}}8(!7.G[7.d[\'1s\']]){7.G[7.d[\'1s\']]=(4v(h,7,\'2K\'))?\'1e\':h[7.d[\'2K\']](M)}8(!7[7.d[\'1s\']]){7[7.d[\'1s\']]=7.G[7.d[\'1s\']]}8(!7.G.P&&!7.2J){8(7.G[7.d[\'S\']]==\'1e\'){7.G.12.1e=M}8(!7.G.12.1e){8(K 7[7.d[\'S\']]==\'14\'){7.G.P=1K.3w(7[7.d[\'S\']]/7.G[7.d[\'S\']])}Q{F i=35($1B.36(),7,\'34\');7.G.P=1K.3w(i/7.G[7.d[\'S\']]);7[7.d[\'S\']]=7.G.P*7.G[7.d[\'S\']];8(!7.G.12.2l)7.1C=O}8(7.G.P==\'6A\'||7.G.P<1){1c(M,\'28 a 4w 14 3x P G: 5w 3u "1e".\');7.G.12.1e=M}}}8(!7[7.d[\'S\']]){7[7.d[\'S\']]=\'1e\';8(!7.2J&&7.G.1v==\'*\'&&!7.G.12.1e&&7.G[7.d[\'S\']]!=\'1e\'){7[7.d[\'S\']]=7.G.P*7.G[7.d[\'S\']];7.1C=O}}8(7.G.12.1e){7.3y=(7[7.d[\'S\']]==\'1e\')?35($1B.36(),7,\'34\'):7[7.d[\'S\']];8(7.1C===O){7[7.d[\'S\']]=\'1e\'}7.G.P=2P(h,7,0)}Q 8(7.G.1v!=\'*\'){7.G.12.41=7.G.P;7.G.P=3z(h,7,0)}8(K 7.1C==\'1y\'){7.1C=(7[7.d[\'S\']]==\'1e\')?O:\'4x\'}7.G.P=2Q(7.G.P,7,7.G.12.2l,$19);7.G.12.2m=7.G.P;7.1u=O;8(7.2J){8(!7.G.12.2N)7.G.12.2N=7.G.P;8(!7.G.12.27)7.G.12.27=7.G.P;7.1C=O;7.1i=[0,0,0,0];F j=$1B.1W(\':P\');8(j)$1B.3a();F k=3Z(35($1B.36(),7,\'34\'),7[7.d[\'S\']]);8(K 7[7.d[\'S\']]==\'14\'&&k<7[7.d[\'S\']]){k=7[7.d[\'S\']]}8(j)$1B.3b();F m=4y(1K.2v(k/7.G[7.d[\'S\']]),7.G.12);8(m>h.W){m=h.W}F n=1K.3w(k/m),4z=7[7.d[\'1s\']],5x=3Y(4z);h.1Q(I(){F a=$(1h),4A=n-5y(a,7,\'6B\');a[7.d[\'S\']](4A);8(5x){a[7.d[\'1s\']](3Z(4A,4z))}});7.G.P=m;7.G[7.d[\'S\']]=n;7[7.d[\'S\']]=m*n}Q{7.1i=5z(7.1i);8(7.1C==\'2L\')7.1C=\'1t\';8(7.1C==\'4B\')7.1C=\'2M\';1x(7.1C){V\'4x\':V\'1t\':V\'2M\':8(7[7.d[\'S\']]!=\'1e\'){F p=42(3c(h,7),7);7.1u=M;7.1i[7.d[1]]=p[1];7.1i[7.d[3]]=p[0]}18;2w:7.1C=O;7.1u=(7.1i[0]==0&&7.1i[1]==0&&7.1i[2]==0&&7.1i[3]==0)?O:M;18}}8(K 7.2n==\'1r\'&&7.2n)7.2n=\'6C\'+A.6D(\'6E\');8(K 7.G.3d!=\'14\')7.G.3d=7.G.P;8(K 7.1n.1k!=\'14\')7.1n.1k=5A;8(K 7.1n.G==\'1y\')7.1n.G=(7.G.12.1e||7.G.1v!=\'*\')?\'P\':7.G.P;7.T=3A($19,7.T,\'T\');7.17=3A($19,7.17);7.1a=3A($19,7.1a);7.1b=3A($19,7.1b,\'1b\');7.T=$.25(M,{},7.1n,7.T);7.17=$.25(M,{},7.1n,7.17);7.1a=$.25(M,{},7.1n,7.1a);7.1b=$.25(M,{},7.1n,7.1b);8(K 7.1b.43!=\'1r\')7.1b.43=O;8(K 7.1b.3e!=\'I\'&&7.1b.3e!==O)7.1b.3e=$.1P.1J.5B;8(K 7.T.1H!=\'1r\')7.T.1H=M;8(K 7.T.4C!=\'14\')7.T.4C=0;8(K 7.T.44==\'1y\')7.T.44=M;8(K 7.T.4D!=\'1r\')7.T.4D=M;8(K 7.T.3f!=\'14\')7.T.3f=(7.T.1k<10)?6F:7.T.1k*5;8(7.29){7.29=4E(7.29)}8(H.1c){1c(H,\'3g S: \'+7.S);1c(H,\'3g 1s: \'+7.1s);8(7.3y)1c(H,\'6G \'+7.d[\'S\']+\': \'+7.3y);1c(H,\'5C 6H: \'+7.G.S);1c(H,\'5C 6I: \'+7.G.1s);1c(H,\'45 3x G P: \'+7.G.P);8(7.T.1H)1c(H,\'45 3x G 4F 6J: \'+7.T.G);8(7.17.Y)1c(H,\'45 3x G 4F 4G: \'+7.17.G);8(7.1a.Y)1c(H,\'45 3x G 4F 5D: \'+7.1a.G)}};A.5E=I(){A.1q(\'4q\',M);F a={\'4H\':A.16(\'4H\'),\'4I\':A.16(\'4I\'),\'3B\':A.16(\'3B\'),\'2L\':A.16(\'2L\'),\'2M\':A.16(\'2M\'),\'4B\':A.16(\'4B\'),\'1t\':A.16(\'1t\'),\'S\':A.16(\'S\'),\'1s\':A.16(\'1s\'),\'4J\':A.16(\'4J\'),\'1E\':A.16(\'1E\'),\'3X\':A.16(\'3X\'),\'4K\':A.16(\'4K\')};1x(a.3B){V\'4L\':F b=\'4L\';18;V\'5F\':F b=\'5F\';18;2w:F b=\'6K\'}$1B.16(a).16({\'6L\':\'2O\',\'3B\':b});A.1q(\'5G\',a).16({\'4H\':\'1t\',\'4I\':\'46\',\'3B\':\'4L\',\'2L\':0,\'1t\':0,\'4J\':0,\'1E\':0,\'3X\':0,\'4K\':0});8(7.1u){A.Z().1Q(I(){F m=2o($(1h).16(7.d[\'1E\']));8(2p(m))m=0;$(1h).1q(\'1S\',m)})}};A.5H=I(){A.4M();A.13(L(\'4N\',H),I(e,a){e.1f();8(!C.1Z){8(7.T.Y){7.T.Y.2R(2q(\'47\',H))}}C.1Z=M;8(7.T.1H){7.T.1H=O;A.X(L(\'2S\',H),a)}J M});A.13(L(\'4O\',H),I(e){e.1f();8(C.1T){3C(R)}J M});A.13(L(\'2S\',H),I(e,a,b){e.1f();1F=3h(1F);8(a&&C.1T){R.1Z=M;F c=2x()-R.2T;R.1k-=c;8(R.1o)R.1o.1k-=c;8(R.1R)R.1R.1k-=c;3C(R,O)}8(!C.1X&&!C.1T){8(b)1F.3D+=2x()-1F.2T}8(!C.1X){8(7.T.Y){7.T.Y.2R(2q(\'5I\',H))}}C.1X=M;8(7.T.5J){F d=7.T.3f-1F.3D,3E=3F-1K.2v(d*3F/7.T.3f);7.T.5J.1z($19,3E,d)}J M});A.13(L(\'1H\',H),I(e,b,c,d){e.1f();1F=3h(1F);F v=[b,c,d],t=[\'1l\',\'14\',\'1r\'],a=2U(v,t);F b=a[0],c=a[1],d=a[2];8(b!=\'17\'&&b!=\'1a\')b=C.2k;8(K c!=\'14\')c=0;8(K d!=\'1r\')d=O;8(d){C.1Z=O;7.T.1H=M}8(!7.T.1H){e.20();J 1c(H,\'3g 47: 28 2V.\')}8(C.1X){8(7.T.Y){7.T.Y.2y(2q(\'47\',H));7.T.Y.2y(2q(\'5I\',H))}}C.1X=O;1F.2T=2x();F f=7.T.3f+c;3G=f-1F.3D;3E=3F-1K.2v(3G*3F/f);1F.T=6M(I(){8(7.T.5K){7.T.5K.1z($19,3E,3G)}8(C.1T){A.X(L(\'1H\',H),b)}Q{A.X(L(b,H),7.T)}},3G);8(7.T.5L){7.T.5L.1z($19,3E,3G)}J M});A.13(L(\'2W\',H),I(e){e.1f();8(R.1Z){R.1Z=O;C.1X=O;C.1T=M;R.2T=2x();2a(R)}Q{A.X(L(\'1H\',H))}J M});A.13(L(\'17\',H)+\' \'+L(\'1a\',H),I(e,b,f,g){e.1f();8(C.1Z||A.1W(\':2O\')){e.20();J 1c(H,\'3g 47 6N 2O: 28 2V.\')}8(7.G.3d>=N.U){e.20();J 1c(H,\'28 5M G (\'+N.U+\', \'+7.G.3d+\' 5N): 28 2V.\')}F v=[b,f,g],t=[\'1j\',\'14/1l\',\'I\'],a=2U(v,t);F b=a[0],f=a[1],g=a[2];F h=e.4P.1d(H.3i.3H.W);8(K b!=\'1j\'||b==2b)b=7[h];8(K g==\'I\')b.21=g;8(K f!=\'14\'){8(7.G.1v!=\'*\'){f=\'P\'}Q{F i=[f,b.G,7[h].G];1m(F a=0,l=i.W;a<l;a++){8(K i[a]==\'14\'||i[a]==\'5O\'||i[a]==\'P\'){f=i[a];18}}}1x(f){V\'5O\':e.20();J A.1A(h+\'6O\',[b,g]);18;V\'P\':8(!7.G.12.1e&&7.G.1v==\'*\'){f=7.G.P}18}}8(R.1Z){A.X(L(\'2W\',H));A.X(L(\'3j\',H),[h,[b,f,g]]);e.20();J 1c(H,\'3g 6P 2V.\')}8(b.1k>0){8(C.1T){8(b.3j)A.X(L(\'3j\',H),[h,[b,f,g]]);e.20();J 1c(H,\'3g 6Q 2V.\')}}8(b.4Q&&!b.4Q.1z($19)){e.20();J 1c(H,\'6R "4Q" 6S O.\')}1F.3D=0;A.X(\'5P\'+h,[b,f]);8(7.29){F s=7.29,c=[b,f];1m(F j=0,l=s.W;j<l;j++){F d=h;8(!s[j][1])c[0]=s[j][0].1A(\'5Q\',h);8(!s[j][2])d=(d==\'17\')?\'1a\':\'17\';c[1]=f+s[j][3];s[j][0].X(\'5P\'+d,c)}}J M});A.13(L(\'6T\',H,O),I(e,f,g){e.1f();F h=A.Z();8(!7.1L){8(N.11==0){8(7.3k){A.X(L(\'1a\',H),N.U-1)}J e.20()}}8(7.1u)1M(h,7);8(K g!=\'14\'){8(7.G.12.1e){g=48(h,7,N.U-1)}Q 8(7.G.1v!=\'*\'){F i=(K f.G==\'14\')?f.G:4R(A,7);g=5R(h,7,N.U-1,i)}Q{g=7.G.P}g=4a(g,7,f.G,$19)}8(!7.1L){8(N.U-g<N.11){g=N.U-N.11}}7.G.12.2m=7.G.P;8(7.G.12.1e){F j=2P(h,7,N.U-g);8(7.G.P+g<=j&&g<N.U){g++;j=2P(h,7,N.U-g)}7.G.P=2Q(j,7,7.G.12.2l,$19)}Q 8(7.G.1v!=\'*\'){F j=3z(h,7,N.U-g);7.G.P=2Q(j,7,7.G.12.2l,$19)}8(7.1u)1M(h,7,M);8(g==0){e.20();J 1c(H,\'0 G 3u 1n: 28 2V.\')}1c(H,\'5S \'+g+\' G 4G.\');N.11+=g;22(N.11>=N.U){N.11-=N.U}8(!7.1L){8(N.11==0&&f.4b)f.4b.1z($19);8(!7.3k)2X(7,N.11,H)}A.Z().1d(N.U-g,N.U).6U(A);8(N.U<7.G.P+g){A.Z().1d(0,(7.G.P+g)-N.U).4c(M).3I(A)}F h=A.Z(),2r=5T(h,7,g),1U=5U(h,7),2c=h.1N(g-1),2d=2r.2Y(),2z=1U.2Y();8(7.1u)1M(h,7);8(7.1C){F p=42(1U,7),k=p[0],2s=p[1]}Q{F k=0,2s=0}F l=(k<0)?7.1i[7.d[3]]:0;8(f.1I==\'5V\'&&7.G.P<g){F m=h.1d(7.G.12.2m,g),4d=7.G[7.d[\'S\']];m.1Q(I(){F a=$(1h);a.1q(\'4e\',a.1W(\':2O\')).3a()});7.G[7.d[\'S\']]=\'1e\'}Q{F m=O}F n=3l(h.1d(0,g),7,\'S\'),2e=4f(2A(1U,7,M),7,!7.1u);8(m)7.G[7.d[\'S\']]=4d;8(7.1u){1M(h,7,M);8(2s>=0){1M(2d,7,7.1i[7.d[1]])}1M(2c,7,7.1i[7.d[3]])}8(7.1C){7.1i[7.d[1]]=2s;7.1i[7.d[3]]=k}F o={},1w=f.1k;8(f.1I==\'46\')1w=0;Q 8(1w==\'T\')1w=7.1n.1k/7.1n.G*g;Q 8(1w<=0)1w=0;Q 8(1w<10)1w=n/1w;R=23(1w,f.1G);8(7[7.d[\'S\']]==\'1e\'||7[7.d[\'1s\']]==\'1e\'){R.1g.1p([$1B,2e])}8(7.1u){F q=7.1i[7.d[3]];8(2z.4S(2c).W){F r={};r[7.d[\'1E\']]=2c.1q(\'1S\');8(k<0)2c.16(r);Q R.1g.1p([2c,r])}8(2z.4S(2d).W){F s={};s[7.d[\'1E\']]=2d.1q(\'1S\');R.1g.1p([2d,s])}8(2s>=0){F t={};t[7.d[\'1E\']]=2z.1q(\'1S\')+7.1i[7.d[1]];R.1g.1p([2z,t])}}Q{F q=0}o[7.d[\'1t\']]=q;F u=[2r,1U,2e,1w];8(f.2f)f.2f.3J($19,u);1Y.2f=3K(1Y.2f,$19,u);1x(f.1I){V\'2B\':V\'2g\':V\'2C\':V\'2h\':R.1o=23(R.1k,R.1G);R.1R=23(R.1k,R.1G);R.1k=0;18}1x(f.1I){V\'2g\':V\'2C\':V\'2h\':F v=A.4c().3I($1B);18}1x(f.1I){V\'2h\':v.Z().1d(0,g).1O();V\'2g\':V\'2C\':v.Z().1d(7.G.P).1O();18}1x(f.1I){V\'2B\':R.1o.1g.1p([A,{\'2i\':0}]);18;V\'2g\':v.16({\'2i\':0});R.1o.1g.1p([A,{\'S\':\'+=0\'},I(){v.1O()}]);R.1R.1g.1p([v,{\'2i\':1}]);18;V\'2C\':R=4T(R,A,v,7,M);18;V\'2h\':R=4U(R,A,v,7,M,g);18}F w=I(){F b=7.G.P+g-N.U;8(b>0){A.Z().1d(N.U).1O();2r=$(A.Z().1d(N.U-(7.G.P-b)).4g().5W(A.Z().1d(0,b).4g()))}8(m){m.1Q(I(){F a=$(1h);8(!a.1q(\'4e\'))a.3b()})}8(7.1u){F c=A.Z().1N(7.G.P+g-1);c.16(7.d[\'1E\'],c.1q(\'1S\'))}R.1g=[];8(R.1o)R.1o=23(R.4V,R.1G);F d=I(){1x(f.1I){V\'2B\':V\'2g\':A.16(\'1v\',\'\');18}R.1R=23(0,2b);C.1T=O;F a=[2r,1U,2e];8(f.21)f.21.3J($19,a);1Y.21=3K(1Y.21,$19,a);8(1V.W){A.X(L(1V[0][0],H),1V[0][1]);1V.5X()}8(!C.1X)A.X(L(\'1H\',H))};1x(f.1I){V\'2B\':R.1o.1g.1p([A,{\'2i\':1},d]);2a(R.1o);18;V\'2h\':R.1o.1g.1p([A,{\'S\':\'+=0\'},d]);2a(R.1o);18;2w:d();18}};R.1g.1p([A,o,w]);C.1T=M;A.16(7.d[\'1t\'],-(n-l));1F=3h(1F);2a(R);4W(7.2n,A.1A(L(\'3L\',H)));A.X(L(\'2D\',H),[O,2e]);J M});A.13(L(\'6V\',H,O),I(e,f,g){e.1f();F h=A.Z();8(!7.1L){8(N.11==7.G.P){8(7.3k){A.X(L(\'17\',H),N.U-1)}J e.20()}}8(7.1u)1M(h,7);8(K g!=\'14\'){8(7.G.1v!=\'*\'){F i=(K f.G==\'14\')?f.G:4R(A,7);g=5Y(h,7,0,i)}Q{g=7.G.P}g=4a(g,7,f.G,$19)}F j=(N.11==0)?N.U:N.11;8(!7.1L){8(7.G.12.1e){F k=2P(h,7,g),i=48(h,7,j-1)}Q{F k=7.G.P,i=7.G.P}8(g+k>j){g=j-i}}7.G.12.2m=7.G.P;8(7.G.12.1e){F k=4X(h,7,g,j);22(7.G.P-g>=k&&g<N.U){g++;k=4X(h,7,g,j)}7.G.P=2Q(k,7,7.G.12.2l,$19)}Q 8(7.G.1v!=\'*\'){F k=3z(h,7,g);7.G.P=2Q(k,7,7.G.12.2l,$19)}8(7.1u)1M(h,7,M);8(g==0){e.20();J 1c(H,\'0 G 3u 1n: 28 2V.\')}1c(H,\'5S \'+g+\' G 5D.\');N.11-=g;22(N.11<0){N.11+=N.U}8(!7.1L){8(N.11==7.G.P&&f.4b)f.4b.1z($19);8(!7.3k)2X(7,N.11,H)}8(N.U<7.G.P+g){A.Z().1d(0,(7.G.P+g)-N.U).4c(M).3I(A)}F h=A.Z(),2r=4Y(h,7),1U=4Z(h,7,g),2c=h.1N(g-1),2d=2r.2Y(),2z=1U.2Y();8(7.1u)1M(h,7);8(7.1C){F p=42(1U,7),l=p[0],2s=p[1]}Q{F l=0,2s=0}8(f.1I==\'5V\'&&7.G.12.2m<g){F m=h.1d(7.G.12.2m,g),4d=7.G[7.d[\'S\']];m.1Q(I(){F a=$(1h);a.1q(\'4e\',a.1W(\':2O\')).3a()});7.G[7.d[\'S\']]=\'1e\'}Q{F m=O}F n=3l(h.1d(0,g),7,\'S\'),2e=4f(2A(1U,7,M),7,!7.1u);8(m)7.G[7.d[\'S\']]=4d;8(7.1C){8(7.1i[7.d[1]]<0){7.1i[7.d[1]]=0}}8(7.1u){1M(h,7,M);1M(2d,7,7.1i[7.d[1]])}8(7.1C){7.1i[7.d[1]]=2s;7.1i[7.d[3]]=l}F o={},1w=f.1k;8(f.1I==\'46\')1w=0;Q 8(1w==\'T\')1w=7.1n.1k/7.1n.G*g;Q 8(1w<=0)1w=0;Q 8(1w<10)1w=n/1w;R=23(1w,f.1G);8(7[7.d[\'S\']]==\'1e\'||7[7.d[\'1s\']]==\'1e\'){R.1g.1p([$1B,2e])}8(7.1u){F q=2z.1q(\'1S\');8(2s>=0){q+=7.1i[7.d[1]]}2z.16(7.d[\'1E\'],q);8(2c.4S(2d).W){F r={};r[7.d[\'1E\']]=2d.1q(\'1S\');R.1g.1p([2d,r])}F s=2c.1q(\'1S\');8(l>=0){s+=7.1i[7.d[3]]}F t={};t[7.d[\'1E\']]=s;R.1g.1p([2c,t])}o[7.d[\'1t\']]=-n;8(l<0){o[7.d[\'1t\']]+=l}F u=[2r,1U,2e,1w];8(f.2f)f.2f.3J($19,u);1Y.2f=3K(1Y.2f,$19,u);1x(f.1I){V\'2B\':V\'2g\':V\'2C\':V\'2h\':R.1o=23(R.1k,R.1G);R.1R=23(R.1k,R.1G);R.1k=0;18}1x(f.1I){V\'2g\':V\'2C\':V\'2h\':F v=A.4c().3I($1B);18}1x(f.1I){V\'2h\':v.Z().1d(7.G.12.2m).1O();18;V\'2g\':V\'2C\':v.Z().1d(0,g).1O();v.Z().1d(7.G.P).1O();18}1x(f.1I){V\'2B\':R.1o.1g.1p([A,{\'2i\':0}]);18;V\'2g\':v.16({\'2i\':0});R.1o.1g.1p([A,{\'S\':\'+=0\'},I(){v.1O()}]);R.1R.1g.1p([v,{\'2i\':1}]);18;V\'2C\':R=4T(R,A,v,7,O);18;V\'2h\':R=4U(R,A,v,7,O,g);18}F w=I(){F b=7.G.P+g-N.U,5Z=(7.1u)?7.1i[7.d[3]]:0;A.16(7.d[\'1t\'],5Z);8(b>0){A.Z().1d(N.U).1O()}F c=A.Z().1d(0,g).3I(A).2Y();8(b>0){1U=3c(h,7)}8(m){m.1Q(I(){F a=$(1h);8(!a.1q(\'4e\'))a.3b()})}8(7.1u){8(N.U<7.G.P+g){F d=A.Z().1N(7.G.P-1);d.16(7.d[\'1E\'],d.1q(\'1S\')+7.1i[7.d[3]])}c.16(7.d[\'1E\'],c.1q(\'1S\'))}R.1g=[];8(R.1o)R.1o=23(R.4V,R.1G);F e=I(){1x(f.1I){V\'2B\':V\'2g\':A.16(\'1v\',\'\');18}R.1R=23(0,2b);C.1T=O;F a=[2r,1U,2e];8(f.21)f.21.3J($19,a);1Y.21=3K(1Y.21,$19,a);8(1V.W){A.X(L(1V[0][0],H),1V[0][1]);1V.5X()}8(!C.1X)A.X(L(\'1H\',H))};1x(f.1I){V\'2B\':R.1o.1g.1p([A,{\'2i\':1},e]);2a(R.1o);18;V\'2h\':R.1o.1g.1p([A,{\'S\':\'+=0\'},e]);2a(R.1o);18;2w:e();18}};R.1g.1p([A,o,w]);C.1T=M;1F=3h(1F);2a(R);4W(7.2n,A.1A(L(\'3L\',H)));A.X(L(\'2D\',H),[O,2e]);J M});A.13(L(\'2Z\',H),I(e,b,c,d,f,g,h){e.1f();F v=[b,c,d,f,g,h],t=[\'1l/14/1j\',\'14\',\'1r\',\'1j\',\'1l\',\'I\'],a=2U(v,t);F f=a[3],g=a[4],h=a[5];b=3m(a[0],a[1],a[2],N,A);8(b==0)J;8(K f!=\'1j\')f=O;8(C.1T){8(K f!=\'1j\'||f.1k>0)J O}8(g!=\'17\'&&g!=\'1a\'){8(7.1L){8(b<=N.U/2)g=\'1a\';Q g=\'17\'}Q{8(N.11==0||N.11>b)g=\'1a\';Q g=\'17\'}}8(g==\'17\')b=N.U-b;A.X(L(g,H),[f,b,h]);J M});A.13(L(\'6W\',H),I(e,a,b){e.1f();F c=A.1A(L(\'3M\',H));J A.1A(L(\'51\',H),[c-1,a,\'17\',b])});A.13(L(\'6X\',H),I(e,a,b){e.1f();F c=A.1A(L(\'3M\',H));J A.1A(L(\'51\',H),[c+1,a,\'1a\',b])});A.13(L(\'51\',H),I(e,a,b,c,d){e.1f();8(K a!=\'14\')a=A.1A(L(\'3M\',H));F f=7.1b.G||7.G.P,27=1K.2v(N.U/f)-1;8(a<0)a=27;8(a>27)a=0;J A.1A(L(\'2Z\',H),[a*f,0,M,b,c,d])});A.13(L(\'60\',H),I(e,s){e.1f();8(s)s=3m(s,0,M,N,A);Q s=0;s+=N.11;8(s!=0){22(s>N.U)s-=N.U;A.6Y(A.Z().1d(s,N.U))}J M});A.13(L(\'29\',H),I(e,s){e.1f();8(s)s=4E(s);Q 8(7.29)s=7.29;Q J 1c(H,\'5q 6Z 3u 29.\');F n=A.1A(L(\'3L\',H)),x=M;1m(F j=0,l=s.W;j<l;j++){8(!s[j][0].1A(L(\'2Z\',H),[n,s[j][3],M])){x=O}}J x});A.13(L(\'3j\',H),I(e,a,b){e.1f();8(K a==\'I\'){a.1z($19,1V)}Q 8(31(a)){1V=a}Q 8(K a!=\'1y\'){1V.1p([a,b])}J 1V});A.13(L(\'70\',H),I(e,b,c,d,f){e.1f();F v=[b,c,d,f],t=[\'1l/1j\',\'1l/14/1j\',\'1r\',\'14\'],a=2U(v,t);F b=a[0],c=a[1],d=a[2],f=a[3];8(K b==\'1j\'&&K b.3n==\'1y\')b=$(b);8(K b==\'1l\')b=$(b);8(K b!=\'1j\'||K b.3n==\'1y\'||b.W==0)J 1c(H,\'28 a 4w 1j.\');8(K c==\'1y\')c=\'4h\';8(7.1u){b.1Q(I(){F m=2o($(1h).16(7.d[\'1E\']));8(2p(m))m=0;$(1h).1q(\'1S\',m)})}F g=c,3N=\'3N\';8(c==\'4h\'){8(d){8(N.11==0){c=N.U-1;3N=\'61\'}Q{c=N.11;N.11+=b.W}8(c<0)c=0}Q{c=N.U-1;3N=\'61\'}}Q{c=3m(c,f,d,N,A)}8(g!=\'4h\'&&!d){8(c<N.11)N.11+=b.W}8(N.11>=N.U)N.11-=N.U;F h=A.Z().1N(c);8(h.W){h[3N](b)}Q{A.62(b)}N.U=A.Z().W;F i=A.1A(\'52\');3O(7,N.U,H);2X(7,N.11,H);A.X(L(\'53\',H));A.X(L(\'2D\',H),[M,i]);J M});A.13(L(\'71\',H),I(e,b,c,d){e.1f();F v=[b,c,d],t=[\'1l/14/1j\',\'1r\',\'14\'],a=2U(v,t);F b=a[0],c=a[1],d=a[2];8(K b==\'1y\'||b==\'4h\'){A.Z().2Y().1O()}Q{b=3m(b,d,c,N,A);F f=A.Z().1N(b);8(f.W){8(b<N.11)N.11-=f.W;f.1O()}}N.U=A.Z().W;F g=A.1A(\'52\');3O(7,N.U,H);2X(7,N.11,H);A.X(L(\'2D\',H),[M,g]);J M});A.13(L(\'2f\',H)+\' \'+L(\'21\',H),I(e,a){e.1f();F b=e.4P.1d(H.3i.3H.W);8(31(a))1Y[b]=a;8(K a==\'I\')1Y[b].1p(a);J 1Y[b]});A.13(L(\'5r\',H,O),I(e,a){e.1f();J A.1A(L(\'3L\',H),a)});A.13(L(\'3L\',H),I(e,a){e.1f();8(N.11==0)F b=0;Q F b=N.U-N.11;8(K a==\'I\')a.1z($19,b);J b});A.13(L(\'3M\',H),I(e,a){e.1f();F b=7.1b.G||7.G.P;F c=1K.2v(N.U/b-1);8(N.11==0)F d=0;Q 8(N.11<N.U%b)F d=0;Q 8(N.11==b&&!7.1L)F d=c;Q F d=1K.72((N.U-N.11)/b);8(d<0)d=0;8(d>c)d=c;8(K a==\'I\')a.1z($19,d);J d});A.13(L(\'73\',H),I(e,a){e.1f();$i=3c(A.Z(),7);8(K a==\'I\')a.1z($19,$i);J $i});A.13(L(\'1d\',H),I(e,f,l,b){e.1f();F v=[f,l,b],t=[\'14\',\'14\',\'I\'],a=2U(v,t);f=(K a[0]==\'14\')?a[0]:0,l=(K a[1]==\'14\')?a[1]:N.U,b=a[2];f+=N.11;l+=N.11;22(f>N.U){f-=N.U}22(l>N.U){l-=N.U}22(f<0){f+=N.U}22(l<0){l+=N.U}F c=A.Z();8(l>f){F d=c.1d(f,l)}Q{F d=$(c.1d(f,N.U).4g().5W(c.1d(0,l).4g()))}8(K b==\'I\')b.1z($19,d);J d});A.13(L(\'1X\',H)+\' \'+L(\'1Z\',H)+\' \'+L(\'1T\',H),I(e,a){e.1f();F b=e.4P.1d(H.3i.3H.W);8(K a==\'I\')a.1z($19,C[b]);J C[b]});A.13(L(\'5Q\',H,O),I(e,a,b,c){e.1f();J A.1A(L(\'4r\',H),[a,b,c])});A.13(L(\'4r\',H),I(e,a,b,c){e.1f();F d=O;8(K a==\'I\'){a.1z($19,7)}Q 8(K a==\'1j\'){2u=$.25(M,{},2u,a);8(b!==O)d=M;Q 7=$.25(M,{},7,a)}Q 8(K a!=\'1y\'){8(K b==\'I\'){F f=4i(\'7.\'+a);8(K f==\'1y\')f=\'\';b.1z($19,f)}Q 8(K b!=\'1y\'){8(K c!==\'1r\')c=M;4i(\'2u.\'+a+\' = b\');8(c!==O)d=M;Q 4i(\'7.\'+a+\' = b\')}Q{J 4i(\'7.\'+a)}}8(d){1M(A.Z(),7);A.3V(2u);A.54();F g=3P(A,7,O);A.X(L(\'2D\',H),[M,g])}J 7});A.13(L(\'53\',H),I(e,a,b){e.1f();8(K a==\'1y\'||a.W==0)a=$(\'74\');Q 8(K a==\'1l\')a=$(a);8(K a!=\'1j\')J 1c(H,\'28 a 4w 1j.\');8(K b!=\'1l\'||b.W==0)b=\'a.63\';a.75(b).1Q(I(){F h=1h.64||\'\';8(h.W>0&&A.Z().65($(h))!=-1){$(1h).24(\'55\').55(I(e){e.2j();A.X(L(\'2Z\',H),h)})}});J M});A.13(L(\'2D\',H),I(e,b,c){e.1f();8(!7.1b.1D)J;8(b){F d=7.1b.G||7.G.P,l=1K.2v(N.U/d);8(7.1b.3e){7.1b.1D.Z().1O();7.1b.1D.1Q(I(){1m(F a=0;a<l;a++){F i=A.Z().1N(3m(a*d,0,M,N,A));$(1h).62(7.1b.3e(a+1,i))}})}7.1b.1D.1Q(I(){$(1h).Z().24(7.1b.3o).1Q(I(a){$(1h).13(7.1b.3o,I(e){e.2j();A.X(L(\'2Z\',H),[a*d,0,M,7.1b])})})})}7.1b.1D.1Q(I(){$(1h).Z().2y(2q(\'66\',H)).1N(A.1A(L(\'3M\',H))).2R(2q(\'66\',H))});J M});A.13(L(\'52\',H),I(e){F a=A.Z(),3Q=7.G.P;8(7.G.12.1e)3Q=2P(a,7,0);Q 8(7.G.1v!=\'*\')3Q=3z(a,7,0);8(!7.1L&&N.11!=0&&3Q>N.11){8(7.G.12.1e){F b=48(a,7,N.11)-N.11}Q 8(7.G.1v!=\'*\'){F b=68(a,7,N.11)-N.11}Q{b=7.G.P-N.11}1c(H,\'76 77-1L: 78 \'+b+\' G 4G.\');A.X(\'17\',b)}7.G.P=2Q(3Q,7,7.G.12.2l,$19);J 3P(A,7)});A.13(L(\'5s\',H,O),I(e,a){e.1f();A.X(L(\'69\',H),a);J M});A.13(L(\'69\',H),I(e,a){e.1f();1F=3h(1F);A.1q(\'4q\',O);A.X(L(\'4O\',H));8(a){A.X(L(\'60\',H))}8(7.1u){1M(A.Z(),7)}A.16(A.1q(\'5G\'));A.4M();A.56();$1B.79(A);J M})};A.4M=I(){A.24(L(\'\',H));A.24(L(\'\',H,O))};A.54=I(){A.56();3O(7,N.U,H);2X(7,N.11,H);8(7.T.2t){F c=3p(7.T.2t);$1B.13(L(\'4j\',H,O),I(){A.X(L(\'2S\',H),c)}).13(L(\'4k\',H,O),I(){A.X(L(\'2W\',H))})}8(7.T.Y){7.T.Y.13(L(7.T.3o,H,O),I(e){e.2j();F a=O,c=2b;8(C.1X){a=\'1H\'}Q 8(7.T.44){a=\'2S\';c=3p(7.T.44)}8(a){A.X(L(a,H),c)}})}8(7.17.Y){7.17.Y.13(L(7.17.3o,H,O),I(e){e.2j();A.X(L(\'17\',H))});8(7.17.2t){F c=3p(7.17.2t);7.17.Y.13(L(\'4j\',H,O),I(){A.X(L(\'2S\',H),c)}).13(L(\'4k\',H,O),I(){A.X(L(\'2W\',H))})}}8(7.1a.Y){7.1a.Y.13(L(7.1a.3o,H,O),I(e){e.2j();A.X(L(\'1a\',H))});8(7.1a.2t){F c=3p(7.1a.2t);7.1a.Y.13(L(\'4j\',H,O),I(){A.X(L(\'2S\',H),c)}).13(L(\'4k\',H,O),I(){A.X(L(\'2W\',H))})}}8($.1P.2E){8(7.17.2E){8(!C.57){C.57=M;$1B.2E(I(e,a){8(a>0){e.2j();F b=59(7.17.2E);A.X(L(\'17\',H),b)}})}}8(7.1a.2E){8(!C.5a){C.5a=M;$1B.2E(I(e,a){8(a<0){e.2j();F b=59(7.1a.2E);A.X(L(\'1a\',H),b)}})}}}8($.1P.3R){F d=(7.17.5b)?I(){A.X(L(\'17\',H))}:2b,3S=(7.1a.5b)?I(){A.X(L(\'1a\',H))}:2b;8(3S||3S){8(!C.3R){C.3R=M;F f={\'7a\':30,\'7b\':30,\'7c\':M};1x(7.2k){V\'4u\':V\'6a\':f.7d=d;f.7e=3S;18;2w:f.7f=3S;f.7g=d}$1B.3R(f)}}}8(7.1b.1D){8(7.1b.2t){F c=3p(7.1b.2t);7.1b.1D.13(L(\'4j\',H,O),I(){A.X(L(\'2S\',H),c)}).13(L(\'4k\',H,O),I(){A.X(L(\'2W\',H))})}}8(7.17.2F||7.1a.2F){$(3T).13(L(\'6b\',H,O,M,M),I(e){F k=e.6c;8(k==7.1a.2F){e.2j();A.X(L(\'1a\',H))}8(k==7.17.2F){e.2j();A.X(L(\'17\',H))}})}8(7.1b.43){$(3T).13(L(\'6b\',H,O,M,M),I(e){F k=e.6c;8(k>=49&&k<58){k=(k-49)*7.G.P;8(k<=N.U){e.2j();A.X(L(\'2Z\',H),[k,0,M,7.1b])}}})}8(7.T.1H){A.X(L(\'1H\',H),7.T.4C)}8(C.4t){$(3q).13(L(\'7h\',H,O,M,M),I(e){A.X(L(\'4O\',H));8(7.T.4D&&!C.1X){A.X(L(\'1H\',H))}1M(A.Z(),7);A.3V(2u);F a=3P(A,7,O);A.X(L(\'2D\',H),[M,a])})}};A.56=I(){F a=L(\'\',H),3r=L(\'\',H,O);5c=L(\'\',H,O,M,M);$(3T).24(5c);$(3q).24(5c);$1B.24(3r);8(7.T.Y)7.T.Y.24(3r);8(7.17.Y)7.17.Y.24(3r);8(7.1a.Y)7.1a.Y.24(3r);8(7.1b.1D){7.1b.1D.24(3r);8(7.1b.3e){7.1b.1D.Z().1O()}}3O(7,\'3a\',H);2X(7,\'2y\',H)};F C={\'2k\':\'1a\',\'1X\':M,\'1T\':O,\'1Z\':O,\'5a\':O,\'57\':O,\'3R\':O},N={\'U\':A.Z().W,\'11\':0},1F={\'7i\':2b,\'T\':2b,\'3j\':2b,\'2T\':2x(),\'3D\':0},R={\'1Z\':O,\'1k\':0,\'2T\':0,\'1G\':\'\',\'1g\':[]},1Y={\'2f\':[],\'21\':[]},1V=[],H=$.25(M,{},$.1P.1J.6d,z),7={},2u=y,$1B=A.7j(\'<\'+H.5d.4p+\' 7k="\'+H.5d.6e+\'" />\').36();H.3U=A.3U;H.4l=$.1P.1J.4l++;A.3V(2u,M,B);A.5E();A.5H();A.54();8(31(7.G.2I)){F D=7.G.2I}Q{F D=[];8(7.G.2I!=0){D.1p(7.G.2I)}}8(7.2n){D.7l(6f(7.2n))}8(D.W>0){1m(F a=0,l=D.W;a<l;a++){F s=D[a];8(s==0){5e}8(s===M){s=3q.7m.64;8(s.W<1){5e}}Q 8(s===\'6g\'){s=1K.3w(1K.6g()*N.U)}8(A.1A(L(\'2Z\',H),[s,0,M,{1I:\'46\'}])){18}}}F E=3P(A,7,O),6h=3c(A.Z(),7);8(7.6i){7.6i.1z($19,6h,E)}A.X(L(\'2D\',H),[M,E]);A.X(L(\'53\',H));J A};$.1P.1J.4l=1;$.1P.1J.4s={\'29\':O,\'3k\':M,\'1L\':M,\'2J\':O,\'2k\':\'1t\',\'G\':{\'2I\':0},\'1n\':{\'1G\':\'7n\',\'1k\':5A,\'2t\':O,\'2E\':O,\'5b\':O,\'3o\':\'55\',\'3j\':O}};$.1P.1J.6d={\'1c\':O,\'3i\':{\'3H\':\'\',\'6j\':\'7o\'},\'5d\':{\'4p\':\'7p\',\'6e\':\'7q\'},\'5f\':{}};$.1P.1J.5B=I(a,b){J\'<a 7r="#"><6k>\'+a+\'</6k></a>\'};I 23(d,e){J{1g:[],1k:d,4V:d,1G:e,2T:2x()}}I 2a(s){8(K s.1o==\'1j\'){2a(s.1o)}1m(F a=0,l=s.1g.W;a<l;a++){F b=s.1g[a];8(!b)5e;8(b[3])b[0].4N();b[0].6l(b[1],{6m:b[2],1k:s.1k,1G:s.1G})}8(K s.1R==\'1j\'){2a(s.1R)}}I 3C(s,c){8(K c!=\'1r\')c=M;8(K s.1o==\'1j\'){3C(s.1o,c)}1m(F a=0,l=s.1g.W;a<l;a++){F b=s.1g[a];b[0].4N(M);8(c){b[0].16(b[1]);8(K b[2]==\'I\')b[2]()}}8(K s.1R==\'1j\'){3C(s.1R,c)}}I 3h(t){8(t.T)7s(t.T);J t}I 3K(b,t,c){8(b.W){1m(F a=0,l=b.W;a<l;a++){b[a].3J(t,c)}}J[]}I 7t(a,c,x,d,f){F o={\'1k\':d,\'1G\':a.1G};8(K f==\'I\')o.6m=f;c.6l({2i:x},o)}I 4T(a,b,c,o,d){F e=2A(4Y(b.Z(),o),o,M)[0],5g=2A(c.Z(),o,M)[0],4m=(d)?-5g:e,2G={},3s={};2G[o.d[\'S\']]=5g;2G[o.d[\'1t\']]=4m;3s[o.d[\'1t\']]=0;a.1o.1g.1p([b,{\'2i\':1}]);a.1R.1g.1p([c,3s,I(){$(1h).1O()}]);c.16(2G);J a}I 4U(a,b,c,o,d,n){F e=2A(4Z(b.Z(),o,n),o,M)[0],5h=2A(c.Z(),o,M)[0],4m=(d)?-5h:e,2G={},3s={};2G[o.d[\'S\']]=5h;2G[o.d[\'1t\']]=0;3s[o.d[\'1t\']]=4m;a.1R.1g.1p([c,3s,I(){$(1h).1O()}]);c.16(2G);J a}I 3O(o,t,c){8(t==\'3b\'||t==\'3a\'){F f=t}Q 8(o.G.3d>=t){1c(c,\'28 5M G: 7u 7v (\'+t+\' G, \'+o.G.3d+\' 5N).\');F f=\'3a\'}Q{F f=\'3b\'}F s=(f==\'3b\')?\'2y\':\'2R\',h=2q(\'2O\',c);8(o.T.Y)o.T.Y[f]()[s](h);8(o.17.Y)o.17.Y[f]()[s](h);8(o.1a.Y)o.1a.Y[f]()[s](h);8(o.1b.1D)o.1b.1D[f]()[s](h)}I 2X(o,f,c){8(o.1L||o.3k)J;F a=(f==\'2y\'||f==\'2R\')?f:O,4n=2q(\'7w\',c);8(o.T.Y&&a){o.T.Y[a](4n)}8(o.17.Y){F b=a||(f==0)?\'2R\':\'2y\';o.17.Y[b](4n)}8(o.1a.Y){F b=a||(f==o.G.P)?\'2R\':\'2y\';o.1a.Y[b](4n)}}I 3W(a,b){8(K b==\'I\')b=b.1z(a);8(K b==\'1y\')b={};J b}I 3A(a,b,c){8(K c!=\'1l\')c=\'\';b=3W(a,b);8(K b==\'1l\'){F d=5i(b);8(d==-1)b=$(b);Q b=d}8(c==\'1b\'){8(K b==\'1r\')b={\'43\':b};8(K b.3n!=\'1y\')b={\'1D\':b};8(K b.1D==\'I\')b.1D=b.1D.1z(a);8(K b.1D==\'1l\')b.1D=$(b.1D);8(K b.G!=\'14\')b.G=O}Q 8(c==\'T\'){8(K b.3n!=\'1y\')b={\'Y\':b};8(K b==\'1r\')b={\'1H\':b};8(K b==\'14\')b={\'3f\':b};8(K b.Y==\'I\')b.Y=b.Y.1z(a);8(K b.Y==\'1l\')b.Y=$(b.Y)}Q{8(K b.3n!=\'1y\')b={\'Y\':b};8(K b==\'14\')b={\'2F\':b};8(K b.Y==\'I\')b.Y=b.Y.1z(a);8(K b.Y==\'1l\')b.Y=$(b.Y);8(K b.2F==\'1l\')b.2F=5i(b.2F)}J b}I 3m(a,b,c,d,e){8(K a==\'1l\'){8(2p(a))a=$(a);Q a=2o(a)}8(K a==\'1j\'){8(K a.3n==\'1y\')a=$(a);a=e.Z().65(a);8(a==-1)a=0;8(K c!=\'1r\')c=O}Q{8(K c!=\'1r\')c=M}8(2p(a))a=0;Q a=2o(a);8(2p(b))b=0;Q b=2o(b);8(c){a+=d.11}a+=b;8(d.U>0){22(a>=d.U){a-=d.U}22(a<0){a+=d.U}}J a}I 48(i,o,s){F t=0,x=0;1m(F a=s;a>=0;a--){F j=i.1N(a);t+=(j.1W(\':P\'))?j[o.d[\'26\']](M):0;8(t>o.3y)J x;8(a==0)a=i.W;x++}}I 68(i,o,s){J 5j(i,o.G.1v,o.G.12.41,s)}I 5R(i,o,s,m){J 5j(i,o.G.1v,m,s)}I 5j(i,f,m,s){F t=0,x=0;1m(F a=s,l=i.W-1;a>=0;a--){x++;8(x==l)J x;F j=i.1N(a);8(j.1W(f)){t++;8(t==m)J x}8(a==0)a=i.W}}I 4R(a,o){J o.G.12.41||a.Z().1d(0,o.G.P).1v(o.G.1v).W}I 2P(i,o,s){F t=0,x=0;1m(F a=s,l=i.W-1;a<=l;a++){F j=i.1N(a);t+=(j.1W(\':P\'))?j[o.d[\'26\']](M):0;8(t>o.3y)J x;x++;8(x==l)J x;8(a==l)a=-1}}I 4X(i,o,s,l){F v=2P(i,o,s);8(!o.1L){8(s+v>l)v=l-s}J v}I 3z(i,o,s){J 5k(i,o.G.1v,o.G.12.41,s,o.1L)}I 5Y(i,o,s,m){J 5k(i,o.G.1v,m+1,s,o.1L)-1}I 5k(i,f,m,s,c){F t=0,x=0;1m(F a=s,l=i.W-1;a<=l;a++){x++;8(x==l)J x;F j=i.1N(a);8(j.1W(f)){t++;8(t==m)J x}8(a==l)a=-1}}I 3c(i,o){J i.1d(0,o.G.P)}I 5T(i,o,n){J i.1d(n,o.G.12.2m+n)}I 5U(i,o){J i.1d(0,o.G.P)}I 4Y(i,o){J i.1d(0,o.G.12.2m)}I 4Z(i,o,n){J i.1d(n,o.G.P+n)}I 1M(i,o,m){F x=(K m==\'1r\')?m:O;8(K m!=\'14\')m=0;i.1Q(I(){F j=$(1h);F t=2o(j.16(o.d[\'1E\']));8(2p(t))t=0;j.1q(\'6n\',t);j.16(o.d[\'1E\'],((x)?j.1q(\'6n\'):m+j.1q(\'1S\')))})}I 3P(a,o,p){F b=a.36(),$i=a.Z(),$v=3c($i,o),4o=4f(2A($v,o,M),o,p);b.16(4o);8(o.1u){F p=o.1i,r=p[o.d[1]];8(o.1C){8(r<0)r=0}F c=$v.2Y();c.16(o.d[\'1E\'],c.1q(\'1S\')+r);a.16(o.d[\'2L\'],p[o.d[0]]);a.16(o.d[\'1t\'],p[o.d[3]])}a.16(o.d[\'S\'],4o[o.d[\'S\']]+(3l($i,o,\'S\')*2));a.16(o.d[\'1s\'],5l($i,o,\'1s\'));J 4o}I 2A(i,o,a){F b=3l(i,o,\'S\',a),6o=5l(i,o,\'1s\',a);J[b,6o]}I 5l(i,o,a,b){8(K b!=\'1r\')b=O;8(K o[o.d[a]]==\'14\'&&b)J o[o.d[a]];8(K o.G[o.d[a]]==\'14\')J o.G[o.d[a]];F c=(a.5m().32(\'S\')>-1)?\'26\':\'2K\';J 3v(i,o,c)}I 3v(i,o,b){F s=0;1m(F a=0,l=i.W;a<l;a++){F j=i.1N(a);F m=(j.1W(\':P\'))?j[o.d[b]](M):0;8(s<m)s=m}J s}I 35(b,o,c){8(!b.1W(\':P\'))J 0;F d=b[o.d[c]](),5n=(o.d[c].5m().32(\'S\')>-1)?[\'7x\',\'7y\']:[\'7z\',\'7A\'];1m(F a=0,l=5n.W;a<l;a++){F m=2o(b.16(5n[a]));d-=(2p(m))?0:m}J d}I 3l(i,o,b,c){8(K c!=\'1r\')c=O;8(K o[o.d[b]]==\'14\'&&c)J o[o.d[b]];8(K o.G[o.d[b]]==\'14\')J o.G[o.d[b]]*i.W;F d=(b.5m().32(\'S\')>-1)?\'26\':\'2K\',s=0;1m(F a=0,l=i.W;a<l;a++){F j=i.1N(a);s+=(j.1W(\':P\'))?j[o.d[d]](M):0}J s}I 4v(i,o,b){F s=O,v=O;1m(F a=0,l=i.W;a<l;a++){F j=i.1N(a);F c=(j.1W(\':P\'))?j[o.d[b]](M):0;8(s===O)s=c;Q 8(s!=c)v=M;8(s==0)v=M}J v}I 5y(i,o,d){J i[o.d[\'7B\'+d]](M)-35(i,o,\'7C\'+d)}I 3Y(x){J(K x==\'1l\'&&x.1d(-1)==\'%\')}I 3Z(s,o){8(3Y(o)){o=o.1d(0,-1);8(2p(o))J s;s*=o/3F}J s}I L(n,c,a,b,d){8(K a!=\'1r\')a=M;8(K b!=\'1r\')b=M;8(K d!=\'1r\')d=O;8(a)n=c.3i.3H+n;8(b)n=n+\'.\'+c.3i.6j;8(b&&d)n+=c.4l;J n}I 2q(n,c){J(K c.5f[n]==\'1l\')?c.5f[n]:n}I 4f(a,o,p){8(K p!=\'1r\')p=M;F b=(o.1u&&p)?o.1i:[0,0,0,0];F c={};c[o.d[\'S\']]=a[0]+b[1]+b[3];c[o.d[\'1s\']]=a[1]+b[0]+b[2];J c}I 2U(c,d){F e=[];1m(F a=0,6p=c.W;a<6p;a++){1m(F b=0,6q=d.W;b<6q;b++){8(d[b].32(K c[a])>-1&&K e[b]==\'1y\'){e[b]=c[a];18}}}J e}I 5z(p){8(K p==\'1y\')J[0,0,0,0];8(K p==\'14\')J[p,p,p,p];Q 8(K p==\'1l\')p=p.3t(\'7D\').6r(\'\').3t(\'7E\').6r(\'\').3t(\' \');8(!31(p)){J[0,0,0,0]}1m(F i=0;i<4;i++){p[i]=2o(p[i])}1x(p.W){V 0:J[0,0,0,0];V 1:J[p[0],p[0],p[0],p[0]];V 2:J[p[0],p[1],p[0],p[1]];V 3:J[p[0],p[1],p[2],p[1]];2w:J[p[0],p[1],p[2],p[3]]}}I 42(a,o){F x=(K o[o.d[\'S\']]==\'14\')?1K.2v(o[o.d[\'S\']]-3l(a,o,\'S\')):0;1x(o.1C){V\'1t\':J[0,x];V\'2M\':J[x,0];V\'4x\':2w:J[1K.2v(x/2),1K.3w(x/2)]}}I 4a(x,o,a,b){F v=x;8(K a==\'I\'){v=a.1z(b,v)}Q 8(K a==\'1l\'){F p=a.3t(\'+\'),m=a.3t(\'-\');8(m.W>p.W){F c=M,5o=m[0],2H=m[1]}Q{F c=O,5o=p[0],2H=p[1]}1x(5o){V\'7F\':v=(x%2==1)?x-1:x;18;V\'7G\':v=(x%2==0)?x-1:x;18;2w:v=x;18}2H=2o(2H);8(!2p(2H)){8(c)2H=-2H;v+=2H}}8(K v!=\'14\')v=1;8(v<1)v=1;J v}I 2Q(x,o,a,b){J 4y(4a(x,o,a,b),o.G.12)}I 4y(v,i){8(K i.2N==\'14\'&&v<i.2N)v=i.2N;8(K i.27==\'14\'&&v>i.27)v=i.27;8(v<1)v=1;J v}I 4E(s){8(!31(s))s=[[s]];8(!31(s[0]))s=[s];1m(F j=0,l=s.W;j<l;j++){8(K s[j][0]==\'1l\')s[j][0]=$(s[j][0]);8(K s[j][1]!=\'1r\')s[j][1]=M;8(K s[j][2]!=\'1r\')s[j][2]=M;8(K s[j][3]!=\'14\')s[j][3]=0}J s}I 5i(k){8(k==\'2M\')J 39;8(k==\'1t\')J 37;8(k==\'4u\')J 38;8(k==\'6a\')J 40;J-1}I 4W(n,v){8(n)3T.2n=n+\'=\'+v+\'; 7H=/\'}I 6f(n){n+=\'=\';F b=3T.2n.3t(\';\');1m(F a=0,l=b.W;a<l;a++){F c=b[a];22(c.7I(0)==\' \'){c=c.1d(1)}8(c.32(n)==0){J c.1d(n.W)}}J 0}I 3p(p){8(p&&K p==\'1l\'){F i=(p.32(\'7J\')>-1)?M:O,r=(p.32(\'2W\')>-1)?M:O}Q{F i=r=O}J[i,r]}I 59(a){J(K a==\'14\')?a:2b}I 31(a){J K(a)==\'1j\'&&(a 7K 7L)}I 2x(){J 7M 7N().2x()}I 1c(d,m){8(K d==\'1j\'){F s=\' (\'+d.3U+\')\';d=d.1c}Q{F s=\'\'}8(!d)J O;8(K m==\'1l\')m=\'1J\'+s+\': \'+m;Q m=[\'1J\'+s+\':\',m];8(3q.5p&&3q.5p.6s)3q.5p.6s(m);J O}$.1P.63=I(o,c){J 1h.1J(o,c)};$.25($.1G,{\'7O\':I(t){F a=t*t;J t*(-a*t+4*a-6*t+4)},\'7P\':I(t){J t*(4*t*t-9*t+6)},\'7Q\':I(t){F a=t*t;J t*(33*a*a-7R*a*t+7S*a-67*t+15)}})})(7T);',62,490,'|||||||opts|if|||||||||||||||||||||||||||||||||var|items|conf|function|return|typeof|cf_e|true|itms|false|visible|else|scrl|width|auto|total|case|length|trigger|button|children||first|visibleConf|bind|number||css|prev|break|tt0|next|pagination|debug|slice|variable|stopPropagation|anims|this|padding|object|duration|string|for|scroll|pre|push|data|boolean|height|left|usePadding|filter|a_dur|switch|undefined|call|triggerHandler|wrp|align|container|marginRight|tmrs|easing|play|fx|carouFredSel|Math|circular|sz_resetMargin|eq|remove|fn|each|post|cfs_origCssMargin|isScrolling|c_new|queu|is|isPaused|clbk|isStopped|stopImmediatePropagation|onAfter|while|sc_setScroll|unbind|extend|outerWidth|max|Not|synchronise|sc_startScroll|null|l_cur|l_old|w_siz|onBefore|crossfade|uncover|opacity|preventDefault|direction|adjust|old|cookie|parseInt|isNaN|cf_c|c_old|pR|pauseOnHover|opts_orig|ceil|default|getTime|removeClass|l_new|ms_getSizes|fade|cover|updatePageStatus|mousewheel|key|css_o|adj|start|responsive|outerHeight|top|right|min|hidden|gn_getVisibleItemsNext|cf_getItemsAdjust|addClass|pause|startTime|cf_sortParams|scrolling|resume|nv_enableNavi|last|slideTo||is_array|indexOf||innerWidth|ms_getTrueInnerSize|parent||||hide|show|gi_getCurrentItems|minimum|anchorBuilder|pauseDuration|Carousel|sc_clearTimers|events|queue|infinite|ms_getTotalSize|gn_getItemIndex|jquery|event|bt_pauseOnHoverConfig|window|ns2|ani_o|split|to|ms_getTrueLargestSize|floor|of|maxDimention|gn_getVisibleItemsNextFilter|go_getNaviObject|position|sc_stopScroll|timePassed|perc|100|dur2|prefix|appendTo|apply|sc_callCallbacks|currentPosition|currentPage|before|nv_showNavi|sz_setSizes|vI|touchwipe|wN|document|selector|_cfs_init|go_getObject|marginBottom|ms_isPercentage|ms_getPercentage||org|cf_getAlignPadding|keys|pauseOnEvent|Number|none|stopped|gn_getVisibleItemsPrev||cf_getAdjust|onEnd|clone|orgW|isHidden|cf_mapWrapperSizes|get|end|eval|mouseenter|mouseleave|serialNumber|cur_l|di|sz|element|cfs_isCarousel|configuration|defaults|upDateOnWindowResize|up|ms_hasVariableSizes|valid|center|cf_getItemAdjustMinMax|seco|nw|bottom|delay|pauseOnResize|cf_getSynchArr|scrolled|backward|textAlign|float|marginTop|marginLeft|absolute|_cfs_unbind_events|stop|finish|type|conditions|gn_getVisibleOrg|not|fx_cover|fx_uncover|orgDuration|cf_setCookie|gn_getVisibleItemsNextTestCircular|gi_getOldItemsNext|gi_getNewItemsNext||slideToPage|updateSizes|linkAnchors|_cfs_bind_buttons|click|_cfs_unbind_buttons|mousewheelPrev||bt_mousesheelNumber|mousewheelNext|wipe|ns3|wrapper|continue|classnames|new_w|old_w|cf_getKeyCode|gn_getItemsPrevFilter|gn_getItemsNextFilter|ms_getLargestSize|toLowerCase|arr|sta|console|No|_cfs_currentPosition|_cfs_destroy|the|innerHeight|dx|Set|secp|ms_getPaddingBorderMargin|cf_getPadding|500|pageAnchorBuilder|Item|forward|_cfs_build|fixed|cfs_origCss|_cfs_bind_events|paused|onPausePause|onPauseEnd|onPauseStart|enough|needed|page|_cfs_slide_|_cfs_configuration|gn_getScrollItemsPrevFilter|Scrolling|gi_getOldItemsPrev|gi_getNewItemsPrev|directscroll|concat|shift|gn_getScrollItemsNextFilter|new_m|jumpToStart|after|append|caroufredsel|hash|index|selected||gn_getVisibleItemsPrevFilter|destroy|down|keyup|keyCode|configs|classname|cf_readCookie|random|itm|onCreate|namespace|span|animate|complete|cfs_tempCssMargin|s2|l1|l2|join|log|found|The|option|should|be|moved|second|Infinity|Width|caroufredsel_cookie_|attr|id|2500|Available|widths|heights|automatically|relative|overflow|setTimeout|or|Page|resumed|currently|Callback|returned|_cfs_slide_prev|prependTo|_cfs_slide_next|prevPage|nextPage|prepend|carousel|insertItem|removeItem|round|currentVisible|body|find|Preventing|non|sliding|replaceWith|min_move_x|min_move_y|preventDefaultEvents|wipeUp|wipeDown|wipeLeft|wipeRight|resize|timer|wrap|class|unshift|location|swing|cfs|div|caroufredsel_wrapper|href|clearTimeout|fx_fade|hiding|navigation|disabled|paddingLeft|paddingRight|paddingTop|paddingBottom|outer|inner|px|em|even|odd|path|charAt|immediate|instanceof|Array|new|Date|quadratic|cubic|elastic|106|126|jQuery'.split('|'),0,{}));


/**
 * jQuery Mobile Menu 
 * Turn unordered list menu into dropdown select menu
 * version 1.0(31-OCT-2011)
 * 
 * Built on top of the jQuery library
 *   http://jquery.com
 * 
 * Documentation
 *   http://github.com/mambows/mobilemenu
 */
(function(a){a.fn.mobileMenu=function(b){var c={defaultText:"Navigate to...",className:"select-menu",subMenuClass:"sub-menu",subMenuDash:"–"},d=a.extend(c,b);this.each(function(){var b=a(this),c;b.find("ul").addClass(d.subMenuClass);a("<select />",{"class":d.className}).insertAfter(b);c=b.next("."+d.className);a("<option />",{value:"#",text:d.defaultText}).appendTo(c);b.find("a").each(function(){var b=a(this),e=" "+b.text(),f=b.parents("."+d.subMenuClass),g=f.length,h;if(b.parents("ul").hasClass(d.subMenuClass)){h=Array(g+1).join(d.subMenuDash);e=h+e}a("<option />",{value:this.href,html:e,selected:this.href==window.location.href}).appendTo(c)});a("."+d.className).change(function(){var b=a(this).val();if(b!=="#"){window.location.href=a(this).val()}})});return this}})(jQuery);


/*! 
 * Overthrow v.0.1.0. 
 * An overflow:auto polyfill for responsive design. 
 * (c) 2012: Scott Jehl, Filament Group, Inc. 
 * http://filamentgroup.github.com/Overthrow/license.txt
 */
(function(w,undefined){var doc=w.document,docElem=doc.documentElement,classtext="overthrow-enabled",canBeFilledWithPoly="ontouchmove"in doc,overflowProbablyAlreadyWorks="WebkitOverflowScrolling"in docElem.style||!canBeFilledWithPoly&&w.screen.width>1200||function(){var ua=w.navigator.userAgent,webkit=ua.match(/AppleWebKit\/([0-9]+)/),wkversion=webkit&&webkit[1],wkLte534=webkit&&wkversion>=534;return ua.match(/Android ([0-9]+)/)&&RegExp.$1>=3&&wkLte534||ua.match(/ Version\/([0-9]+)/)&&RegExp.$1>=0&&
w.blackberry&&wkLte534||ua.indexOf(/PlayBook/)>-1&&RegExp.$1>=0&&wkLte534||ua.match(/Fennec\/([0-9]+)/)&&RegExp.$1>=4||ua.match(/wOSBrowser\/([0-9]+)/)&&RegExp.$1>=233&&wkLte534||ua.match(/NokiaBrowser\/([0-9\.]+)/)&&parseFloat(RegExp.$1)===7.3&&webkit&&wkversion>=533}(),defaultEasing=function(t,b,c,d){return c*((t=t/d-1)*t*t+1)+b},enabled=false,timeKeeper,toss=function(elem,options){var i=0,sLeft=elem.scrollLeft,sTop=elem.scrollTop,o={top:"+0",left:"+0",duration:100,easing:w.overthrow.easing},endLeft,
endTop;if(options)for(var j in o)if(options[j]!==undefined)o[j]=options[j];if(typeof o.left==="string"){o.left=parseFloat(o.left);endLeft=o.left+sLeft}else{endLeft=o.left;o.left=o.left-sLeft}if(typeof o.top==="string"){o.top=parseFloat(o.top);endTop=o.top+sTop}else{endTop=o.top;o.top=o.top-sTop}timeKeeper=setInterval(function(){if(i++<o.duration){elem.scrollLeft=o.easing(i,sLeft,o.left,o.duration);elem.scrollTop=o.easing(i,sTop,o.top,o.duration)}else{if(endLeft!==elem.scrollLeft)elem.scrollLeft=endLeft;
if(endTop!==elem.scrollTop)elem.scrollTop=endTop;intercept()}},1);return{top:endTop,left:endLeft,duration:o.duration,easing:o.easing}},closest=function(target,ascend){return!ascend&&target.className&&target.className.indexOf("overthrow")>-1&&target||closest(target.parentNode)},intercept=function(){clearInterval(timeKeeper)},enable=function(){if(enabled)return;enabled=true;if(overflowProbablyAlreadyWorks||canBeFilledWithPoly)docElem.className+=" "+classtext;w.overthrow.forget=function(){docElem.className=
docElem.className.replace(classtext,"");if(doc.removeEventListener)doc.removeEventListener("touchstart",start,false);w.overthrow.easing=defaultEasing;enabled=false};if(overflowProbablyAlreadyWorks||!canBeFilledWithPoly)return;var elem,lastTops=[],lastLefts=[],lastDown,lastRight,resetVertTracking=function(){lastTops=[];lastDown=null},resetHorTracking=function(){lastLefts=[];lastRight=null},finishScroll=function(){var top=(lastTops[0]-lastTops[lastTops.length-1])*8,left=(lastLefts[0]-lastLefts[lastLefts.length-
1])*8,duration=Math.max(Math.abs(left),Math.abs(top))/8;top=(top>0?"+":"")+top;left=(left>0?"+":"")+left;if(!isNaN(duration)&&duration>0&&(Math.abs(left)>80||Math.abs(top)>80))toss(elem,{left:left,top:top,duration:duration})},inputs,setPointers=function(val){inputs=elem.querySelectorAll("textarea, input");for(var i=0,il=inputs.length;i<il;i++)inputs[i].style.pointerEvents=val},changeScrollTarget=function(startEvent,ascend){if(doc.createEvent){var newTarget=(!ascend||ascend===undefined)&&elem.parentNode||
elem.touchchild||elem,tEnd;if(newTarget!==elem){tEnd=doc.createEvent("HTMLEvents");tEnd.initEvent("touchend",true,true);elem.dispatchEvent(tEnd);newTarget.touchchild=elem;elem=newTarget;newTarget.dispatchEvent(startEvent)}}},start=function(e){intercept();resetVertTracking();resetHorTracking();elem=closest(e.target);if(!elem||elem===docElem||e.touches.length>1)return;setPointers("none");var touchStartE=e,scrollT=elem.scrollTop,scrollL=elem.scrollLeft,height=elem.offsetHeight,width=elem.offsetWidth,
startY=e.touches[0].pageY,startX=e.touches[0].pageX,scrollHeight=elem.scrollHeight,scrollWidth=elem.scrollWidth,move=function(e){var ty=scrollT+startY-e.touches[0].pageY,tx=scrollL+startX-e.touches[0].pageX,down=ty>=(lastTops.length?lastTops[0]:0),right=tx>=(lastLefts.length?lastLefts[0]:0);if(ty>0&&ty<scrollHeight-height||tx>0&&tx<scrollWidth-width)e.preventDefault();else changeScrollTarget(touchStartE);if(lastDown&&down!==lastDown)resetVertTracking();if(lastRight&&right!==lastRight)resetHorTracking();
lastDown=down;lastRight=right;elem.scrollTop=ty;elem.scrollLeft=tx;lastTops.unshift(ty);lastLefts.unshift(tx);if(lastTops.length>3)lastTops.pop();if(lastLefts.length>3)lastLefts.pop()},end=function(e){finishScroll();setPointers("auto");setTimeout(function(){setPointers("none")},450);elem.removeEventListener("touchmove",move,false);elem.removeEventListener("touchend",end,false)};elem.addEventListener("touchmove",move,false);elem.addEventListener("touchend",end,false)};doc.addEventListener("touchstart",
start,false)};w.overthrow={set:enable,forget:function(){},easing:defaultEasing,toss:toss,intercept:intercept,closest:closest,support:overflowProbablyAlreadyWorks?"native":canBeFilledWithPoly&&"polyfilled"||"none"};enable()})(this);