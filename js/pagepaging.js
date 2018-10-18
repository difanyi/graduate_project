var pagePaging = function (config) {
            var _self = this;
            _self.config = $.extend({},pagePaging.config,config);
            _self.global = {

            };
            _self._init();
        };
        /*
        * parentCls--翻页控制节点外层容器
        * pageTotal--总页数
        * pageSingle--未知参数
        * maxPageIndex--显示可点击的方块数目
        * currentPageIndex--当前页数(从1开始)
        * pageChangeCallback--todo your page changing
        * */
        pagePaging.config={
            parentCls : '.paging-page',
            pageTotal : 10,
            pageSingle : 10,
            maxPageIndex : 9,
            currentPageIndex : 1,
            pageSize: 20,
            itemTotal: '',
            pageChangeCallback : ''
        };
        pagePaging.prototype ={
            _reset:function(index,total,itemTotal){
                var _self  = this;
                _self.config.currentPageIndex = index;
                _self.config.pageTotal = total;
                itemTotal !== undefined && (_self.config.itemTotal = itemTotal);
                _self._pagingRender();
            },
            _init : function () {
                var _self = this;
                var $wrap = $(_self.config.parentCls);
                $wrap.css("position","relative");
                _self._pagingRender();

                $wrap.off('click','.page-items,.page-prev,.page-next,.page-op,.page-ed').off('click','.j_page_size').off('click','.page-num-select li');
                $wrap.on('click','.page-items,.page-prev,.page-next,.page-op,.page-ed', function (e) {
                    var $this = $(this);
                    var _type;
                    $this.hasClass("page-op") && (_type = 1) ||
                    $this.hasClass("page-prev") && (_type = 2) ||
                    $this.hasClass("page-next") && (_type = 4) ||
                    $this.hasClass("page-ed") && (_type = 5) || (_type = 3);
                    switch(_type){
                        case 1: _self.config.currentPageIndex=1;break;
                        case 2: _self.config.currentPageIndex--;break;
                        case 4: _self.config.currentPageIndex++;break;
                        case 5:_self.config.currentPageIndex=_self.config.pageTotal;break;
                        default:
                            var currentTarget = $(e.currentTarget);
                            _self.config.currentPageIndex = parseInt(currentTarget.html(),10);
                    }
                    _self.config.pageChangeCallback && _self.config.pageChangeCallback(_self.config.currentPageIndex);
                    _self._pagingRender();
                });

                $wrap.on('click',".j_page_size",function(){
                    var $parent = $(this).parent();

                    var $select = $parent.find(".page-num-select");
                    var $size = $parent.find(".page-num-size");
                    if( $size.hasClass("page-active") ){
                        $select.hide();
                        $size.removeClass("page-active");
                    }else{
                        $select.show();
                        $size.addClass("page-active");
                    }
                });
                $wrap.on('click',".page-num-select li",function(){
                    var $this = $(this);
                    var _val = $.trim($this.text());
                    var $parent = $this.parents(".page-num-statistics");
                    var $size = $parent.find(".page-num-size");
                    if( $size.val() != _val ){
                        $size.val(_val);
                        _self.config.pageSize = _val;
                        _self.config.pageChangeCallback && _self.config.pageChangeCallback(1);
                    }
                    $this.parent().hide();
                    $size.removeClass("page-active");
                });
                $wrap.off('blur',".j_page_size");
                $wrap.on('blur',".j_page_size",function(){
                    var $parent = $(this).parent();
                    setTimeout(function(){
                        $parent.find(".page-num-select").hide();
                        $parent.find(".page-num-size").removeClass("page-active");
                    },500);
                });


                //解决双击选择文案的bug
                $wrap.off('selectstart','.page-num');
                $wrap.on('selectstart','.page-num', function () {
                    return false;
                })


            },
            _pagingRender: function () {
                var _self = this;
                _self.config.currentPageIndex = _self.config.currentPageIndex > _self.config.pageTotal ? _self.config.pageTotal : _self.config.currentPageIndex; //传入的页数超过总页数,则显示最后一页
                _self.config.currentPageIndex = _self.config.currentPageIndex < 1 ? 1 : _self.config.currentPageIndex;//传入的页数小于1,则显示第一页
                var prevPage =  _self.config.currentPageIndex == 1 ?  '<dd class="page-num page-arrow page-first"><i class="page-mark"></i></dd><dd class="page-num page-arrow page-up"><i class="page-mark"></i></dd>' :  '<dd class="page-num page-arrow page-op page-first"><i class="page-mark"></i></dd><dd class="page-num page-arrow page-prev page-up"><i class="page-mark"></i></dd>';
                var nextPage =  _self.config.currentPageIndex == _self.config.pageTotal ?  '<dd class="page-num page-arrow page-down"><i class="page-mark"></i></dd><dd class="page-num page-arrow page-last"><i class="page-mark"></i></dd>' : '<dd class="page-num page-arrow page-next page-down"><i class="page-mark"></i></dd><dd class="page-num page-arrow page-ed page-last"><i class="page-mark"></i></dd>';
                var pagePagingHtml = '';
                $(_self.config.parentCls).html('');//重置分页样式


                var afterStartPage = _self.config.currentPageIndex;
                if(_self.config.pageTotal < 1 || _self.config.itemTotal < 1 ){//只有一页,不需要分页
                    return false;
                }else if(_self.config.pageTotal <= _self.config.maxPageIndex){//总页数小于等于可显示页数
                    pagePagingHtml = _self._getPageHtml(1,_self.config.pageTotal);
                }else{
                    var middlePage = Math.floor(_self.config.maxPageIndex / 2);
                    var beforeHtml = '';
                    var pageOmit = '<dd class="page-num "> ... </dd>';
                    var lastPage = '<dd class="page-num page-items">' + _self.config.pageTotal + '</dd>';
                    var afterHtml = '';

                    if(_self.config.currentPageIndex > middlePage) { //如果当前页面大于一屏可放页数的中间值
                        var afterNum = _self.config.currentPageIndex + middlePage;
                        if( afterNum < _self.config.pageTotal ){
                            var afterEnd = (middlePage - 2) + _self.config.currentPageIndex; //减去最后一页和省略号的位置+当前位置,就是结束位置
                            afterHtml = _self._getPageHtml(_self.config.currentPageIndex,afterEnd) + pageOmit + lastPage ;
                        }else if(afterNum == _self.config.pageTotal){
                            afterHtml =  _self._getPageHtml(_self.config.currentPageIndex,_self.config.pageTotal)  ;
                        }else{
                            var afterDiff = afterNum - _self.config.pageTotal;
                            afterStartPage = _self.config.currentPageIndex - afterDiff;
                            afterHtml = _self._getPageHtml(afterStartPage,_self.config.pageTotal)
                        }

                        afterStartPage--;//当前开始的那个已经渲染,需要去掉
                        if(afterStartPage - middlePage >= 1 ){
                            var beforeStart = (afterStartPage - middlePage) + 2;
                            beforeHtml =  pageOmit +  _self._getPageHtml(beforeStart,afterStartPage)
                        }else if(afterStartPage - middlePage == 0){
                            beforeHtml = _self._getPageHtml(1,afterStartPage)
                        }
                        pagePagingHtml = beforeHtml + afterHtml;
                    }else{
                        var afterEndPage = _self.config.maxPageIndex - 2;
                        beforeHtml = _self._getPageHtml(1,afterEndPage);
                        pagePagingHtml = beforeHtml + pageOmit + lastPage;
                    }
                }
                //页面条目数控制 - dom
                var statistics = "<div class='page-num-statistics'>每页显示 " +
                    "<span class='j_page_size' tabindex='0'>" +
                    "<input class='page-num-size' type='text' value='"+(_self.config.pageSize)+"' disabled='disabled'/>" +
                    "</span> 条，共"+(_self.config.itemTotal)+"条" +
                    "<ul class='page-num-select'>" +
                    (   _self.config.pageSize == 20 ? "<li>100</li><li>50</li><li class='page-active'>20</li>" :
                        _self.config.pageSize == 50 ? "<li>100</li><li class='page-active'>50</li><li>20</li>" :
                            "<li class='page-active'>100</li><li>50</li><li>20</li>"
                    ) +
                    "</ul></div>";
                $(_self.config.parentCls).html(prevPage + pagePagingHtml + nextPage + statistics);
                _self._initClass();
                $(window).scrollTop(0);
            },
            _getPageHtml : function (start,end) {
                var _self = this;
                var pageNumHtml = '';
                end++;
                for(var i = start; i < end ;i++){
                    if(i == _self.config.currentPageIndex){
                        pageNumHtml += '<dd class="page-num page-sub">' + i + '</dd>';
                    }else{
                        pageNumHtml += '<dd class="page-num page-items">' + i + '</dd>';
                    }
                }
                return pageNumHtml;
            },
            _initClass:function(){
                $(".page-num").removeClass("page-num-f page-num-e");
                $(".page-up").next().addClass("page-num-f");
                $(".page-down").prev().addClass("page-num-e");
            }
        };