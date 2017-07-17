<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FlowSale */

$this->title = 'Update Flow Sale: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Flow Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="flow-sale-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
