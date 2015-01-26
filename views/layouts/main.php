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
    <?php $this->head() ?>
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
                    ['label' => '<i class="fa fa-home"></i> Visão Geral', 'url' => ['/site/index'], 'visible' => !Yii::$app->user->isGuest,],
                    ['label' => '<i class="fa fa-usd"></i> Lançamentos', 'url' => ['/cashbook/index'], 'visible' => !Yii::$app->user->isGuest,],
                    ['label' => '<i class="fa fa-bullseye"></i> Metas', 'url' => ['/cashbook/target'], 'visible' => !Yii::$app->user->isGuest,],
                    ['label' => '<i class="fa fa-briefcase"></i> Opções', 'visible' => !Yii::$app->user->isGuest,
                    'items' => [
                         ['label' => '<i class="fa fa-briefcase"></i> Categoria', 'url' => ['category/index']],
                         ['label' => '<i class="fa fa-briefcase"></i> Tipo', 'url' => ['/type/index']],
                        ],
                    ],
                    Yii::$app->user->isGuest ?
                        ['label' => '<i class="fa fa-lock"></i> Entrar', 'url' => ['/user/login']] :
                        ['label' => '<i class="fa fa-unlock"></i> Sair (' . Yii::$app->user->displayName . ')',
                            'url' => ['/user/logout'],
                            'linkOptions' => ['data-method' => 'post']],
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
        <div class="container">
            <p class="pull-left">Copyright &copy; <?= date('Y') ?> - Economizzer</p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
