// Generated by CoffeeScript 1.10.0
(function(factory) {
  if (typeof module === 'object' && module.exports) {
    return module.exports = factory(require('jquery'));
  } else if (typeof define === 'function' && define.amd) {
    return define(['jquery'], factory);
  } else {
    return factory(jQuery);
  }
})(function($) {
  return $.extend({
    tips: function(options) {
      var hideTooltip, log, replaceCharacters, settings, showTooltip;
      settings = {
        action: 'focus',
        debug: false,
        element: '.error',
        fadeSpeed: 200,
        html5: true,
        preventDefault: false,
        removeAll: false,
        removeSpecific: false,
        tailLength: 14,
        tooltipClass: ''
      };
      settings = $.extend(settings, options);
      log = function(msg) {
        if (settings.debug) {
          return typeof console !== "undefined" && console !== null ? console.info(msg) : void 0;
        }
      };
      replaceCharacters = function(txt) {
        var content, emArray, headerArray, key, liArray, strongArray, val;
        headerArray = [];
        strongArray = [];
        emArray = [];
        liArray = [];
        content = txt.split("");
        for (key in content) {
          val = content[key];
          if (val === '^') {
            headerArray.push(key);
          }
          if (val === '*') {
            strongArray.push(key);
          }
          if (val === '~') {
            emArray.push(key);
          }
          if (val === '`') {
            liArray.push(key);
          }
          if (val === '|') {
            content[key] = '<br />';
          }
          if (val === '{') {
            content[key] = '<ul>';
          }
          if (val === '}') {
            content[key] = '</ul>';
          }
        }
        while (headerArray.length > 1) {
          content[headerArray[0]] = '<h1>';
          content[headerArray[1]] = '</h1>';
          headerArray.splice(0, 2);
        }
        while (strongArray.length > 1) {
          content[strongArray[0]] = '<strong>';
          content[strongArray[1]] = '</strong>';
          strongArray.splice(0, 2);
        }
        while (emArray.length > 1) {
          content[emArray[0]] = '<em>';
          content[emArray[1]] = '</em>';
          emArray.splice(0, 2);
        }
        while (liArray.length) {
          content[liArray[0]] = '<li>';
          liArray.splice(0, 1);
        }
        return content.join("");
      };
      showTooltip = function(ele) {
        var direction, elementHeightAdjustment, elementWidthAdjustment, html, leftPosition, offset, rightPosition, tooltipElement, tooltipHeightAdjustment, tooltipWidthAdjustment, topPosition;
        if (ele.attr('data-tooltip')) {
          hideTooltip();
          html = replaceCharacters(ele.attr('data-tooltip'));
          direction = ele.attr('data-tooltip-direction');
          if (settings.html5) {
            tooltipElement = '<aside>';
          } else {
            tooltipElement = '<div>';
          }
          $(tooltipElement).addClass('tooltip ' + settings.tooltipClass).html(html).appendTo('body');
          elementWidthAdjustment = ele.outerWidth();
          elementHeightAdjustment = ele.outerHeight();
          tooltipWidthAdjustment = $('.tooltip:last').outerWidth();
          tooltipHeightAdjustment = $('.tooltip:last').outerHeight();
          offset = ele.offset();
          topPosition = offset.top;
          leftPosition = 0;
          rightPosition = 0;
          switch (direction) {
            case 'left':
              rightPosition = offset.left - tooltipWidthAdjustment - settings.tailLength;
              topPosition = topPosition - (tooltipHeightAdjustment / 2) + (elementHeightAdjustment / 2);
              $('.tooltip:last').css({
                left: rightPosition,
                top: topPosition
              }).addClass('left').fadeIn(settings.fadeSpeed);
              break;
            case 'bottom':
              topPosition = offset.top + elementHeightAdjustment + settings.tailLength;
              leftPosition = offset.left + (elementWidthAdjustment / 2) - (tooltipWidthAdjustment / 2);
              $('.tooltip:last').css({
                left: leftPosition,
                top: topPosition
              }).addClass('bottom').fadeIn(settings.fadeSpeed);
              break;
            case 'top':
              topPosition = offset.top - tooltipHeightAdjustment - settings.tailLength;
              leftPosition = offset.left + (elementWidthAdjustment / 2) - (tooltipWidthAdjustment / 2);
              $('.tooltip:last').css({
                left: leftPosition,
                top: topPosition
              }).addClass('top').fadeIn(settings.fadeSpeed);
              break;
            default:
              leftPosition = offset.left + elementWidthAdjustment + settings.tailLength;
              topPosition = topPosition - (tooltipHeightAdjustment / 2) + (elementHeightAdjustment / 2);
              $('.tooltip:last').css({
                left: leftPosition,
                top: topPosition
              }).fadeIn(settings.fadeSpeed);
          }
          if (settings.debug) {
            log('Tooltip Content: ' + html);
            if (elementWidthAdjustment) {
              log('Element Width: ' + elementWidthAdjustment);
            }
            if (elementHeightAdjustment) {
              log('Element Height: ' + elementHeightAdjustment);
            }
            if (topPosition) {
              log('Element Top Position: ' + topPosition);
            }
            if (leftPosition) {
              log('Element Left Position: ' + leftPosition);
            }
            if (rightPosition) {
              log('Element Right Position: ' + rightPosition);
            }
            if (tooltipWidthAdjustment) {
              log('Tooltip Width: ' + tooltipWidthAdjustment);
            }
            if (tooltipHeightAdjustment) {
              return log('Tooltip Height: ' + tooltipHeightAdjustment);
            }
          }
        }
      };
      hideTooltip = function() {
        return $('.tooltip').fadeOut(settings.fadeSpeed, function() {
          return $(this).remove();
        });
      };
      return this(function() {
        var ele;
        ele = settings.element;
        if (settings.removeSpecific && !settings.removeAll) {
          if (settings.debug) {
            log('unbinding tooltip');
          }
          if (settings.action && ele) {
            switch (settings.action) {
              case 'click':
                $(document).off('click.tips.cd', ele);
                $(document).off('blur.tips.bc', ele);
                break;
              case 'hover':
                $(document).off('click.tips.hc', ele);
                $(document).off('mouseenter.tips.he', ele);
                $(document).off('mouseout.tips.ho', ele);
                break;
              default:
                $(document).off('click.tips.fc', ele);
                $(document).off('focus.tips.ff', ele);
                $(document).off('blur.tips.fb', ele);
                $(document).off('change.tips.fch', ele);
            }
          }
        }
        if (settings.removeAll) {
          if (settings.debug) {
            log('removing all tooltip binding');
          }
          $(document).off('click.tips');
          $(document).off('blur.tips');
          $(document).off('mouseenter.tips');
          $(document).off('mouseout.tips');
          $(document).off('change.tips');
        }
        if (!settings.removeAll && !settings.removeSpecific) {
          switch (settings.action) {
            case 'click':
              $(document).on('click.tips.cc', ele, function(e) {
                if (settings.preventDefault) {
                  e.preventDefault();
                }
                if (!$(this).is(':input') && !$(this).attr('tabindex')) {
                  $(this).attr('tabindex', 0).focus();
                }
                return showTooltip($(this));
              });
              return $(document).on('blur.tips.bc', ele, function(e) {
                if (!$(this).is(':input') && !$(this).attr('tabindex')) {
                  $(this).removeAttr('tabindex');
                }
                return hideTooltip();
              });
            case 'hover':
              $(document).on('click.tips.hc', ele, function(e) {
                if (settings.preventDefault) {
                  return e.preventDefault();
                }
              });
              $(document).on('mouseenter.tips.he', ele, function(e) {
                return showTooltip($(this));
              });
              return $(document).on('mouseout.tips.ho', ele, function(e) {
                return hideTooltip();
              });
            default:
              $(document).on('click.tips.fc', ele, function(e) {
                if (settings.preventDefault) {
                  return e.preventDefault();
                }
              });
              $(document).on('focus.tips.ff', ele, function(e) {
                return showTooltip($(this));
              });
              $(document).on('blur.tips.fb', ele, function(e) {
                return hideTooltip();
              });
              return $(document).on('change.tips.fch', ele, function(e) {
                return hideTooltip();
              });
          }
        }
      });
    }
  });
});
