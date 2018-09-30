define( function (require, exports, module) {

  if ( !!document.getElementById( 'mobileDialog' ) ) {
    return;
  };

var mobileDialog = '';

mobileDialog += '<div id="mobileDialog" data-alertModal class="hide">';
mobileDialog += '	<div class="malertDialog">';
mobileDialog += '			<div class="malertDialogMain">';
mobileDialog += '			<div class="dialog_hgroup">';
mobileDialog += '				<div class="dialog_title">提示信息</div>';
mobileDialog += '				<div class="dialog_close" data-dialog-close></div>';
mobileDialog += '			</div>';
mobileDialog += '			<div class="dialog_body" data-dialogBody>';
mobileDialog += '				用户名不正确';
mobileDialog += '			</div>';
mobileDialog += '			<div class="dialog_button" data-alert>';
mobileDialog += '				<button class="dialog_cancel" data-dialog-close>关闭</button>';
mobileDialog += '			</div>';
mobileDialog += '			<div class="dialog_button" data-prompt>';
mobileDialog += '				<button class="dialog_submit" data-dialog-submit>确定</button>';
mobileDialog += '				<button class="dialog_cancel ml10" data-dialog-cancel>取消</button>';
mobileDialog += '			</div>';
mobileDialog += '		</div>';
mobileDialog += '	</div>';
mobileDialog += '</div>';


  $( 'body' ).append( mobileDialog );

  const dialogBody = $( '[data-dialogBody]' );
  const alertModal = $( '[data-alertModal]' );

  const alertButtonGroup = $( '[data-alert]' );
  const promptButtonGroup = $( '[data-prompt]' );

  const dataDialogSubmit = $( '[data-dialog-submit]' );
  const dataDialogCancel = $( '[data-dialog-cancel]' );


  var ok, cancel;

  $( document )
    .on( 'click.bs.alertDialog', '[data-dialog-submit]', function () {
      ok();
      alertModal.hide();
    } )
    .on( 'click.bs.alertDialog', '[data-dialog-cancel]', function () {
      cancel();
      alertModal.hide();
    } )
    .on( 'click.bs.alertDialog', '[data-dialog-close]', function () {
      alertModal.hide();
    } );



  ( function () {
  	/**
  	 * alertDialog("提交成功");
  	 */
    window.alertDialog = function ( html ) {
      alertButtonGroup.show();
      promptButtonGroup.hide();
      dialogBody.html( html );
      alertModal.show();
    }
  } )();

  ( function () {

  	/** 案例
    promptDialog( '你好朋友', {
      text: 'OK',
      fn: function () {
        alert( 1 );
      }
    }, {
      text: 'cancel',
      fn: function () {
        alert( 1 );
      }
    } );
   */

    window.promptDialog = function ( html, first, two ) {
      first = first || {};
      two = two || {};
      dataDialogSubmit.text( first.text || '确定' );
      dataDialogCancel.text( two.text || '取消' );
      ok = first.fn || function () {};
      cancel = two.fn || function () {};
      alertButtonGroup.hide();
      promptButtonGroup.show();
      dialogBody.html( html );
      alertModal.show();
    };
  } )();
} );
