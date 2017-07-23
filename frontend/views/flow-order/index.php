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
        <?= Html::a('Create Flow Order', ['create-auto'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
//            'number',
            'order_number',
            'bill_number',
            'product_suppliers',
            'product_name',
            'model',
            'quantity',
            'product_price',
            [
                'label' => '折扣',
                'format'=> 'raw',
                'attribute'=> 'discount',
                'value' => function($model){
                    return ($model->discount*100)."%";
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
