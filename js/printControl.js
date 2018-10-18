/**
 * Created by air_eienniutau on 2016/5/23.
 */
/**
 * 打印控制js-基类
 * 公共方法:
 * function initPrint 绑定打印事件 可接受参数opts 在子类的init方法里调用即可
 *      opts:{
 *          defaultButton:true  是否使用默认的打印按钮(true 页面上存在打印按钮)
 *      }
 * function doPrint 不通过打印按钮触发 而直接调用打印的方法
 * 其余为私有方法 不建议子类中直接调用
 *
 * 依赖dom:
 * 打印按钮(可选)
 *  <span class="j_printf actived">打印</span>
 * 打印容器
 *  <div class="print-wrap" print-type="undefined:未渲染dom,1:打印清单dom,2:打印总价dom">
 *      <div class="print-cont j_print_cont"></div>
 *  </div>
 */
function printControl(){
    this._printConfig={
        defaultButton:true,  //页面是否存在打印按钮.j_printf 默认存在
        invoiceLookedUp:window.top.getCookieInfo('hospitalName')
    };
}
printControl.prototype={
    /*在子类的init方法中调用以初始化*/
    initPrint:function(opts){
        var _self=this;
        opts && $.extend(_self._printConfig,opts);          //默认参数设置
        _self._getLocalConfig();                            //'打印设置'初始状态(localstorage的read)
        _self._printConfig.defaultButton && _self._printEvent();    //'打印'该按钮的事件绑定
    },
    /*绑定"打印"按钮事件*/
    _printEvent:function(){
        var _self=this;
        /**
         * .j_printf按钮在有.actived类时才能激活事件 移除.actived后通过css控制变灰
         * 避免重复绑定 先解绑再绑定,将_self作为event.data传入处理函数以重新获取this指针
         */
        $("body").off("click",".j_printf.actived",_self.doPrint)
            .on("click",".j_printf.actived",_self,_self.doPrint);
    },
    /*控制打印操作(包括打印dom渲染的操作) 可直接在子类中调用*/
    doPrint:function(e){
        var _self = e===undefined ? this : e.data;          //子类调用和事件触发有不同的this指向 统一处理下
        //判断打印设置的当前勾选状态
        var configType = (_self._printConfig.printDetail==1) ? "1" : "2";

        var $printCont = $(".j_print_cont");
        //判断打印内容的当前渲染类型
        var currentType = $printCont.attr("print-type")||"0";
        if(configType == currentType){
            //类型相同直接打印
            $printCont.jqprint();
        }else{
            //否则调用打印内容dom渲染
            if(configType=="1")
                $printCont.html(_self._changeToPrintListDom()).attr("print-type",1);
            else if(configType=="2")
                $printCont.html(_self._changeToPrintTotalDom()).attr("print-type",2);
            $printCont.jqprint();
        }
    },
    /*localstorage的读取*/
    _getLocalConfig:function(){
        var _self=this;
        var huimeiPrintStr = window.localStorage && window.localStorage.getItem("huimeiPrint")||null;
        if(huimeiPrintStr){
            var huimeiPrint = JSON.parse(huimeiPrintStr);
            var systemSet = huimeiPrint['systemSet'];
            if(systemSet && systemSet['printDetail'] !=undefined){
                $.extend(_self._printConfig,systemSet);
                _self._fixedSysSetToDom();
            }else{
                _self._setDefaultSystemSet();
            }
        }else{
            _self._setDefaultSystemSet();
        }
    },
    /*设定默认systemSet*/
    _setDefaultSystemSet:function(){
        var _self=this;
        var originSetObj = {};
        var hospitalName = doctorInfo().hospitalName||'';
        var setObj = {
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
        $.extend(_self._printConfig,setObj);
        _self._fixedSysSetToDom();
        cloudClinic.api.io(
            "his/manage/searchHospitalConfig",
            {"configType":2},
            function(data){
                if(data.body && data.body.configAttrs && data.body.configAttrs.length){
                    for(var i= 0;i<data.body.configAttrs.length;i++){
                        var configItem = data.body.configAttrs[i];
                        originSetObj[configItem.attrName] = configItem.attrValue;
                    }
                    $.extend(setObj,originSetObj);
                    $.extend(_self._printConfig,setObj);
                    _self._fixedSysSetToDom();
                }

                var huimeiPrintStr = window.localStorage && window.localStorage.getItem("huimeiPrint")||"";
                var huimeiPrint = huimeiPrintStr ? JSON.parse(huimeiPrintStr) :{};
                huimeiPrint['systemSet'] = setObj;
                window.localStorage && window.localStorage.setItem("huimeiPrint",JSON.stringify(huimeiPrint));
            }
        );
    },
    /*设定打印容器属性*/
    _fixedSysSetToDom:function(){
        var _self=this;
        var widthSet = 0,paddingSet= 0,hasMargin=false;
        var isChrome = navigator.userAgent.toLowerCase().match(/chrome/) != null;
        switch(_self._printConfig.paperType){
            case "58":widthSet="52mm";break;
            case "80":widthSet="80mm";hasMargin=true;break;
            case "A5":widthSet="80mm";hasMargin=true;break;
            default:widthSet="52mm";break;
        }
        if(isChrome){
            $(".j_print_cont").css({"width":widthSet});
        }else{
            $(".j_print_cont").css({"width":widthSet});
        }
    }
};