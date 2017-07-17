<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FlowOut */

$this->title = 'Update Flow Out: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Flow Outs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="flow-out-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
