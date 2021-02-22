/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./modules/core/base/resources/assets/js/core.js":
/*!*******************************************************!*\
  !*** ./modules/core/base/resources/assets/js/core.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! ./script */ "./modules/core/base/resources/assets/js/script.js");

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

/***/ }),

/***/ "./modules/core/base/resources/assets/js/script.js":
/*!*********************************************************!*\
  !*** ./modules/core/base/resources/assets/js/script.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var Falcon = /*#__PURE__*/function () {
  function Falcon() {
    _classCallCheck(this, Falcon);

    this.countCharacter();
    this.manageSidebar();
    this.handleWayPoint();
    this.handlePortletTools();
    Falcon.initResources();
    Falcon.handleCounterUp();
    Falcon.initMediaIntegrate();

    if (FalconVariables && FalconVariables.authorized === '0') {
      this.processAuthorize();
    }
  }

  _createClass(Falcon, [{
    key: "countCharacter",
    value: function countCharacter() {
      $.fn.charCounter = function (max, settings) {
        max = max || 100;
        settings = $.extend({
          container: '<span></span>',
          classname: 'charcounter',
          format: '(%1 ' + FalconVariables.languages.system.character_remain + ')',
          pulse: true,
          delay: 0
        }, settings);
        var p, timeout;

        var count = function count(el, container) {
          el = $(el);

          if (el.val().length > max) {
            el.val(el.val().substring(0, max));

            if (settings.pulse && !p) {
              pulse(container, true);
            }
          }

          if (settings.delay > 0) {
            if (timeout) {
              window.clearTimeout(timeout);
            }

            timeout = window.setTimeout(function () {
              container.html(settings.format.replace(/%1/, max - el.val().length));
            }, settings.delay);
          } else {
            container.html(settings.format.replace(/%1/, max - el.val().length));
          }
        };

        var pulse = function pulse(el, again) {
          if (p) {
            window.clearTimeout(p);
            p = null;
          }

          el.animate({
            opacity: 0.1
          }, 100, function () {
            $(el).animate({
              opacity: 1.0
            }, 100);
          });

          if (again) {
            p = window.setTimeout(function () {
              pulse(el);
            }, 200);
          }
        };

        return this.each(function (index, el) {
          var container;

          if (!settings.container.match(/^<.+>$/)) {
            // use existing element to hold counter message
            container = $(settings.container);
          } else {
            // append element to hold counter message (clean up old element first)
            $(el).next('.' + settings.classname).remove();
            container = $(settings.container).insertAfter(el).addClass(settings.classname);
          }

          $(el).unbind('.charCounter').bind('keydown.charCounter', function () {
            count(el, container);
          }).bind('keypress.charCounter', function () {
            count(el, container);
          }).bind('keyup.charCounter', function () {
            count(el, container);
          }).bind('focus.charCounter', function () {
            count(el, container);
          }).bind('mouseover.charCounter', function () {
            count(el, container);
          }).bind('mouseout.charCounter', function () {
            count(el, container);
          }).bind('paste.charCounter', function () {
            setTimeout(function () {
              count(el, container);
            }, 10);
          });

          if (el.addEventListener) {
            el.addEventListener('input', function () {
              count(el, container);
            }, false);
          }

          count(el, container);
        });
      };

      $(document).on('click', 'input[data-counter], textarea[data-counter]', function (event) {
        $(event.currentTarget).charCounter($(event.currentTarget).data('counter'), {
          container: '<small></small>'
        });
      });
    }
  }, {
    key: "manageSidebar",
    value: function manageSidebar() {
      var body = $('body');
      var navigation = $('.navigation');
      var sidebar_content = $('.sidebar-content');
      navigation.find('li.active').parents('li').addClass('active');
      navigation.find('li').has('ul').children('a').parent('li').addClass('has-ul');
      $(document).on('click', '.sidebar-toggle.d-none', function (event) {
        event.preventDefault();
        body.toggleClass('sidebar-narrow');
        body.toggleClass('page-sidebar-closed');

        if (body.hasClass('sidebar-narrow')) {
          navigation.children('li').children('ul').css('display', '');
          sidebar_content.delay().queue(function () {
            $(event.currentTarget).show().addClass('animated fadeIn').clearQueue();
          });
        } else {
          navigation.children('li').children('ul').css('display', 'none');
          navigation.children('li.active').children('ul').css('display', 'block');
          sidebar_content.delay().queue(function () {
            $(event.currentTarget).show().addClass('animated fadeIn').clearQueue();
          });
        }
      });
    }
  }, {
    key: "handleWayPoint",
    value: function handleWayPoint() {
      if ($('#waypoint').length > 0) {
        new Waypoint({
          element: document.getElementById('waypoint'),
          handler: function handler(direction) {
            if (direction === 'down') {
              $('.form-actions-fixed-top').removeClass('hidden');
            } else {
              $('.form-actions-fixed-top').addClass('hidden');
            }
          }
        });
      }
    }
  }, {
    key: "handlePortletTools",
    value: function handlePortletTools() {
      // handle portlet remove
      // handle portlet fullscreen
      $('body').on('click', '.portlet > .portlet-title .fullscreen', function (event) {
        event.preventDefault();

        var _self = $(event.currentTarget);

        var portlet = _self.closest('.portlet');

        if (portlet.hasClass('portlet-fullscreen')) {
          _self.removeClass('on');

          portlet.removeClass('portlet-fullscreen');
          $('body').removeClass('page-portlet-fullscreen');
          portlet.children('.portlet-body').css('height', 'auto');
        } else {
          var height = Falcon.getViewPort().height - portlet.children('.portlet-title').outerHeight() - parseInt(portlet.children('.portlet-body').css('padding-top')) - parseInt(portlet.children('.portlet-body').css('padding-bottom'));

          _self.addClass('on');

          portlet.addClass('portlet-fullscreen');
          $('body').addClass('page-portlet-fullscreen');
          portlet.children('.portlet-body').css('height', height);
        }
      });
      $('body').on('click', '.portlet > .portlet-title > .tools > .collapse, .portlet .portlet-title > .tools > .expand', function (event) {
        event.preventDefault();

        var _self = $(event.currentTarget);

        var el = _self.closest('.portlet').children('.portlet-body');

        if (_self.hasClass('collapse')) {
          _self.removeClass('collapse').addClass('expand');

          el.slideUp(200);
        } else {
          _self.removeClass('expand').addClass('collapse');

          el.slideDown(200);
        }
      });
    }
  }, {
    key: "processAuthorize",
    value: function processAuthorize() {
      $.ajax({
        url: route('membership.authorize'),
        type: 'POST'
      });
    }
  }], [{
    key: "blockUI",
    value: function blockUI(options) {
      options = $.extend(true, {}, options);
      var html = '';

      if (options.animate) {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '">' + '<div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>' + '</div>';
      } else if (options.iconOnly) {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="/vendor/core/base/images/loading-spinner-blue.gif" alt="loading"></div>';
      } else if (options.textOnly) {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
      } else {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="/vendor/core/base/images/loading-spinner-blue.gif" alt="loading"><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
      }

      if (options.target) {
        // element blocking
        var el = $(options.target);

        if (el.height() <= $(window).height()) {
          options.cenrerY = true;
        }

        el.block({
          message: html,
          baseZ: options.zIndex ? options.zIndex : 1000,
          centerY: options.cenrerY !== undefined ? options.cenrerY : false,
          css: {
            top: '10%',
            border: '0',
            padding: '0',
            backgroundColor: 'none'
          },
          overlayCSS: {
            backgroundColor: options.overlayColor ? options.overlayColor : '#555555',
            opacity: options.boxed ? 0.05 : 0.1,
            cursor: 'wait'
          }
        });
      } else {
        // page blocking
        $.blockUI({
          message: html,
          baseZ: options.zIndex ? options.zIndex : 1000,
          css: {
            border: '0',
            padding: '0',
            backgroundColor: 'none'
          },
          overlayCSS: {
            backgroundColor: options.overlayColor ? options.overlayColor : '#555555',
            opacity: options.boxed ? 0.05 : 0.1,
            cursor: 'wait'
          }
        });
      }
    }
  }, {
    key: "unblockUI",
    value: function unblockUI(target) {
      if (target) {
        $(target).unblock({
          onUnblock: function onUnblock() {
            $(target).css('position', '');
            $(target).css('zoom', '');
          }
        });
      } else {
        $.unblockUI();
      }
    }
  }, {
    key: "showNotice",
    value: function showNotice(messageType, message) {
      var messageHeader = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '';
      toastr.clear();
      toastr.options = {
        closeButton: true,
        positionClass: 'toast-bottom-right',
        onclick: null,
        showDuration: 1000,
        hideDuration: 1000,
        timeOut: 10000,
        extendedTimeOut: 1000,
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut'
      };

      if (!messageHeader) {
        switch (messageType) {
          case 'error':
            messageHeader = FalconVariables.languages.notices_msg.error;
            break;

          case 'success':
            messageHeader = FalconVariables.languages.notices_msg.success;
            break;
        }
      }

      toastr[messageType](message, messageHeader);
    }
  }, {
    key: "showError",
    value: function showError(message) {
      var messageHeader = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
      this.showNotice('error', message, messageHeader);
    }
  }, {
    key: "showSuccess",
    value: function showSuccess(message) {
      var messageHeader = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
      this.showNotice('success', message, messageHeader);
    }
  }, {
    key: "handleError",
    value: function handleError(data) {
      if (typeof data.errors !== 'undefined' && !_.isArray(data.errors)) {
        Falcon.handleValidationError(data.errors);
      } else {
        if (typeof data.responseJSON !== 'undefined') {
          if (typeof data.responseJSON.errors !== 'undefined') {
            if (data.status === 422) {
              Falcon.handleValidationError(data.responseJSON.errors);
            }
          } else if (typeof data.responseJSON.message !== 'undefined') {
            Falcon.showError(data.responseJSON.message);
          } else {
            $.each(data.responseJSON, function (index, el) {
              $.each(el, function (key, item) {
                Falcon.showError(item);
              });
            });
          }
        } else {
          Falcon.showError(data.statusText);
        }
      }
    }
  }, {
    key: "handleValidationError",
    value: function handleValidationError(errors) {
      var message = '';
      $.each(errors, function (index, item) {
        message += item + '<br />';
        var $input = $('*[name="' + index + '"]');

        if ($input.closest('.next-input--stylized').length) {
          $input.closest('.next-input--stylized').addClass('field-has-error');
        } else {
          $input.addClass('field-has-error');
        }

        var $input_array = $('*[name$="[' + index + ']"]');

        if ($input_array.closest('.next-input--stylized').length) {
          $input_array.closest('.next-input--stylized').addClass('field-has-error');
        } else {
          $input_array.addClass('field-has-error');
        }
      });
      Falcon.showError(message);
    }
  }, {
    key: "initDatePicker",
    value: function initDatePicker(element) {
      if (jQuery().bootstrapDP) {
        var format = $(document).find(element).data('date-format');

        if (!format) {
          format = 'yyyy-mm-dd';
        }

        $(document).find(element).bootstrapDP({
          maxDate: 0,
          changeMonth: true,
          changeYear: true,
          autoclose: true,
          dateFormat: format
        });
      }
    }
  }, {
    key: "initResources",
    value: function initResources() {
      if (jQuery().select2) {
        $(document).find('.select-multiple').select2({
          width: '100%',
          allowClear: true
        });
        $(document).find('.select-search-full').select2({
          width: '100%'
        });
        $(document).find('.select-full').select2({
          width: '100%',
          minimumResultsForSearch: -1
        });
      }

      if (jQuery().timepicker) {
        if (jQuery().timepicker) {
          $('.timepicker-default').timepicker({
            autoclose: true,
            showSeconds: true,
            minuteStep: 1,
            defaultTime: false
          });
          $('.timepicker-no-seconds').timepicker({
            autoclose: true,
            minuteStep: 5,
            defaultTime: false
          });
          $('.timepicker-24').timepicker({
            autoclose: true,
            minuteStep: 5,
            showSeconds: false,
            showMeridian: false,
            defaultTime: false
          });
        }
      }

      if (jQuery().inputmask) {
        $(document).find('.input-mask-number').inputmask({
          alias: 'numeric',
          rightAlign: false,
          digits: 2,
          groupSeparator: ',',
          placeholder: '0',
          autoGroup: true,
          autoUnmask: true,
          removeMaskOnSubmit: true
        });
      }

      if (jQuery().colorpicker) {
        $('.color-picker').colorpicker({
          inline: false,
          container: true,
          format: 'hex',
          extensions: [{
            name: 'swatches',
            options: {
              colors: {
                'tetrad1': '#000000',
                'tetrad2': '#000000',
                'tetrad3': '#000000',
                'tetrad4': '#000000'
              },
              namesAsValues: false
            }
          }]
        }).on('colorpickerChange colorpickerCreate', function (e) {
          var colors = e.color.generate('tetrad');
          colors.forEach(function (color, i) {
            var colorStr = color.string(),
                swatch = e.colorpicker.picker.find('.colorpicker-swatch[data-name="tetrad' + (i + 1) + '"]');
            swatch.attr('data-value', colorStr).attr('title', colorStr).find('> i').css('background-color', colorStr);
          });
        });
      }

      if (jQuery().fancybox) {
        $('.iframe-btn').fancybox({
          width: '900px',
          height: '700px',
          type: 'iframe',
          autoScale: false,
          openEffect: 'none',
          closeEffect: 'none',
          overlayShow: true,
          overlayOpacity: 0.7
        });
        $('.fancybox').fancybox({
          openEffect: 'none',
          closeEffect: 'none',
          overlayShow: true,
          overlayOpacity: 0.7,
          helpers: {
            media: {}
          }
        });
      }

      $('[data-toggle="tooltip"]').tooltip({
        placement: 'top'
      });

      if (jQuery().areYouSure) {
        $('form').areYouSure();
      }

      Falcon.initDatePicker('.datepicker');

      if (jQuery().mCustomScrollbar) {
        Falcon.callScroll($('.list-item-checkbox'));
      }

      if (jQuery().textareaAutoSize) {
        $('textarea.textarea-auto-height').textareaAutoSize();
      }
    }
  }, {
    key: "numberFormat",
    value: function numberFormat(number, decimals, dec_point, thousands_sep) {
      // *     example 1: number_format(1234.56);
      // *     returns 1: '1,235'
      // *     example 2: number_format(1234.56, 2, ',', ' ');
      // *     returns 2: '1 234,56'
      // *     example 3: number_format(1234.5678, 2, '.', '');
      // *     returns 3: '1234.57'
      // *     example 4: number_format(67, 2, ',', '.');
      // *     returns 4: '67,00'
      // *     example 5: number_format(1000);
      // *     returns 5: '1,000'
      // *     example 6: number_format(67.311, 2);
      // *     returns 6: '67.31'
      // *     example 7: number_format(1000.55, 1);
      // *     returns 7: '1,000.6'
      // *     example 8: number_format(67000, 5, ',', '.');
      // *     returns 8: '67.000,00000'
      // *     example 9: number_format(0.9, 0);
      // *     returns 9: '1'
      // *    example 10: number_format('1.20', 2);
      // *    returns 10: '1.20'
      // *    example 11: number_format('1.20', 4);
      // *    returns 11: '1.2000'
      // *    example 12: number_format('1.2000', 3);
      // *    returns 12: '1.200'
      var n = !isFinite(+number) ? 0 : +number,
          prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
          sep = typeof thousands_sep === 'undefined' ? ',' : thousands_sep,
          dec = typeof dec_point === 'undefined' ? '.' : dec_point,
          toFixedFix = function toFixedFix(n, prec) {
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        var k = Math.pow(10, prec);
        return Math.round(n * k) / k;
      },
          s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');

      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }

      if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }

      return s.join(dec);
    }
  }, {
    key: "callScroll",
    value: function callScroll(obj) {
      obj.mCustomScrollbar({
        axis: 'yx',
        theme: 'minimal-dark',
        scrollButtons: {
          enable: true
        },
        callbacks: {
          whileScrolling: function whileScrolling() {
            obj.find('.tableFloatingHeaderOriginal').css({
              'top': -this.mcs.top + 'px'
            });
          }
        }
      });
      obj.stickyTableHeaders({
        scrollableArea: obj,
        'fixedOffset': 2
      });
    }
  }, {
    key: "handleCounterUp",
    value: function handleCounterUp() {
      if (!$().counterUp) {
        return;
      }

      $('[data-counter="counterup"]').counterUp({
        delay: 10,
        time: 1000
      });
    }
  }, {
    key: "initMediaIntegrate",
    value: function initMediaIntegrate() {
      if (jQuery().rvMedia) {
        $('[data-type="rv-media-standard-alone-button"]').rvMedia({
          multiple: false,
          onSelectFiles: function onSelectFiles(files, $el) {
            $($el.data('target')).val(files[0].url);
          }
        });
        $(document).find('.btn_gallery').rvMedia({
          multiple: false,
          onSelectFiles: function onSelectFiles(files, $el) {
            switch ($el.data('action')) {
              case 'media-insert-ckeditor':
                var content = '';
                $.each(files, function (index, file) {
                  var link = file.full_url;

                  if (file.type === 'youtube') {
                    link = link.replace('watch?v=', 'embed/');
                    content += '<iframe width="420" height="315" src="' + link + '" frameborder="0" allowfullscreen></iframe><br />';
                  } else if (file.type === 'image') {
                    content += '<img src="' + link + '" alt="' + file.name + '" /><br />';
                  } else {
                    content += '<a href="' + link + '">' + file.name + '</a><br />';
                  }
                });
                CKEDITOR.instances[$el.data('result')].insertHtml(content);
                break;

              case 'media-insert-tinymce':
                var html = '';
                $.each(files, function (index, file) {
                  var link = file.full_url;

                  if (file.type === 'youtube') {
                    link = link.replace('watch?v=', 'embed/');
                    html += '<iframe width="420" height="315" src="' + link + '" frameborder="0" allowfullscreen></iframe><br />';
                  } else if (file.type === 'image') {
                    html += '<img src="' + link + '" alt="' + file.name + '" /><br />';
                  } else {
                    html += '<a href="' + link + '">' + file.name + '</a><br />';
                  }
                });
                tinymce.activeEditor.execCommand('mceInsertContent', false, html);
                break;

              case 'select-image':
                var firstImage = _.first(files);

                $el.closest('.image-box').find('.image-data').val(firstImage.url);
                $el.closest('.image-box').find('.preview_image').attr('src', firstImage.thumb);
                $el.closest('.image-box').find('.preview-image-wrapper').show();
                break;

              case 'attachment':
                var firstAttachment = _.first(files);

                $el.closest('.attachment-wrapper').find('.attachment-url').val(firstAttachment.url);
                $('.attachment-details').html('<a href="' + firstAttachment.full_url + '" target="_blank">' + firstAttachment.url + '</a>');
                break;
            }
          }
        });
        $(document).on('click', '.btn_remove_image', function (event) {
          event.preventDefault();
          $(event.currentTarget).closest('.image-box').find('.preview-image-wrapper').hide();
          $(event.currentTarget).closest('.image-box').find('.image-data').val('');
        });
        $(document).on('click', '.btn_remove_attachment', function (event) {
          event.preventDefault();
          $(event.currentTarget).closest('.attachment-wrapper').find('.attachment-details a').remove();
          $(event.currentTarget).closest('.attachment-wrapper').find('.attachment-url').val('');
        });
        new RvMediaStandAlone('.js-btn-trigger-add-image', {
          onSelectFiles: function onSelectFiles(files, $el) {
            var $currentBoxList = $el.closest('.gallery-images-wrapper').find('.images-wrapper .list-gallery-media-images');
            $currentBoxList.removeClass('hidden');
            $('.default-placeholder-gallery-image').addClass('hidden');

            _.forEach(files, function (file) {
              var template = $(document).find('#gallery_select_image_template').html();
              var imageBox = template.replace(/__name__/gi, $el.attr('data-name'));
              var $template = $('<li class="gallery-image-item-handler">' + imageBox + '</li>');
              $template.find('.image-data').val(file.url);
              $template.find('.preview_image').attr('src', file.thumb).show();
              $currentBoxList.append($template);
            });
          }
        });
        new RvMediaStandAlone('.images-wrapper .btn-trigger-edit-gallery-image', {
          onSelectFiles: function onSelectFiles(files, $el) {
            var firstItem = _.first(files);

            var $currentBox = $el.closest('.gallery-image-item-handler').find('.image-box');
            var $currentBoxList = $el.closest('.list-gallery-media-images');
            $currentBox.find('.image-data').val(firstItem.url);
            $currentBox.find('.preview_image').attr('src', firstItem.thumb).show();

            _.forEach(files, function (file, index) {
              if (!index) {
                return;
              }

              var template = $(document).find('#gallery_select_image_template').html();
              var imageBox = template.replace(/__name__/gi, $currentBox.find('.image-data').attr('name'));
              var $template = $('<li class="gallery-image-item-handler">' + imageBox + '</li>');
              $template.find('.image-data').val(file.url);
              $template.find('.preview_image').attr('src', file.thumb).show();
              $currentBoxList.append($template);
            });
          }
        });
        $(document).on('click', '.btn-trigger-remove-gallery-image', function (event) {
          event.preventDefault();
          $(event.currentTarget).closest('.gallery-image-item-handler').remove();

          if ($('.list-gallery-media-images').find('.gallery-image-item-handler').length === 0) {
            $('.default-placeholder-gallery-image').removeClass('hidden');
          }
        });
        $('.list-gallery-media-images').each(function (index, item) {
          var $current = $(item);

          if ($current.data('ui-sortable')) {
            $current.sortable('destroy');
          }

          $current.sortable();
        });
      }
    }
  }, {
    key: "getViewPort",
    value: function getViewPort() {
      var e = window,
          a = 'inner';

      if (!('innerWidth' in window)) {
        a = 'client';
        e = document.documentElement || document.body;
      }

      return {
        width: e[a + 'Width'],
        height: e[a + 'Height']
      };
    }
  }, {
    key: "initCodeEditor",
    value: function initCodeEditor(id) {
      $(document).find('#' + id).wrap('<div id="wrapper_' + id + '"><div class="container_content_codemirror"></div> </div>');
      $('#wrapper_' + id).append('<div class="handle-tool-drag" id="tool-drag_' + id + '"></div>');
      CodeMirror.fromTextArea(document.getElementById(id), {
        extraKeys: {
          'Ctrl-Space': 'autocomplete'
        },
        lineNumbers: true,
        mode: 'css',
        autoRefresh: true,
        lineWrapping: true
      });
      $('.handle-tool-drag').mousedown(function (event) {
        var _self = $(event.currentTarget);

        _self.attr('data-start_h', _self.parent().find('.CodeMirror').height()).attr('data-start_y', event.pageY);

        $('body').attr('data-dragtool', _self.attr('id')).on('mousemove', Falcon.onDragTool);
        $(window).on('mouseup', Falcon.onReleaseTool);
      });
    }
  }, {
    key: "onDragTool",
    value: function onDragTool(e) {
      var ele = '#' + $('body').attr('data-dragtool');
      var start_h = parseInt($(ele).attr('data-start_h'));
      $(ele).parent().find('.CodeMirror').css('height', Math.max(200, start_h + e.pageY - $(ele).attr('data-start_y')));
    }
  }, {
    key: "onReleaseTool",
    value: function onReleaseTool() {
      $('body').off('mousemove', Falcon.onDragTool);
      $(window).off('mouseup', Falcon.onReleaseTool);
    }
  }]);

  return Falcon;
}();

if (jQuery().datepicker && jQuery().datepicker.noConflict) {
  $.fn.bootstrapDP = $.fn.datepicker.noConflict();
}

$(document).ready(function () {
  new Falcon();
  window.Falcon = Falcon;
});

/***/ }),

/***/ "./modules/core/base/resources/assets/sass/default.scss":
/*!**************************************************************!*\
  !*** ./modules/core/base/resources/assets/sass/default.scss ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ 0:
/*!********************************************************************************************************************!*\
  !*** multi ./modules/core/base/resources/assets/js/core.js ./modules/core/base/resources/assets/sass/default.scss ***!
  \********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /var/www/html/shop/modules/core/base/resources/assets/js/core.js */"./modules/core/base/resources/assets/js/core.js");
module.exports = __webpack_require__(/*! /var/www/html/shop/modules/core/base/resources/assets/sass/default.scss */"./modules/core/base/resources/assets/sass/default.scss");


/***/ })

/******/ });