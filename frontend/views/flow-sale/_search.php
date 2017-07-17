<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FlowSaleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flow-sale-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'sale_number') ?>

    <?= $form->field($model, 'bill_number') ?>

    <?= $form->field($model, 'model') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'in_one_price') ?>

    <?php // echo $form->field($model, 'in_price') ?>

    <?php // echo $form->field($model, 'sale_one_price') ?>

    <?php // echo $form->field($model, 'sale_price') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'custom') ?>

    <?php // echo $form->field($model, 'custom_short') ?>

    <?php // echo $form->field($model, 'salesman') ?>

    <?php // echo $form->field($model, 'product_name') ?>

    <?php // echo $form->field($model, 'operator') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
