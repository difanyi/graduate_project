jQuery.hmSelect = function(elem, list, complete, ajax, height) {
	var addHiddenInput = function(value) {
    	var input = document.createElement('input');      
        $(input).attr({'type': 'hidden', 'name': (elem.attr('id')+'[]'), 'id': (elem.attr('id')+'[]'), 'value': value});
        return input;
    };
    var getChar = function(e) {
    	if(window.event) {
			keynum = e.keyCode;
		} else if(e.which) {
		  keynum = e.which;
    	}
    	if (keynum == 8)
    		return '';
    		
    	return String.fromCharCode(keynum);
    }
    var addItem = function(item, preadded) {
    	var title = item.html().replace(/<em>/gi,'').replace(/<\/em>/gi,'');
    	var value = (item.attr('val') && item.attr('val') != -1 ?item.attr('val'):title); 
        var id = (item.attr('data-id'));   	
        var li = document.createElement('li');
        var txt = document.createTextNode(title);
        var span = document.createElement('span');
        var aclose = document.createElement('a');
		var input = addHiddenInput(value);
        var ifExist = false;

        $('.bit-box').each(function(index,ele){
            if($(ele).attr('data-id')==id&&$(ele).attr('val')==value){
                ifExist=true;
            }
        })
		
        if(!ifExist){
            $(li).attr({'val': value,'data-id':id, 'class': 'bit-box'});
            $(span).attr("title",title).prepend(txt);
            $(aclose).attr({'class': 'closebutton','href': '#'});
            li.appendChild(span);
            li.appendChild(aclose);
            li.appendChild(input);
            holder.appendChild(li);
            //var s_ipt = document.getElementById('annoninput');
            //holder.insertBefore(s_ipt,holder.childNodes[0])
            if (!preadded) {
                holder.removeChild(document.getElementById('annoninput'));
                addInput();
            }
            $('.default').show();                     
            feed.hide().html('');
            curIndex=0;
            $('#feed').scrollTop(0);
            //$('.maininput').val('');
            hmNewRecord._cdssSetDiagnosis && hmNewRecord._cdssSetDiagnosis();
        }else{
            $('.maininput').val('');
            feed.hide().html('');
            var overLay = new overlay({
                width: 500, //{number} 浮层的宽度
                height: 300, //{number} 浮层的高度
                title: '提示',
                content: '<p>该诊断已存在...</p>',
                DialogSureBtn: true, //{boolean} dialog是否需要确认按钮
                DialogCancelBtn: false,//{boolean} dialog是否需要取消按钮
                DialogSureCallback: function(){
                    $('.yd-overlay-box').remove();
                }
            });
            overLay._dialog();
        }
    }
    var addItemFeed = function(data,input) {
    	feed.children('li[fckb=2]').remove();
    	$.each(data.body, function(i, val) {
           if (val.diseaseId) {
		    	var li = document.createElement('li');		    	
		        $(li).attr({'data-name': val.diseaseName,'data-id': val.diseaseId,'fckb': '2'});
		        $(li).html(val.diseaseName.replace(input,'<em>'+input+'</em>'));
		        feed.append(li);
	    	}
        });    	
        addTextItemFeed(input);
    }
    var addTextItemFeed = function(value) {
    		feed.children('li[fckb=1]').remove();
	    	var li = document.createElement('li');
            var exist = false;
	        $(li).attr({'val':value,'fckb': '1'});
	        $(li).html(value);
            feed.find('li').each(function(index,ele){
                if($(ele).attr('data-name')==value){
                    exist = true;
                }
            });
            if(exist==false){
                feed.prepend(li);
            }
            $('#feed').find('li').eq(0).addClass('auto-focus');
    }
    //thanks to idgnarn for fix
    var bindEvents = function () {
		var nowFocusOn;
     	feed.children('li').mouseover(
     		function(){
                $(this).addClass("auto-focus");
				nowFocusOn=$(this);
            }
        ); 
        feed.children('li').mouseout(
        	function(){
                $(this).removeClass("auto-focus");
				nowFocusOn=null;
        	}
       	);        
        feed.children('li').unbind('click');
        feed.children('li').click(function(){            
            addItem($(this));
            complete.hide();
        });
		$('.maininput').unbind('keypress');
		$('.maininput').keypress(
			function(event){
				if (event.keyCode == 13 && nowFocusOn != null) {
					addItem($(nowFocusOn));
					complete.hide();
					event.preventDefault();
				}
			}
		);
    }
    var addInput = function () {
        var li = document.createElement('li');
        var input = document.createElement('input');
        $(li).attr({'class': 'bit-input', 'id': 'annoninput'});
        $(input).attr({'type': 'text', 'class': 'maininput recordIpt','maxlength':'50'});
        li.appendChild(input);
        if(holder.childNodes.length){
            holder.insertBefore(li,holder.childNodes[0]);
        }else{
            holder.appendChild(li);
        }
        $(li).click(function() {
            complete.fadeIn('fast');
        });
	    $(li).keyup(function(event) {
	    	var etext = $.trim($(input).val());
            if(etext){
                if(event.keyCode>=65&&event.keyCode<=90||event.keyCode>=48&&event.keyCode<=57||event.keyCode>=96&&event.keyCode<=105||event.keyCode==8||event.keyCode==32||event.keyCode==229){
                    deleteIndex=1;
                    $('.bit-box').last().css('background','#f5f5f5');
                    curIndex=0;
                    $('#feed').scrollTop(0);
                    if (ajax) {
                        clearTimeout(hmSugCon.sugKeyupTimeHwnd);
                        hmSugCon.sugKeyupTimeHwnd=setTimeout(function(){
                            var _diseaseName= $.trim($(input).val());
                            hmSugCon.sugPostVer++;
                            $.ajax({
                                url:  cloudClinic.api.query_port+ajax, type: 'POST',dataType: 'json',
                                data: JSON.stringify({
                                    "hospitalGuid":hospitalGuid,
                                    "diseaseName":_diseaseName,
                                    "version":hmSugCon.sugPostVer
                                }),
                                headers:{
                                    "Content-Type": "application/json; charset=utf-8"
                                },
                                success:function(data){
                                    if(data.head.error==0){
                                        if(data.head.version && hmSugCon.sugReceiveVer > data.head.version) return false;
                                        hmSugCon.sugReceiveVer = data.head.version;
                                        addItemFeed(data, _diseaseName);
                                        bindEvents();
                                    }
                                }
                            })
                            //cloudClinic.api.io(ajax,{
                            //    "hospitalGuid":hospitalGuid,
                            //    "diseaseName":_diseaseName,
                            //    "version":hmSugCon.sugPostVer
                            //},function(data){
                            //    if(data.head.error==0){
                            //        if(data.head.version && hmSugCon.sugReceiveVer > data.head.version) return false;
                            //        hmSugCon.sugReceiveVer = data.head.version;
                            //        addItemFeed(data, _diseaseName);
                            //        bindEvents();
                            //    }
                            //});
                        },100);
                    }
                    bindEvents();
                    $('.default').hide();
                    feed.show();
                }
                if(event.keyCode==38){//上移
                    if(curIndex>0){
                        curIndex=curIndex-1;
                        $('#feed').find('li').removeClass('auto-focus');
                        $('#feed').find('li').eq(curIndex).addClass('auto-focus');
                        if(curIndex<5){
                             $('#feed').scrollTop(0);
                        }
                    }
                }
                if(event.keyCode==40){//下移
                    if(curIndex<$('#feed').find('li').length-1){
                        curIndex=curIndex+1;
                        $('#feed').find('li').removeClass('auto-focus');
                        $('#feed').find('li').eq(curIndex).addClass('auto-focus');
                        //if(curIndex>5){
                        //    $('#feed').scrollTop(360);
                        //}
                    }
                }
                if(event.keyCode==13){//回车
                    if($('#feed').is(':visible')&&curIndex!=-1){
                        $('#feed').find('li').removeClass('auto-focus');
                        addItem($('#feed li').eq(curIndex));
                        curIndex=-1;
                        $('.maininput').focus();
                        $('#feed').hide().html('');
                    }
                }

            }else{
                if(event.keyCode==8){//删除
                    if(!etext&&$('#feed').is(':hidden')){
                        switch(deleteIndex){
                            case 1:$('.bit-box').last().css('background','#999');
                                    deleteIndex=2;
                                    break;
                            case 2:$('.bit-box').last().fadeOut('fast',function() {
                                        $(this).remove();
                                        setTimeout(function(){
                                            hmNewRecord._cdssSetDiagnosis && hmNewRecord._cdssSetDiagnosis();
                                        },300);
                                    });
                                    deleteIndex=1;
                                break;
                            default :break;
                        }
                    }
                }
                feed.hide();
                curIndex=0;
                $('#feed').scrollTop(0);
            }
	  });
    };
    var curIndex = 0;
    var hmSugCon = {
        sugPostVer:0,
        sugReceiveVer:0,
        sugKeyupTimeHwnd:null
    };
    if (typeof(elem) != 'object') elem = $(elem);
    if (typeof(list) != 'object') list = $(list);
    if (typeof(complete) != 'object') complete = $(complete);    
    var feed = $('#feed');
    feed.css({'max-height':(height*24)+'px', 'overflow':'auto'});
    var holder = document.createElement('ul');
    var deleteIndex = 1;
    elem.css('display','none');
    $(holder).attr('class', 'holder');           
    if (list && list.children('li').length) {
        $.each(list.children('li'), function(i, val) {
        	addItem($(list.children('li')[i]),1);
        });
    }
    addInput();
    elem.before(holder);
};