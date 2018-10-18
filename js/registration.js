var Request = cloudClinic.api.getRequest();
$(function() {
    var ls = parseInt(getQueryString("localPage")) || 1;
    var registration = function () {
        var self=this;
        printControl.call(this);
        this.config = {
            listPagination : null, //记录分页实例
            'patientName':'.p_patientName',
            'patientNameSearchContent':'.sug-ul-dom',
            'allData':[],//渲染到更多页面的数据
            'curPage':1,
            'pageSize' : 20
        }
        this.init();
    };
    cloudClinic.api.inhertClass.inheritClass(printControl,registration);
    $.extend(registration.prototype, {
        init: function () {
            var self = this;
            self.initPrint({defaultButton:false});
            self._initHeight();
            //self.getId();
            $(window).on('resize',function(){
                self._initHeight();
            })
            self.btnSelect();
            self.createInputExp();
            //打印-读取勾选状态-操作
            var huimeiPrintStr = window.localStorage && window.localStorage.getItem("huimeiPrint")||null;
            var huimeiPrint = huimeiPrintStr ? JSON.parse(huimeiPrintStr) : {};
            huimeiPrint['purchase'] == 1 && $(".print-check").addClass("print-checked");
            self.selectSet();
            self.laboratoryRender();
            self.doctorRender();
            self.projectRender();
            self.handleSearchDrug();
            self.nameSug();
            self.onEvent();
        },
        //获取序号
        getId:function(){
            var self=this;
            cloudClinic.api.io('his/register/registeredPatientList',{currentPage:1},function (data){
                var k=1;
                for(var i=0;i<data.body.patientList.length;i++){
                    var year=new Date().getFullYear();
                    var month=new Date().getMonth()+1
                    var day=new Date().getDate()
                    var getDay=year+'/'+month+'/'+day
                    //var getDay='2016/9/18'
                    if(new Date(data.body.patientList[0].registerDateTime)>=new Date(getDay)){
                        k=parseInt(data.body.patientList[0].registerNo)+1;
                    }
                }
                if(k<10){
                    k='00'+k
                }else if(k<100){
                    k='0'+k
                }else{
                    k=k
                }
                $('.register-num .register-id').html(k)
            })

        },
        //创建input输入限制
        createInputExp: function(){
            var exp = cloudClinic.api.inputExpApi;
            exp.isFloat('.J_inputFloatZer', {
                info: '仅支持大于或等于0的数字',
                fixed: 2,
                maxValue: 999999.99,
                zero: true,
                cont: "body"
            });
            exp.isInt('.J_inputIntZero', {
                info: '仅支持大于或等于0的整数',
                zero: true,
                cont: "body"
            });
            exp.isFloat(".register-age-input",{
                fixed:1,
                maxValue:200
                ,info:"仅支持最多1位小数的正数！",
                showFixed: false
            });
        },
        //下拉框设置
        selectSet:function(){
            var self=this;
            //状态下拉框设置样式
            var select1=$('.J_status').ui_select({
                width: '7%',
                wrapClass: 'header-drugstatus'
            });
            //项目名下拉框设置样式
            self.config.select2=$('.J_project').ui_select({
                width: '7%',
                wrapClass: 'header-drugstatus',
                onChange:function(e){
                    var val=$('.project .selected').attr('data-price')
                    $('.pay-num').text(parseFloat(val).toFixed(3).decimalPoint());
                    $('.really-pay-input').val(parseFloat(val).toFixed(3).decimalPoint());
                    $('.discount-pay-input').val('0.00')
                }
            });
            //科室下拉框设置样式
            self.config.select3=$('.J_department').ui_select({
                width: '7%',
                wrapClass: 'header-drugstatus',
                onChange:function(value,$this){
                    var id=$('.department .ui-select-input').attr('key');
                    self.doctorRender(id);
                    $('.doctor .ui-select-input').text('不指定').attr('key','').attr('title','不指定')
                    $('.status .ui-select-input').text('待诊').attr('key','1').attr('title','待诊')
                }
            });
            //医生下拉框设置样式
            self.config.select4=$('.J_doctor').ui_select({
                width: '7%',
                wrapClass: 'header-drugstatus',
                onChange:function(){
                    $('.status .ui-select-input').text('待诊').attr('key','1').attr('title','待诊')
                }
            });
            //年龄单位
            self.config.select5=$('.J_ageUnit').ui_select({
                width: '7%',
                wrapClass: 'header-drugstatus'
            });
        },
        _initHeight: function () {
            var self = this;
            var _height = $(window).height(),
                _width = $(window).width() - 492;
            if (_width < 788) {
                _width = 788;
            }
            $(".first .cloudClinic-box").css('height', _height - 128).css('width', _width);
            $(".newRegister-content").css('height', _height - 178)
            $(".newRegister").css('left', _width+40).show();
        },
        //按钮选择
        btnSelect:function(){
            var self=this;
            //挂号列表选择
            $('.J_registerList').on('click','tr',function(e){
                var target= e.currentTarget;//当前点击的节点
                var allCls=$(target).parent().parent()//父节点
                $('.select-radio-q').removeClass('select-cur')
                $(target).addClass('line-cur').siblings().removeClass('line-cur')
                $(target).children('td').children('.select-radio-q').addClass('select-cur')
            })
            //新增挂号-性别选择
            $('.J_singleInformation').on('click','.sex-radio-q',function(e){
                var target= e.currentTarget;//当前点击的节点
                $('.sex-radio-q').removeClass('sex-cur')
                $(target).addClass('sex-cur')
            })
            //打印-打印小票勾选切换-事件
            $(".print-check").on("click",function(){
                var $this = $(this);
                var huimeiPrintStr = window.localStorage && window.localStorage.getItem("huimeiPrint")||null;
                var huimeiPrint = huimeiPrintStr ? JSON.parse(huimeiPrintStr) : {};
                if($this.hasClass("print-checked")){
                    $this.removeClass("print-checked");
                    huimeiPrint['purchase'] = 0;
                }else{
                    $this.addClass("print-checked");
                    huimeiPrint['purchase'] = 1;
                }
                window.localStorage && window.localStorage.setItem("huimeiPrint",JSON.stringify(huimeiPrint));
            });
        },
        //绑定事件
        onEvent:function(){
            var self=this;
            //点击收费按钮
            $('.newRegister').on('click','.J_register_charge',function(){
                self._charge();
            })
            //挂号列表中单击点击一条记录
            $('.J_registerList').on('click','tr',function(e){
                self.clickEachItem(e)
            })
            //价格保留两位小数
            cloudClinic.api.inputExpApi.isFloat('.really-pay-input,#payPri,.discount-pay-input',{
                info:"仅支持两位正小数！",
                fixed:2,
                cont:"body",
                zero:true,
                errEmpty:true,
                maxValue:999999.99
            });
            $(document).on('blur','.register-name-input',function(e){
                if($('.register-name-input').val()){
                    $('.more-btn').removeClass('disable-color').show();
                    $('.header-registeradd').show()
                }else{
                    $('.more-btn').addClass('disable-color').hide();
                    $('.header-registeradd').hide()
                }
            })
            $(document).on('blur','.really-pay-input',function(e){
                var ele = $(e.target);
                var reg=/^[+-]?\d+(\.\d+)?$/;
                var disPrice=$('.discount-pay-input').val()||0.00;
                var realPay=parseFloat($('.pay-num').text())-parseFloat(disPrice);
                if(!reg.test(parseFloat($('.really-pay-input').val()))){
                    $('.discount-pay-input').val('0.00')
                    return;
                }
                $('.discount-pay-input').removeClass('red-ipt');
                $('.really-pay-input').val(parseFloat($('.really-pay-input').val()).toFixed(3).decimalPoint()).attr('data-price',parseFloat($('.really-pay-input').val()).toFixed(3).decimalPoint());
                $('.discount-pay-input').val(parseFloat($('.pay-num').text()-$('.really-pay-input').val()).toFixed(3).decimalPoint())
            }).on('blur','.discount-pay-input',function(e){
                var ele = $(e.target);
                var $disInput = $('.discount-pay-input');
                var disPrice = $.trim($disInput.val())||0.00;
                var reg=/^[-+－＋]?\s*[0-9]+(\.[0-9]+)?$/;
                if(!reg.test(disPrice)){
                    cloudClinic.api.inputExpApi.showError('只能是数字');
                    $disInput.addClass('red-ipt').val('');
                    return;
                }
                var markReg = /[-－]/, numReg = /[0-9]+(\.[0-9]+)?$/;
                if(disPrice==''){
                    $disInput.val(parseFloat('0.00').toFixed(3).decimalPoint());
                    return;
                }
                var priceNum = parseFloat(disPrice.match(numReg));
                if(markReg.test(disPrice)){
                    priceNum = -priceNum;
                }
                $disInput.removeClass('red-ipt');
                $disInput.val(parseFloat(priceNum).toFixed(3).decimalPoint());
                var realPay = parseFloat($('.pay-num').text())-parseFloat(priceNum);
                $('.really-pay-input').val(realPay.toFixed(3).decimalPoint()).attr('data-price',realPay.toFixed(3).decimalPoint());
            }).on('focus','.discount-pay-input,.really-pay-input',function(){
                if($(this).val() == '0.00'){
                    $(this).val('');
                }
            }).on('click','.header .header-registeradd',function(e){
                var target= e.currentTarget;
                if(!$(target).hasClass('disable-color')){
                    $('.header-registeradd').hide()
                    self.addRegister();
                    self.selectSet();
                    self.btnSelect();
                    self.doctorRender();
                    self.laboratoryRender();
                    self.projectRender();
                    self.nameSug();
                    self.createInputExp();
                    $('.select-cur').removeClass('select-cur')
                    $('.line-cur').removeClass('line-cur')
                }
            })
            //查看更多按钮点击
            $(document).on('click','.more-btn',function(e){
                var target= e.currentTarget;
                if(!$(target).hasClass('disable-color')){
                    self.showMoreInfo();
                }

            })
            $(document).on('click','.J_searchRegister',$.proxy(self.handleSearchDrug,self)).on('click','.header .header-drugstatus .ui-select-list li',function(){
                $('.J_searchRegister').click();
            })
            $(document).on('click','.radio-lbl,.pay-method',function(){
                $('.radio-cur').removeClass('radio-cur');
                $(this).addClass('radio-cur');
            }).on('blur','#payPri',function(){
                var payNum = $('.really-pay-input').val(),
                    payPri = $('#payPri').val(),
                    chargeEle = $('#giveChange'),
                    charge = (payPri-payNum).toFixed(3).decimalPoint();
                if(payPri){
                    if(charge>=0){
                        chargeEle.text(charge);
                    }else{
                        chargeEle.text('0.00');
                        $(this).val('');
                        cloudClinic.api.inputExpApi.showError('付款金额不能小于实收金额');
                    }
                }else{
                    chargeEle.text('0.00');
                }
            }).on('click','.pay-method',function(){
                var v = $(this).attr('data-value');
                if(v==1||v==5){
                    $('#showPayPri').hide();
                    $('#payPri').show();
                    $('#giveChange').text(($('#payPri').val()-$('.really-pay-input').val()).toFixed(3).decimalPoint());
                }else{
                    $('#payPri').hide().val($('#payPri').val());
                    $('#showPayPri').show();
                    $('#giveChange').text('0.00');
                }
            })
            //点击保存修改
            //点击修改挂号下的打印按钮
            $(document).on('click','.modify_print',function(){
                self.modifyPrint()
            })
        },
        //在列表中点击一条数据
        clickEachItem:function(e){
            var self=this;
            var target= e.currentTarget;
            var department;
            var Name=$(target).find('.J_register_name').text();
            var patientId=$(target).attr('patientId');
            var registerId=$(target).attr('data-registerid');
            //渲染右边修改处的数据
            cloudClinic.api.io('his/register/getRegisteredDatail',{'registerId':registerId},function(d) {
                var laboratoryName= d.body.laboratoryName==null?'不指定':d.body.laboratoryName;
                var patientName= d.body.patientName;
                var laboratoryId= d.body.laboratoryId;
                var registerId=d.body.registerId
                var doctorName=d.body.doctorName==null?'不指定':d.body.doctorName;
                var doctorId= d.body.doctorId;
                var registerStatus= d.body.registerStatus;
                var registerTypeName=d.body.registerTypeName;
                var registerType= d.body.registerType;
                var age= d.body.age;
                var ageType= d.body.ageType;
                var receivedAmt =  parseFloat(d.body.receivedAmt);
                var disPrice = parseFloat(d.body.discount);
                var recordId=d.body.recordId==null?'':d.body.recordId
                var gender= d.body.gender;
                self.modify(target,registerStatus)
                self.selectSet();
                self.btnSelect();
                self.laboratoryRender();
                //self.projectRender();
                self.config.select2.disable();
                $('.header-registeradd').show()
                $('.department .ui-select-input').text(laboratoryName).attr('key',laboratoryId)
                $('.doctor .ui-select-input').text(doctorName).attr('key',doctorId);
                $('.project .ui-select-input').text(registerTypeName).attr('key',registerType)
                $('.register-age-input').val(age)
                $('.register-age-input').attr('disabled','disabled').addClass('disabled')
                self.config.select5.disable()
                gender==1?$('.sex-radio').eq(0).addClass('sex-cur').siblings().removeClass('sex-cur'):$('.sex-radio').eq(1).addClass('sex-cur').siblings().removeClass('sex-cur')
                $('.sex-radio').removeClass('sex-radio-q');
                $('.sex-cur').addClass('sex-disable').siblings().removeClass('sex-disable')
                $('.age-unit .ui-select-input').text(ageType).attr('key',ageType)
                $('.register-name').attr('status',registerStatus).attr('registerId',registerId).attr('recordId',recordId)
                $('.discount-pay-input').text(disPrice.toFixed(3).decimalPoint())
                $('.pay-num').text(receivedAmt.toFixed(3).decimalPoint())
                $('.really-pay-input').text((receivedAmt - disPrice).toFixed(3).decimalPoint()).attr('data-price',(receivedAmt - disPrice).toFixed(3).decimalPoint())
                self.doctorRender(laboratoryId);
                var status=parseInt($('.register-name').attr('status'))
                var statusName='',
                    index=null;
                if(status==1||status==2||status==4){
                    switch(status){
                        case 1:
                            statusName='待诊',
                            index=0
                            break;
                        case 2:
                            statusName='接诊中',
                            index=1
                            break;
                        case 4:
                            statusName='已过号',
                            index=2
                            break;
                    }
                    self.config.select6=$('.J_regiterstatus').ui_select({
                        width: '7%',
                        wrapClass: 'header-registerstatus',
                        initValue:status,
                        onChange:function(value, item){
                            var key=$('.status .ui-select-list .selected').attr('data-value')
                            $('.status .ui-select-input').attr('key',key)
                        },
                        onClick:function(value, item){
                            $(item).val(status)
                        }
                    });
                    $('.status .ui-select-input').attr('title',statusName).text(statusName).attr('key',status)
                    $('.status .ui-select-list li').eq(index).addClass('selected').siblings().removeClass('selected')
                }else{
                    $('.status').hide()
                }
                if(status==2||status==3){
                    $('.more-btn').addClass('disable-color').hide();
                }else if(status==5){
                    $('.modify_print').removeClass('auto');
                    $('.modify_print').addClass('auto');
                    //$('.J_register_Back').hide();
                    //$('.J_register_save').hide();
                    $('.more-btn').addClass('disable-color').hide();
                }else if(status==6){
                    //$('.J_register_save').hide();
                    $('.more-btn').addClass('disable-color').hide();
                }else{
                    $('.more-btn').removeClass('disable-color').show();
                }
                 //点击退号
                $('.J_register_Back').on('click',function(){
                    var status=$('.register-name').attr('status')
                    var registerId=parseInt($('.register-name').attr('registerid')),
                        registerNo=parseInt($('.register-id').text())
                    if(status==5){
                        cloudClinic.api.inputExpApi.showError('已退费，不能退号！');
                    }else{
                        self.backRegister(registerId)
                    }

                })
                //保存修改
                $(document).on('click','.register_charge_modify',function(){
                    var status=$('.register-name').attr('status'),
                        recordId=$('.register-name').attr('recordId')
                    if(status==5) {
                        cloudClinic.api.inputExpApi.showError('已退号，不能修改！');
                    }else{
                        self.saveModify()
                    }
                    //}else if(status==4){
                    //    cloudClinic.api.inputExpApi.showError('已过期，不能修改！');
                    //}else{
                    //    cloudClinic.api.inputExpApi.showError('已保存病历，不能修改挂号信息！');
                    //}
                })
            })
        },
        //显示更多页面信息
        showMoreInfo:function(){
            var self=this;
            var patientId=$('.register-name-input').attr('patientId')||'';
            var name=$('.register-name-input').val()||'';
            var gender=$('.first .sex-cur').attr('data-id');
            var age=$('.register-age-input').val()||'';
            var ageType=$('.age-unit .ui-select-input').text()||'岁';
            //每次查看更多之前清空更多页面之前留下的信息
            $('.p_patientName').val('')
            $('.alert-box .sex-radio').removeClass('sex-disable')
            $('.patient-age').val('')
            $('.personId-input').val('')
            $('.emergency-contact-input').val('')
            $('.emergency-contact-phone-input').val('')
            $('.p_patientPhone').val('')
            $('.remarks-input').val('')
            $('.J_symptom').text('')
            $('.p_previousHistory').text('')
            $('.p_personalHistory').text('')
            $('.J_allergyHistory').text('')
            $('.J_familyHistory').text('')
            $('.alert-box').show();
            if(patientId){
                cloudClinic.api.io('his/outpatient/newRecord',{"patientId":patientId},function(d){
                    //for(var i=0;i<d.body.patientList.length;i++){
                    //    if(d.body.patientList[i].patientId==patientId){
                    self.config.allData=d.body
                    self.renderpatientInfo(self.config.allData);
                    //}
                    //}
                });

            }else{
                self.renderNewPatientInfo(name,gender,age,ageType);
            }
        },
        //页面渲染信息（初诊患者）
        /*
         * 如果该患者没有patientId则判断是初诊，在更多页面渲染新建挂号时填写的信息
         * name 患者姓名
         * gender 患者性别
         * age 患者年龄
         * ageType 患者年龄类型
         * */
        renderNewPatientInfo:function(name,gender,age,ageType){
            var self=this;
            //重新生成姓名和性别的dom（因为之前如果是复诊患者,姓名和性别是不可更改的）
            var div=document.createElement("input");//患者姓名空div
            $(div).attr('type','text').attr("class",'patient-name zh-ipt recordIpt mustInt p_patientName').attr("name",'patient-name').val(name);
            $('.patient-name').after(div).remove();
            $('.single-information .ui-select-input').html(ageType).attr('title',ageType).attr('key',ageType)
            gender=='1'?$('.alert-box .sex-radio').eq(0).addClass('sex-cur').removeClass('sex-disable').siblings().removeClass('sex-cur'):$('.alert-box .sex-radio').eq(1).addClass('sex-cur').removeClass('sex-disable').siblings().removeClass('sex-cur')
            $('.alert-box .sex-radio').addClass('sex-radio-q')
            $('.patient-age').val(age)
            $('.phone-num').val('')
        },
        //页面渲染基本信息（复诊患者）
        /*
         * 如果该患者有patientId则判断是复诊，则在更多页面渲染从新建病历接口获取到的数据
         * data 从新建病历接口获取到的数据
         * */
        renderpatientInfo:function(data){
            var self=this;
            var Name = data.patientName;
            var patientId = data.patientId;
            var patientAge = data.age||'';
            var gender=data.gender;
            var ageType=data.ageType;
            var idCardNo=data.idCardNo||'';
            var phoneNo=data.phoneNo||'';
            cloudClinic.api.io('his/outpatient/getPatientInfo',{"patientId":patientId},function(d){
                var idCardNo= d.body.idCardNo? d.body.idCardNo:'';
                var linkman=d.body.linkman?d.body.linkman:'';
                var linkmanPhone=d.body.linkmanPhone?d.body.linkmanPhone:'';
                var comment=d.body.comment? d.body.comment:'';
                var div=document.createElement("div");//患者姓名空div
                $(div).attr("class",$(".patient-name").attr("class")+" disabled").attr("patientId",+data.patientId).text(data.patientName||"");
                $('.patient-name').addClass('zh-ipt recordIpt mustInt p_patientName')
                $('.patient-name').after(div).remove();
                $('.single-information .ui-select-input').html(ageType).attr('title',ageType).attr('key',ageType)
                gender==1?$('.alert-box .sex-radio').removeClass('sex-radio-q').eq(0).addClass('sex-cur').siblings().removeClass('sex-cur'):$('.alert-box .sex-radio').removeClass('sex-radio-q').eq(1).addClass('sex-cur').siblings().removeClass('sex-cur')
                $('.alert-box .sex-cur').addClass('sex-disable').siblings().removeClass('sex-disable')
                $('.patient-age').val(patientAge)
                $('.phone-num').val(phoneNo)
                $('.personId-input').val(idCardNo)
                $('.emergency-contact-input').val(linkman)
                $('.emergency-contact-phone-input').val(linkmanPhone)
                $('.remarks-input').val(comment)
                $('.J_previousHistory').text(data.personalHistory)
                $('.p_previousHistory').text(data.previousHistory)
                $('.J_allergyHistory').text(data.allergyHistory)
                $('.J_familyHistory').text(data.familyHistory)
            })
            //})
        },
        //修改挂号
        /*
         * target 当前点击的节点
         * */
        modify:function(target,registerStatus){
            var self=this;
            var dataRegisterNo,
                statusStr='',
                btnStr='',
                titleStr='';
            dataRegisterNo=parseInt($(target).attr('data-registerno'));
            if(dataRegisterNo<10){
                dataRegisterNo='00'+dataRegisterNo.toString();
            }else if(dataRegisterNo<100){
                dataRegisterNo='0'+dataRegisterNo.toString();
            }else if(dataRegisterNo<1000){
                dataRegisterNo=dataRegisterNo;
            }
            //对于状态是已诊、已退号的患者，查看信息时修改挂号应改为挂号信息
            if(registerStatus==5){
                titleStr+='挂号信息';
            }else{
                titleStr+='修改挂号';
            }
            //修改的dom
            var str='<div class="newRegister-top">'
                +'<span class="newRegister-title">';
                str+=titleStr+'</span>'+'</div>'
                +'<div class="newRegister-content">'
                +'<div class="register-num">'
                +'<span class="newRegister-desc">序号：</span><span class="register-id">'+dataRegisterNo+'</span>'
               //待诊、接诊中、已过号状态患者显示状态选择框
                if(registerStatus==1||registerStatus==2||registerStatus==4){
                    statusStr+='<div class="status">'
                                +'<span class="f-left newRegister-desc J_project_before">状态：</span>'
                                +'<select class="J_regiterstatus">'
                                +'<option value="1">待诊</option>'
                                +'<option value="2">接诊中</option>'
                                +'<option value="4">已过号</option>'
                                +'</select>'
                                +'</div>'
                }else{
                    statusStr=''
                }
                str+=statusStr+'</div>'
                +'<p class="register-name">'
                +'<span class="newRegister-desc">姓名：</span>'
                +'<span class="register-name-input disabled" patientId="'+$(target).attr('patientid')+'">'+$(target).children('.J_register_name').html()+'</span>'
                +'</p>'
                +'<div class="register-sex-age J_singleInformation">'
                +'<span class="single-information sex">'
                +'<i class="sex-radio-q sex-radio sex-cur" data-sex="男" data-id="1"></i><i>男</i>'
                +'<i class="sex-radio-q sex-radio" data-sex="女" data-id="0"  style="margin-left:27px;"></i>女'
                +'</div>'
                +'<div class="register-age">'
                +'<div class="age">'
                +'<span class="newRegister-desc">年龄：</span><input type="text" class="register-age-input"/>'
                +'<span class="age-unit">'
                +'<select class="J_ageUnit">'
                +'<option value="岁" selected="selected" title="岁">岁</option>'
                +'<option value="月" title="月">月</option>'
                +'<option value="天" title="天">天</option>'
                +'</select>'
                +' </span>'
                +'</div>'
                +'<a class="more-btn btn-style f-left">查看更多</a>'
                +'</div>'
                +'<p class="department">'
                +'<span class="f-left newRegister-desc">科室：</span>'
                +'<select class="J_department">'
                +'<option value="" selected="selected">不指定</option>'
                +'</select>'
                +'</p>'
                +'<p class="doctor">'
                +'<span class="f-left newRegister-desc">医生：</span>'
                +'<select class="J_doctor">'
                +'<option value="" selected="selected">不指定</option>'
                +'</select>'
                +'</p>'
                +'<p class="project">'
                +'<span class="f-left newRegister-desc J_project_before">项目名：</span>'
                +'<select class="J_project ">'
                +'<option value="" selected="selected">不指定</option>'
                +'</select>'
                +'</p>'
                +'<p class="should-pay">'
                +'<span class="newRegister-desc">应收：</span><span class="pay-num">0.00</span>元'
                +'</p>'
                +'<div class="discount-pay">'
                +'<span class="newRegister-desc">优惠：</span>'
                +'<div class="discount-pay-input-box">'
                +'<p class="discount-pay-input disabled">1.00</p><span class="unit">元</span>'
                +'</div>'
                +'</div>'
                +'<div class="really-pay">'
                +'<span class="newRegister-desc">实收：</span>'
                +'<div class="really-pay-input-box">'
                +'<p class="really-pay-input disabled">5.00</p><span class="unit">元</span>'
                +'</div>'
                +'</div>'
                +'<div class="register-btn-print register-btn-print-modify">'
                //已退号状态不显示退号和修改按钮，已过去按钮不显示修改按钮
                if(registerStatus==5){
                    btnStr+=''
                }else if(registerStatus==6||registerStatus==3){
                    btnStr+='<span class="J_register_Back btn-style register_back float-right">退号</span>'
                }else{
                    btnStr+='<span class="J_register_save btn-style register_charge_modify">保存修改</span>'
                            +'<span class="J_register_Back btn-style register_back">退号</span>'

                }
                str+=btnStr+'<div class="print-config2 btn-style modify_print">打印'
                +'</div>'
                +'</div>'
                +'</div>'
            $('.newRegister').html(str);
            var _height = $(window).height();
            $(".newRegister-content").css('height', _height - 178);
            $('.sex-cur').addClass('sex-disable');
        },
        //更多信息页面姓名sug
        nameSug:function(){
            var self = this;
            $('.first').sugSelect({
                isProxyEvent:true,
                inputNode: '.register-name-input',
                onFocus:function($this){
                    //var $sug = $this.next(".sug-ul-dom");
                    //$sug.html() && $sug.show();
                },
                onInput:function($this){
                    cloudClinic.api.io('his/outpatient/searchPatientBySug',{"patientName":$this.val()},function(d){self._nameSearchSuccess(d,$this)});
                },
                selected:function($item,$this){
                    if($item.length){
                        var index =$this.next(".sug-ul-dom").find("li").index($item);
                        self._nameSearchAdd(self.config.nameData.body.patientList[index]);
                        self.config.allData=self.config.nameData.body.patientList[index];
                    }
                }
            });
        },
        //sug患者姓名接口调用成功
        /*
         * data sug接口获取到的接口
         * $input 当前调用sug接口的节点
         * */
        _nameSearchSuccess:function(data,$input){
            var self = this;
            $input.next(".sug-ul-dom").html('');
            if(data.body.patientList.length){
                for(var i = 0;i<data.body.patientList.length;i++){
                    var st = '<li><i class="name-search-name">'+data.body.patientList[i].patientName+'</i><i class="name-search-gender">'+(data.body.patientList[i].gender==1?"男":"女"||"")+'</i><i class="name-search-age">'+(data.body.patientList[i].age&&(data.body.patientList[i].age+"<em>"+data.body.patientList[i].ageType+"</em>")||"")+'</i></li>';
                    //var st = '<li>'+data.body.patientList[i].patientName+'</li>';
                    $input.next(".sug-ul-dom").append(st);
                }
                $input.next(".sug-ul-dom").find('li').eq(0).addClass('s-hover');
                $input.next(".sug-ul-dom").show();
            }else{
                //$(self.config.patientNameSearchContent).append('<li>找不到该患者</li>');
                $input.next(".sug-ul-dom").hide();
            }
            self.config.nameData = data;
        },
        //患者姓名搜索
        /*
         * data sug接口获取到的接口
         * */
        _nameSearchAdd:function(data){
            var self = this;
            //cloudClinic.api.io('his/outpatient/newRecord',{patientId:data.patientId},function(d){self._patientRender(d)});
            self._patientRender(data)
        },
        //_nameSearchAdd之后的仅有患者基本信息的渲染
        /*
         * data sug接口获取到的接口
         * */
        _patientRender:function(data){
            var self = this;
            $('.patient-name').val(data.patientName||"").attr('disabled','true');
            var div=document.createElement("div");//患者姓名空div
            $(div).attr("class",$(".register-name-input").attr("class")+" disabled").attr("patientId",+data.patientId).text(data.patientName||"");
            $('.register-name-input').after(div).remove();
            $('.first .sex-radio').removeClass('sex-radio-q').removeClass('sex-cur').addClass("sex-disable");
            if(data.gender==1){
                $('.first .sex-radio').eq(0).addClass('sex-cur');
            }else{
                $('.first .sex-radio').eq(1).addClass('sex-cur');
            };
            if(data.age){
                $('.register-age-input').val(data.age).removeClass('red-ipt');
            }
            if(data.symptom){
                $('.patient-old').text(data.symptom).removeClass('red-ipt');
            }
            var $p_age_parent=$('.patient-age').parent();
            $p_age_parent.find(".p_ageType").val(data.ageType||"");
            $('.age-unit .ui-select-input').text(data.ageType).attr('title',data.ageType).attr('key',data.ageType);
            $('.register-age-input').val(data.age)
            $('.register-age-input').attr('disabled','disabled').addClass('disabled')
            self.config.select5.disable()
            //$p_age_parent.find(".ui-select-input").text(data.body.ageType||"").attr("title",data.body.ageType||"");
            //self.config.patientId=data.body.patientId;
            //self.config.recordId=data.body.recordId;
        },
        //收费
        _charge:function(){
            var self = this;
            setTimeout(function(){
                var totalPrice = parseFloat($('.really-pay-input').val()).toFixed(3).decimalPoint();
                var project=$('.project .ui-select-input').attr('key');
                var hasName=false;
                var age=$('.register-age-input').val();
                var name=$('.register-name-input').html()?$('.register-name-input').html():$('.register-name-input').val()
                var doctorId=parseInt($('.doctor .ui-select-input').attr('key'))==0?'':parseInt($('.doctor .ui-select-input').attr('key'))
                var laboratoryId=parseInt($('.department .ui-select-input').attr('key'))==0?'':parseInt($('.department .ui-select-input').attr('key'))
                var inData = {
                    "age": parseInt($('.register-age-input').val())||0,
                    "gender": parseInt($(".single-information .sex-cur").attr('data-id')),
                    'patientId':parseInt($('.register-name-input').attr('patientId'))||null,
                    'patientName':name||'',
                    'ageType':$('.age-unit .ui-select-input').attr('title')||'岁',
                    "discount":parseFloat($('.discount-pay-input').val())||0,
                    "laboratoryId":laboratoryId||'',
                    "doctorId":doctorId||'',
                    "registerTypeId":parseInt($('.project .ui-select-input').attr('key'))||'',
                    "payMode":parseInt($('.radio-cur').attr('data-value'))||null
                };
                if(name!=''){
                    hasName=true;
                }else{
                    hasName=false
                }
                if(!$('.red-ipt').length){
                    if(hasName==true) {
                        if(age!=''){
                            if (project!='') {
                                if($('.really-pay-input').val()<0){
                                    cloudClinic.api.inputExpApi.showError('实收金额不能小于0');
                                    return false;
                                }
                                cloudClinic.api.ctrlEnter = {
                                    _this: self,
                                    fn: sucCallback
                                };
                                var overLay = new overlay({
                                    width: 520, //{number} 浮层的宽度
                                    height: 365, //{number} 浮层的高度
                                    title: '确认收费',
                                    content: '<div class="overlay-box">' +
                                    '<p class="purchase-overlay" style="color:#fc4a36">实收金额：<span style="font-size: 18px">' + totalPrice + '</span></p>' +
                                    '<p class="purchase-overlay">付款方式：<i class="pay-method radio-cur" data-value="1">现金</i><i class="pay-method" data-value="2">支付宝</i><i class="pay-method" data-value="3">微信</i><i class="pay-method" data-value="4">银行卡</i><i class="pay-method" data-value="5">其他</i></p>' +
                                    '<p class="purchase-overlay">付款金额：<input type="text" id="payPri" value="' + totalPrice + '"/><span id="showPayPri" style="display: none;">' + totalPrice + '</span></p>' +
                                    '<p class="purchase-overlay"><span style="margin-left: 28px">找零：</span><span id="giveChange" style="font-size: 18px">0.00</span></p>' +
                                    '<img src="../../images/chargeTag.png" alt="" class="ovl-charge-tag J_tag"/>' +
                                    '</div>',
                                    DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                                    DialogCancelBtn: true,//{boolean} dialog是否需要取消按钮
                                    DialogCancelCallback: function () {
                                        cloudClinic.api.ctrlEnter = {
                                            _this: self,
                                            fn: self._charge
                                        };
                                        overLay._remove();
                                    },
                                    DialogSureCallback: function () {
                                        sucCallback();
                                    },
                                    ifClose: false,
                                    renderCallback: function () {
                                        //$('#payPri').focus();
                                    }
                                });
                                function sucCallback() {
                                    $('#payPri').blur();
                                    setTimeout(function () {
                                        var payAmount = parseFloat($('#payPri').val()),
                                            payMode = $('.pay-method.radio-cur').attr('data-value');
                                        //if (payAmount>=0) {
                                            inData.payAmount = payAmount;
                                            inData.payMode = payMode;
                                            overLay._remove();
                                            self.config.data = inData;
                                            var isPrinting = $(".print-checked").length ? true : false;
                                            $('.J_charge').text('已收费').removeClass('J_charge');
                                            cloudClinic.api.loading.showLoading();
                                            cloudClinic.api.io('his/register/registerAndCharge', inData, function (d) {
                                                if (d.head.error == 0) {
                                                    $('.alert-box .success-mark').html('<span class="success-mark-txt"></span>收费成功').show(300);
                                                    var registerNo;
                                                    if(parseInt(d.body.registerNo)<10){
                                                        registerNo='00'+d.body.registerNo
                                                    }else if(parseInt(d.body.registerNo)<100){
                                                        registerNo='0'+d.body.registerNo
                                                    }else{
                                                        registerNo=d.body.registerNo
                                                    }
                                                    $('.register-id').text(registerNo)
                                                    setTimeout(function () {
                                                        $('.alert-box .success-mark').html('').hide(300);
                                                        if (isPrinting) {
                                                            self.modifyPrint();
                                                        } else {
                                                            location.href = '../registration/registration.html';
                                                        }
                                                    }, 1500);
                                                } else {
                                                    var overLay = new overlay({
                                                        width: 500, //{number} 浮层的宽度
                                                        height: 300, //{number} 浮层的高度
                                                        title: '提示',
                                                        content: '<p>' + d.head.message||'' + '</p>',
                                                        DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                                                        DialogCancelBtn: false,//{boolean} dialog是否需要取消按钮
                                                        DialogSureCallback: function () {
                                                            $('.yd-overlay-box').remove();
                                                            //location.href='../../view/noChargeList/noChargeList.html?doctorId='+doctorId;
                                                        }
                                                    });
                                                    overLay._dialog();
                                                }
                                            }, 500)
                                        //} else {
                                        //    cloudClinic.api.inputExpApi.showError('请输入付款金额！');
                                        //}
                                    }, 100);
                                }
                                overLay._dialog();
                            } else {
                                cloudClinic.api.inputExpApi.showError('请选择项目名');
                            }
                        }else{
                            cloudClinic.api.inputExpApi.showError('请输入年龄！');
                        }
                    }else{
                        cloudClinic.api.inputExpApi.showError('请输入姓名！');
                    }
                }else{
                    if(!$('.record-error').text()){
                        cloudClinic.api.inputExpApi.showError('请检查红色输入框格式！');
                    }
                }
            },150);
        },
        //修改挂号-打印
        modifyPrint:function(){
            var self=this;
            self.doPrint();
            setTimeout(function () {
                var errorOverlay;
                errorOverlay = new overlay({
                    width: 500, //{number} 浮层的宽度
                    height: 300, //{number} 浮层的高度
                    title: '提示',
                    content: '<p>打印完成</p>',
                    DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                    DialogCancelBtn: false,//{boolean} dialog是否需要取消按钮
                    DialogSureText: '确定',//{string} dialog的确认按钮自定义文案
                    DialogSureCallback: function () {
                        window.location.reload();
                        errorOverlay._remove();
                    },
                    ifClose: false
                });
                errorOverlay._dialog();
            }, 1000)
        },
        //科室下拉数据渲染
        laboratoryRender:function(){
            var self=this;
            var str = '';
            function listRender(data){
                str += '<li title="不指定" data-value="0" class="selected">不指定</li>';
                if(data.body.laboratoryList.length){
                    $.each(data.body.laboratoryList,function(index,ele){
                        str += '<li title="'+ele.laboratoryName+'" data-value="'+ele.laboratoryId+'" class="">'+ele.laboratoryName+'</li>';
                    });
                }
                $('.department .ui-select-list').html(str);
            }
            cloudClinic.api.io('his/registerMsg/getLaboratoryList',{},function(d){
                listRender(d)
            });
        },
        //医生下拉信息渲染
        /*
         * laboratoryId 科室id
         * */
        doctorRender:function(laboratoryId){
            var self=this;
            var str = '';
            var laboratoryId=$('.department .ui-select-wrap .ui-select-input').attr('key')=='0'?'':$('.department .ui-select-wrap .ui-select-input').attr('key')//科室id
            function listRender(data){
                str += '<li title="不指定" data-value="0" class="selected">不指定</li>';
                if(data.body.doctorList){
                    $.each(data.body.doctorList,function(index,ele){
                        var realName=ele.realName==null?ele.doctorName:ele.realName;
                        str += '<li title="'+realName+'" data-value="'+ele.doctorId+'" class="">'+realName+'</li>';
                    });
                }
                $('.doctor .ui-select-list').html(str);
            }
            cloudClinic.api.io('his/registerMsg/getDoctorList',{'laboratoryId':laboratoryId},function (data){
                listRender(data)
            })
        },
        //项目下拉信息渲染
        /*
         * type 项目类型
         * */
        projectRender:function(type){
            var self=this;
            var str = '';
            function listRender(data){
                if(data.body.registerTypeList.length){
                    $.each(data.body.registerTypeList,function(index,ele){
                        str += '<li title="'+ele.registerTypeName+'" data-value="'+ele.registerType+'" class="" data-price="'+ele.registerPrice+'">'+ele.registerTypeName+'</li>';
                    });
                    $('.project .ui-select-list').html(str);
                    $('.project .ui-select-input').text(data.body.registerTypeList[0].registerTypeName).attr('title',data.body.registerTypeList[0].registerTypeName).attr('key',data.body.registerTypeList[0].registerType)
                    $('.pay-num').text(parseFloat(data.body.registerTypeList[0].registerPrice).toFixed(3).decimalPoint())
                    $('.really-pay-input').val(parseFloat(data.body.registerTypeList[0].registerPrice-$('.discount-pay-input').val()).toFixed(3).decimalPoint())
                }
            }
            cloudClinic.api.io('his/registerMsg/getRegisterTypeItems',{},function (data){
                    if(data.body.registerTypeList.length){
                        listRender(data)}
                    else{
                        var overLay = new overlay({
                            width: 500, //{number} 浮层的宽度
                            height: 300, //{number} 浮层的高度
                            title: '提示',
                            content: '未设置挂号项，请到<a class="stress" href="../../view/registrationFee/registrationFee.html">诊所管理/挂号费设置</a>中新建挂号项',
                            DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                            DialogCancelBtn: false,//{boolean} dialog是否需要取消按钮
                            DialogSureCallback: function () {
                                $('.yd-overlay-box').remove();
                            },
                            DialogCancelCallback:function(){
                                $('.yd-overlay-box').remove();
                            }
                        });
                        overLay._dialog();
                    }
            })
        },
        //新增挂号-功能
        addRegister:function(){
            var self=this;
            var str='<div class="newRegister-top">'
                +'<span class="newRegister-title">新增挂号</span>'
                +'</div>'
                +'<div class="newRegister-content">'
                +'<p class="register-num">'
                +'<span class="newRegister-desc">序号：</span><span class="register-id"></span>'
                +'</p>'
                +'<p class="register-name">'
                +'<span class="newRegister-desc">姓名：</span>'
                +'<input type="text" class="register-name-input"/>'
                +'</p>'
                +'<div class="register-sex-age J_singleInformation">'
                +'<span class="single-information sex">'
                +'<i class="sex-radio-q sex-radio sex-cur" data-sex="男" data-id="1"></i>男'
                +'<i class="sex-radio-q sex-radio" data-sex="女" data-id="0"  style="margin-left:27px;"></i>女'
                +'</span>'
                +'</div>'
                +'<div class="register-age">'
                +'<div class="age">'
                +'<span class="newRegister-desc">年龄：</span><input type="text" class="register-age-input"/>'
                +'<span class="age-unit">'
                +'<select class="J_ageUnit">'
                +'<option value="岁" selected="selected" title="岁">岁</option>'
                +'<option value="月" title="月">月</option>'
                +'<option value="天" title="天">天</option>'
                +'</select>'
                +'</div>'
                +'<a class="more-btn btn-style f-left disable-color" style="display: none;">查看更多</a>'
                +'</span>'
                +'</div>'
                +'<p class="department">'
                +'<span class="f-left newRegister-desc">科室：</span>'
                +'<select class="J_department">'
                +'<option value="" selected="selected">不指定</option>'
                +'</select>'
                +'</p>'
                +'<p class="doctor">'
                +'<span class="f-left newRegister-desc">医生：</span>'
                +'<select class="J_doctor">'
                +'<option value="" selected="selected">不指定</option>'
                +'</select>'
                +'</p>'
                +'<p class="project">'
                +'<span class="f-left newRegister-desc J_project_before">项目名：</span>'
                +'<select class="J_project ">'
                +'<option value="" selected="selected">不指定</option>'
                +'</select>'
                +'</p>'
                +'<p class="should-pay">'
                +'<span class="newRegister-desc">应收：</span><span class="pay-num">0.00</span>元'
                +'</p>'
                +'<p class="discount-pay">'
                +'<span class="newRegister-desc">优惠：</span>'
                +'<span class="discount-pay-input-box">'
                +'<input type="text" class="discount-pay-input"  value="0.00"/><span class="unit">元</span>'
                +'</span>'
                +'</p>'
                +'<p class="really-pay">'
                +'<span class="newRegister-desc">实收：</span>'
                +'<span class="really-pay-input-box">'
                +'<input type="text" class="really-pay-input" value="0.00"/><span class="unit">元</span>'
                +'</span>'
                +'</p>'
                +'<div class="register-btn-print">'
                +'<span class="J_register_charge btn-style register_charge">挂号收费</span>'
                +'<div class="print-config">'
                +'<i class="print-check"></i>打印'
                +'</div>'
                +'</div>'
                +'</div>'
            $('.newRegister').html(str);
            var _height = $(window).height();
            $(".newRegister-content").css('height', _height - 178);
            //打印-读取勾选状态-操作
            var huimeiPrintStr = window.localStorage && window.localStorage.getItem("huimeiPrint")||null;
            var huimeiPrint = huimeiPrintStr ? JSON.parse(huimeiPrintStr) : {};
            huimeiPrint['purchase'] == 1 && $(".print-check").addClass("print-checked");
            //self.getId();
        },
        //退号-功能
        /*
         * registerId 患者挂号id
         * */
        backRegister:function(registerId){
            var self=this;
            var overLay = new overlay({
                width: 500, //{number} 浮层的宽度
                height: 300, //{number} 浮层的高度
                title: '提示',
                content: '确认退号？',
                DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                DialogCancelBtn: true,//{boolean} dialog是否需要取消按钮
                DialogSureCallback: function () {
                    $('.yd-overlay-box').remove();
                    cloudClinic.api.io('his/register/registeredRefund',{'registerId':registerId},function (data){
                        if(data.head.error==0){
                            $('.success-mark').html('<span class="success-mark-txt"></span>退号成功').show(300);
                            setTimeout(function(){
                                $('.success-mark').hide(300).html('');
                                window.location.reload()
                            },600)
                        }else{
                            cloudClinic.api.inputExpApi.showError(data.head.message||'');
                        }
                    })
                    //location.href='../../view/noChargeList/noChargeList.html?doctorId='+doctorId;
                },
                DialogCancelCallback:function(){
                    $('.yd-overlay-box').remove();
                }
            });
            overLay._dialog();
        },
        //保存修改
        saveModify:function(){
            var self=this;
            var data={
                'registerId':parseInt($('.register-name').attr('registerId'))||null,//挂号id
                'registerNO':parseInt($('.register-id').text())||null,//挂号序号
                'patientId':parseInt($('.register-name-input').attr('patientid'))||null,//患者id
                'patientName':$('.register-name-input').text()||'',//患者姓名
                'gender':parseInt($('.sex-cur').attr('data-id'))||1,//性别
                'age':parseInt($('.register-age-input').val())||null,//年龄
                'ageType':$('.age-unit .ui-select-input').text()||'岁',//年龄单位
                'laboratoryId':parseInt($('.department .ui-select-input').attr('key'))||null,//科室id
                'doctorId':parseInt($('.doctor .ui-select-input').attr('key'))||null,//医生id
                'registerTypeId':parseInt($('.project .ui-select-input').attr('key'))||null,//挂号类型id
                'discount':parseInt($('.discount-pay-input').text())||0,//优惠钱数
                'payMode':null,//支付方式
                'registerStatus':parseInt($('.status .ui-select-input').attr('key'))||null//状态
            }
            var overLay = new overlay({
                width: 500, //{number} 浮层的宽度
                height: 300, //{number} 浮层的高度
                title: '提示',
                content: '确认修改挂号？',
                DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                DialogCancelBtn: true,//{boolean} dialog是否需要取消按钮
                DialogSureCallback: function () {
                    $('.yd-overlay-box').remove();
                    cloudClinic.api.io('his/register/registerAndCharge',data,function(rep){
                        if(rep.head.error==0){
                            $('.success-mark').html('<span class="success-mark-txt"></span>保存成功').show(300);
                            setTimeout(function(){
                                $('.success-mark').hide(300).html('');
                                window.location.reload()
                            },600)
                        }else{
                            cloudClinic.api.inputExpApi.showError(rep.head.message||'');
                        }
                    })
                    //location.href='../../view/noChargeList/noChargeList.html?doctorId='+doctorId;
                },
                DialogCancelCallback:function(){
                    $('.yd-overlay-box').remove();
                }
            });
            overLay._dialog();
        },
        //点击查询事件处理
        handleSearchDrug : function(){
            var self = this,
                g = self.config;
            var $patientName = $('.J_userName'),
                patientName=null;
            var doctorName=$('.J_doctorName').val()==''?null:$('.J_doctorName').val();
            var registerStatus=$('.J_status').val()==''?null:$('.J_status').val();
            patientName=$patientName.val() == ''?null:$patientName.val();
            var dataObj = {
                patientName : patientName,
                doctorName : doctorName,
                registerStatus : registerStatus
            };
            self.showRegisterLsit(dataObj,function(total,itemTotal){
                if(g.listPagination === null){
                    g.listPagination = self.createPagination(total, itemTotal);;
                }else{
                    g.listPagination._reset(1,total,itemTotal);
                }
            });
        },
        //创建分页
        /*
         * totalPage 总页数
         * index 当前页
         * */
        createPagination : function(totalPage,itemTotal){
            var self = this;
            return new pagePaging({
                pageTotal : totalPage,
                currentPageIndex: ls,
                maxPageIndex: 7,
                pageSize: self.config.pageSize,
                itemTotal: itemTotal,
                pageChangeCallback: function (index) {
                    var $patientName = $('.J_userName'),
                        patientName=$patientName.val() == ''?null:patientName;
                    ls = index;
                    self.config.pageSize = parseInt($(".page-num-size").val()) || self.config.pageSize;
                    var doctorName=$('.J_doctorName').val()==''?null:$('.J_doctorName').val();
                    var registerStatus=$('.J_status').val()==''?null:$('.J_status').val();
                    var dataObj = {
                        currentPage : index,
                        patientName : patientName,
                        doctorName : doctorName,
                        registerStatus : registerStatus
                    };
                    self.showRegisterLsit(dataObj, function(total, itemTotal){
                            self.config.listPagination._reset(index, total||1, itemTotal);
                    });
                }
            });
        },
        //挂号列表渲染
        /*
         * dataObj 当前页数的数据
         * */
        showRegisterLsit : function(dataObj,callback){
            var self = this;
            showList(self.config.pageSize);
            function showList(pageSize){
                var self = this,
                    g = self.global;
                var data = {
                    "currentPage": 1,
                    "doctorName": null,
                    "patientName": null,
                    "pageSize":pageSize,
                    "registerStatus":null
                };
                $('.paging-page').html('');
                $('.J_registerList').html('<p class="please-wait">正在加载，请稍等！</p>');
                data = $.extend({},data,dataObj);
                var $notFound = $('.J_drugnotfound'),
                    $table = $('.J_drugtable'),
                    $zero = $('.J_drugzero');
                var url = 'his/register/registeredPatientList';
                //var url='his/inventory/searchDrugList'
                //处理价格变为2位小数
                function fixedPrice(price){
                    var price=price.toFixed(3).decimalPoint();
                    return '&yen;'+price;
                }
                cloudClinic.api.io(url,data,function(rep){
                    var localPage = data.currentPage;
                    if(rep.head.error == 0){
                        if(rep.body.isConfig == 0){
                            $zero.show();
                            $table.hide();
                            $notFound.hide();
                            return false;
                        }else{
                            if(rep.body.patientList && rep.body.patientList.length < 1){
                                $notFound.show();
                                $table.hide();
                                $zero.hide();
                                return false;
                            }else{
                                $notFound.hide();
                                $table.show();
                                $zero.hide();
                            }
                            var str = '',
                                list = rep.body.patientList,
                                dl = null;
                            for(var i=0,len=list.length;i < len;i++){
                                dl = list[i];
                                var gender=dl.gender==1?'男':'女'
                                var registerOperator=dl.registerOperator||''
                                var status;
                                var doctor=dl.doctorName||'未指定';
                                var laboratoryName=dl.laboratoryName||'未指定';
                                var type;
                                switch(dl.registerStatus)
                                {
                                    case 1:
                                        status='待诊'
                                        break;
                                    case 2:
                                        status='接诊中'
                                        break;
                                    case 3:
                                        status='已诊'
                                        break;
                                    case 4:
                                        status='已过号'
                                        break;
                                    case 5:
                                        status='已退号'
                                        break;
                                    case 6:
                                        status='已过期'
                                        break;
                                }
                                str += '<tr patientId="'+dl.patientId+'"  data-registerNo="'+dl.registerNo+'" data-registerId="'+dl.registerId+'" data-typeId="'+dl.registerType+'"  data-typeName="'+dl.registerTypeName+'"  data-status="'+dl.registerStatus+'" laboratoryId="'+dl.laboratoryId+'">'+
                                '<td class="J_register_radio"><i class="select-radio-q select-radio" data-id="0"></i></td>'+
                                '<td class="J_register_status">'+status+'</td>'+
                                '<td class="J_register_name">'+dl.patientName+'</td>'+
                                '<td class="J_register_sex">'+gender+'</td>'+
                                '<td class="J_register_age">'+dl.age+dl.ageType+'</td>'+
                                '<td class="J_register_department">'+laboratoryName+'</td>'+
                                '<td class="J_register_doctor">'+doctor+'</td>'+
                                '<td class="J_register_operator">'+registerOperator+'</td>'+
                                '<td class="J_register_dateTime">'+dl.registerDateTime+'</td>'+
                                '</tr>';
                            }
                            $('.J_registerList').html(str);
                            $('.J_selectAll').removeClass('select-cur');
                            callback && callback(rep.body.totalPage, rep.body.totalSize || 0);
                        }
                    }
                });
            }
        },
        //打印dom渲染
        _changeToPrintTotalDom:function(){
            var self = this,
                str = '',
                laboratory=$('.department .ui-select-input').text(),
                registerNo=$('.register-id').text(),
                patientName=$('.register-name-input').val()?$('.register-name-input').val():$('.register-name-input').text(),
                price=$(".really-pay-input").attr('data-price')||$(".really-pay-input").val(),
                hosName = self._printConfig.invoiceLookedUp||'',
                name = doctorInfo().realName||'',
                newDate = new Date(),
                month = newDate.getMonth()+1,
                day = newDate.getDate(),
                hour = newDate.getHours(),
                minutes = newDate.getMinutes(),
                seconds = newDate.getSeconds(),
                pageSize=self._printConfig.paperType,
                printDetail=self._printConfig.printDetail,
                registerPrice='',
                title='';
            if(month<10) month = '0'+month;
            if(day<10) day = '0'+day;
            if(hour<10) hour = '0'+hour;
            if(minutes<10) minutes = '0'+minutes;
            if(seconds<10) seconds = '0'+seconds;
            var date = newDate.getFullYear()+'-'+month+'-'+day+' '+hour+':'+minutes+':'+seconds;
            if(pageSize==58){
                title='<li class="print-title">'+hosName+'</li>' + '<p class="print-title ">挂号凭条</p>'
            }else{
                title= '<li class="print-title">'+hosName+'挂号凭条</li>'
            }
            str += '<ul class="print-table print-only-total">' +
            title+
            '<li class="print-info"><div class="info"><span class="print-head">科室：</span><span class="j_print_hisname">'+laboratory+'</span></div></li>'+
            '<li class="print-info"><div class="info"><span class="print-head">就诊序号：</span><span class="j_print_registerNo">'+registerNo+'</span></div></li>' +
            '<li class="print-info"><div class="info"><span class="print-head">姓名：</span><span class="j_print_patientName">'+patientName+'</span></div></li>'
            if(printDetail==1){
                registerPrice='<li class="print-info"><div class="info"><span class="print-head">挂号费：</span><span class="j_print_price">'+price+'元</span></div></li>'
            }else{
                registerPrice=''
            }
            str +=registerPrice+'<li class="print-info"><div class="info"><span class="print-head">挂号员：</span><span class="j_print_doctor">'+name+'</span></div></li>' +
            '<li class="print-info"><div class="info"><span class="print-head"></span><span class="j_print_time">'+date+'</span></div></li>' +
            '<li class="print-end">'+(self._printConfig.inscribe||"")+'</li>' +
            '<li class="j_print_bottom">'+
            '</li>'+
            '</ul>';
            return str;
        },
        //打印dom渲染
        _changeToPrintListDom:function(){
            var self = this,
                str = '',
                laboratory=$('.department .ui-select-input').text(),
                registerNo=$('.register-id').text(),
                patientName=$('.register-name-input').val()?$('.register-name-input').val():$('.register-name-input').text(),
                price=$(".really-pay-input").attr('data-price')||$(".really-pay-input").val(),
                hosName = self._printConfig.invoiceLookedUp||'',
                name = doctorInfo().realName||'',
                newDate = new Date(),
                month = newDate.getMonth()+1,
                day = newDate.getDate(),
                hour = newDate.getHours(),
                minutes = newDate.getMinutes(),
                seconds = newDate.getSeconds(),
                pageSize=self._printConfig.paperType,
                printDetail=self._printConfig.printDetail,
                title='',
                registerPrice='';
            if(month<10) month = '0'+month;
            if(day<10) day = '0'+day;
            if(hour<10) hour = '0'+hour;
            if(minutes<10) minutes = '0'+minutes;
            if(seconds<10) seconds = '0'+seconds;
            var date = newDate.getFullYear()+'-'+month+'-'+day+' '+hour+':'+minutes+':'+seconds;
            if(pageSize==58){
                title='<li class="print-title">'+hosName+'</li>' + '<p class="print-title ">挂号凭条</p>'
            }else{
                title= '<li class="print-title">'+hosName+'挂号凭条</li>'
            }
            str += '<ul class="print-table print-only-total">' +
            title+
            '<li class="print-info"><div class="info"><span class="print-head">科室：</span><span class="j_print_hisname">'+laboratory+'</span></div></li>'+
            '<li class="print-info"><div class="info"><span class="print-head">就诊序号：</span><span class="j_print_registerNo">'+registerNo+'</span></div></li>' +
            '<li class="print-info"><div class="info"><span class="print-head">姓名：</span><span class="j_print_patientName">'+patientName+'</span></div></li>';
            if(printDetail==1){
                registerPrice='<li class="print-info"><div class="info"><span class="print-head">挂号费：</span><span class="j_print_price">'+price+'元</span></div></li>'
            }else{
                registerPrice=''
            }
            str+=registerPrice+'<li class="print-info"><div class="info"><span class="print-head">挂号员：</span><span class="j_print_doctor">'+name+'</span></div></li>' +
            '<li class="print-info"><div class="info"><span class="print-head"></span><span class="j_print_time">'+date+'</span></div></li>' +
            '<li class="print-end">'+(self._printConfig.inscribe||"")+'</li>' +
            '<li class="j_print_bottom">'+
            '</li>'+
            '</ul>';
            return str;
        }

    })
    var hmRegistration = new registration();
})
