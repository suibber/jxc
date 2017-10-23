<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FlowInSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '客户库存查询';
$this->params['breadcrumbs'][] = $this->title;
$isSale = Yii::$app->authManager->getAssignment('sale', Yii::$app->user->id)?1:0;
?>
<div class="flow-in-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div id="w0" class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>收货方简写</th>
                    <th>分类</th>
                    <th>产品型号</th>
                    <th>公司出库数量</th>
                    <th <?=$isSale?'style="display:none"':''?>>公司出库金额</th>
                    <th>公司入库数量</th>
                    <th <?=$isSale?'style="display:none"':''?>>公司入库金额</th>
                    <th>销售数量</th>
                    <th <?=$isSale?'style="display:none"':''?>>销售金额</th>
                    <th>库存数量</th>
                    <th <?=$isSale?'style="display:none"':''?>>库存金额</th>
                </tr>
                <tr class="filters">
                    <td>
                        <input type="text" class="form-control search" id="in_store" value="<?=Yii::$app->request->get('receiver')?>">
                    </td>
                    <td>
                        <input type="text" class="form-control search" id="type" value="<?=Yii::$app->request->get('type')?>">
                    </td>
                    <td>
                        <input type="text" class="form-control search" id="model" value="<?=str_ireplace("  ", " +", Yii::$app->request->get('model'))?>">
                    </td>
                    <td><?=$count_quantity?></td>
                    <td <?=$isSale?'style="display:none"':''?>><?=$count_in_price?></td>
                    <td><?=$count_inin_quantity?></td>
                    <td <?=$isSale?'style="display:none"':''?>><?=$count_inin_price?></td>
                    <td><?=$count_sale_quantity?></td>
                    <td <?=$isSale?'style="display:none"':''?>><?=$count_sale_price?></td>
                    <td><?=$count_quantity-$count_inin_quantity-$count_sale_quantity?></td>
                    <td <?=$isSale?'style="display:none"':''?>><?=$count_in_price-$count_inin_price-$count_sale_price?></td>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($list as $item) { ?>
                <tr>
                    <td><?=$item['receiver_short']?></td>
                    <td><?=$item['type']?></td>
                    <td><?=$item['model']?></td>
                    <td><?=$item['quantity']?></td>
                    <td <?=$isSale?'style="display:none"':''?>><?=$item['in_price']?></td>
                    <td><?=$item['inin_quantity']?></td>
                    <td <?=$isSale?'style="display:none"':''?>><?=$item['inin_price']?></td>
                    <td><?=$item['sale_quantity']?></td>
                    <td <?=$isSale?'style="display:none"':''?>><?=$item['sale_price']?></td>
                    <td><?=$item['quantity']-$item['inin_quantity']-$item['sale_quantity']?></td>
                    <td <?=$isSale?'style="display:none"':''?>><?=$item['in_price']-$item['inin_price']-$item['sale_price']?></td>
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
    var url = "/flow-out/store?receiver="+in_store+"&type="+type+"&model="+model;
    window.location.href = url;
});
</script>
