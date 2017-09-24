<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FlowOrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '订单';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('订单录入', ['create-auto'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'number',
            'order_number',
            'bill_number',
            [
                'label' => '供应商',
                'format'=> 'raw',
                'attribute'=> 'product_suppliers',
                'value' => function($model){
                    return "<span style='font-size:8px;'>".$model->product_suppliers."</span>";
                },
            ],
            [
                'label' => '产品名称',
                'format'=> 'raw',
                'attribute'=> 'product_name',
                'value' => function($model){
                    return "<span style='font-size:8px;'>".$model->product_name."</span>";
                },
            ],
            'model',
            'quantity',
            'product_price',
            [
                'label' => '折扣',
                'format'=> 'raw',
                'attribute'=> 'discount',
                'value' => function($model){
                    return round($model->discount, 2)."%";
                },
            ],
            'discount_price',
            'order_price',
            'comment',
//            'operator',
//            'created_at',
//            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
