<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FlowSaleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '销售';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-sale-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Flow Sale', ['create-auto'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'number',
            'sale_number',
            'bill_number',
            'custom',
            'model',
            'product_name',
            'quantity',
            'in_one_price',
            'in_price',
            'sale_one_price',
            'sale_price',
            'salesman',
            'comment',
            'custom_short',
//            'operator',
//            'created_at',
//            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
