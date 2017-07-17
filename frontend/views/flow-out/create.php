<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FlowOut */

$this->title = 'Create Flow Out';
$this->params['breadcrumbs'][] = ['label' => 'Flow Outs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-out-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
