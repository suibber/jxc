<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FlowInSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '入库';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-in-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Flow In', ['create-auto'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'number',
            'in_number',
            'order_number',
            'in_store',
            'bill_number',
            'product_suppliers',
            'model',
            'product_name',
            'quantity',
            'in_one_price',
            'in_price',
            'lot_number',
            'expiration_date_one',
            'comment',
            'product_suppliers_short',
            'type',
            //'code_one',
            //'code_two',
            //'expiration_date_two',
//            'operator',
//            'created_at',
//            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
