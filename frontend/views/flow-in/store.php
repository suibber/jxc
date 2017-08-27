<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FlowInSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '公司库存查询'.'（共'.$count.'条数据）';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-in-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div id="w0" class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>库房</th>
                    <th>分类</th>
                    <th>产品型号</th>
                    <th>入库数量</th>
                    <th>入库金额</th>
                    <th>出库金额</th>
                    <th>出库数量</th>
                    <th>库存数量</th>
                    <th>库存金额</th>
                </tr>
                <tr class="filters">
                    <td>
                        <input type="text" class="form-control search" id="in_store" value="<?=Yii::$app->request->get('in_store')?>">
                    </td>
                    <td>
                        <input type="text" class="form-control search" id="type" value="<?=Yii::$app->request->get('type')?>">
                    </td>
                    <td>
                        <input type="text" class="form-control search" id="model" value="<?=Yii::$app->request->get('model')?>">
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>总：<?=$countQuantity?><br/ >1000条内有效</td>
                    <td>总：<?=$countPrice?><br/ >1000条内有效</td>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $item) { ?>
                <tr>
                    <td><?=$item['in_store']?></td>
                    <td><?=$item['type']?></td>
                    <td><?=$item['model']?></td>
                    <td><?=$item['quantity']?></td>
                    <td><?=$item['in_price']?></td>
                    <td><?=$item['out_price']?></td>
                    <td><?=$item['out_quantity']?></td>
                    <td><?=$item['quantity']-$item['out_quantity']?></td>
                    <td><?=$item['in_price']-$item['out_price']?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
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
    var model = $("#model").val();
    var url = "/flow-in/store?in_store="+in_store+"&type="+type+"&model="+model;
    window.location.href = url;
});
</script>
