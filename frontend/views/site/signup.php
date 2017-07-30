<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>请填写注册信息:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->label('用户名')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email')->label('邮箱') ?>

                <?= $form->field($model, 'password')->label('密码')->passwordInput() ?>

                <div style="color:#999;margin:1em 0">
                    注册后，请联系系统负责人开通使用权限.
                </div>
                <div class="form-group">
                    <?= Html::submitButton('确认注册', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
