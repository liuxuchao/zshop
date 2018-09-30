define(function(require, exports, module){
var exports = module.exports;

exports.init = function(options){
  if ( options.home ) {
    require('./page/home');
  }

}
});