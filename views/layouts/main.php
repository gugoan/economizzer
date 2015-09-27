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
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo Yii::$app->request->baseUrl;?>/images/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo Yii::$app->request->baseUrl;?>/images/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo Yii::$app->request->baseUrl;?>/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo Yii::$app->request->baseUrl;?>/images/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo Yii::$app->request->baseUrl;?>/images/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo Yii::$app->request->baseUrl;?>/images/apple-touch-icon-120x120.png">
    <link rel="icon" type="image/png" href="<?php echo Yii::$app->request->baseUrl;?>/images/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="<?php echo Yii::$app->request->baseUrl;?>/images/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="<?php echo Yii::$app->request->baseUrl;?>/images/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="<?php echo Yii::$app->request->baseUrl;?>/images/manifest.json">
    <meta name="apple-mobile-web-app-title" content="Economizzer">
    <meta name="application-name" content="Economizzer">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

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
                    ['label' => '<i class="fa fa-home"></i> '.Yii::t('app', 'Overview'), 'url' => ['/cashbook/overview'], 'visible' => !Yii::$app->user->isGuest,],
                    ['label' => '<i class="fa fa-usd"></i> '.Yii::t('app', 'Entries'), 'url' => ['/cashbook/index'], 'visible' => !Yii::$app->user->isGuest,],
                    ['label' => '<i class="fa fa-bullseye"></i> '.Yii::t('app', 'Targets'), 'url' => ['/cashbook/target'], 'visible' => !Yii::$app->user->isGuest,],
                    ['label' => '<i class="fa fa-briefcase"></i> '.Yii::t('app', 'Options'), 'visible' => !Yii::$app->user->isGuest,
                    'items' => 
                        [
                            ['label' => '<i class="fa fa-tag"></i> '.Yii::t('app', 'Category'), 'url' => ['/category/index']],
                            //['label' => '<i class="fa fa-briefcase"></i> '.Yii::t('app', 'Type'), 'url' => ['/type/index']],
                        ],
                    ],
                    Yii::$app->user->isGuest ?
                    ['label' => '<i class="fa fa-user-plus"></i> '.Yii::t('app', 'Create an account'), 'url' => ['/user/register']] :
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
            <p>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container" align="center">Copyright &copy; <?= date('Y') ?> - <?= Html::a('Economizzer', 'http://www.economizzer.org') ?>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
