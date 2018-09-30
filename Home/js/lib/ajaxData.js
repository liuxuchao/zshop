;
( function (global, factory) {
  'use strict';
  if (typeof define === 'function' && (define.amd || define.cmd)) {
    // AMD\CMD. Register as an anonymous module.
    define(function (require, exports, module) {
      return factory(global);
    });

  } else if (typeof exports === 'object') {
    module.exports = factory();
  } else {
    global.ajaxData = factory(global);
  }
}(typeof window !== "undefined" ? window : this, function (window) {

  "use strict";

  var _typeof = typeof Symbol === "function" && typeof Symbol.iterator === "symbol" ? function (obj) {
      return typeof obj;
    } : function (obj) {
      return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
    };

  var ajaxData = function (window) {

    function AjaxData() {
      var loading;
      // 加载Ajax前去显示
      function beforeSend(fn) {
        return function () {
          loading.show();
          if (fn) {
            fn();
          }
        };
      }

      /*    function complete( fn ) {
       return function () {
       loading.hide();
       if ( fn ) {
       fn();
       }
       }
       }*/
      this.ajax = function (param) {

        if (!param.url) {
          return;
        }
        if (_typeof(param.loading) == "object") {
          loading = param.loading;
        } else if (typeof param.loading == "string") {
          loading = $(param.loading);
        } else if (document.getElementById('loading')) {
          loading = $("#loading");
        } else {
          loading = $('<div/>');
        }
        /**
         * typeData 类型:
         * "xml": 返回 XML 文档，可用 jQuery 处理。
         "html": 返回纯文本 HTML 信息；包含的script标签会在插入dom时执行。
         "script": 返回纯文本 JavaScript 代码。不会自动缓存结果。除非设置了"cache"参数。'''注意：'''在远程请求时(不在同一个域下)，所有POST请求都将转为GET请求。(因为将使用DOM的script标签来加载)
         "json": 返回 JSON 数据 。
         "jsonp": JSONP 格式。使用 JSONP 形式调用函数时，如 "myurl?callback=?" jQuery 将自动替换 ? 为正确的函数名，以执行回调函数。
         "text": 返回纯文本字符串
         */

        var _cache = param.cache || false;
        var _type = param.type || "POST";
        var _dataType = param.dataType || "json";
        var _async = param.async;
        var _data = param.data || null;
        var _url = param.url || null;

        var _beforeSend = function _beforeSend() {
          //console.log("beforeSend");
        };
        var _complete = function _complete() {
          //console.log("complete");
        };
        var _dataFilter = function _dataFilter(a, b) {
          // console.log(arguments.length);
          // console.log(b);
          // console.log("在请求成功之后调用！dataFilter");
        };
        var _success = function _success() {
        };
        var _error = function _error() {
        };
        var _statusCode = {
          404: function _() {
            console.log('404: http://' + window.location.host + param.url);
            window.location.href = '/Home/Html/404.html?v=1487680497363?v='+(new Date());
          }
        };
        // 设置全局 AJAX 默认选项。
        $.ajaxSetup({
          type: _type,
          dataType: _dataType,
          timeout:15000,
          url: _url,
          async: _async,
          data: _data,
          cache: _cache,
          statusCode: _statusCode,
          beforeSend: _beforeSend,
          complete: _complete,
          success: _success,
          error: function(){
            $('[data-outTime]').show();
          }
        });

        return $.ajax(param).always(function () {
          //当递延对象是解决(success)或拒绝(error)时被调用添加处理程序。
          loading.hide();
        });
      };
      this.post = function (param) {
        param["type"] = param.type || "POST";
        param.beforeSend = beforeSend(param.beforeSend);
        //param.complete = complete(param.complete);
        return this.ajax(param);
      };

      this.get = function (param) {
        param["type"] = param.type || "GET";
        param.beforeSend = beforeSend(param.beforeSend);
        //param.complete = complete(param.complete);
        return this.ajax(param);
      };
      return this;
    }

    return new AjaxData();
  }(window);
  window.ajaxData = ajaxData;
  return ajaxData;

}) );
