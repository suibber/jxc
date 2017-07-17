<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\FlowOut */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Flow Outs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-out-view">

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
            'operator',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
