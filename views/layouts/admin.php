<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            //['label' => 'Home', 'url' => ['site/index'], 'visible' => !Yii::$app->user->isGuest],
            ['label' => 'Главная', 'url' => ['admin/index']],
            ['label' => 'Материалы', 'url' => ['post/index'], 'visible' => Yii::$app->user->can('roleRoot')],
            ['label' => 'Студенты', 'url' => ['user/index'], 'visible' => Yii::$app->user->can('roleRoot')],
            ['label' => 'Группы', 'url' => ['group/index'], 'visible' => Yii::$app->user->can('roleRoot')],
            ['label' => 'Регистрация', 'url' => ['admin/signup'], 'visible' => Yii::$app->user->can('roleRoot')],
            //['label' => 'Регистрация', 'url' => ['site/signup']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Авторизоваться', 'url' => ['/admin/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/admin/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
                )   
        ],
    ]);
    NavBar::end();
    ?>

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
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
