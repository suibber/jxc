<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FlowSale */

$this->title = 'Create Flow Sale';
$this->params['breadcrumbs'][] = ['label' => 'Flow Sales', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-sale-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
