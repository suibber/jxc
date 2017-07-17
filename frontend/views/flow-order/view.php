<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FlowOrder */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Flow Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-order-view">

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
            'order_number',
            'bill_number',
            'model',
            'quantity',
            'discount',
            'discount_price',
            'order_price',
            'comment',
            'product_price',
            'product_suppliers',
            'product_name',
            'operator',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
