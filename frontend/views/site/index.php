<?php

/* @var $this yii\web\View */

$this->title = '亨通瑞鑫（北京）科技有限公司出入库管理系统';

$isSale = Yii::$app->authManager->getAssignment('sale', Yii::$app->user->id)?1:0;
$isAdmin = Yii::$app->authManager->getAssignment('admin', Yii::$app->user->id)?1:0;
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-lg-3" <?=$isSale?'style="display:none"':''?>>
                <h2>订单</h2>
                <p>

                </p>
                <p>
                    <a class="btn btn-default" href="/flow-order/index?sort=-id">点击进入</a></p>
            </div>
            <div class="col-lg-3"  <?=$isSale?'style="display:none"':''?>>
                <h2>入库</h2>
                <p>

                </p>
                <p>
                    <a class="btn btn-default" href="/flow-in/index?sort=-id">点击进入</a></p>
            </div>
            <div class="col-lg-3" <?=$isSale?'style="display:none"':''?>>
                <h2>出库</h2>
                <p>

                </p>
                <p>
                    <a class="btn btn-default" href="/flow-out/index?sort=-id">点击进入</a></p>
            </div>
            <div class="col-lg-3" <?=$isSale?'style="display:none"':''?>>
                <h2>销售</h2>
                <p>

                </p>
                <p>
                    <a class="btn btn-default" href="/flow-sale/index?sort=-id">点击进入</a></p>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-lg-3" <?=$isSale?'style="display:none"':''?>>
                <h2>订单状态明细</h2>
                <p>

                </p>
                <p>
                    <a class="btn btn-default" href="/flow-order/store">点击进入</a></p>
            </div>
            <div class="col-lg-3" <?=$isSale?'style="display:none"':''?>>
                <h2>销售状态明细</h2>
                <p>

                </p>
                <p>
                    <a class="btn btn-default" href="/flow-sale/store">点击进入</a></p>
            </div>
            <div class="col-lg-3">
                <h2>公司库存查询</h2>
                <p>

                </p>
                <p>
                    <a class="btn btn-default" href="/flow-in/store">点击进入</a></p>
            </div>
            <div class="col-lg-3">
                <h2>客户库存查询</h2>
                <p>

                </p>
                <p>
                    <a class="btn btn-default" href="/flow-out/store">点击进入</a></p>
            </div>
        </div>
        <br><br>
        <div class="row"  <?=$isSale?'style="display:none"':''?>>
            <div class="col-lg-3">
                <h2>产品</h2>
                <p>

                </p>
                <p>
                    <a class="btn btn-default" href="/product/index">点击进入</a></p>
            </div>
            <div class="col-lg-3">
                <h2>销售价格</h2>
                <p>

                </p>
                <p>
                    <a class="btn btn-default" href="/sale-price/index">点击进入</a></p>
            </div>
            <div class="col-lg-3">
                <h2>客户</h2>
                <p>

                </p>
                <p>
                    <a class="btn btn-default" href="/customer/index">点击进入</a></p>
            </div>
            <div class="col-lg-3">
                <h2>用户</h2>
                <p>

                </p>
                <p>
                    <a class="btn btn-default" href="/user/index?sort=-id">点击进入</a></p>
            </div>
        </div>

    </div>
</div>
