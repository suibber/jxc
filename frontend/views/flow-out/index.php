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
        <?= Html::a('Create Flow Out', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'number',
            'out_number',
            'bill_number',
            'out_store',
            'code_one',
            'code_two',
            'sale_number',
            'model',
            'quantity',
            'in_one_price',
            'in_price',
            'lot_number',
            'expiration_date_one',
            'expiration_date_two',
            'comment',
            'type',
            'receiver',
            'receiver_short',
            'product_name',
//            'operator',
//            'created_at',
//            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>