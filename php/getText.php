<?php
//处理语句
/*header("content-type=text/html;charset=utf-8");
//得到原描述
session_start();
$str = $_POST['dis_description'];
echo $str;echo"<br>";
*/

function getstr($str){
//*修改同义词
$str=str_replace('的','',$str);                //删去所有'的'
$str=str_replace('和','',$str);                //删去'和'
$str=str_replace('区','',$str);                //删去'区'
$str=str_replace('量','',$str);                //删去'量'
$str=str_replace('疼','痛',$str);              //疼->痛
$str=str_replace('轻微','轻度',$str);          //轻微->轻度


$str=str_replace('损害','损伤',$str);          //损害->损伤
$str=str_replace('受损','损伤',$str);          //受损->损伤
$str=str_replace('间断性','间歇性',$str);      //间断性->间歇性
$str=str_replace('间断','间歇性',$str);        //间断性->间歇性
$str=str_replace('疲倦','疲乏',$str);          //疲倦->疲乏
$str=str_replace('疲惫','疲乏',$str);          //疲惫->疲乏
$str=str_replace('流血','出血',$str);          //流血->出血
$str=str_replace('周身','全身',$str);          //周身->全身
$str=str_replace('浑身','全身',$str);          //浑身->全身
$str=str_replace('全身性','全身',$str);        //全身性->全身
$str=str_replace('全身症状','全身不适',$str);  //全身症状->全身不适
$str=str_replace('全身无力','全身乏力',$str);  //全身无力->全身乏力
$str=str_replace('显著','明显',$str);          //显著->明显
$str=str_replace('语言','言语',$str);          //语言->言语
$str=str_replace('精力','精神',$str);          //精力->精神
$str=str_replace('过分','过度',$str);          //过分->过度
$str=str_replace('行走','行动',$str);          //行走->行动
$str=str_replace('高烧','高热',$str);          //高烧->高热
$str=str_replace('发烧','发热',$str);          //发烧->发热
$str=str_replace('放射状','放射性',$str);      //放射状->放射性
$str=str_replace('发声','发音',$str);          //发声->发音
$str=str_replace('毒性反应','毒性症状',$str);  //毒性反应->毒性症状
$str=str_replace('饱胀感','饱胀不适',$str);    //饱胀感->饱胀不适
$str=str_replace('咳血','咯血',$str);          //咳血->咯血
$str=str_replace('颅内压增高','颅内高压',$str);//颅内压增高->颅内高压
$str=str_replace('进食','饮食',$str);          //进食->饮食
$str=str_replace('搔痒','瘙痒',$str);          //搔痒->瘙痒
$str=str_replace('灼烧','烧灼',$str);          //灼烧->烧灼
$str=str_replace('少许','少',$str);          //少许->少
$str=str_replace('重影','复视',$str);          //重影->复视
$str=str_replace('受寒','受凉',$str);          //受寒->受凉
$str=str_replace('视觉','视力',$str);          //视觉->视力
$str=str_replace('睡眠困难','入睡困难',$str);  //睡眠困难->入睡困难
$str=str_replace('体胖','肥胖',$str);          //体胖->肥胖
$str=str_replace('体重过轻','体重过低',$str);  //体重过轻->体重过低
$str=str_replace('体重过高','体重过重',$str);  //体重过高->体重过重
$str=str_replace('听觉','听力',$str);          //听觉->听力
$str=str_replace('不能弯腰','弯腰困难',$str);  //不能弯腰->弯腰困难
$str=str_replace('肠胃','胃肠',$str);          //肠胃->胃肠
$str=str_replace('怕光','畏光',$str);          //怕光->畏光
$str=str_replace('心跳','心率',$str);          //心跳->心率
$str=str_replace('血行缓慢','血流缓慢',$str);  //血行缓慢->血流缓慢
$str=str_replace('智能','智力',$str);          //智能->智力
$str=str_replace('神智','神志',$str);          //神智->神志
$str=str_replace('尿路刺激征','尿路刺激症状',$str); //尿路刺激征->尿路刺激症状
$str=str_replace('少腹水','腹水减少',$str);  //少腹水->腹水减少

$str=str_replace('难耐疼痛','剧痛',$str);  //难耐疼痛->剧痛
$str=str_replace('疼痛难耐','剧痛',$str);  //疼痛难耐->剧痛

$str=str_replace('心律失常','心律不齐',$str);  //心律失常->心律不齐
$str=str_replace('心率混乱','心律不齐',$str);  //心率混乱->心律不齐

$str=str_replace('消化道不适','消化道症状',$str);  //消化道不适->消化道症状
$str=str_replace('消化道反应','消化道症状',$str);  //消化道反应->消化道症状

$str=str_replace('肠不适','肠道症状',$str);  //肠不适->肠道症状
$str=str_replace('肠腔狭窄','肠狭窄',$str);  //肠腔狭窄->肠狭窄

$str=str_replace('晨起僵硬','晨僵',$str);  //晨起僵硬->晨僵

$str=str_replace('驰张热','弛张热',$str);  //驰张热->弛张热

$str=str_replace('昏厥','晕厥',$str);          //昏厥->晕厥
$str=str_replace('昏倒','晕厥',$str);          //昏倒->晕厥
$str=str_replace('头昏','头晕',$str);          //头昏->头晕
$str=str_replace('神昏','神志障碍',$str);      //神昏->神志障碍

$str=str_replace('多汗','汗多',$str);          //多汗->汗多

$str=str_replace('发音含糊不清','发音不清',$str);          //发音含糊不清->发音不清

$str=str_replace('痒','瘙痒',$str);          //痒->瘙痒

$str=str_replace('混浊','浑浊',$str);          //混浊->浑浊

$str=str_replace('淤斑','瘀斑',$str);          //淤斑->瘀斑

$str=str_replace('疼痛感','疼痛症状',$str);          //疼痛感->疼痛症状

$str=str_replace('突然','突发',$str);        //突然->突发

$str=str_replace('胃肠道不适','胃肠道症状',$str);        //胃肠道不适->胃肠道症状

$str=str_replace('血丝痰','血痰',$str);        //血丝痰->血痰
$str=str_replace('血痰','痰中带血',$str);        //血痰->痰中带血

//*保留简写
$str=str_replace('自发性','自发',$str);        //自发性->自发
$str=str_replace('继发性','继发',$str);        //继发性->继发
$str=str_replace('全身性','全身',$str);        //全身性->全身
$str=str_replace('先天性','先天',$str);        //先天性->先天
$str=str_replace('持续性','持续',$str);        //持续性->持续
$str=str_replace('暂时性','暂时',$str);        //暂时性->暂时
$str=str_replace('持久性','持久',$str);        //持久性->持久
$str=str_replace('出血性','出血',$str);        //出血性->出血
$str=str_replace('短暂性','短暂',$str);        //短暂性->短暂
$str=str_replace('反复性','反复',$str);        //反复性->反复
$str=str_replace('放射性','放射',$str);        //放射性->放射
$str=str_replace('过敏性','过敏',$str);        //过敏性->过敏
$str=str_replace('神经根性','神经根',$str);    //神经根性->神经根
$str=str_replace('突发性','突发',$str);        //突发性->突发


$str=str_replace('部症状','不适',$str);        //部症状->不适
$str=str_replace('部','',$str);        		   //若仍存在部，删去


$str=str_replace('肌肉','肌',$str);        	   //肌肉->肌
$str=str_replace('月经','经',$str);            //月经->经
$str=str_replace('剧烈','剧',$str);            //剧烈->剧
$str=str_replace('牙齿','牙',$str);            //牙齿->牙
$str=str_replace('眼睛','眼',$str);            //眼睛->眼
$str=str_replace('咽喉','咽',$str);            //咽喉->咽
$str=str_replace('鼻子','鼻',$str);            //鼻子->鼻
$str=str_replace('颈项','颈',$str);            //颈项->颈
$str=str_replace('按压','压',$str);            //按压->压
$str=str_replace('钝性','钝',$str);            //钝性->钝
$str=str_replace('流鼻涕','流涕',$str);        //流鼻涕->流涕
$str=str_replace('声音嘶哑','声嘶',$str);      //声音嘶哑->声嘶
$str=str_replace('痰中带血','痰血',$str);      //痰中带血->痰血
$str=str_replace('呼吸功能','呼吸',$str);      //呼吸功能->呼吸
$str=str_replace('腐败臭味','腐臭味',$str);    //腐败臭味->腐臭味
$str=str_replace('压迫性疼痛','压痛',$str);    //压迫疼痛->压痛
$str=str_replace('按压痛','压痛',$str);        //按压痛->压痛
$str=str_replace('皮肤破损','皮损',$str);      //皮肤破损->皮损
$str=str_replace('记忆力','记忆',$str);        //记忆力->记忆
$str=str_replace('干性咳嗽','干咳',$str);      //干性咳嗽->干咳
$str=str_replace('声音低沉','声低',$str);      //声音低沉->声低

$str=str_replace('面色苍白','面色白',$str);    //面色苍白->面色白
$str=str_replace('面色发黄','面色黄',$str);    //面色发黄->面色黄
$str=str_replace('面部瘫痪','面瘫',$str);      //面部瘫痪->面瘫

$str=str_replace('鼻阻塞','鼻塞',$str);        //鼻祖塞->鼻塞
$str=str_replace('鼻子不通气','鼻塞',$str);    //鼻子不通气->鼻塞

$str=str_replace('胀满','胀',$str);        	   //胀满->胀
$str=str_replace('肿胀','肿',$str);        	   //肿胀->肿

//*增长、增加-->增多
$str=str_replace('增长','增多',$str);          //增长->增多
$str=str_replace('增加','增多',$str);          //增加->增多

//*下降等
$str=str_replace('已减退','减退',$str);        //已减退->减退
$str=str_replace('减退','下降',$str);          //减退->下降
$str=str_replace('降低','下降',$str);          //降低->下降
$str=str_replace('减少','下降',$str);          //减少->下降
$str=str_replace('低下','下降',$str);          //低下->下降

$str=str_replace('较差','差',$str);            //较差->差
$str=str_replace('欠佳','不佳',$str);          //欠佳->不佳

//精神下降
$str=str_replace('精神不济','精神下降',$str);          //精神不济->精神下降
$str=str_replace('精神不适','精神下降',$str);          //精神不适->精神下降
$str=str_replace('精神不振','精神下降',$str);          //精神不振->精神下降
$str=str_replace('精神差','精神下降',$str);          //精神差->精神下降
$str=str_replace('精神衰退','精神下降',$str);          //精神衰退->精神下降
$str=str_replace('精神委顿','精神下降',$str);          //精神委顿->精神下降
$str=str_replace('精神萎靡','精神下降',$str);          //精神萎靡->精神下降
$str=str_replace('精神不佳','精神下降',$str);          //精神不佳->精神下降

//记忆下降
$str=str_replace('记忆丧失','记忆下降',$str);          //记忆丧失->记忆下降
$str=str_replace('记忆改变','记忆下降',$str);          //记忆改变->记忆下降
$str=str_replace('记忆障碍','记忆下降',$str);          //记忆障碍->记忆下降

//肺功能下降
$str=str_replace('肺功能障碍','肺功能下降',$str);          //肺功能障碍->肺功能下降
$str=str_replace('肺功能不全','肺功能下降',$str);          //肺功能不全->肺功能下降
$str=str_replace('肺功能削弱','肺功能下降',$str);          //肺功能削弱->肺功能下降

//肾功能下降
$str=str_replace('肾功能障碍','肾功能下降',$str);          //肾功能障碍->肾功能下降
$str=str_replace('肾功能恶化','肾功能下降',$str);          //肾功能恶化->肾功能下降
$str=str_replace('肾功能衰竭','肾功能下降',$str);          //肾功能衰竭->肾功能下降
$str=str_replace('肾功能异常','肾功能下降',$str);          //肾功能异常->肾功能下降

//视力下降
$str=str_replace('视力差','视力下降',$str);          //视力差->视力下降

//粒细胞
$str=str_replace('粒细胞缺乏','粒细胞下降',$str);          //粒细胞缺乏->粒细胞下降

//氧化物
$str=str_replace('氧化物差','氧化物下降',$str);          //氧化物差->氧化物下降

//食欲
$str=str_replace('食欲差','食欲下降',$str);          //食欲差->食欲下降
$str=str_replace('食欲异常','食欲下降',$str);          //食欲异常->食欲下降
$str=str_replace('食欲缺乏','食欲下降',$str);          //食欲缺乏->食欲下降
$str=str_replace('食欲不佳','食欲下降',$str);          //食欲不佳->食欲下降
$str=str_replace('食欲下降','食欲不振',$str);          //食欲下降->食欲不振

//体重
$str=str_replace('体重减轻','体重下降',$str);          //体重减轻->体重下降

//胃纳差
$str=str_replace('胃纳下降','胃纳差',$str);          //胃纳下降->胃纳差
$str=str_replace('胃纳不佳','胃纳差',$str);          //胃纳不佳->胃纳差

//体力
$str=str_replace('体力差','体力下降',$str);          //体力差->体力下降
$str=str_replace('体力不支','体力下降',$str);          //体力不支->体力下降
$str=str_replace('体力匮乏','体力下降',$str);          //体力匮乏->体力下降
$str=str_replace('体力衰弱','体力下降',$str);          //体力衰弱->体力下降

//睡眠
$str=str_replace('睡眠下降','睡眠不佳',$str);          //睡眠下降->睡眠不佳
$str=str_replace('睡眠易醒','睡眠不佳',$str);          //睡眠易醒->睡眠不佳
$str=str_replace('睡眠不安','睡眠不佳',$str);          //睡眠不安->睡眠不佳
$str=str_replace('睡眠质下降','睡眠不佳',$str);      //睡眠质下降->睡眠不佳

//反应
$str=str_replace('反应差','反应迟钝',$str);          //反应差->反应迟钝

//补充
$str=str_replace('便血下降','便血减少',$str);        //便血下降->便血减少
$str=str_replace('言语下降','言语减少',$str);        //言语下降->言语减少
$str=str_replace('饮食下降','饮食减少',$str);        //饮食下降->饮食减少

//*障碍等
$str=str_replace('受限','困难',$str);          //受限->困难
$str=str_replace('不利','困难',$str);          //不利->困难
$str=str_replace('不便','困难',$str);          //不便->困难
$str=str_replace('问题','障碍',$str);          //问题->障碍
$str=str_replace('不畅','困难',$str);          //不畅->困难
$str=str_replace('费力','困难',$str);          //费力->困难

//进食困难
$str=str_replace('进食障碍','进食困难',$str);          //进食障碍->进食困难

//呼吸困难
$str=str_replace('呼吸障碍','呼吸困难',$str);          //呼吸障碍->呼吸困难
$str=str_replace('呼吸费力','呼吸困难',$str);          //呼吸费力->呼吸困难

//活动困难
$str=str_replace('活动障碍','活动困难',$str);          //活动障碍->活动困难

//构音困难
$str=str_replace('构音障碍','构音困难',$str);          //构音障碍->构音困难
$str=str_replace('构音不清','构音困难',$str);          //构音不清->构音困难

//言语不清
$str=str_replace('言语困难','言语不清',$str);          //言语困难->言语不清
$str=str_replace('言语含糊','言语不清',$str);          //言语含糊->言语不清

//发音困难
$str=str_replace('发音障碍','发音困难',$str);          //发音障碍->发音困难

//意识障碍
$str=str_replace('意识模糊','意识障碍',$str);          //意识模糊->意识障碍

//定向障碍
$str=str_replace('定向困难','定向障碍',$str);          //定向困难->定向障碍

//联想困难
$str=str_replace('联想障碍','联想困难',$str);          //联想障碍->联想困难

//吞咽困难
$str=str_replace('吞咽不适','吞咽困难',$str);          //吞咽不适->吞咽困难

//心理障碍
$str=str_replace('心理症状','心理障碍',$str);          //心理症状->心理障碍

//神志障碍
$str=str_replace('神志不清','神志障碍',$str);          //神志不清->神志障碍
$str=str_replace('神志异常','神志障碍',$str);          //神志异常->神志障碍

//咀嚼无力
$str=str_replace('咀嚼困难','咀嚼无力',$str);          //咀嚼困难->咀嚼无力


//*尿便
$str=str_replace('小便','尿',$str);                    //小便->尿
$str=str_replace('排尿','尿',$str);                    //排尿->尿
$str=str_replace('排便','便',$str);                    //排便->便
$str=str_replace('大便','便',$str);                    //大便->便
$str=str_replace('大尿','大小便',$str);                //大尿->大小便
$str=str_replace('尿便','大小便',$str);                //尿便->大小便

//大小便
$str=str_replace('大小便失控','大小便失禁',$str);          //大小便失控->大小便失禁
$str=str_replace('大小便不能自理','大小便困难',$str);          //大小便不能自理->大小便困难
$str=str_replace('大小便功能障碍','大小便困难',$str);          //大小便功能障碍->大小便困难
$str=str_replace('大小便障碍','大小便困难',$str);          //大小便障碍->大小便困难

//便秘
$str=str_replace('便不适','便秘',$str);          //便不适->便秘
$str=str_replace('便障碍','便秘',$str);          //便障碍->便秘
$str=str_replace('便困难','便秘',$str);          //便困难->便秘
$str=str_replace('便秘结','便秘',$str);          //便秘结->便秘
$str=str_replace('便不通','便秘',$str);          //便不通->便秘
$str=str_replace('便不爽','便秘',$str);          //便不爽->便秘
$str=str_replace('便困难','便秘',$str);          //便困难->便秘
$str=str_replace('便排出困难','便秘',$str);      //便排出困难->便秘

//尿困难
$str=str_replace('尿障碍','尿困难',$str);        //尿障碍->尿困难
$str=str_replace('尿不适','尿困难',$str);        //尿不适->尿困难
$str=str_replace('尿异常','尿困难',$str);        //尿异常->尿困难
$str=str_replace('尿不通','尿困难',$str);        //尿不通->尿困难

//关节活动
$str=str_replace('关节活动受限','关节活动困难',$str);        //关节活动受限->关节活动困难
$str=str_replace('关节活动不灵活','关节活动困难',$str);        //关节活动不灵活->关节活动困难

//*多少
//*痰
$str=str_replace('多痰','痰多',$str);            //多痰->痰多
$str=str_replace('痰少','少痰',$str);            //痰少->少痰

//食少
$str=str_replace('进食','食',$str);              //进食->食
$str=str_replace('食减少','食少',$str);          //食减少->食少
//多食
$str=str_replace('食多','多食',$str);            //食多->多食
$str=str_replace('食增多','多食',$str);          //食增多->多食

//白带增多
$str=str_replace('白带多','白带增多',$str);            //白带多->白带增多

//汗少
$str=str_replace('汗量','汗',$str);              //汗量->汗
$str=str_replace('多汗','汗多',$str);            //多汗->汗多
$str=str_replace('汗增多','汗多',$str);          //汗增多->汗多
//汗少
$str=str_replace('汗减少','汗少',$str);          //汗减少->汗少
$str=str_replace('少汗','汗少',$str);            //少汗->汗少

$str=str_replace('出血增多','出血多',$str);          //出血增多->出血多

$str=str_replace('尿增多','尿多',$str);          //尿增多->尿多
$str=str_replace('多尿','尿多',$str);            //多尿->尿多
$str=str_replace('少尿','尿少',$str);            //少尿->尿少
$str=str_replace('尿减少','尿少',$str);          //尿减少->尿少

$str=str_replace('经过多','经多',$str);            //经过多->经多
$str=str_replace('经稍多','经多',$str);            //经稍多->经多

$str=str_replace('腹泻频繁','频繁腹泻',$str);            //腹泻频繁->频繁腹泻

$str=str_replace('寒颤','寒战',$str);            //寒颤->寒战

$str=str_replace('高原反应','高山反应',$str);            //高原反应->高山反应

$str=str_replace('呼吸加速','呼吸加快',$str);            //呼吸加速->呼吸加快

$str=str_replace('患痛','患处痛',$str);                  //患痛->患处痛

$str=str_replace('胃肠道不良反应','胃肠道症状',$str);    //胃肠道不良反应->胃肠道症状

$str=str_replace('烦渴','心烦口渴',$str);    //烦渴->心烦口渴

//echo"<br>";echo "修改后疾病描述   ".$str;echo"<br>";
return $str;
}

function getarr($array){
	$oldones=array('感染','出血','过敏','黄疸','紧张','精神病','痉挛','剧痛-','粘液','喷嚏','特异性','炎症','中毒');
	$replace=array('感染症状','出血症状','过敏反应','黄疸症状','紧张不安','精神病症状','痉挛症状','剧烈疼痛','粘液产生','打喷嚏','特异性症状','炎症症状','中毒症状');
	$abc=$array;
		for($i=0;$i<count($abc);$i++){
			//echo $abc[$i];
		    //echo $val;
			if(in_array($abc[$i],$oldones)){
				$j=array_search($abc[$i],$oldones);
				$abc[$i]=$replace[$j];
			}
		}	
	return $abc;
}
	


//main

//$array=array('ccc','烦渴','aaa','感染','出血','ttt','过敏','黄疸','紧张','精神病','痉挛','啦啦啦','剧痛-','粘液','喷嚏','特异性','炎症','中毒');
//$array=array('烦渴','过敏'); 
//$abc=getarr($array);
//echo "<pre>";
//print_r($abc);

?>