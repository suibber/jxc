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
        <?= Html::a('Create Flow In', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'number',
            'in_number',
            'bill_number',
            'order_number',
            'in_store',
            'code_one',
            'code_two',
            'lot_number',
            'expiration_date_one',
            'expiration_date_two',
            'model',
            'quantity',
            'in_one_price',
            'in_price',
            'comment',
            'product_suppliers',
            'product_suppliers_short',
            'product_name',
            'type',
//            'operator',
//            'created_at',
//            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
