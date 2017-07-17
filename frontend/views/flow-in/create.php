<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\FlowIn */

$this->title = 'Create Flow In';
$this->params['breadcrumbs'][] = ['label' => 'Flow Ins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flow-in-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
