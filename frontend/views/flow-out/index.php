<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FlowOutSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '出库';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-out-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('出库录入', ['create-auto'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            //'number',
            'out_number',
            'bill_number',
            'out_store',
            [
                'label' => '收货方',
                'format'=> 'raw',
                'attribute'=> 'receiver',
                'value' => function($model){
                    return "<span style='font-size:8px;'>".$model->receiver."</span>";
                },
            ],
            'model',
            [
                'label' => '产品名称',
                'format'=> 'raw',
                'attribute'=> 'product_name',
                'value' => function($model){
                    return "<span style='font-size:8px;'>".$model->product_name."</span>";
                },
            ],
            'quantity',
            'in_one_price',
            'in_price',
            'lot_number',
            'expiration_date_one',
            'comment',
            [
                'label' => '收货方简写',
                'format'=> 'raw',
                'attribute'=> 'receiver_short',
                'value' => function($model){
                    return "<span style='font-size:8px;'>".$model->receiver_short."</span>";
                },
            ],
            'type',
            //'code_one',
            //'code_two',
            //'sale_number',
            //'expiration_date_two',
//            'operator',
//            'created_at',
//            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
