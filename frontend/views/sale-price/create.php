<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\SalePrice */

$this->title = 'Create Sale Price';
$this->params['breadcrumbs'][] = ['label' => 'Sale Prices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sale-price-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
