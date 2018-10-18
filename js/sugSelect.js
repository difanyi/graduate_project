/**
 * Created by air_eienniutau on 2016/4/15.
 */
(function($){
    /**
     * v1.0.1   内测版本
     * sug层组件
     * @param opts
     *      width       string||number  设置sug层宽度
     *      sugClass    string          生成的sug节点上的class
     *      isProxyEvent    bool    是否执行事件代理(是>组件不负责sug节点生成)
     *      inputNode   string      事件代理触发的节点(选择器)
     *      isScroll    bool                设置sug层是否定高度且存在滚动条
     *      height      string||number      isScroll为true时设定sug层高度
     *      onFocus     function($input,$sug)     输入框获得焦点时执行的方法
     *      onInput     function($input,$sug)     输入框输入时执行的方法
     *      selected    function($item,$input)    sug层item被选择时执行的方法
     * @returns {$.fn}
     */
    $.fn.sugSelect=function(opts) {
        var $this = this;
        var config = {
            width: "",
            sugClass: "",
            isProxyEvent: false,
            inputNode: "",
            isScroll: false,
            height: "auto",
            onFocus: "",
            onInput: "",
            selected: ""
        };
        $.extend(config, opts || {});
        new sug_Select($this,config);
        return $this;
    };
    //keyup setTimeout句柄指针
    if(window.sugKeyupTimeHwnd === undefined) window.sugKeyupTimeHwnd = null;
    //sug_Select对象
    function sug_Select(ele,opt){
        this.$ele=ele;
        this.config=opt;
        return this.init();
    }
    // sug_Select 原型链扩展
    sug_Select.prototype={
        init:function(){
            var _self=this;
            _self.config.isProxyEvent ? _self.ProxyEvent() : _self.bindEvent();
            _self.hideSugEvent();
        },
        ProxyEvent:function(){
            var _self=this;
            _self.$ele.on("focus",_self.config.inputNode,function(){
                var $input=$(this),$sug;
                if($input.attr("issug")=="1"){
                    $sug=$input.next(".sug-ul-dom");
                }else if($input.attr("issug")=="0"){
                    $sug=$input.next(".sug-ul-dom");
                    _self.sugLiClick($input,$sug);
                    $input.attr("issug","1");
                }else{
                    $sug = _self.addSugDom($input);
                    _self.sugLiClick($input,$sug);
                }
                _self.config.onFocus&&_self.config.onFocus($input,$sug);
                clearInterval(window.sugKeyupTimeHwnd);
                var _inputPreValue = $input.val();
                window.sugKeyupTimeHwnd = setInterval(function(){
                    if(_inputPreValue != $input.val()){
                        _inputPreValue = $input.val();
                        _self.config.onInput && _self.config.onInput($input,$sug);
                    }
                },100);
            }).on("keyup",_self.config.inputNode,function(e){
                var $input=$(this);
                var $sug=$input.next(".sug-ul-dom");
                _self.keyupEvent(e,$input,$sug);
            }).on("keydown",_self.config.inputNode,function(e){
                var $input=$(this);
                var $sug=$input.next(".sug-ul-dom");
                _self.keydownEvent(e,$input,$sug);
            }).on("blur",_self.config.inputNode,function(){
                clearInterval(window.sugKeyupTimeHwnd);
            });
        },
        bindEvent:function(){
            var _self=this;
            _self.$ele.each(function(i,e){
                var $input=$(e);
                if($input.attr("issug")!="1"){
                    var $sug=_self.addSugDom($input);
                    $input.on("focus",function(){
                        _self.config.onFocus&&_self.config.onFocus($input,$sug);
                        clearInterval(window.sugKeyupTimeHwnd);
                        var _inputPreValue = $input.val();
                        window.sugKeyupTimeHwnd = setInterval(function(){
                            if(_inputPreValue != $input.val()){
                                _inputPreValue = $input.val();
                                _self.config.onInput && _self.config.onInput($input,$sug);
                            }
                        },100);
                    }).on("keyup",function(e){
                        _self.keyupEvent(e,$input,$sug);
                    }).on("keydown",function(e){
                        _self.keydownEvent(e,$input,$sug);
                    }).on("blur",function(){
                        clearInterval(window.sugKeyupTimeHwnd);
                    });
                    _self.sugLiClick($input,$sug);
                }
            });
        },
        addSugDom:function($input){
            var _self=this;
            var sug=document.createElement("ul");
            var $sug=$(sug);
            $sug.attr({
                "class":"sug-ul-dom "+_self.config.sugClass
            }).css({
                "border":"1px solid #dfdfdf",
                "width":(_self.config.width||$input.innerWidth()),
                "display":"none"
            });
            _self.config.isScroll && $sug.css({
                "height":_self.config.height,"overflow-x":"hidden","overflow-y":"scroll"
            });
            //未绑定
            $input.attr("issug","1").after(sug);
            return $sug;
        },
        sugLiClick:function($input,$sug){
            var _self=this;
            $sug.on("click","li",function(){
                var _$li=$(this);
                $sug.hide().find('.s-hover').removeClass('s-hover');
                _$li.addClass('s-hover');
                $input.blur();
                _self.config.isScroll&&$sug.scrollTop(0);
                _self.config.selected && _self.config.selected(_$li,$input);
            })
        },
        keyupEvent:function(e,$input,$sug){
            var _self=this;
            var $liList=$sug.find("li");
            if($sug.is(':visible') && $liList.length){
                var nLi=$sug.find("li.s-hover");  //被选中的li
                var nIndex=nLi.length ? $liList.index(nLi):-1;  //被选中的li位置(不存在则为-1)
                var i,_top=0;   //可滚动时

                //上下键 enter键判定
                switch (e.keyCode){
                    case 38:
                        if(nIndex != 0){
                            nIndex < 0 ? $liList.eq(0).addClass("s-hover") : nLi.removeClass("s-hover").prev().addClass("s-hover");
                            if(_self.config.isScroll){
                                if(nIndex < 0 ){
                                    $sug.scrollTop(0);
                                }else{
                                    for(i=0;i<nIndex-2;i++){
                                        _top+=$liList.eq(i).outerHeight();
                                    }
                                    $sug.scrollTop(_top);
                                }
                            }
                        }
                        break;
                    case 40:
                        if(nIndex != $liList.length-1 ){
                            nIndex < 0 ? $liList.eq(0).addClass("s-hover") : nLi.removeClass("s-hover").next().addClass("s-hover");
                            if(_self.config.isScroll){
                                if(nIndex < 0 ){
                                    $sug.scrollTop(0);
                                }else{
                                    for(i=0;i<nIndex;i++){
                                        _top+=$liList.eq(i).outerHeight();
                                    }
                                    $sug.scrollTop(_top);
                                }
                            }
                        }
                        break;
                    case 13:
                        var _nLi= nIndex==-1 ? $liList.eq(0) : nLi;
                        $input.blur();
                        _self.config.isScroll&&$sug.scrollTop(0);
                        $sug.hide();
                        _self.config.selected && _self.config.selected(_nLi,$input);
                        break;
                    default :break;
                }
            }
        },
        keydownEvent:function(e,$input,$sug){
            var _self=this;
            e.keyCode == 9 && $sug.hide();
        },
        hideSugEvent:function(){
            var _self=this;
            if(window.hasSugSelectEv) return false;
            $(document).on("click",function(e){
                var _this= $(e.target);
                if (_this.closest(".sug-ul-dom").length) return false;
                var $sug= _this.next(".sug-ul-dom");
                var $allSug=$(".sug-ul-dom");
                var $hideSug= $sug.length ? $allSug.not($sug) : $allSug;
                _self.config.isScroll && $hideSug.scrollTop(0);
                $hideSug.hide();
            });
            window.hasSugSelectEv=true;
        }
    }
})(jQuery);