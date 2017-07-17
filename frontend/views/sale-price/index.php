<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SalePriceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sale Prices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-price-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Sale Price', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'receiver',
            'model',
            'price',
            'sales',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
