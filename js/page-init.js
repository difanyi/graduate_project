//加载即执行
(function($){
    if($!=="undefined"){
        //生成菜单
        pageInit();
    }
})(jQuery);

//创建菜单和头部主体内容
function pageInit(right_arr){
    //参数部分
    var domain = 'http://'+location.host,
        menu_url= '../sysFrame.json',
        //menu_url= '../manageFrame.json',
        login_url= '../../login.html',
        userinfo_url = '../userInfo/userInfo.html',
        message_url = '../newMessage/newMessage.html',
        help_url='../helpofPatient/helpofPatient.html'
        Request = cloudClinic.api.getRequest();
    //---处理部分---//
    //判断登录状态
    loginStateCheck();
    adapter();
    judgeNeedImprove();
    $(window).resize(function(){adapter();});
    //初始化菜单
    //本地
    //$.getJSON(menu_url,function(data){
    //if(!$.isEmptyObject(data)&&data.header_cont&&data.menu_conf){
    //        messageInit();
    //	createFrameCont(data,right_arr);
    //	accountInfoInit();
    //        cloudClinic.leftnav.todayListInit();
    //}
    //else{
    //	alert("获取数据失败，请刷新页面重试");
    //}
    //});

    //获取存在localStorage中的sysFrame数据，如果存在则搭建页面，如果不存在则跑接口获取并且存入localStorage
   var frame = window.localStorage&&window.localStorage.getItem('sysFrame');
   if(!frame){
        cloudClinic.api.io('his/login/getSysFrame',{},function(data){
            if(!$.isEmptyObject(data)&&data.header_cont&&data.menu_conf){
                messageInit();
                createFrameCont(data,right_arr);
                accountInfoInit();
                cloudClinic.leftnav.todayListInit();
                window.localStorage&&window.localStorage.setItem('sysFrame',JSON.stringify(data));
            }else{
                alert("获取数据失败，请刷新页面重试");
            }
        });
   }else{
        var lsFrame = JSON.parse(frame);
        messageInit();
        createFrameCont(lsFrame, right_arr);
        accountInfoInit();
        cloudClinic.leftnav.todayListInit();
   }

    //二维码相关
    $(document).on('mouseenter','.J_showEwm',function(){$('.J_hm_ewm').show()})
        .on('mouseleave','.J_showEwm',function(){ $('.J_hm_ewm').hide()});

    //---函数定义部分---//

    //框架主要内容填充
    function createFrameCont(fra_data,right_arr){
        var checkLeft = false;
        var header_cont=stripscript(fra_data.header_cont),
            menu_conf=fra_data.menu_conf,
            template_admin = fra_data.super_admin,
            menu_strs=createMenuStr(menu_conf,right_arr);
        $("#header-content").html(header_cont);
        $(".header-nav").html(menu_strs.header);
        $("#page-left-nav").html(menu_strs.leftnav);
        var header_title = $('.j_logo_pos').text();
        var localUrl = window.location.href.split('/')[2];
        if((localUrl.indexOf('anheshou')==-1)&&(header_title.indexOf('安和寿')==-1)){
            $('.bottom-ewm').show();
        }
        if(template_admin=='1'){
            $('.cloudClinic-body').attr('superAdmin',0)
        }else{
           //非管理员诊所处方不显示
        }
        if(!checkLeft){
            var overLay = new overlay({
                width: 550, //{number} 浮层的宽度
                height: 330, //{number} 浮层的高度
                title: '提示',
                content: '<p>该帐号没有此页面权限,请联系管理员</p>',
                DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                DialogCancelBtn: false,//{boolean} dialog是否需要取消按钮
                DialogSureCallback: function () {
                    userLoginout(login_url);
                }
            });
            overLay._dialog();
        }
        //生成菜单字符串
        function createMenuStr(menu_data,right_data){
            var menu_strs={"header":"","leftnav":""};
            if(menu_data&&!$.isEmptyObject(menu_data)){
                var cur_dir=getPageInfo("dir"),
                    cur_page=getPageInfo();
                for(var h_key in menu_data){
                    if(checkMenuRight(right_data,h_key)){
                        var item_data = menu_data[h_key],
                            son_data = item_data.son_menu,
                            cur_hmenu = son_data[cur_dir] !== undefined,
                            hmenu_mark = cur_hmenu ? "nav-check" : "",
                            hmenu_url = item_data.def_url;
                        //判断是否显示主菜单项
                        !item_data.hide&&(menu_strs.header += '<a href="'+hmenu_url+'" class="nav-list nav-'+h_key+' '+hmenu_mark+'">'+item_data.des+'</a>');
                        //生成左侧菜单
                        if(cur_hmenu&&son_data){
                            checkLeft = true;
                            for(var l_key in son_data){
                                if(checkMenuRight(right_data,h_key,l_key)){
                                    var cur_son = son_data[l_key],
                                        pages = son_data[l_key].pages,
                                        def_page = pages[cur_son['def_page']]?V(pages[cur_son['def_page']].url):'',
                                        cur_lmenu = (l_key==cur_dir)&&(pages[cur_page] !== undefined),
                                        lmenu_mark = cur_lmenu?"cc-left-mark":"",
                                        lmenu_url = def_page?('../'+l_key+'/'+def_page):'javascript:void(0);',
                                        lname = V(cur_son.name);
                                    cur_lmname = cur_lmenu?pages[cur_page]['name']:'';
                                    cur_lmname && (document.title = cur_lmname);
                                    menu_strs.leftnav += '<a href="'+lmenu_url+'" class="left-nav-'+l_key+' '+lmenu_mark+'"><span class="ln-i-'+l_key+'"></span>'+lname+'</a>';
                                }
                            }
                        }
                        //追加左侧菜单附加内容
                        if(cur_hmenu&&item_data.add_cont){
                            menu_strs.leftnav += stripscript(item_data.add_cont);
                        }
                    }
                }
            }
            return menu_strs;
        }
        //权限检测
        function checkMenuRight(right_data,header,left){
            return true;
        }
    }


    //登录状态处理,无cookie尝试从后来获取
    function loginStateCheck(){
        //获取cookie中信息
        var doctor_info=doctorInfo();
        if(doctor_info.doctorId === undefined){
            cloudClinic.api.io("his/user/getAccountInfo",{},function(d){
                if(d.head.error!=0){location.href = login_url;}
                else{
                    var doc_info_str=JSON.stringify(d.body);
                    doctorInfo(doc_info_str);
                    location.href=location.href;
                }
            })
        }
    }
    //系统消息初始化
    function messageInit(){
        var urlArr = location.href.split('/'),
            pageName = urlArr[urlArr.length-1].split('.')[0],
            boxId = null;
        switch (pageName){
            case 'newMessage':boxId=0;numSet(); break;
            case 'allMessage':boxId=1;numSet(); break;
            case 'starMessage':boxId=13;numSet(); break;
            case 'messageDetail': break;
            default :numSet();
        }
        $(document).on('click','.userhelp-img',function(){
                location.href = help_url;
        })
        //系统消息入口
        $(document).on('click','.sysmsg-img,.new-msg-num',function(){
            if($('#header-content').attr('data-warn')!='1'){
                location.href = message_url;
            }
        }).on('click','.userhelp-img',function(){
            if($('#header-content').attr('data-warn')!='1'){
                location.href = help_url;
            }
        }).on('click','.J_allToRead',function(){
            var overLay = new overlay({
                width: 500, //{number} 浮层的宽度
                height: 300, //{number} 浮层的高度
                title: '提示',
                content: '<p>确定把所有消息置为已读吗？</p>',
                DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                DialogCancelBtn: true,//{boolean} dialog是否需要取消按钮
                DialogSureCallback: function(){
                    cloudClinic.api.io('his/message/allToRead',{"boxId": boxId},function(d){
                        if(d.head.error==0){
                            new overlay({
                                toastStatus : 'success', //{string} 气泡类型 success || error 默认success
                                toastText : '操作成功',//{string} 气泡内的文案
                                toastCallback: function(thisDialog){
                                    location.reload();
                                }
                            })._toast();
                        }
                    });
                    $('.yd-overlay-box').remove();
                },
                OverlayCloseCallback:function(){
                    $('.yd-overlay-box').remove();
                }
            });
            overLay._dialog();
            //全部清空
        }).on('click','.J_allClear',function(){
            var overLay = new overlay({
                width: 500, //{number} 浮层的宽度
                height: 300, //{number} 浮层的高度
                title: '提示',
                content: '<p>确定清空所有消息吗？</p>',
                DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                DialogCancelBtn: true,//{boolean} dialog是否需要取消按钮
                DialogSureCallback: function(){
                    cloudClinic.api.io('his/message/delete',{"boxId": boxId},function(d){
                        if(d.head.error==0){
                            new overlay({
                                toastStatus : 'success', //{string} 气泡类型 success || error 默认success
                                toastText : '操作成功',//{string} 气泡内的文案
                                toastCallback: function(thisDialog){
                                    location.reload();
                                }
                            })._toast();
                        }
                    });
                    $('.yd-overlay-box').remove();
                },
                OverlayCloseCallback:function(){
                    $('.yd-overlay-box').remove();
                }
            });
            overLay._dialog();
        }).on('click','.J_star',function(){
            var $this = $(this),
                cls = $this.hasClass('message-star'),
                prs = $this.parents('.new-message'),
                msgId = prs.attr('data-id');
            cloudClinic.api.io('his/message/asterisk',{"messageId": msgId},function(){
                if(cls){
                    $this.removeClass('message-star');
                }else{
                    $this.addClass('message-star');
                }
                numSet();
            });
        }).on('click','.J_delete',function(){
            var $this = $(this),
                prs = $this.parents('.new-message'),
                msgId = prs.attr('data-id');
            var overLay = new overlay({
                width: 500, //{number} 浮层的宽度
                height: 300, //{number} 浮层的高度
                title: '提示',
                content: '<p>确定删除该消息吗？</p>',
                DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                DialogCancelBtn: true,//{boolean} dialog是否需要取消按钮
                DialogSureCallback: function(){
                    cloudClinic.api.io('his/message/delete',{"messageId": msgId},function(data){
                        if(data.head.error == 0){
                            prs.fadeOut();
                            numSet();
                        }
                        $('.yd-overlay-box').remove();
                    })
                },
                OverlayCloseCallback:function(){
                    $('.yd-overlay-box').remove();
                }
            });
            overLay._dialog();
        });
    }

    //初始化页面账号信息
    function accountInfoInit(){
        var doctor_info=doctorInfo();
        if(doctor_info.doctorName){
            var timeHwnd=null,
                $slide_box=$(".user-name-box");
            $(".user-name").text(doctor_info.doctorName);
            $(".header-user").hover(function(){
                clearTimeout(timeHwnd);
                $slide_box.stop().slideDown(300);
            },function(){
                timeHwnd=setTimeout(function(){$slide_box.stop().slideUp(200);},500);
            });
            $(".user-change-loginout").click(function(){
                if($('#header-content').attr('data-warn')!='1'){
                    userLoginout(login_url);
                }
            });
            $(".J-userInfo").click(function(){
                if($('#header-content').attr('data-warn')!='1'){
                    location.href = userinfo_url;
                }
            });
        }
    }


}
printSet();
function printSet(){
    var huimeiPrintStr = window.localStorage && window.localStorage.getItem("huimeiPrint")||"",
        hospitalName = doctorInfo().hospitalName||'',
        localSysSet={
            paperType:"58",
            invoiceLookedUp:hospitalName,
            inscribe:"谢谢惠顾！祝您健康！",
            printDetail:1,
            recipeLookedUp:hospitalName,
            printUnitPrice:1,
            printTotalPrice:1,
            printDirection:1,
            printDoctor:0
        };
    huimeiPrintStr = huimeiPrintStr?JSON.parse(huimeiPrintStr):{};
    if(!huimeiPrintStr['systemSet']){
        var setObj = localSysSet, originSetObj={};
        cloudClinic.api.io(
            "his/manage/searchHospitalConfig",
            {"configType":2},
            function(data){
                if(data.body && data.body.configAttrs && data.body.configAttrs.length){
                    for(var i= 0;i<data.body.configAttrs.length;i++){
                        var configItem = data.body.configAttrs[i];
                        originSetObj[configItem.attrName] = configItem.attrValue;
                    }
                }
                $.extend(setObj, originSetObj);
                var huimeiPrintStr = window.localStorage && window.localStorage.getItem("huimeiPrint")||"";
                var huimeiPrint = huimeiPrintStr ? JSON.parse(huimeiPrintStr) :{};
                huimeiPrint['systemSet'] = setObj;
                window.localStorage && window.localStorage.setItem("huimeiPrint",JSON.stringify(huimeiPrint));
            })
    }
}
/*** 获取或设置账号信息 ***/
function doctorInfo(set_str){
    if(set_str){
        var info_str=encodeURI(encodeURI(set_str));
        setCookie("doctorInfo",info_str,7);
    }
    else{
        var info_str=decodeURI(decodeURI(getCookieInfo("doctorInfo")))||"";
        var doctor ={};
        try {
            doctor = $.parseJSON(info_str);
        }
        catch(e){}
        return doctor;
    }
}
/*** 获取当前页面文件名 ***/
function getPageInfo(key){
    var c_url=window.location.pathname;
    if(key=='dir'){
        var tmp_dir=c_url.substring(0,c_url.lastIndexOf("/"));
        return tmp_dir.substring(tmp_dir.lastIndexOf("/")+1);
    }
    else
        return c_url.substring(c_url.lastIndexOf("/") + 1,c_url.lastIndexOf(".")) ;
}

/*** 设置cookie ***/
function setCookie(name,value, day){
    var Days = day || 0.5;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days*24*60*60*1000);
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString()+';path=/';
}
/*** 获取cookie ***/
function getCookieInfo (name){
    var cookieArray=document.cookie.split("; "); //得到分割的cookie名值对
    var cookie={};
    for (var i=0;i<cookieArray.length;i++){
        var arr=cookieArray[i].split("=");       //将名和值分开
        if(arr[0]==name && arr[1] ){
            return unescape(arr[1]); //如果是指定的cookie，则返回它的值
        }
    }
    return "";
}
/*** todo 右侧内容适配 */
function adapter(){
    var leftNavWidth = 164,
        min_width=1080,
        mainCls = $("#page-main-content"),
        viewWidth = $(window).width(),
        viewHeight = $(window).height();

    if(viewWidth - 165 > min_width){
        mainCls.width(viewWidth - 165);
    }
    else{
        mainCls.width(min_width);
    }
    $("#cloudClinic-main").css("height",viewHeight-64);
}
/*** 系统登出函数 ***/
function userLoginout(login_url){
    cloudClinic.api.io('his/login/logout',{},function(data){
        var cookieData={
            mainIndex: 0,
            leftIndex: 0,
            srcMain: '',
            srcNav: '',
            preMainIndex: '',
            useBatch:''
        };
        for(var p in cookieData){
            setCookie(p,cookieData[p],-1);
        }
        //var header_title = $('.j_logo_pos').text(),
        //    localUrl = window.location.href.split('/')[2],
        //    fromStr = '';
        //if((localUrl.indexOf('anheshou')>-1)||(header_title.indexOf('管理平台')>-1)){
        //    fromStr = '?from=anheshou'
        //}
        var from = data.body.from,
            fromStr = '';
        if(from&&from=='anheshou'){
            fromStr = '?from=anheshou'
        }
        var huimeiPrintStr = window.localStorage && window.localStorage.getItem("huimeiPrint"),
            huimeiPrintObj = huimeiPrintStr ? JSON.parse(huimeiPrintStr) :{};
        huimeiPrintObj['systemSet'] = "";
        window.localStorage && window.localStorage.setItem("huimeiPrint",JSON.stringify(huimeiPrintObj));
        window.localStorage&&window.localStorage.setItem('sysFrame','');
        window.location= login_url+fromStr;
    });
}
/*** 时间类扩展，输出当前时间格式 ***/
Date.prototype.format = function(partten){
    if(partten ==null||partten=='')
    {
        partten = 'y-m-d'    ;
    }
    var y = this.getFullYear();
    var m = this.getMonth()+1;
    var d = this.getDate();
    var r = partten.replace(/y+/gi,y);
    r = r.replace(/m+/gi,(m<10?"0":"")+m);
    r = r.replace(/d+/gi,(d<10?"0":"")+d);
    return r;
}
/*** 字符串拓展,判断该数字小数点后第三位是不是0***/
String.prototype.decimalPoint = function(){
    return this.replace(/(\d*\.\d{2}[1-9]*)0+/, "$1");
};
/*** 重写toFixed方法***/
Number.prototype.toFixed = function(s) {
    var changenum = (parseInt(this * Math.pow(10, s) + (this<0?-0.5:0.5)) / Math.pow(10, s)).toString();
    var index = changenum.indexOf(".");
            if (index < 0 && s > 0) {
                changenum = changenum + ".";
                for (var i = 0; i < s; i++) {
                    changenum = changenum + "0";
                }

            } else {
                index = changenum.length - index;
                for (var i = 0; i < (s - index) + 1; i++) {
                    changenum = changenum + "0";
                }

            }

    return changenum;
}
/*** 由给定数组生成select选项 ***/
function createOption(arr){
    var result="";
    if(arr){
        for(i in arr){
            result+='<option value="'+i+'">'+arr[i]+'</option>';
        }
    }
    return result;
}
/*** js标签过滤 ***/
function stripscript(s) {
    return s.replace(/<script.*?>.*?<\/script>/ig, '');
}
/*** 系统消息接口 ***/
function numSet(){
    cloudClinic.api.io('his/message/getMessageCount',{},function(d){
        var unreadInboxCount = V(d.body.unreadInboxCount,0),
            totalCount = V(d.body.totalCount,0),
            asteriskCount = V(d.body.asteriskCount,0);
        $('.l_num').remove();
        if(unreadInboxCount>0){
            var newNum = unreadInboxCount>9?'9+':unreadInboxCount;
            $('.new-msg-num').text(newNum).show();
            $('.left-nav-newMessage').append('<i class="l_num">('+unreadInboxCount+')</i>');
        }
        if(totalCount>0){
            $('.left-nav-allMessage').append('<i class="l_num">('+totalCount+')</i>');
        }
        if(asteriskCount>0){
            $('.left-nav-starMessage').append('<i class="l_num">('+asteriskCount+')</i>');
        }
    });
}
/*** 离开此页提示 ***/
function leaveWarn(ele){
    $('#header-content').attr('data-warn','1');
    $(document).on('click','#page-left-nav a,.header-nav a,.user-name-box a,.sysmsg-img,.new-msg-num',function(){
        var $this = $(this);
        if(ele?$(ele).length:true) {
            var warn = false;
            $('input[type=text]').each(function(i, k){
                var $k = $(k),
                    p = $k.attr('placeholder'),
                    val = $k.val();
                if(val != '' && val != p && warn == false){
                    warn = true;
                    return false;
                }
            });
            if(warn){
                var r = confirm("有内容未保存，确定离开此页吗?");
                if (r == true) {
                        btn_event($this.attr('class'));
                }
                if (r == false) {return false;}
            }else{
                btn_event($this.attr('class'));
            }
        }else{
            btn_event($this.attr('class'));
        }
    });
}
function btn_event(cls){
    switch (cls){
        case 'sysmsg-img':
        case 'new-msg-num':location.href = '../newMessage/newMessage.html';break;
        case 'user-change-password J-userInfo':location.href = '../userInfo/userInfo.html';break;
        case 'user-change-loginout':userLoginout('../../login.html');break;
    }
}

/*** 操作埋点统一函数 ***/
function system_spm(opts){
    var hostUrl = "http://log.huimei.com/1.gif";
    opts.hospitalId = doctorInfo().hospitalId;
    opts.doctorId = doctorInfo().doctorId;
    opts.time = new Date().getTime();

    var args = "";
    var symbol = true;
    for(var key in opts){
        args += symbol ? "?" : "&";
        args += key + "=" + opts[key];
        symbol = false;
    }

    var img = new Image(1,1);
    img.src = hostUrl + args;
}

function judgeNeedImprove(){
    var isNeed=window.localStorage.getItem('needImprove');
    var str='<div class="improve-outer" id="improve-outer"><span class="closeBtn" id="closeBtn"></span><a class="improve-link" id="improve-link"><img src="../../images/improve.png" alt="" width="116" height="116" class="improve-icon"/></a></div>';
    if(isNeed==true||isNeed=='true'){
        $('.cloudClinic-body').append(str);
    }
    drag();
}
//实现浮标拖拽
function drag(){
    var params = {
    	left: 0,
    	top: 0,
    	currentX: 0,
    	currentY: 0,
    	flag: false,//是否停止运动
        isMove:false//是否有移动
    };
    //获取相关CSS属性
    var getCss = function(o,key){
    	return o.currentStyle? o.currentStyle[key] : document.defaultView.getComputedStyle(o,false)[key];
    };

    //拖拽的实现
    var startDrag = function(bar, target, callback){
        params.xMax = document.documentElement.clientWidth - parseInt(getCss(target, "width"));
        params.yMax = document.documentElement.clientHeight - parseInt(getCss(target, "height"));
        params.xMin = 0;
        params.yMin = 0;
        function Median(target,min,max) {
        if (target > max) return max;
        else if (target < min) return min;
        else return target;
        }
        //因为没有设置left值，ie下会获取到auto
    	if(getCss(target, "left") !== "auto"){
    		params.left = getCss(target, "left");
    	}else{
            params.left=params.xMax-50
        }
    	if(getCss(target, "top") !== "auto"){
    		params.top = getCss(target, "top");
    	}else{
            params.top=params.yMax-50
        }
    	//o是移动对象
    	bar.onmousedown = function(event){
            params.flag = true;
            var num = 0 ;
    		if(!event){
    			event = window.event;
    			//防止IE文字选中
    			bar.onselectstart = function(){
    				return false;
    			}
    		}
    		var e = event;
    		params.currentX = e.clientX+document.body.scrollLeft + document.documentElement.scrollLeft;
    		params.currentY = e.clientY+document.body.scrollTop + document.documentElement.scrollTop;
    	};
    	document.onmouseup = function(e){
    		params.flag = false;
            var  e= e||window.event;
            var currentTarget= e.target|| e.srcElement ;
    		if(getCss(target, "left") !== "auto"){
    			params.left = getCss(target, "left");
    		}else{
                params.top=params.yMax-50
            }
    		if(getCss(target, "top") !== "auto"){
    			params.top = getCss(target, "top");
    		}else{
                params.top=params.yMax-50
            }
            //如果没有移动，则可以跳转外链
            if(params.isMove==false) {
                //console.log(target)
                if (currentTarget.className == 'improve-link'||currentTarget.className=='improve-icon'){
                    location.href = '../../view/register/improveInfo.html'
                }
            }
            //每次鼠标弹起时，默认设置为没有移动
            params.isMove=false;
    	};
    	document.onmousemove = function(event){
    		var e = event ? event: window.event;
    		if(params.flag){
    			var nowX = e.clientX+document.body.scrollLeft + document.documentElement.scrollLeft, nowY = e.clientY+document.body.scrollTop + document.documentElement.scrollTop;
    			var disX = nowX - params.currentX, disY = nowY - params.currentY;
                var targetX = parseInt(params.left) + disX;
                var targetY = parseInt(params.top) + disY;
                target.style.left = Median(targetX, params.xMin, params.xMax) + "px";
                target.style.top = Median(targetY, params.yMin, params.yMax) + "px";
                //如果移动了
                if(disX!=0 && disY!=0){
                    params.isMove=true;
                }
    		}
    		if (typeof callback == "function") {
    			callback(parseInt(params.left) + disX, parseInt(params.top) + disY);
    		}
            if(disX==0 && disY==0){
            }else{
                //如果移动了
                return false;
            }
    	}
    };
    var oBox = document.getElementById("improve-outer");
    var oClose = document.getElementById('closeBtn')
    if(!oBox){
        return;
    }
    startDrag(oBox, oBox);
    window.onresize=function(){
        startDrag(oBox, oBox);
    }
    if(!oClose){
        return;
    }
    oClose.onclick=function(){
        oBox.style.display='none';
    }
}