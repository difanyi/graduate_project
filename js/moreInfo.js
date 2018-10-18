$('#p_ageType').ui_select();
var Request = cloudClinic.api.getRequest();
var moreInfo = function(){
    this.config = {
        'allIpt':'.recordIpt',
        'recordBox':'.cloudClinic-box',
        'sexRadio':'.sex-radio-q',
        'mustInt':'.mustInt',
        'highLight':'.highLight',
        'patientName':'.p_patientName',
        'patientNameSearchContent':'.name .sug-ul-dom',
        'nameCurIndex':0,
        submitUrl:'his/outpatient/savePatinetRecord',//复诊患者保存接口
        newUrl:'his/outpatient/addPatinetRecordFirst',//初诊患者保存接口
        pageUrl:'../registration/registration.html',
        ifNew:true
    }
};
moreInfo.prototype = {
    _init:function(){
        var self = this;
        self._onEvents();
        //诊断select
        $.hmSelect('#hmSelect', '#preadded', '#hmSelect-auto','cdss/searchDiseases', 10);//his/assist/searchDiseases
        //仅保存按钮
        $('.nav-btn').on("click",".j_only_save",function(){
            cloudClinic.api.loading.showLoading();
            self._inData();
        }).on("click",".only-cancel",function(){
            var cancelLay=new overlay({
                width: 550, //{number} 浮层的宽度
                height: 330, //{number} 浮层的高度
                title: '提示',
                content: '<p>您确认要放弃更多信息编辑吗？</p>',
                DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                DialogCancelBtn: true,//{boolean} dialog是否需要取消按钮
                DialogSureCallback: function(){
                    $(window).unbind('beforeunload');
                    $('.alert-box').hide();
                    cancelLay._remove();
                },
                DialogCancelCallback:function(){
                    cancelLay._remove();
                }
            });
            cancelLay._dialog();
        });
        self._initHeight();
        //self._post();
        self.inputLimitEvent();
        cloudClinic.api.ctrlEnter = {
            _this:self,
            fn:self._inData
        };
    },
    _initHeight:function(){
        var self = this;
        var _height=$(window).height(),
            _width=$(window).width();
        if(_width<710){
            _width=710;
        }
        $(".alert-box .cloudClinic-box").css('height',_height-128)
    },

    //事件代理
    _onEvents:function(){
        var self = this;
        $(window).on("resize",function(){
            self._initHeight();
        });
        //得到焦点时外框蓝色
        $(self.config.recordBox).on('focus',self.config.allIpt,function(e){
            if($(this).hasClass('red-ipt')){
                $(this).removeClass('red-ipt');
            }
            //必选项为空时失去焦点外框变红
        }).on('blur',self.config.allIpt,function(){
            var $this = $(this);
            if($this.hasClass('mustInt')){
                if(!$.trim($this.val())){
                    $this.addClass('red-ipt');
                }
            }
            //性别选项
        }).on('click',self.config.sexRadio,function(){
            if(!$(this).hasClass('sex-cur')){
                $(self.config.sexRadio).removeClass('sex-cur');
                $(this).addClass('sex-cur');
            }
        }).on('mouseover','.error-pri',function(){
            $(this).siblings('.error-info').show();
        }).on('mouseout','.error-pri',function(){
            $(this).siblings('.error-info').hide();
        });
        //sug选取-姓名-操作
        $('.page-main-content').sugSelect({
            isProxyEvent:true,
            inputNode:'.patient-name',
            onFocus:function($this){
                //var $sug = $this.next(".sug-ul-dom");
                //$sug.html() && $sug.show();
            },
            onInput:function($this){
                cloudClinic.api.io('his/outpatient/searchPatientBySug',{"patientName":$this.val()},function(d){self.nameSearchSuccess(d)});
            },
            selected:function($item,$this){
                if($item.length){
                    var index =$this.next(".sug-ul-dom").find("li").index($item);
                    self.nameSearchAdd(self.config.nameData.body.patientList[index]);
                }
            }
        });
        $(document).on('focus','input,.recordIpt',function(){
            $('.only-save').addClass('j_only_save');
        }).on('click','.long-btn,.deleteCheck,.drugBtn,.J_advice_temp,.deleteWestDrugList,.deleteChinesePrescriptionList,.closebutton,.ui-select-list li',function(){
            $('.only-save').addClass('j_only_save');
        })
    },
    //保存更多信息
    _inData:function(){
        var self = this,
            indata = {},
            checkArr = []
        if($('.j_only_save').length){
            var oListbox = document.getElementById("p_ageType");
            var rId = null
            var pId = $('.patient-name').attr('patientId')||'';
            function returnText(str){
                var newStr= $.trim(str).replace(/<div>/g," ").replace(/<\/div>/g,"").replace(/<br>/g,"");
                return newStr;
            }
            indata = {
                patientId:pId,
                patientName: $.trim($('.patient-name').val())||$.trim($('.patient-name').text()),
                gender:$('.alert-box .sex-cur').attr('data-id'),
                age:$('.p_age').val(),
                ageType: $('.single-information .ui-select-input').attr('key'),
                phoneNo:$(".p_patientPhone").val(),
                idCardNo:returnText($(".personId-input").val()),
                linkman:returnText($(".emergency-contact-input").val()),
                linkmanPhone:returnText($(".emergency-contact-phone-input").val()),
                comment:returnText($(".remarks-input").val()),
                symptom:returnText($('.J_symptom').text())||'',
                previousHistory:returnText($('.p_previousHistory').html()),
                personalHistory:returnText($('.p_personalHistory').html()),
                allergyHistory:returnText($('.p_allergyHistory').html()),
                familyHistory:returnText($('.p_familyHistory').html())
            };
            //判断必填项是否为空
            if(!indata.patientName){
                cloudClinic.api.inputExpApi.showError('请填写患者名！');
                return false;
            }
            if(!$('.patient-age').val()){
                cloudClinic.api.inputExpApi.showError('请填写患者年龄！');
                return false;
            }
            if($('.red-ipt').length){
                cloudClinic.api.inputExpApi.showError('请检查红色边框是否合法！');
                return false;
            }
            //if(!$(".p_patientPhone").hasClass("red-ipt")){//手机号
            var beforeTimestamp = new Date().getTime(),
                postUrl = 'his/outpatient/savePatientInfo';
            cloudClinic.api.io(postUrl,indata,function(data){
                self.config.indata = indata;
                if(!data.head.error==0){
                    return false;
                }
                var patientId=data.body.patientId;
                var timestamp = new Date().getTime()-beforeTimestamp-500;
                $(window).unbind('beforeunload');
                $('.success-mark').html('<span class="success-mark-txt"></span>保存成功').show(300);
                setTimeout(function(){
                    $('.success-mark').html('').hide(300);
                },1500);
                setTimeout(function(){
                    $('.alert-box').hide();
                },2000);
                var age=$('.patient-age').val()
                var name=$('.patient-name').val()
                var sex=$('.alert-box .sex-cur').attr('data-id')
                var sexDisabled=$('.alert-box .sex-disable').length
                var ageType=$('.single-information .ui-select-input').attr('title')
                var gender=$('.alert-box .sex-cur').attr('data-id');
                $('.single-information .ui-select-input').html(ageType).attr('title',ageType).attr('key',ageType)
                gender==1?$('.alert-box .sex-radio').removeClass('sex-radio-q').eq(0).addClass('sex-cur').siblings().removeClass('sex-cur'):$('.alert-box .sex-radio').removeClass('sex-radio-q').eq(1).addClass('sex-cur').siblings().removeClass('sex-cur')
                $('.alert-box .sex-cur').addClass('sex-disable').siblings().removeClass('sex-disable')
                $('.record-success').html('<span class="record-success-mark"></span>保存成功！').hide();
                if(name){
                    var div=document.createElement("div");//患者姓名空div
                    $(div).attr("class",$(".register-name-input").attr("class")+" disabled").attr("patientId",+data.patientId).text(name||"");
                    $('.register-name-input').after(div).remove();
                    $('.register-name-input').val(name);
                    gender==1?$('.first .sex-radio').removeClass('sex-radio-q').eq(0).addClass('sex-cur').siblings().removeClass('sex-cur'):$('.alert-box .sex-radio').removeClass('sex-radio-q').eq(1).addClass('sex-cur').siblings().removeClass('sex-cur')
                    $('.first .sex-cur').addClass('sex-disable').siblings().removeClass('sex-disable')
                    $('.register-age-input').val(age)
                    $('.register-age-input').attr('disabled','disabled').addClass('disabled')
                }else{
                    var div=document.createElement("div");//患者姓名空div
                    $(div).attr("class",$(".register-name-input").attr("class")+" disabled").text($('.patient-name').text())
                    $('.register-name-input').after(div).remove();
                }
                $('.register-name-input').attr('patientId',patientId)
                sex==1?$('.first .sex-radio').eq(0).addClass('sex-cur').siblings().removeClass('sex-cur'):$('.first .sex-radio').eq(1).addClass('sex-cur').siblings().removeClass('sex-cur')
                if(sexDisabled>0){
                    $('.first .sex-cur').addClass('sex-disable').siblings().removeClass('sex-disable')
                    $('.first .sex-radio').removeClass('sex-radio-q')
                }else{
                }
                $('.age-unit .ui-select-input').attr('title',ageType).attr('title',ageType).text(ageType)
                $('.register-age-input').val(age)
            },100);
        }
    },
    //name sug成功以后患者信息的渲染
    patientRender:function(data){
        var self = this;
        cloudClinic.api.io('his/outpatient/getPatientInfo',{"patientId":data.patientId},function(d) {
            var div = document.createElement("div");
            $(div).attr("class", $(".patient-name").attr("class") + " disabled").text(data.patientName || "")
            $('.patient-name').after(div).remove();
            $('.patient-name').attr("patientId", data.patientId);
            $('.alert-box .sex-radio').removeClass('sex-radio-q').removeClass('sex-cur').addClass("sex-disable");
            if (data.gender == 1) {
                $('.alert-box .sex-radio').eq(0).addClass('sex-cur');
            } else {
                $('.alert-box .sex-radio').eq(1).addClass('sex-cur');
            }
            ;
            if (data.age) {
                $('.patient-age').val(data.age).removeClass('red-ipt');
            }
            if (data.symptom) {
                $('.patient-old').text(data.symptom).removeClass('red-ipt');
            }
            var $p_age_parent = $('.patient-age').parent();
            var idCardNo= d.body.idCardNo? d.body.idCardNo:'';
            var linkman=d.body.linkman?d.body.linkman:'';
            var linkmanPhone=d.body.linkmanPhone?d.body.linkmanPhone:'';
            var comment=d.body.comment? d.body.commtent:'';
            $p_age_parent.find(".p_ageType").val(data.ageType || "");
            $p_age_parent.find(".ui-select-input").text(data.ageType || "").attr("title", data.ageType || "");
            $('.p_patientPhone').val(data.phone || data.phoneNo || "");
            self.config.patientId = data.patientId;
            self.config.recordId = data.recordId;
            $('.personId-input').val(idCardNo)
            $('.emergency-contact-input').val(linkman)
            $('.emergency-contact-phone-input').val(linkmanPhone)
            $('.remarks-input').val(comment)
            $('.J_symptom').text(data.symptom)
            $('.J_previousHistory').text(data.personalHistory)
            $('.p_previousHistory').text(data.previousHistory)
            $('.J_allergyHistory').text(data.allergyHistory)
            $('.J_familyHistory').text(data.familyHistory)
        })
    },
    nameSearchSuccess:function(data){
        var self = this;
        $(self.config.patientNameSearchContent).html('');
        if(data.body.patientList.length){
            for(var i = 0;i<data.body.patientList.length;i++){
                var st = '<li><i class="name-search-name">'+data.body.patientList[i].patientName+'</i><i class="name-search-gender">'+(data.body.patientList[i].gender==1?"男":"女"||"")+'</i><i class="name-search-age">'+(data.body.patientList[i].age&&(data.body.patientList[i].age+"<em>"+data.body.patientList[i].ageType+"</em>")||"")+'</i></li>';
                $(self.config.patientNameSearchContent).append(st);
            }
            $(self.config.patientNameSearchContent).find('li').eq(0).addClass('s-hover');
            $(self.config.patientNameSearchContent).show();
        }else{
            $(self.config.patientNameSearchContent).hide();
        }
        self.config.nameData = data;
    },

    //患者姓名搜索
    nameSearchAdd:function(data){
        var self = this;
        self.patientRender(data)
    },

    //3.29:16 输入校验事件绑定-操作
    inputLimitEvent:function(){
        var _self=this;
        _self.bindTextPlaceholder();
        cloudClinic.api.handelPlaceholder();
        //姓名，去除头尾的空格，不能为空，最长30个字符
        cloudClinic.api.inputExpApi.textLimitLength(".p_patientName",{maxLength:30,actionCallback:function(opts){
            if(opts.result) {
                var $this=$(".p_patientName");
                $this.val($.trim($this.val()));
            }
        }});
        //年龄，最多1位小数的正数，最大值200
        cloudClinic.api.inputExpApi.isFloat(".p_age",{fixed:1,maxValue:200,info:"仅支持最多1位小数的正数！",showFixed: false});
        //电话，只能包含+、-、空格和数字，不判断位数
        cloudClinic.api.inputExpApi.isPhoneNo(".p_patientPhone,.emergency-contact-phone-input");
        //身份证号码
        cloudClinic.api.inputExpApi.isIDnumber(".personId-input");
    },
    //3.31:15 ie89placeholder兼容-操作
    bindTextPlaceholder:function(){
        var ua = navigator.userAgent,
            reg = /msie (\d*)/;
        if(reg.test(ua.toLowerCase())) {
            if (RegExp.$1 < 10) {
                $('textarea[placeholder]').each(function (i, k) {
                    if(!$(k).val())
                        addPlaceholeder($(k));
                });
                $(document).on('blur', 'textarea[placeholder]', function () {
                    var $this = $(this);
                    if ($this.hasClass('drug-num')) return;//排除直接购药数量的input
                    if ($this.val() === '') {
                        addPlaceholeder($this);
                    }
                }).on('focus', 'textarea[placeholder]', function () {
                    var $this = $(this);
                    if ($this.val() === $this.attr('placeholder')) {
                        $this.val('').removeClass('placeholder');
                    }
                }).on('change', 'textarea[placeholder]', function () {
                    var $this = $(this);
                    if ($this.val() != $this.attr('placeholder')) {
                        $this.removeClass('placeholder');
                    }
                });

                function addPlaceholeder($el) {
                    $el.addClass('placeholder')
                        .val($el.attr('placeholder'));
                }
            }
        }
    }
};
var hmMoreInfo = new moreInfo();
hmMoreInfo._init();
