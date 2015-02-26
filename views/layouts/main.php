<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Economizzer</title>
    <?php $this->head();
    AppAsset::register($this);
    $js = <<< 'SCRIPT'
    /* To initialize BS3 tooltips set this below */
    $(function () {
    $("[data-toggle='tooltip']").tooltip();
    });;
    /* To initialize BS3 popovers set this below */
    $(function () {
    $("[data-toggle='popover']").popover();
    });
SCRIPT;
    // Register tooltip/popover initialization javascript
    $this->registerJs($js);
     ?>
    <link rel="shortcut icon" href="<?php echo Yii::$app->request->baseUrl;?>/images/favicon.ico">

</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => '<img src="images/logo-icon.png" style="height:20px;float:left;margin-right: 5px" align="absbottom">  Economizzer',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar navbar-default navbar-fixed-top',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'encodeLabels' => false,
                'items' => [
                    ['label' => '<i class="fa fa-home"></i> '.Yii::t('app', 'Overview'), 'url' => ['/site/index'], 'visible' => !Yii::$app->user->isGuest,],
                    ['label' => '<i class="fa fa-usd"></i> '.Yii::t('app', 'Cashbook'), 'url' => ['/cashbook/index'], 'visible' => !Yii::$app->user->isGuest,],
                    ['label' => '<i class="fa fa-bullseye"></i> '.Yii::t('app', 'Targets'), 'url' => ['/cashbook/target'], 'visible' => !Yii::$app->user->isGuest,],
                    ['label' => '<i class="fa fa-briefcase"></i> '.Yii::t('app', 'Options'), 'visible' => !Yii::$app->user->isGuest,
                    'items' => 
                        [
                            ['label' => '<i class="fa fa-briefcase"></i> '.Yii::t('app', 'Category'), 'url' => ['/category/index']],
                            ['label' => '<i class="fa fa-briefcase"></i> '.Yii::t('app', 'Type'), 'url' => ['/type/index']],
                        ],
                    ],
                    Yii::$app->user->isGuest ?
                    ['label' => '<i class="fa fa-user"></i> '.Yii::t('app', 'Create an account'), 'url' => ['/user/register']] :
                    ['label' => '<i class="fa fa-user"></i> '. Yii::$app->user->displayName,
                    'items' => 
                        [
                            ['label' => '<i class="fa fa-briefcase"></i> '.Yii::t('app', 'Account'), 'url' => ['/user/account']],
                            ['label' => '<i class="fa fa-briefcase"></i> '.Yii::t('app', 'Profile'), 'url' => ['/user/profile']],
                            '<li class="divider"></li>',
                            ['label' => '<i class="fa fa-unlock"></i> '.Yii::t('app', 'Sign Out'),
                                'url' => ['/user/logout'],
                                'linkOptions' => ['data-method' => 'post']],
                        ],
                    ],
                    
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container" align="center">Copyright &copy; <?= date('Y') ?> - Economizzer</div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
