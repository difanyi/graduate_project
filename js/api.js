/**
 * Created by 道一 on 2016/3/15.
 */
$.support.cors = true;
var localUrl = 'http://'+window.location.href.split('/')[2]+'/api/';
if(localUrl.indexOf('localhost')>-1){
    localUrl = 'http://his.huimei.com/api/';
}
var cloudClinic = {};
cloudClinic.api = {
    is_jump  : false,
    query_port : localUrl, //接口请求域名
    logo_from:{
        huimei:{
            logo:"./images/header_logo.png",
            title:"惠每云诊所系统",
            src:"http://www.huimei.com",
            name:"惠每云诊所",
            icon:"./images/favicon.ico"
        },
        anheshou:{
            logo:"./images/header_logo_anheshou.png",
            title:"安和寿诊所系统",
            src:"#",
            name:"安和寿诊所",
            icon:"./images/favicon_anheshou.ico"
        }
    },
    /**
     * todo 简单封装ajax，统一处理 401 和 error
     * @param url 接口的url
     * @param data 接口的参数
     * @param callback 成功的回调
     */
    io : function (url,data,callback,delay,asyncCtr) {
        var _self = this;
        var dataStr = JSON.stringify(data),
            first = dataStr.indexOf('?'),
            newDataStr = dataStr;
        if(first > -1){
            newDataStr = dataStr.replace(/\?/g, '');
            newDataStr = dataStr.split('?')[0]+ '?' + newDataStr.slice(first);
        }
        var async = true; 
        if(asyncCtr && asyncCtr != ''){
            async = false;
        }
        $.ajax({
                url: _self.query_port + url,
                data: newDataStr,
                type: 'POST',
                async: async,
                ContentType: "application/json; charset=utf-8",
                dataType: 'json',
                xhrFields: {
                    withCredentials: true
                },
                headers: {
                    "Content-Type": "application/json; charset=utf-8"
                    //Authorization:auth
                },
                success: function (data) {
                    var $delay = delay||0;
                    setTimeout(function(){
                        if($delay){cloudClinic.api.loading.removeLoading();}
                        if(data.head&&data.head.error == 401){
                            //from参数处理
                            var searchStr=window.top.location.search;
                            var Request= cloudClinic.api.getRequest(searchStr);
                            //未登录
                            var win_is_jump = !window.is_jump ?  window.parent.is_jump : window.is_jump;
                            if(win_is_jump == false || win_is_jump == undefined){
                                window.is_jump ?  window.parent.is_jump = true : window.is_jump = true;
                                var href = JSON.stringify(window.parent.location.href);
                                var current_href = JSON.stringify(window.location.href);
                                var origin_url = 'originurl='+ new Base64().encode(window.location.href);
                                var huimeiPrintStr = window.localStorage && window.localStorage.getItem("huimeiPrint"),
                                    huimeiPrintObj = JSON.parse(huimeiPrintStr)||{};
                                huimeiPrintObj['systemSet'] = {};
                                window.localStorage && window.localStorage.setItem("huimeiPrint",JSON.stringify(huimeiPrintObj));
                                window.localStorage&&window.localStorage.setItem('sysFrame','');
                                if(href.indexOf('login') == -1 && current_href.indexOf('index') == -1){
                                    window.parent.location.href = '../../login.html' + "?"+origin_url;
                                }else if(href.indexOf('login') == -1 && current_href.indexOf('index') > -1){
                                    window.parent.location.href = 'login.html' + "?"+origin_url;
                                }
                            }
                        }else{
                            callback && callback(data);
                        }
                    },$delay);
                },
               
/*			   error: function (e) {
                    var $delay = delay||0;
                    setTimeout(function() {
                        function huimei_post_page(action,url){
                            $.ajax({
                                url: localUrl+'cdss/js_log?action='+action+'&api='+url,
                                type: 'POST',
                                headers:{
                                    "Content-Type":"application/json; charset=utf-8"
                                },
                                success: function(d){}
                            });
                        }
                        huimei_post_page('2.0.1',url);
                        cloudClinic.api.loading.removeLoading();
                        //console.log(e);
                        var errorOverlay;
                        errorOverlay = new overlay({
                            width: 500, //{number} 浮层的宽度
                            height: 300, //{number} 浮层的高度
                            title: '系统提示',
                            content: '<p>系统开小差了，马上回来</p>',
                            DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                            DialogCancelBtn: false,//{boolean} dialog是否需要取消按钮
                            DialogSureCallback: function () {
                                errorOverlay._remove();
                            }
                        });
                        errorOverlay._dialog();
                        //console && console.log('url:' + JSON.stringify(url) + ' data:' + JSON.stringify(data));
                    },$delay)
                }*/
            })
    },
    //placeholder兼容ie10以下
    handelPlaceholder : function(){
        var ua = navigator.userAgent,
            reg = /msie (\d*)/;
        if(reg.test(ua.toLowerCase())){
            if(RegExp.$1 < 10){
                $('input[placeholder]').each(function(i,k){
                    addPlaceholeder($(k));
                });
                $(document).on('blur','input[placeholder]',function(){
                    var $this = $(this);
                    if($this.hasClass('drug-num')) return;//排除直接购药数量的input
                    if($this.val() === ''){
                        addPlaceholeder($this);
                    }
                })
                    .on('focus','input[placeholder]',function(){
                        var $this = $(this);
                        if($this.val() === $this.attr('placeholder')){
                            $this.val('').removeClass('placeholder');
                        }
                    })
                    .on('change','input[placeholder]',function(){
                        var $this = $(this);
                        if($this.val() != $this.attr('placeholder')){
                            $this.removeClass('placeholder');
                        }
                    });

                function addPlaceholeder($el){
                    $el.addClass('placeholder')
                        .val($el.attr('placeholder'));
                }
            }
        }
    },
    //判断浏览器是否是IE，并判断版本号
    jugleIeVersion : function(){
        var ua = navigator.userAgent,
            reg = /msie (\d*)/;
        if(reg.test(ua.toLowerCase())){
            if(RegExp.$1 < 8){
                var ieOverlay = new overlay({
                    width: 500, //{number} 浮层的宽度
                    height: 300, //{number} 浮层的高度
                    title: '系统提示',
                    content: '<p>您的浏览器版本过低，请使用谷歌浏览器或者最新的IE浏览器尝试。</p>',
                    DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                    DialogCancelBtn: false,//{boolean} dialog是否需要取消按钮
                    DialogSureCallback: function (thisOverlay) {
                        thisOverlay._remove();
                    }
                })._dialog();
            }
        }
    },
    //获取url中"?"符后的字串所包含的值，返回对象
    getRequest : function(searchStr) {
        var url = searchStr||location.search; //获取url中"?"符后的字串
        var theRequest = {};
        if (url.indexOf("?") != -1) {
            var str = url.substr(1);
            var strs = str.split("&");
            for(var i = 0; i < strs.length; i ++) {
                theRequest[strs[i].split("=")[0]]=(strs[i].split("=")[1]);
            }
        }
        return theRequest;
    },
    //将F5更改为刷新当前iframe
    changeFlashWindow : function(callback){
        $(window.top.document).on('keydown',function(e){
            handleFlash(e,callback);
        });
        $(window.document).on('keydown',function(e){
            handleFlash(e,callback);
        });
        function handleFlash(e,callback){
            if(e.keyCode == 116){
                e.preventDefault();
                e.keyCode = 0;
                if(callback){
                    callback(window);
                }else{
                    window && window.location.reload();
                }
                return false;
            }
        }
    },
    //页面input验证
    inputExpApi: {
        timer : null ,
        showError:function(info,callback,time){
            var _self = this;
            cloudClinic.api.loading.removeLoading();
            clearTimeout(_self.timer);
            var $error = $('.record-error');
            $error.hide();
            if(!$error.length) $("body").append('<div class="record-pop record-error" style="display: none;"></div>');
            $('.record-error').html('<span class="record-error-mark"></span>'+info).show(300);
            _self.timer = setTimeout(function(){
                $('.record-error').fadeOut(300,function(){
                    callback && callback();
                    $('.record-error').html('');
                });
            },time||2400);
        },
        bindEvents : function($str, opts, regFn){
            if(opts.cont){
                $(opts.cont).on("blur",$str,function(){var _this=this;regFn(_this)})
                    .on("focus",$str,function(){var _this=this;$(_this).removeClass("red-ipt")});
            }else{
                $($str).on("blur",function(){var _this=this;regFn(_this)})
                    .on("focus",function(){var _this=this;$(_this).removeClass("red-ipt")});
            }
        },
        //针对上面handelPlaceholder做的特殊处理
        iePlaceholder : function($el){
            var ua = navigator.userAgent,
                reg = /msie (\d*)/;
            if(reg.test(ua.toLowerCase())){
                if(RegExp.$1 < 10 && $el.attr('placeholder') != '' && $el.val() == $el.attr('placeholder')){
                    return true;
                }else{
                    return false;
                }
            }
        },
        isInt:function($str,opts){
            var self=this;
            var _opts={
                info:"仅支持正整数！",    //error描述
                cont:"",                  //事件代理绑定需要
                zero:false,               //判断为0时是否通过验证
                errEmpty:true,            //错误提示时是否清空
                maxValue:'',               //最大值
                actionCallback: '',        //成功或者失败时返回的回调
                remind : true        //是否显示pop提示
            };
            $.extend(_opts,opts);

            function isIntExp(_this){
                var nd=$(_this);
                var val=nd.val();
                if(val=="" || self.iePlaceholder(nd)) return;
                var nval=parseInt(val);
                if(nval>0 || _opts.zero && nval==0){
                    if(_opts.maxValue && nval > parseInt(_opts.maxValue)){
                        _opts.errEmpty&&nd.val("");
                        nd.addClass('red-ipt');
                        _opts.remind && self.showError('此处最大值为'+_opts.maxValue);
                        _opts.actionCallback && _opts.actionCallback({result:false,reason:'此处最大值为'+_opts.maxValue});
                        return ;
                    }
                    nd.val(nval);
                    _opts.actionCallback && _opts.actionCallback({result:true,reason:''});
                }else{
                    _opts.errEmpty&&nd.val("");
                    nd.addClass('red-ipt');
                    _opts.remind && self.showError(_opts.info);
                    _opts.actionCallback && _opts.actionCallback({result:false,reason:_opts.info});
                }
            }
            self.bindEvents($str, _opts, isIntExp);
        },
        isFloat:function($str,opts){

            var self=this;
            var _opts={
                info:"仅支持正数！",
                fixed:"",            //设置保留几位小数
                cont:"",
                zero:false,
                decimalPoint:false,
                errEmpty:true,
                maxValue:'',
                actionCallback : '',
                remind : true,
                showFixed: true,     //是否需要将值根据fixed设置显示保留相应位数小数的值
                negative:false       //是否可为负数
            };
            $.extend(_opts,opts);

            function isFloatExp(_this){
                var nd=$(_this);
                var val=nd.val();
                if(val=="" || self.iePlaceholder(nd)) return;
                var nval=parseFloat(val);
                if(_opts.negative?_opts.negative:(nval>0|| _opts.zero && nval==0)){
                    if(_opts.fixed){
                        var numArray = nval.toString().split('.');
                        if(numArray[1] && numArray[1].length > parseInt(_opts.fixed)-1){
                            nval = _opts.decimalPoint ? nval.toFixed(_opts.fixed).decimalPoint() : nval.toFixed(_opts.fixed);
                        }else{
                            _opts.showFixed && ( nval = _opts.decimalPoint ? nval.toFixed(_opts.fixed).decimalPoint() : nval.toFixed(_opts.fixed) );
                        }
                    }
                    if(_opts.maxValue && nval > parseFloat(_opts.maxValue)){
                        _opts.errEmpty&&nd.val("");
                        nd.addClass('red-ipt');
                        _opts.remind && self.showError('此处最大值为'+_opts.maxValue);
                        _opts.actionCallback && _opts.actionCallback({result:false,reason:'此处最大值为'+_opts.maxValue});
                        return ;
                    }
                    nd.val(nval);
                    _opts.actionCallback && _opts.actionCallback({result:true,reason:''});
                }else{
                    _opts.errEmpty&&nd.val("");
                    nd.addClass('red-ipt');
                    _opts.remind && self.showError(_opts.info);
                    _opts.actionCallback && _opts.actionCallback({result:false,reason:_opts.info});
                }
            }
            self.bindEvents($str, _opts, isFloatExp);
        },
        isIDnumber:function($str,opts){
            var self=this;
            var _opts={
                info:"身份证号格式有误",
                cont:"",
                errEmpty:false,
                actionCallback:'',
                remind: true
            };
            $.extend(_opts,opts);

            function isIDnumExp(_this){
                var nd=$(_this);
                var val= $.trim(nd.val());
                if(self.iePlaceholder(nd)) return;
                nd.val(val);
                var idNoTest=/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/;
                if(val!="" && !idNoTest.test(val)){
                    _opts.errEmpty&&nd.val("");
                    nd.addClass('red-ipt');
                    _opts.remind && self.showError(_opts.info);
                    _opts.actionCallback && _opts.actionCallback({result:false,reason:_opts.info});
                }else{
                    _opts.actionCallback && _opts.actionCallback({result:true,reason:''});
                }
            }
            self.bindEvents($str, _opts, isIDnumExp);
        },
        isPhoneNo:function($str,opts){
            var self=this;
            var _opts={
                info:"电话号码格式有误！",
                cont:"",
                errEmpty:false,
                actionCallback: '',
                remind : true,
                telphoneNo: false      //是否需要精确的手机号码验证
            };
            $.extend(_opts,opts);

            function isPhoneNoExp(_this){
                var nd=$(_this);
                var val= $.trim(nd.val()),
                    phoneTest = '';
                if(self.iePlaceholder(nd)) return;
                nd.val(val);
                if(!_opts.telphoneNo){
                    phoneTest=/^[\+\s\-\d]*$/;
                }else{
                    phoneTest=/^(13[0-9]|15[012356789]|17[01678]|18[0-9]|14[57])[0-9]{8}$/;
                }
                if(val!="" && !phoneTest.test(val)){
                    _opts.errEmpty&&nd.val("");
                    nd.addClass('red-ipt');
                    _opts.remind && self.showError(_opts.info);
                    _opts.actionCallback && _opts.actionCallback({result:false,reason:_opts.info});
                }else{
                    _opts.actionCallback && _opts.actionCallback({result:true,reason:''});
                }
            }
            self.bindEvents($str, _opts, isPhoneNoExp);
        },
        isNumber:function($str,opts){
            var self=this;
            var _opts={
                info:"仅支持数字！",
                cont:"",
                errEmpty:false,
                actionCallback: '',
                remind:true,
                alsoLetter: false         //是否还可以支持字母
            };
            $.extend(_opts,opts);

            function isNumberExp(_this){
                var nd=$(_this);
                var val= $.trim(nd.val());
                if(self.iePlaceholder(nd)) return;
                var reg=/^[0-9]*$/;
                _opts.alsoLetter && (reg = /^[a-zA-Z0-9]*$/);
                if(val!="" && !reg.test(val)){
                    _opts.errEmpty&&nd.val("");
                    nd.addClass('red-ipt');
                    _opts.remind && self.showError(_opts.info);
                    _opts.actionCallback && _opts.actionCallback({result:false,reason:_opts.info});
                }else{
                    nd.val(val);
                    _opts.actionCallback && _opts.actionCallback({result:true,reason:''});
                }
            }
            self.bindEvents($str, _opts, isNumberExp);
        },
        textLimitLength : function($str, opts){
            var self = this;
            var _opts = {
                info:'超出指定字符长度！',
                cont: '',
                maxLength: 1,                //字符串最大长度
                errEmpty:false,
                actionCallback:'',
                remind:true
            };
            $.extend(_opts,opts);

            function textLimitLengthExp(_this){
                var $this = $(_this),
                    val = $.trim($this.val());
                if(self.iePlaceholder($this)) return;
                if(val != '' && strlen(val) > parseInt(_opts.maxLength)){
                    _opts.errEmpty && $this.val('');
                    $this.addClass('red-ipt');
                    _opts.remind && self.showError(_opts.info);
                    _opts.actionCallback && _opts.actionCallback({result:false,reason:_opts.info,ele:$this})
                }else{
                    _opts.actionCallback && _opts.actionCallback({result:true,reason:'',ele:$this});
                    $this.val(val);
                }
                //获取字符串，字符长度
                function strlen(str){
                    var len = 0;
                    for(var i=0; i<str.length; i++){
                        var c = str.charCodeAt(i);
                        //单字节加1
                        if((c >= 0x0001 && c <= 0x007e) || (0xff60<=c && c<=0xff9f)) { 
                            len++;
                        }
                        else{ 
                            len+=2; 
                        }
                    }
                    return len;
                }
            }
            self.bindEvents($str, _opts, textLimitLengthExp);
        },
        trimText:function($str,opts){
            var self = this;
            var _opts = {
                inDiv:false,
                needText:false,
                info:'信息不能为空！',
                cont: '',
                errEmpty:true,
                actionCallback:'',
                remind:true
            };
            $.extend(_opts,opts);
            self.bindEvents($str, _opts, function(_this){
                var $this = $(_this),
                    val = $.trim($this.val());
                _opts.inDiv && (val = $.trim($this.text()));
                if(val=="" || self.iePlaceholder($this)) {
                    _opts.needText &&
                    ($this.addClass('red-ipt'),
                    _opts.remind && self.showError(_opts.info),
                    _opts.actionCallback&&_opts.actionCallback({result:false,reason:_opts.info,ele:$this}));
                }else{
                    _opts.actionCallback&&_opts.actionCallback({result:true,reason:'',ele:$this});
                }
                $this.val(val);
                _opts.inDiv && $this.text(val);
            });
        }
    },
    //获取时间区间,返回一个对象包括该月开始时间和当前时间
    getTimeInterval : function(){
        var split = '-';

        var nowDate = new Date(),
            nowYear = nowDate.getFullYear(),
            nowMonth = nowDate.getMonth() +1,
            nowDay = nowDate.getDate(),
            nowYM = nowYear +split+ changeDate(nowMonth),
            dateStart = nowYM+split+changeDate(nowDay),
            dateEnd = nowYM+split+changeDate(nowDay),
            interval = {
                start : dateStart,
                end : dateEnd
            };
        //在一位的日期数字前补上0
        function changeDate(str){
            parseInt(str) < 10 && (str = '0' + str);
            return str;
        }

        return interval;
    },
    //左部导航的点击事件绑定函数
    bindNavListEvent : function(){
        var doctorId=window.parent.window.doctorId;
        $(document).on('click','.nav-list',function(){
            var pageName = $(this).attr('data-page'),
                index = $('.nav-list').index($(this)),
                mainIndex = getCookieInfo('mainIndex'),
                getTimestamp = new Date().getTime();
            window.parent.jumpGlobal.jumpFromLeft = true;    //修改父元素的全局变量
            window.parent.document.getElementById("clinic_main").src="./view/"+pageName+"/"+pageName+".html?doctorId="+doctorId+'&timestamp='+getTimestamp;
            $('.nav-check').removeClass('nav-check');
            $(this).addClass('nav-check');
            window.parent.setCookie('leftIndex',index);
            window.parent.setCookie('preMainIndex',mainIndex);
        });
        function setCookie(name,value,day){
            var Days = day || 0.5;
            var exp = new Date();
            exp.setTime(exp.getTime() + Days*24*60*60*1000);
            document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
        }
        function getCookieInfo (name){
            var cookieArray=document.cookie.split("; "); //得到分割的cookie名值对
            var cookie=new Object();
            for (var i=0;i<cookieArray.length;i++){
                var arr=cookieArray[i].split("=");       //将名和值分开
                if(arr[0]==name)return unescape(arr[1]); //如果是指定的cookie，则返回它的值
            }
            return "";
        }
    },
    /*退出当前窗口时如果有填写了需要保存内容弹出提示
    * win: 窗口window对象
    * jgOtherDomFn: 函数，用户可以按自己需求添加需要判断的内容，需要返回message
    */
    notEmptySaveRemind : function(win, jgOtherDomFn){
        var isClicked = false;
        var isFirst = true;    //防止IE8弹出2次选择
        $(win.document).on('click','input[type=text]',function(e){
            isClicked = true;
        });
        $(win).on('beforeunload', function(e){
            var message = '';
            $('input[type=text]').each(function(i, k){
                var $k = $(k),
                    p = $k.attr('placeholder'),
                    val = $k.val();
                if(val != '' && val != p && message == ''){
                    message = '本页面已填写了内容，确认不保存就退出吗？';
                    return false;
                }
            });
            if(message == '' && jgOtherDomFn){
                message = jgOtherDomFn(message);
            }
            if(isClicked && message != '' && isFirst){
                isFirst = false;
                setTimeout(function(){
                    isFirst = true;
                },100);
                return message;
            }
        });
    },
    loading : {
        showLoading:function(){
            var str = '<div class="loading-pop" id="j_loading_pop">' +
                            '<div class="loading-bg"></div>' +
                            '<img src="../../images/loading.gif" alt="loading" class="loading-img"/>' +
                      '</div>';
            $('body').append(str);
        },
        removeLoading:function (){
            var $e = $('#j_loading_pop');
            $e&&$e.remove();
        }
    },
    //js继承用方法
    inhertClass:{
        _object:function(o){
            var _self=this;
            function F(){}
            F.prototype = o;
            return new F();
        },
        inheritClass:function(parent,Child){
            var _self=this;
            var f = _self._object(parent.prototype);
            f.constructor = Child;
                        Child.prototype = f;
        }
    },
    // 默认的ctrl+enter触发的方法,默认是一个空对象
    ctrlEnter  : {
        _this : this,
        fn : null
    },
    /**
     * 监听ctrl+enter事件,判断ctrlEnter是否是一个方法,如果是就执行
     * 监听 上(keyCode=38),下(keyCode=40)键盘事件,在 `.key-row`之间来回切换
     * 监听 左(keyCode=37),右(keyCode=39)键盘事件,在 `.key-col`之间来回切换
     * @param event
     * @returns {boolean}
     */
    keyDownFn : function (event) {
        var currentActiveCls = $(document.activeElement);
        var keyRowCls,keyColCls,index;
       if( event.ctrlKey && event.keyCode == 13){
           currentActiveCls.blur();
           $.isFunction(cloudClinic.api.ctrlEnter.fn) && cloudClinic.api.ctrlEnter.fn.call(cloudClinic.api.ctrlEnter._this);
       }
        if(event.keyCode == 38){//上
            keyRowCls = $('key-row');
            index = currentActiveCls.index();
            keyRowCls[index-1] && keyRowCls[index-1].focus();
        }
        if(event.keyCode == 40){//下
            keyRowCls = $('key-row');
            index = currentActiveCls.index();
            if(keyRowCls[index+1]){
                 keyRowCls[index+1].focus();
            }else{
                keyRowCls[0] && keyRowCls[0].focus();
            }
        }
        if(event.keyCode == 37){//左
            keyColCls = $('key-col');
            index = currentActiveCls.index();
            keyColCls[index-1] && keyColCls[index-1].focus();
        }
        if(event.keyCode == 39){//右
            keyColCls = $('key-col');
            index = currentActiveCls.index();
            if(keyColCls[index+1]){
                keyColCls[index+1].focus();
            }else{
                keyColCls[0] && keyColCls[0].focus();
            }
        }



        //return false;
    }
};
/***** 全局函数 *****/
/* 
	V() ：默认值检验函数
	参数 ：value 待检验值 ，def value为假值是默认返回值
*/
function V(value,def){
	var def = def===undefined?'':def;
	return (value===undefined||value === null)?def:value;
}
function getQueryString(name) { 
	var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i"); 
	var r = window.location.search.substr(1).match(reg); 
	if (r != null) return unescape(r[2]); return null; 
}
cloudClinic.leftnav = {
    todayListInit:function(){
        var _self = this;
        if($(".nav-clinic").hasClass("nav-check")){
            var todayDom = '<div class="nav-today-list">' +
                '<p class="today-list-title">今日就诊</p>' +
                '<div class="today-list-load">' +
                '<div class="loading-main">' +
                '正在加载中,请稍后...' +
                '</div>' +
                '</div>' +
                '<div class="today-list-data j_today_list"></div>' +
                '</div>';
            $("#page-left-nav").append(todayDom);
            _self.getTodayRecord();
            _self.resizeHeight();
            $(window).on("resize",function(){_self.resizeHeight();});
        }
    },
    getTodayRecord:function(){
        var _self = this;
        var curRecordId = cloudClinic.api.getRequest()['recordId']||null;
        cloudClinic.api.io(
            "his/outpatient/todayPatientInfo",
            { doctorId:doctorInfo().doctorId },
            function(data){
                var d = data.body.patientList;
                $(".today-list-load").hide();
                if(d && d.length){
                    var str="";
                    for(var i=0; i< d.length; i++) {
                        var href = d[i].modle == 2 ? "../newPrescription/newPrescription.html" : "../newRecord/newRecord.html";
                        var mark = curRecordId==null ? "" : (curRecordId == d[i].recordId ? "hover" : "");
                        mark!="" && $(".cc-left-mark").removeClass("cc-left-mark");
                        str += '<a class="today-list-item '+ mark +'" href="'+ href +'?patientId='+ (d[i].patientId||"") +'&recordId='+ (d[i].recordId||"") +'">'
                        + '<i class="item-key">'+ (d.length-i) +'</i>'
                        + '<i class="item-name">'+ (d[i].patientName||"") +'</i>'
                        + '<i class="item-time">'+ (d[i].updateDate||"") +'</i>'
                        + '</a>';
                    }
                    $(".today-list-data").html(str);
                    $('.today-list-title').html('今日就诊('+d.length+')')
                }else{
                    $(".today-list-data").html("<p class='today-list-none'>暂无今日就诊</p>");
                }
            }
        );
    },
    resizeHeight:function(){
        var _self = this;
        //var topHeight = $(".today-list-data").offset().top;
        var screenHeight = $(window).height();
        $(".j_today_list").css("height",screenHeight - 230);
    }
};
$(document).on('keydown',cloudClinic.api.keyDownFn);
