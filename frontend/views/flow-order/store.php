<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FlowInSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单状态明细';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-in-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div id="w0" class="grid-view">
        <form class="ui form">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>订单号</th>
                    <th>供应商</th>
                    <th>订单数量</th>
                    <th>订单金额</th>
                    <th>付款比例</th>
                    <th>付款金额</th>
                    <th>未付金额</th>
                    <th>付款时间</th>
                    <th>到货数量</th>
                    <th>到货金额</th>
                    <th>发票号</th>
                    <th>发票金额</th>
                    <th>开票日期</th>
                    <th>付款状态</th>
                    <th>发票状态</th>
                    <th>到货状态</th>
                    <th>备注</th>
                </tr>
                <tr class="filters">
                    <td>
                        <input type="text" class="form-control search" id="in_store" value="<?=Yii::$app->request->get('in_store')?>">
                    </td>
                    <td>
                        <input type="text" class="form-control search" id="type" value="<?=Yii::$app->request->get('type')?>">
                    </td>
                    <td><?=$countQuantityOrder?></td>
                    <td><?=$countPriceOrder?></td>
                    <td></td>
                    <td><?=$count_pay_price?></td>
                    <td><?=$count_pay_price_not?></td>
                    <td></td>
                    <td><?=$count_in_quantity?></td>
                    <td><?=$count_in_price?></td>
                    <td></td>
                    <td><?=$count_bill_price?></td>
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
                    <td><?=$item['order_number']?></td>
                    <td><?=$item['product_suppliers']?></td>
                    <td><?=$item['quantity']?></td>
                    <td><?=$item['order_price']?></td>
                    <td><input type="text" style="width:60px" value="<?=$item['pay_percent']?>" onchange="setPercent(this,'<?=$item['order_number']?>','<?=$item['order_price']?>')" id="<?=$item['order_number']?>_pay_percent"></td>
                    <td id="<?=$item['order_number']?>_pay_price"><?=$item['pay_price']?></td>
                    <td id="<?=$item['order_number']?>_pay_price_not"><?=$item['pay_price_not']?></td>
                    <td id="<?=$item['order_number']?>_pay_time"><?=$item['pay_time']?></td>
                    <td><?=$item['in_quantity']?></td>
                    <td><?=$item['in_price']?></td>
                    <td><input type="text" style="width:150px" value="<?=$item['bill_number2']?>" onchange="setBill('<?=$item['order_number']?>','<?=$item['order_price']?>')" id="<?=$item['order_number']?>_bill_number2"></td>
                    <td><input type="text" style="width:60px" value="<?=$item['bill_price']?>" onchange="setBill('<?=$item['order_number']?>','<?=$item['order_price']?>')" id="<?=$item['order_number']?>_bill_price"></td>
                    <td><input type="text" style="width:170px" value="<?=$item['bill_time']?>" onchange="setBill('<?=$item['order_number']?>','<?=$item['order_price']?>')" id="<?=$item['order_number']?>_bill_time"></td>
                    <td id="<?=$item['order_number']?>_pay_status"><?=$item['pay_status']?></td>
                    <td id="<?=$item['order_number']?>_bill_status"><?=$item['bill_status']?></td>
                    <td><?=$item['arrival_status']?></td>
                    <td><?=$item['detail_comment']?></td>
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
    var url = "/flow-order/store?in_store="+in_store+"&type="+type;
    window.location.href = url;
});

function setBill(order_id,price){
    var bill_number2 = $("#"+order_id+"_bill_number2").val();
    var bill_price = $("#"+order_id+"_bill_price").val();
    var bill_time = $("#"+order_id+"_bill_time").val();
    var bill_status = '';
    if (price==bill_price) {
        bill_status = '已开票';
    } else if (!bill_price || bill_price==0) {
        bill_status = '未开票';
    } else {
        bill_status = '部分开票';
    }
    var dict = {'order_id':order_id,'bill_number2':bill_number2,'bill_price':bill_price,'bill_time':bill_time,'bill_status':bill_status}; 
    $.post(
        '/flow-order/set-bill',
        dict,
        function(data){
            if (data['success']) {
            }
        }
    );
    $("#"+order_id+"_bill_status").html(bill_status);
}

function setPercent(data,order_id,price){
    var percent = $(data).val();
    var pay_price = percent*0.01*price;
    var pay_price_not = price - pay_price;
    var pay_status = '';
    if (percent==100) {
        pay_status = '已付款';
    } else if (!percent || percent==0) {
        pay_status = '未付款';
    } else {
        pay_status = percent+'%付款';
    }
    
    var dict = {'order_id':order_id,'pay_percent':percent,'pay_price':pay_price,'pay_price_not':pay_price_not,'pay_status':pay_status};
    $.post(
        '/flow-order/set-percent',
        dict,
        function(data){
            if (data['success']) {
            }
        }
    );

    $("#"+order_id+"_pay_price").html(pay_price);
    $("#"+order_id+"_pay_price_not").html(pay_price_not);
    $("#"+order_id+"_pay_price_not").html(pay_price_not);
    $("#"+order_id+"_pay_time").html(getNowFormatDate());
    $("#"+order_id+"_pay_status").html(pay_status);
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
