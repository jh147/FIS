<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
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
    <script type="text/javascript" src="/js/common/global.js"></script>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top manage-header',
        ],
    ]);
    // $menuItems = [
    //     ['label' => 'Home', 'url' => ['/site/index']],
    //     ['label' => 'Input', 'url' => ['/input/index']],
    //     ['label' => 'Search', 'url' => ['/search/index']],
    //     ['label' => 'Statistics', 'url' => ['/statistics/index']],
    //     ['label' => 'Analysis', 'url' => ['/analysis/index']],
    // ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
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


    <div class="container-fixed">

        <div class="manage-container">

            <!-- 菜单 [[-->
            <div class="manage-menu" style="display:<?= Yii::$app->user->isGuest ? 'none' : '' ?>">
                <dl>
                    <dt>
                        <span class="glyphicon glyphicon-book align-m" aria-hidden="true"></span><span class="align-m">基础数据</span>
                    </dt>
                    <dd class="<?php if($this->title == '代理人'){ echo 'on';} ?>">
                        <a href="/agents/index">代理人</a>
                    </dd>
                    <dd class="<?php if($this->title == '航班'){ echo 'on';} ?>">
                        <a href="/flight/index">航班</a>
                    </dd>
                    <dd class="<?php if($this->title == '货物种类'){ echo 'on';} ?>">
                        <a href="/goods/index">货物种类</a>
                    </dd>
                </dl>
                <dl>
                    <dt>
                        <span class="glyphicon glyphicon-th-large align-m" aria-hidden="true"></span><span class="align-m">日常数据</span>
                    </dt>
                    <dd class="<?php if($this->title == '运单'){ echo 'on';} ?>">
                        <a href="/shipping-order/index">运单</a>
                    </dd>
                    <dd class="<?php if($this->title == '拉货'){ echo 'on';} ?>">
                        <a href="/pg-order/index">拉货</a>
                    </dd>
                    <dd class="<?php if($this->title == '日常营业'){ echo 'on';} ?>">
                        <a href="/daily-business/index">日常营业</a>
                    </dd>
                </dl>
                <dl>
                    <dt>
                        <span class="glyphicon glyphicon-signal align-m" aria-hidden="true"></span><span class="align-m">统计分析</span>
                    </dt>
                    <dd class="<?php if($this->title == '周期销售对比'){ echo 'on';} ?>">
                        <a href="/sales-compare/index">周期销售对比</a>
                    </dd>
                    <dd class="<?php if($this->title == '周期销售分析'){ echo 'on';} ?>">
                        <a href="/sales-statistics/index">周期销售分析</a>
                    </dd>
                    <dd class="<?php if($this->title == '周期运价分析'){ echo 'on';} ?>">
                        <a href="/price-cycle">周期运价分析</a>
                    </dd>
                    <dd class="<?php if($this->title == '货源分析'){ echo 'on';} ?>">
                        <a href="/goods-statistics/index">货源分析</a>
                    </dd>
                    <dd class="<?php if($this->title == '出货分析'){ echo 'on';} ?>">
                        <a href="/shipment-statistics/index">出货分析</a>
                    </dd>
                </dl>
            </div>
            <!-- 菜单 ]]-->

            <!-- 内容 [[-->
            <div class="manage-content" style="padding: 30px;">
                <?= $content ?>
            </div>
            <!-- 内容 ]]-->

        </div>
        
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
