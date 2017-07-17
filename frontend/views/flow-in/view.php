<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FlowIn */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Flow Ins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-in-view">

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
            'operator',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
