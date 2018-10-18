<script type="text" class="tmpl">
        {{ for(var n=0;n<it.prescriptionList.length;n++){ }}
        {{ var pitem=it.prescriptionList[n]; }}
        <div class="prescription-cont j_prescription_cont {{=it.inchrome?'prescr-inchrome':''}} {{=(!it.treatmentList.length && n==it.prescriptionList.length-1)?"":"prescr-break"}}">
        <div class="prescription-box">
            <table class="prescr-table"><tbody>
            {{ if(pitem.prescrType==1){ }}
            <tr><td class="prescr-top-type"></td><td class="prescr-top-text">底方</td></tr>
            {{ }else{ }}
            <tr><td class="prescr-top-type">处方类型：草药</td><td class="prescr-top-text">底方</td></tr>
            {{ } }}
            </tbody></table>
            <table class="prescr-table"><tbody>
            <tr>
                <td class="prescr-tit-text"></td>
                <td class="prescr-tit-title">{{=it.invoiceLookedUp||''}}处方</td>
                <td class="prescr-tit-text">门诊</td>
            </tr>
            </tbody></table>
            <table class="prescr-table"><tbody>
            <tr>
                <td class="prescr-info-record">病历号：{{=it.recordId}}</td>
                <td class="prescr-info-date">就诊日期：{{=it.diagnosisDate}}</td>
            </tr>
            </tbody></table>
            <table class="prescr-table"><tbody>
            <tr>
                <td class="prescr-info-name">姓名：{{=it.patientName}}</td>
                <td class="prescr-info-gender">性别：{{=it.gender}}</td>
                <td class="prescr-info-age">年龄：{{=it.age+it.ageType}}</td>
                <td class="prescr-info-depart">科室：{{=it.laboratoryName}}</td>
            </tr>
            </tbody></table>
            <span class="prescr-hr"></span>
            <table class="prescr-table"><tbody>
            <tr>
                {{ if(pitem.prescrType==1){ }}
                <td class="prescr-body-lcase">诊断：{{=it.diagnosis||""}}</td>
                {{ }else{ }}
                <td class="prescr-body-scase">诊断：{{=it.diagnosis||""}}</td>
                <td class="prescr-body-tdosage">剂数：{{=pitem.totalDosage}}剂</td>
                {{ } }}
            </tr>
            </tbody></table>
            <p class="prescr-body-rp">RP</p>
            {{ if(pitem.prescrType==1){ }}
            <div class="prescr-list-wrap">
            <table class="prescr-table"><tbody>
            <tr>
                <td class="prescr-list-name prescr-list-th">药品名称</td>
                <td class="prescr-list-specif prescr-list-th">规格</td>
                <td class="prescr-list-frequ prescr-list-th">频率</td>
                <td class="prescr-list-dosage prescr-list-th">单次剂量</td>
                <td class="prescr-list-usage prescr-list-th">用法</td>
                <td class="prescr-list-tdosage prescr-list-th">数量</td>
                <td class="prescr-list-unival prescr-list-th">{{=it.showPrice ? '单价' : ''}}</td>
            </tr>
            {{ for(var i=0, mark=0;i<pitem.drugList.length;i++){ }}
            {{ var _assId = pitem.drugList[i].assId; }}
            {{ if(mark != _assId && (mark = _assId)){ }}
            <tr>
                <td class="prescr-list-group {{=( i ==0 && _assId !=0 )?"normal":""}}" colspan="7">分组{{=_assId + ((i ==0 && pitem.sameAss ==true)?"(续)":"")}}：</td>
            </tr>
            {{ } }}
            <tr>
                <td class="prescr-list-name">{{=pitem.drugList[i].drugName||''}}</td>
                <td class="prescr-list-specif">{{=pitem.drugList[i].specification||''}}</td>
                <td class="prescr-list-frequ">{{=pitem.drugList[i].frequency && pitem.drugList[i].frequency.replace(/\(\w+\)|（\w+）/,'') ||''}}</td>
                <td class="prescr-list-dosage">{{=pitem.drugList[i].onceDosage &&(pitem.drugList[i].onceDosage+pitem.drugList[i].onceDosageUnit)||''}}</td>
                <td class="prescr-list-usage">{{=pitem.drugList[i].usage||''}}</td>
                <td class="prescr-list-tdosage">{{=pitem.drugList[i].totalDosage||''}}</td>
                <td class="prescr-list-unival">{{=it.showPrice ? (pitem.drugList[i].univalence||'') : ''}}</td>
            </tr>
            {{ } }}
            </tbody></table>
            </div>
            {{ }else{ }}
            <p class="prescr-herbal-wrap">
                {{ for(var i=0;i<pitem.drugList.length;i++){ }}
                <span class="prescr-herbal-item">{{=pitem.drugList[i].drugName+'，'+pitem.drugList[i].value+pitem.drugList[i].unit+(pitem.drugList[i].remark&&('，'+pitem.drugList[i].remark||''))}}</span>
                {{ } }}
            </p>
            {{ } }}
            <span class="prescr-hr"></span>
            {{ if(pitem.prescrType==2){ }}
            <table class="prescr-table"><tbody>
            <tr>
                <td class="prescr-herbal-frequ">用量：{{=pitem.herbDailyDosage||''}}</td>
                <td class="prescr-herbal-usage">用法：{{=pitem.herbUsage||''}}</td>
            </tr>
            </tbody></table>
            {{ } }}
            <table class="prescr-table"><tbody>
            <tr>
                <td class="prescr-check-review">审核/调配：</td>
                <td class="prescr-check-charge">核对/发药：</td>
                <td class="prescr-check-doctor">医师：{{=it.showDoctor ? it.doctorName : ''}}</td>
                {{ if(it.showTotal){ }}
                <td class="prescr-check-ptext">药品金额：</td>
                <td class="prescr-check-price">{{=pitem.prescrPrice}}&nbsp;元</td>
                {{ }else{ }}
                <td class="prescr-check-time-s" colspan="2">打印时间：{{=pitem.printTime}}</td>
                {{ } }}
            </tr>
            </tbody></table>
            <table class="prescr-table"><tbody>
            <tr>
                <td class="prescr-check-friend">提示：此处方有效期为三天，请遵医嘱服药</td>
                {{ if(it.showTotal){ }}
                <td class="prescr-check-time">打印时间：{{=pitem.printTime}}</td>
                {{ } }}
            </tr>
            </tbody></table>
        </div>
        </div>
        {{ } }}
        {{ for(n=0;n<it.treatmentList.length;n++){ }}
        {{ var tItem=it.treatmentList[n]; }}
        <div class="prescription-cont j_prescription_cont {{=it.inchrome?'prescr-inchrome':''}} {{=(n==it.treatmentList.length-1)?'':'prescr-break'}}">
            <div class="examination-box">
                <table class="prescr-table"><tbody>
                <tr>
                    <td class="prescr-tit-text"></td>
                    <td class="prescr-tit-title">{{=it.invoiceLookedUp||''}}诊疗费用单</td>
                    <td class="prescr-tit-text">门诊</td>
                </tr>
                </tbody></table>
                <table class="prescr-table"><tbody>
                <tr>
                    <td class="prescr-info-record" colspan="2">病历号：{{=it.recordId}}</td>
                    <td class="prescr-info-date" colspan="2">就诊日期：{{=it.diagnosisDate}}</td>
                </tr>
                <tr>
                    <td class="prescr-info-name">姓名：{{=it.patientName}}</td>
                    <td class="prescr-info-gender">性别：{{=it.gender}}</td>
                    <td class="prescr-info-age">年龄：{{=it.age+it.ageType}}</td>
                    <td class="prescr-info-depart">科室：{{=it.laboratoryName}}</td>
                </tr>
                </tbody></table>
                <table class="prescr-table"><tbody>
                <tr>
                    <td class="prescr-info-lcase">诊断：{{=it.diagnosis||""}}</td>
                </tr>
                </tbody></table>
                <span class="prescr-hr"></span>
                <div class="prescr-exam-wrap">
                    {{ if(tItem.examList.length){ }}
                    <p class="prescr-exam-title">费别：检查治疗项</p>
                    <span class="prescr-exam-hr"></span>
                    <table class="prescr-exam-type">
                        <colgroup>
                            <col width="22%">
                            <col width="7.2%">
                            <col width="15.2%">
                            <col width="11.2%">
                            <col width="22%">
                            <col width="7.2%">
                            <col width="15.2%">
                        </colgroup>
                        <tbody>
                        {{ for(var j=0;j<tItem.examList.length;j++){ }}
                        {{ var examItem = tItem.examList[j]; }}
                        <tr>
                            <td>{{=examItem.examName}}</td><td>{{=examItem.examNum}}次</td>
                            <td>{{=it.showPrice ?'单价：'+examItem.examPrice+'元':''}}</td><td></td>
                            <td>{{=examItem.hasSecondItem ? examItem.examName_2 :''}}</td>
                            <td>{{=examItem.hasSecondItem ? examItem.examNum_2+'次' :''}}</td>
                            <td>{{=(examItem.hasSecondItem && it.showPrice)? '单价：'+examItem.examPrice_2+'元' :''}}</td>
                        </tr>
                        {{ } }}
                        </tbody>
                    </table>
                    {{ } }}
                    {{ if(tItem.additnList.length){ }}
                    <p class="prescr-exam-title {{=tItem.hasSecond ? 'prescr-exam-blank' : '' }}">费别：附加费用</p>
                    <span class="prescr-exam-hr"></span>
                    <table class="prescr-additn-type">
                        <colgroup>
                            <col width="22%">
                            <col width="22.4%">
                            <col width="11.2%">
                            <col width="22%">
                            <col width="22.4%">
                        </colgroup>
                        <tbody>
                        {{ for(var j=0;j<tItem.additnList.length;j++){ }}
                        {{ var additnItem = tItem.additnList[j]; }}
                        <tr>
                            <td>{{=additnItem.additnName}}</td><td>{{=it.showPrice?'金额：'+additnItem.additnPrice+'元':''}}</td><td></td>
                            <td>{{=additnItem.hasSecondItem ?additnItem.additnName_2 :''}}</td>
                            <td>{{=(additnItem.hasSecondItem && it.showPrice)? '金额：'+additnItem.additnPrice_2+'元' :''}}</td>
                        </tr>
                        {{ } }}
                        </tbody>
                    </table>
                    {{ } }}
                </div>
                <span class="prescr-hr"></span>
                <table class="prescr-table"><tbody>
                <tr>
                    <td class="prescr-check-charge type-exam">收费：</td>
                    <td class="prescr-check-doctor">医师：{{=it.showDoctor ? it.doctorName : ''}}</td>
                    {{ if(it.showTotal){ }}
                    <td class="prescr-check-ptext">合计金额：</td>
                    <td class="prescr-check-price">{{=tItem.prescrPrice}}&nbsp;元</td>
                    {{ }else{ }}
                    <td class="prescr-check-time-s type-exam" colspan="2">打印时间：{{=tItem.printTime}}</td>
                    {{ } }}
                </tr>
                {{ if(it.showTotal){ }}
                <tr>
                    <td class="prescr-check-time type-exam" colspan="4">打印时间：{{=tItem.printTime}}</td>
                </tr>
                {{ } }}
                </tbody></table>
            </div>
        </div>
        {{ } }}
</script>
    <script type="text" class="tmplv">
        {{ for(var n=0;n<it.prescriptionList.length;n++){ }}
        {{ var pitem=it.prescriptionList[n]; }}
        <div class="prescription-v-cont j_prescription_cont {{=it.inchrome?'prescr-inchrome':''}} {{=(!it.treatmentList.length && n==it.prescriptionList.length-1)?"":"prescr-break"}}">
        <div class="prescription-v-box">
            <table class="prescr-v-table"><tbody>
            {{ if(pitem.prescrType==1){ }}
            <tr><td class="prescr-v-top-type"></td><td class="prescr-v-top-text">底方</td></tr>
            {{ }else{ }}
            <tr><td class="prescr-v-top-type">处方类型：草药</td><td class="prescr-v-top-text">底方</td></tr>
            {{ } }}
            </tbody></table>
            <table class="prescr-v-table"><tbody>
            <tr>
                <td class="prescr-v-tit-text"></td>
                <td class="prescr-v-tit-title">{{=it.invoiceLookedUp||''}}处方</td>
                <td class="prescr-v-tit-text">门诊</td>
            </tr>
            </tbody></table>
            <table class="prescr-v-table"><tbody>
            <tr>
                <td class="prescr-v-info-record">病历号：{{=it.recordId}}</td>
                <td class="prescr-v-info-depart">科室：{{=it.laboratoryName}}</td>
                <td class="prescr-v-info-date">就诊日期：{{=it.diagnosisDate}}</td>
            </tr>
            </tbody></table>
            <table class="prescr-v-table"><tbody>
            <tr>
                <td class="prescr-v-info-name">姓名：{{=it.patientName}}</td>
                <td class="prescr-v-info-gender">性别：{{=it.gender}}</td>
                <td class="prescr-v-info-age">年龄：{{=it.age+it.ageType}}</td>
            </tr>
            </tbody></table>
            <span class="prescr-v-hr"></span>
            <table class="prescr-v-table"><tbody>
            <tr>
                {{ if(pitem.prescrType==1){ }}
                <td class="prescr-v-body-lcase">诊断：{{=it.diagnosis||""}}</td>
                {{ }else{ }}
                <td class="prescr-v-body-scase">诊断：{{=it.diagnosis||""}}</td>
                <td class="prescr-v-body-tdosage">剂数：{{=pitem.totalDosage}}剂</td>
                {{ } }}
            </tr>
            </tbody></table>
            <p class="prescr-v-body-rp">RP</p>
            {{ if(pitem.prescrType==1){ }}
            <div class="prescr-v-list-wrap">
                <table class="prescr-v-table"><tbody>
                <tr>
                    <td class="prescr-v-list-name prescr-list-th">药品</td>
                    <td class="prescr-v-list-frequ prescr-list-th">频率</td>
                    <td class="prescr-v-list-dosage prescr-list-th">单次剂量</td>
                    <td class="prescr-v-list-usage prescr-list-th">用法</td>
                    <td class="prescr-v-list-tdosage prescr-list-th">数量</td>
                    <td class="prescr-v-list-unival prescr-list-th">{{=it.showPrice ? '单价' : ''}}</td>
                </tr>
                {{ for(var i=0, mark=0;i<pitem.drugList.length;i++){ }}
                {{ var _assId = pitem.drugList[i].assId; }}
                {{ if(mark != _assId && (mark = _assId)){ }}
                <tr>
                    <td class="prescr-v-list-group {{=( i ==0 && _assId !=0 )?"normal":""}}" colspan="7">分组{{=_assId + ((i ==0 && pitem.sameAss ==true)?"(续)":"")}}：</td>
                </tr>
                {{ } }}
                <tr>
                    <td class="prescr-v-list-name">{{=pitem.drugList[i].drugName||''}}({{=pitem.drugList[i].specification||''}})</td>
                    <td class="prescr-v-list-frequ">{{=pitem.drugList[i].frequency && pitem.drugList[i].frequency.replace(/\(\w+\)|（\w+）/,'') ||''}}</td>
                    <td class="prescr-v-list-dosage">{{=pitem.drugList[i].onceDosage &&(pitem.drugList[i].onceDosage+pitem.drugList[i].onceDosageUnit)||''}}</td>
                    <td class="prescr-v-list-usage">{{=pitem.drugList[i].usage||''}}</td>
                    <td class="prescr-v-list-tdosage">{{=pitem.drugList[i].totalDosage||''}}</td>
                    <td class="prescr-v-list-unival">{{=it.showPrice ? (pitem.drugList[i].univalence||'') : ''}}</td>
                </tr>
                {{ } }}
                </tbody></table>
            </div>
            {{ }else{ }}
            <p class="prescr-v-herbal-wrap">
                {{ for(var i=0;i<pitem.drugList.length;i++){ }}
                <span class="prescr-v-herbal-item">{{=pitem.drugList[i].drugName+'，'+pitem.drugList[i].value+pitem.drugList[i].unit+(pitem.drugList[i].remark&&('，'+pitem.drugList[i].remark||''))}}</span>
                {{ } }}
            </p>
            {{ } }}
            {{ if(pitem.prescrType==2){ }}
            <table class="prescr-v-table"><tbody>
            <tr>
                <td class="prescr-v-herbal-frequ">用量：{{=pitem.herbDailyDosage||''}}</td>
            </tr>
            <tr>
                <td class="prescr-v-herbal-usage">用法：{{=pitem.herbUsage||''}}</td>
            </tr>
            </tbody></table>
            {{ } }}
            <span class="prescr-v-hr"></span>
            <table class="prescr-v-table"><tbody>
            <tr>
                <td class="prescr-v-check-review">审核/调配：</td>
                <td class="prescr-v-check-charge">核对/发药：</td>
                <td class="prescr-v-check-doctor">医师：{{=it.showDoctor ? it.doctorName : ''}}</td>
            </tr>
            <tr>
                {{ if(it.showTotal){ }}
                <td class="prescr-v-check-ptext">药品金额：{{=pitem.prescrPrice}}&nbsp;元</td>
                <td class="prescr-v-check-time" colspan="2">打印时间：{{=pitem.printTime}}</td>
                {{ }else{ }}
                <td class="prescr-v-check-time-s" colspan="3">打印时间：{{=pitem.printTime}}</td>
                {{ } }}
            <tr>
            </tbody></table>
            <table class="prescr-v-table"><tbody>
            <tr>
                <td class="prescr-v-check-friend">提示：此处方有效期为三天，请遵医嘱服药</td>
            </tr>
            </tbody></table>
        </div>
    </div>
    {{ } }}
    {{ for(n=0;n<it.treatmentList.length;n++){ }}
    {{ var tItem=it.treatmentList[n]; }}
    <div class="prescription-v-cont j_prescription_cont {{=it.inchrome?'prescr-inchrome':''}} {{=(n==it.treatmentList.length-1)?'':'prescr-break'}}">
        <div class="examination-v-box">
            <table class="prescr-v-table"><tbody>
            <tr>
                <td class="prescr-v-tit-text"></td>
                <td class="prescr-v-tit-title">{{=it.invoiceLookedUp||''}}诊疗费用单</td>
                <td class="prescr-v-tit-text">门诊</td>
            </tr>
            </tbody></table>
            <table class="prescr-v-table"><tbody>
            <tr>
                <td class="prescr-v-info-record">病历号：{{=it.recordId}}</td>
                <td class="prescr-v-info-depart">科室：{{=it.laboratoryName}}</td>
                <td class="prescr-v-info-date">就诊日期：{{=it.diagnosisDate}}</td>
            </tr>
            <tr>
                <td class="prescr-v-info-name">姓名：{{=it.patientName}}</td>
                <td class="prescr-v-info-gender">性别：{{=it.gender}}</td>
                <td class="prescr-v-info-age">年龄：{{=it.age+it.ageType}}</td>
            </tr>
            </tbody></table>
            <table class="prescr-v-table"><tbody>
            <tr>
                <td class="prescr-v-info-lcase">诊断：{{=it.diagnosis||""}}</td>
            </tr>
            </tbody></table>
            <span class="prescr-v-hr"></span>
            <div class="prescr-v-exam-wrap">
                {{ if(tItem.examList.length){ }}
                <p class="prescr-v-exam-title">费别：检查治疗项</p>
                <span class="prescr-v-exam-hr"></span>
                <table class="prescr-v-exam-type">
                    <colgroup>
                        <col width="57%">
                        <col width="1.5%">
                        <col width="14%">
                        <col width="1.5%">
                        <col width="26%">
                    </colgroup>
                    <tbody>
                    {{ for(var j=0;j<tItem.examList.length;j++){ }}
                    {{ var examItem = tItem.examList[j]; }}
                    <tr>
                        <td>{{=examItem.examName}}</td>
                        <td></td><td>{{=examItem.examNum}}次</td>
                        <td></td><td class="prescr-v-text-right">{{=it.showPrice?'单价：'+examItem.examPrice+'元':''}}</td>
                    </tr>
                    {{ if(examItem.hasSecondItem){ }}
                    <tr>
                        <td>{{=examItem.examName_2}}</td>
                        <td></td><td>{{=examItem.examNum_2}}次</td>
                        <td></td><td class="prescr-v-text-right">{{=it.showPrice?'单价：'+examItem.examPrice_2+'元':''}}</td><td></td>
                    </tr>
                    {{ } }}
                    {{ } }}
                    </tbody>
                </table>
                {{ } }}
                {{ if(tItem.additnList.length){ }}
                <p class="prescr-v-exam-title {{=tItem.hasSecond ? 'prescr-exam-blank' : '' }}">费别：附加费用</p>
                <span class="prescr-v-exam-hr"></span>
                <table class="prescr-v-additn-type">
                    <colgroup>
                        <col width="72.5%">
                        <col width="1.5%">
                        <col width="26%">
                    </colgroup>
                    <tbody>
                    {{ for(var j=0;j<tItem.additnList.length;j++){ }}
                    {{ var additnItem = tItem.additnList[j]; }}
                    <tr>
                        <td>{{=additnItem.additnName}}</td><td></td><td class="prescr-v-text-right">{{=it.showPrice?'金额：'+additnItem.additnPrice+'元':''}}</td>
                    </tr>
                    {{ if(additnItem.hasSecondItem){ }}
                    <tr>
                        <td>{{=additnItem.additnName_2}}</td><td></td><td class="prescr-v-text-right">{{=it.showPrice?'金额：'+additnItem.additnPrice_2+'元':''}}</td>
                    </tr>
                    {{ } }}
                    {{ } }}
                    </tbody>
                </table>
                {{ } }}
            </div>
            <span class="prescr-v-hr"></span>
            <table class="prescr-v-table"><tbody>
            <tr>
                <td class="prescr-v-check-charge type-exam">收费：</td>
                <td class="prescr-v-check-doctor">医师：{{=it.showDoctor ? it.doctorName : ''}}</td>
                {{ if(it.showTotal){ }}
                <td class="prescr-v-check-ptext">合计金额：{{=tItem.prescrPrice}}&nbsp;元</td>
                {{ }else{ }}
                <td class="prescr-v-check-ptext">打印时间：{{=tItem.printTime}}</td>
                {{ } }}
            </tr>
            {{ if(it.showTotal){ }}
            <tr>
                <td class="prescr-v-check-time type-exam" colspan="3">打印时间：{{=tItem.printTime}}</td>
            </tr>
            {{ } }}
            </tbody></table>
        </div>
    </div>
    {{ } }}
    </script>
    <script type="text" class="temp">
        {{ var i=0,j=0,mark=0; }}
        <li class="precord-line precord-inline">
            <div class="precord-note precord-symptom">
                <span class="precord-note-symptom" style="line-height:5.4mm;">主诉／现病史：{{=it.symptom}}</span>
            <div>
        </li>
        <li class="precord-line precord-inline">
            <div class="precord-note">
                <span class="precord-note-info" style="line-height:5.4mm;">既往史：{{=it.previousHistory}}</span>
                <span class="precord-note-info" style="line-height:5.4mm;">个人史：{{=it.personalHistory}}</span>
                <span class="precord-note-info" style="line-height:5.4mm;">过敏史：{{=it.allergyHistory}}</span>
                <span class="precord-note-info" style="line-height:5.4mm;">家族史：{{=it.familyHistory}}</span>
            <div>
        </li>
        <li class="precord-line precord-inline">
            <p class="precord-note precord-note-other" style="line-height:5.4mm;">体格检查：</p>
            <p class="precord-note precord-other-box" style="line-height:5.4mm;">
                {{ if(it.temperature){ }}<span class="other-item">体温：{{=it.temperature}} ℃</span>{{ } }}
                {{ if(it.weight){ }}<span class="other-item">体重：{{=it.weight}} kg</span>{{ } }}
                {{ if(it.heartRate){ }}<span class="other-item">心率：{{=it.heartRate}} bpm</span>{{ } }}
                {{ if(it.sbp||it.dbp){ }}<span class="other-item">血压：{{=it.sbp||""}}/{{=it.dbp||""}} mmHg</span>{{ } }}
                {{ if(it.otherPhysique){ }}<span class="other-item">其它：{{=it.otherPhysique}}</span>{{ } }}
            </p>
        </li>
        <li class="precord-line precord-inline">
            <p class="precord-note precord-note-diagnosis" style="line-height:5.4mm;">诊断：</p><p class="precord-note" style="line-height:5.4mm;">{{=it.diagnosis}}</p>
        </li>
        {{ if(it.examList.length){ }}
        <li class="precord-line title-mark">
            <p class="precord-module">检查治疗项：</p>
        </li>
        {{ for(i=0;i<it.examList.length;i++){ }}
        {{ var examItem = it.examList[i]; }}
        <li class="precord-line">
            <span class="precord-exam-name {{= i==0 ? 'first-line':''}}">{{=examItem.examName}}</span>
            <span class="precord-exam-total {{= i==0 ? 'first-line':''}}">{{=examItem.examNum+'次'}}</span>
            <span class="precord-exam-space {{= i==0 ? 'first-line':''}}"></span>
            <span class="precord-exam-name {{= i==0 ? 'first-line':''}}">{{=examItem.hasSecondItem?examItem.examName_2:''}}</span>
            <span class="precord-exam-total {{= i==0 ? 'first-line':''}}">{{=examItem.hasSecondItem?(examItem.examNum_2+'次'):''}}</span>
        </li>
        {{ } }}
        {{ } }}
        {{ for(i=0;i<it.patentPrescrList.length;i++){ }}
        <li class="precord-line title-mark">
            <p class="precord-module">成药处方{{=i+1}}：</p>
        </li>
        <li class="precord-line title-mark">
            <span class="precord-patent-name first-line">药品名称</span>
            <span class="precord-patent-specif first-line">规格</span>
            <span class="precord-patent-frequ first-line">频率</span>
            <span class="precord-patent-dosage first-line">单次剂量</span>
            <span class="precord-patent-usage first-line">用法</span>
            <span class="precord-patent-total first-line">数量</span>
        </li>
        {{ for(j=0,mark=0;j<it.patentPrescrList[i].patentDrugList.length;j++){ }}
        {{ var patentItem = it.patentPrescrList[i].patentDrugList[j]; }}
        {{ var _assId = patentItem.assId; }}
        {{ if(mark != _assId && (mark = _assId)){ }}
        <li class="precord-line title-mark">
            <div class="precord-patent-group {{=( j ==0 && _assId !=0 )?"normal":""}}">分组{{=_assId}}：</div>
        </li>
        {{ } }}
        <li class="precord-line">
            <span class="precord-patent-name">{{=patentItem.drugName}}</span>
            <span class="precord-patent-specif">{{=patentItem.specification}}</span>
            <span class="precord-patent-frequ">{{=patentItem.frequency.replace(/\(\w+\)|（\w+）/,'')}}</span>
            <span class="precord-patent-dosage">{{=patentItem.dosage + (patentItem.dosageUnit||'')}}</span>
            <span class="precord-patent-usage">{{=patentItem.usage}}</span>
            <span class="precord-patent-total">{{=patentItem.totalDosage + (patentItem.totalDosageUnit||'')}}</span>
        </li>
        {{ } }}
        {{ } }}
        {{ for(i=0;i<it.herbalPrescrList.length;i++){ }}
        {{ var hPrescr = it.herbalPrescrList[i]; }}
        <li class="precord-line title-mark">
            <p class="precord-module">饮片处方{{=i+1}}：</p>
        </li>
        <li class="precord-line precord-div title-mark">
            <div class="precord-chinese-help">
                <span class="precord-chinese-require">剂数：{{=hPrescr.totalDosage}}剂</span>
                <span class="precord-chinese-require">每日剂量：{{=hPrescr.dailyDosage}}剂</span>
                <span class="precord-chinese-require">用法：{{=hPrescr.usage}}</span>
                <span class="precord-chinese-require">频率：{{=hPrescr.frequency.replace(/\(\w+\)|（\w+）/,'')}}</span>
                <span class="precord-chinese-require require-last">服用要求：{{=hPrescr.requirement}}</span>
            </div>
        </li>
        <li class="precord-line precord-div">
            {{ for(j=0;j<hPrescr.decoctionPiecesList.length;j++){ }}
            {{ var herbalItem = hPrescr.decoctionPiecesList[j]; }}
            <div class="precord-chinese-herbal">{{= herbalItem.drugName + '，' + herbalItem.value + herbalItem.unit + (herbalItem.comment && ('，' + herbalItem.comment || ''))}}</div>
            {{ } }}
        </li>
        {{ } }}
        {{ if(it.additList.length){ }}
        <li class="precord-line title-mark">
            <p class="precord-module">附加费用：</p>
        </li>
        {{ for(i=0;i<it.additList.length;i++){ }}
        {{ var additItem = it.additList[i]; }}
        <li class="precord-line">
            <span class="precord-addit-name {{= i==0 ? 'first-line':''}}">{{=additItem.additName}}</span>
            <span class="precord-addit-space {{= i==0 ? 'first-line':''}}"></span>
            <span class="precord-addit-name {{= i==0 ? 'first-line':''}}">{{=additItem.hasSecondItem?additItem.additName_2:''}}</span>
        </li>
        {{ } }}
        {{ } }}
        <li class="precord-line precord-inline">
            <p class="precord-advice precord-advice-lable">医嘱：</p><p class="precord-advice">{{=it.doctorAdvice}}</p>
        </li>
    </script>
    <script type="text" class="tempS">
        {{ for(var i=0; i<it.totalPage; i++){ }}
        <div class="print-record {{= (i==it.totalPage-1) ? "" : "print-break"}}">
            <table class="precord-table"><tbody>
            <tr>
                <td class="precord-tit-text"></td>
                <td class="precord-tit-title">{{=it.invoiceLookedUp||''}}</td>
                <td class="precord-tit-text">门诊</td>
            </tr>
            </tbody></table>
            <table class="precord-table"><tbody>
            <tr>
                <td class="precord-info-record">病历号：{{=it.recordId}}</td>
                <td class="precord-info-date">就诊日期：{{=it.diagnosisDate}}</td>
            </tr>
            </tbody></table>
            <table class="precord-table"><tbody>
            <tr>
                <td class="precord-info-name">姓名：{{=it.patientName}}</td>
                <td class="precord-info-gender">性别：{{=it.gender}}</td>
                <td class="precord-info-age">年龄：{{=it.age+it.ageType}}</td>
                <td class="precord-info-depart">科室：{{=it.laboratoryName}}</td>
            </tr>
            </tbody></table>
            <span class="precord-hr"></span>
            <ul class="precord-cont">
            </ul>
            <span class="precord-hr"></span>
            <table class="precord-table"><tbody>
            <tr>
                <td class="precord-check-doctor">医师：{{=it.showDoctor ? it.doctorName : ''}}</td>
                <td class="precord-check-page">第 {{=i+1}} 页/共 {{=it.totalPage}} 页</td>
                <td class="precord-check-date">打印日期：{{=it.printTime}}</td>
            </tr>
            </tbody></table>
        </div>
        {{ } }}
    </script>