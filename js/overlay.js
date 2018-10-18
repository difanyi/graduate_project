/**
 * Created by DaoYi on 2016/1/21.
 */
var overlay = function (config) {
    var _self = this;
    //var css = require('./index.css');
    _self.config = $.extend({}, overlay.config, config);
    _self._init();
};
overlay.config = {
    width: 625, //{number} 浮层的宽度
    height: 400, //{number} 浮层的高度
    title: '',//{string} dialog的标题,overlay无效
    titleOff: false, //{boolean} dialog是否需要title
    content: '', //{string} 浮层的内容
    DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
    DialogCancelBtn: true,//{boolean} dialog是否需要取消按钮
    DialogSureText: '确定',//{string} dialog的确认按钮自定义文案
    DialogCancelText: '取消',//{string} dialog的取消按钮自定义文案
    DialogSureCallback: '',//{function} dialog的确认按钮回调函数
    DialogCancelCallback: '',//{function} dialog的取消按钮回调函数
    OverlayCloseCallback: '',//{function} overlay的关闭按钮回调函数
    ifClose: true, //{boolean} dialog是否需要右上角关闭按钮和点击遮罩层关闭功能
    display: 'none', //
	cusClass: '', //自定义样式类，用于修改弹框内样式
    toastStatus : 'success', //{string} 气泡类型 success || error 默认success
    toastText : 'success',//{string} 气泡内的文案
    toastCallback : '', //{function} 气泡显示结束的回调函数
	toastStyle : null  //{object} 气泡样式属性
};
overlay.prototype = {
    _init: function () {
        var _self = this;
        $(document).off('keyup',_self._tabSwitch);
        if (_self.config.ifClose) {
            _self.config.display = 'block';
            /**
             * 关闭弹层
             */
            $(document).off('click', '.yd-overlay-close');
            $(document).on('click', '.yd-overlay-close', function (e) {

                if (_self.config.OverlayCloseCallback) {
                    _self.config.OverlayCloseCallback($('.yd-overlay-box'));
                } else {
                    _self._remove();
                }
            });
            /**
             * 点击遮罩层关闭
             */
            //$(document).off('click', '.yd-overlay-mask');
            //$(document).on('click', '.yd-overlay-mask', function (e) {
            //    $(document).off('keyup');
            //    if (_self.config.OverlayCloseCallback) {
            //        _self.config.OverlayCloseCallback($('.yd-overlay-box'));
            //    } else {
            //        _self._remove();
            //    }
            //});
        }
    },
    _overlay: function (callback) {
        var _self = this;
        var Body = $('body');
        var overlayHtml = '<div class="yd-overlay-box ' +_self.config.cusClass+ '">'
            + '<div class="yd-overlay-mask"></div>'
            + '<div class="yd-overlay" style="width:' + _self.config.width + 'px;height:' + _self.config.height + 'px;margin-left:-' + _self.config.width / 2 + 'px;margin-top:-' + _self.config.height / 2 + 'px">'
            + '<a class="yd-overlay-close" href="javascript:void(0);" target="_self" style="display: ' + _self.config.display + '">X</a>'
            + '<div class="yd-overlay-main">'
            + _self.config.content
            + '</div>'
            + '</div></div>';

        _self._remove();
        Body.append(overlayHtml);

        callback && callback($('.yd-overlay-box'));


    },
    _dialog: function () {
        var _self = this;
        var Body = $('body');
        var center = !_self.config.DialogCancelBtn || !_self.config.DialogSureBtn ? ' yd-dialog-center' : '';

        var sureHtml = _self.config.DialogSureBtn ? '<a class="yd-dialog-main-sure yd-dialog-main-btn ' + center + '" data-status="sure" href="javascript:void(0);" target="_self" title="' + _self.config.DialogSureText + '">' + _self.config.DialogSureText + '</a>' : '';
        var cancelHtml = _self.config.DialogCancelBtn ? '<a class="yd-dialog-main-cancel yd-dialog-main-btn' + center + '" data-status="cancel" href="javascript:void(0);" target="_self" title="' + _self.config.DialogCancelText + '">' + _self.config.DialogCancelText + '</a>' : '';
        var dialogInput = _self.config.DialogSureBtn && _self.config.DialogCancelBtn ? '<a href="javascript:void(0)" target="_self" class="yd-dialog-input"></a>' : '';
        var titleStr = _self.config.titleOff ? '' : '<h3 class="yd-dialog-title">' + _self.config.title + '</h3>';
        var dialogHtml = '<div class="yd-overlay-box ' +_self.config.cusClass+ '">'
            + '<div class="yd-overlay-mask"></div>'
            + '<div class="yd-dialog" style="width:' + _self.config.width + 'px;height:' + _self.config.height + 'px;margin-left:-' + _self.config.width / 2 + 'px;margin-top:-' + _self.config.height / 2 + 'px">'
            + '<a class="yd-overlay-close" href="javascript:void(0);" target="_self" style="display: ' + _self.config.display + '">X</a>'
            + titleStr
            + '<div class="yd-dialog-main">'
            + _self.config.content
            + '</div>'
            + sureHtml
            + cancelHtml
            + dialogInput
            + '</div></div>';

        _self._remove();
        $(Body).prepend(dialogHtml);
        if (_self.config.DialogCancelBtn) {
            $('.yd-dialog-main-btn').removeClass('yd-dialog-main-selected').blur();
            $('.yd-dialog-main-cancel').addClass('yd-dialog-main-selected').focus();
        }

        if (_self.config.DialogSureBtn) {
            $('.yd-dialog-main-btn').removeClass('yd-dialog-main-selected').blur();
            $('.yd-dialog-main-sure').addClass('yd-dialog-main-selected').focus();

        }

        if ($('.yd-overlay-box').find('input').length > 1) {
            $('.yd-overlay-box').find('input').eq(0).focus();
            $('.yd-dialog-main-btn').removeClass('yd-dialog-main-selected')
        }


        //$('.yd-dialog-main-btn').eq(1).addClass('yd-dialog-main-selected');

        $('.yd-dialog-box').css('height', window.innerHeight);

        _self.config.renderCallback && _self.config.renderCallback();


        $('.yd-dialog-main-sure').on('click', function (e) {
            _self._dialogSure();
        });

        $('.yd-dialog-main-cancel').on('click', function (e) {
            _self._dialogCancel();
        });


        /**
         * tab切换 + enter确认
         */
        $(document).off('keyup',_self._tabSwitch);
        $(document).on('keyup',_self._tabSwitch)
    },
    _dialogSure: function () {
        var _self = this;
        //$(document).off('keyup');
        //console.log('sure');
        _self.config.DialogSureCallback && _self.config.DialogSureCallback(_self);
    },
    _dialogCancel: function () {
        var _self = this;
        $(document).off('keyup',_self._tabSwitch);
        //console.log('cancel');
        if (_self.config.DialogCancelCallback) {
            _self.config.DialogCancelCallback();
        } else {
            _self._remove();
        }
    },
    _toast:function(){
        var _self  = this;
        var body = $('body');
        var toastClsName = _self.config.toastStatus == 'success' ? 'toast-success' : 'toast-error';
        var toastHtml = '<div class="yd-overlay-box yd-toast-box">' +
            '<div class="yd-overlay-mask"></div>' +
            '<div class="yd-overlay-toast ' + toastClsName + ' "><span></span>'+ _self.config.toastText +'</div>' +
            '</div>';
        _self._remove();
        body.append(toastHtml);
        var toastCls = $('.yd-toast-box');
		_self.config.toastStyle&&toastCls.css(_self.config.toastStyle);
        toastCls.animate({
            opacity :.8,
            filter:'alpha(opacity=80)',
            paddingTop: '+=20px'
        },500,'linear', function () {
            setTimeout(function () {
				_self._remove();
                if(_self.config.toastCallback){
                    _self.config.toastCallback(_self);
                }
            },1000);
        })
    },
    _remove: function () {
        var _self = this;
        var parents = $('.yd-overlay-box');
        $(document).off('keyup',_self._tabSwitch);
        parents.remove();
    },
    _tabSwitch : function(event){
        var currentActiveCls = $(document.activeElement);
        var dialogSelectedCls;
        if (event.keyCode === 9) {
            if (currentActiveCls.hasClass('yd-dialog-main-btn')) {
                currentActiveCls.addClass('yd-dialog-main-selected').focus().siblings('.yd-dialog-main-btn').removeClass('yd-dialog-main-selected');
            }
            currentActiveCls = $(document.activeElement);
            if (currentActiveCls.hasClass('yd-dialog-input')) {
                $('.yd-dialog-main-btn').removeClass('yd-dialog-main-selected').blur();
                $('.yd-dialog-main-sure').addClass('yd-dialog-main-selected').focus();
            }


        }
        return false;
    }

};