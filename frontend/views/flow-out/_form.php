<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FlowOut */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="flow-out-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'out_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bill_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'out_store')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code_one')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code_two')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sale_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?= $form->field($model, 'in_one_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'in_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lot_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'expiration_date_one')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'expiration_date_two')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'receiver')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'receiver_short')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'operator')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
