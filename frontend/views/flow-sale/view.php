<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FlowSale */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Flow Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-sale-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'number',
            'sale_number',
            'bill_number',
            'model',
            'quantity',
            'in_one_price',
            'in_price',
            'sale_one_price',
            'sale_price',
            'comment',
            'custom',
            'custom_short',
            'salesman',
            'product_name',
            'operator',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
