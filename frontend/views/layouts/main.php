<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <?php $this->endBody() ?>
    <style>
        body {
            overflow-x: scroll;
        }
    </style>
</head>
<body onload="enable()">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '出入库管理系统',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => '首页', 'url' => ['/site/index']],
        //['label' => '关于', 'url' => ['/site/about']],
        //['label' => '联系我们', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => '注册', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => '登录', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                Yii::$app->user->identity->username . '，你好 [退出]',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

<div  class="ui modal" id="alert_s_modal">
  <div class="ui icon header" id="alert_s_header">
    
  </div>
  <div class="content" id="alert_s_content">
  </div>
  <div class="actions">
    <div class="ui green ok inverted button" onclick="closeModal('alert_s_modal')">
      <i class="checkmark icon"></i>
      好的
    </div>
  </div>
</div>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; 亨通瑞鑫（北京）科技有限公司 <?= date('Y') ?></p>

        <p class="pull-right">Powered</p>
    </div>
</footer>
<style>
.modal-backdrop{
    z-index:1;
}
</style>

<script>
function alertS(title,content){
    $("#alert_s_header").html(title);
    $("#alert_s_content").html(content);
    $('#alert_s_modal')
        .modal('show')
    ;
}
function closeModal(id){
    $('#'+id)
        .modal('hide')
    ;
}
function enable(){
    $('.dropdown').dropdown();
    $('.ui.accordion').accordion();
    $(".popupinfo").popup();
}
</script>
</body>
</html>
<?php $this->endPage() ?>
