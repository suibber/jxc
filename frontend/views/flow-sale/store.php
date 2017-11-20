<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FlowInSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '销售状态明细';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-in-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div id="w0" class="grid-view">
        <form class="ui form">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>销售单号</th>
                    <th>收货方</th>
                    <th>发货数量</th>
                    <th>销售金额</th>
                    <th>销售负责人</th>
                    <th>发票号</th>
                    <th>发票金额</th>
                    <th>回款金额</th>
                    <th>回款日期</th>
                    <th>发票状态</th>
                    <th>回款金额</th>
                </tr>
                <tr class="filters">
                    <td>
                        <input type="text" class="form-control search" id="in_store" value="<?=Yii::$app->request->get('in_store')?>">
                    </td>
                    <td>
                        <input type="text" class="form-control search" id="type" value="<?=Yii::$app->request->get('type')?>">
                    </td>
                    <td></td>
                    <td></td>
                    <td>
                        <input type="text" class="form-control search" id="sale_man" value="<?=Yii::$app->request->get('sale_man')?>">
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $item) { ?>
                <tr>
                    <td><?=$item['sale_number']?></td>
                    <td><?=$item['custom']?></td>
                    <td><?=$item['quantity']?></td>
                    <td><?=$item['sale_price']?></td>
                    <td><?=$item['salesman']?></td>
                    <td><input type="text" style="width:150px" value="<?=$item['bill_number2']?>" onchange="setBill('<?=$item['sale_number']?>','<?=$item['sale_price']?>')" id="<?=$item['sale_number']?>_bill_number2"></td>
                    <td><input type="text" style="width:60px" value="<?=$item['bill_price']?>" onchange="setBill('<?=$item['sale_number']?>','<?=$item['sale_price']?>')" id="<?=$item['sale_number']?>_bill_price"></td>
                    <td><input type="text" style="width:170px" value="<?=$item['reture_price']?>" onchange="setBill('<?=$item['sale_number']?>','<?=$item['sale_price']?>')" id="<?=$item['sale_number']?>_reture_price"></td>
                    <td id="<?=$item['sale_number']?>_return_time"><?=$item['return_time']?></td>
                    <td id="<?=$item['sale_number']?>_bill_status"><?=$item['bill_status']?></td>
                    <td id="<?=$item['sale_number']?>_return_status"><?=$item['return_status']?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        </form>
        <div class="page">
            <?=LinkPager::widget([
                'pagination' => $pages,
                'maxButtonCount'=>8,
                'lastPageLabel'=>'末页', 'nextPageLabel'=>'下一页',
                'prevPageLabel'=>'上一页', 'firstPageLabel'=>'首页'
            ]);?>
        </div>
    </div>
</div>
<script>
$(".search").on('change', function(){
    var in_store = $("#in_store").val();
    var type = $("#type").val();
    var sale_man = $("#sale_man").val();
    var url = "/flow-sale/store?in_store="+in_store+"&type="+type+"&sale_man="+sale_man;
    window.location.href = url;
});

function setBill(sale_number,price){
    var bill_number2 = $("#"+sale_number+"_bill_number2").val();
    var bill_price = $("#"+sale_number+"_bill_price").val();
    var reture_price = $("#"+sale_number+"_reture_price").val();
    var return_time = getNowFormatDate();
    var bill_status = '';
    var return_status = '';
    if (price==bill_price || price==bill_price+'.00') {
        bill_status = '已开票';
    } else if (!bill_price || bill_price==0) {
        bill_status = '未开票';
    } else {
        bill_status = '部分开票';
    }
    if (price==reture_price || price==reture_price+'.00') {
        return_status = '已回款';
    } else if (!reture_price || reture_price==0) {
        return_status = '未回款';
    } else {
        return_status = '部分回款';
    }
    var dict = {'sale_number':sale_number,'bill_number2':bill_number2,'bill_price':bill_price,'return_time':return_time,'bill_status':bill_status,'reture_price':reture_price,'return_status':return_status}; 
    $.post(
        '/flow-sale/set-bill',
        dict,
        function(data){
            if (data['success']) {
            }
        }
    );
    $("#"+sale_number+"_bill_status").html(bill_status);
    $("#"+sale_number+"_return_time").html(return_time);
    $("#"+sale_number+"_return_status").html(return_status);
}

function getNowFormatDate() {
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
            + " " + date.getHours() + seperator2 + date.getMinutes()
            + seperator2 + date.getSeconds();
    return currentdate;
}
</script>
