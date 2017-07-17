<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FlowInSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flow-in-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'in_number') ?>

    <?= $form->field($model, 'bill_number') ?>

    <?= $form->field($model, 'order_number') ?>

    <?php // echo $form->field($model, 'in_store') ?>

    <?php // echo $form->field($model, 'code_one') ?>

    <?php // echo $form->field($model, 'code_two') ?>

    <?php // echo $form->field($model, 'lot_number') ?>

    <?php // echo $form->field($model, 'expiration_date_one') ?>

    <?php // echo $form->field($model, 'expiration_date_two') ?>

    <?php // echo $form->field($model, 'model') ?>

    <?php // echo $form->field($model, 'quantity') ?>

    <?php // echo $form->field($model, 'in_one_price') ?>

    <?php // echo $form->field($model, 'in_price') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'product_suppliers') ?>

    <?php // echo $form->field($model, 'product_suppliers_short') ?>

    <?php // echo $form->field($model, 'product_name') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'operator') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
