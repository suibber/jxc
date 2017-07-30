<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        当前请求发生错误，请仔细阅读提示内容.
    </p>
    <p>
        如果你认为这是一个系统问题，请联系我们，谢谢.
    </p>

</div>
