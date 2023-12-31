<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag([
    'name'    => 'viewport',
    'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no',
]);
$this->registerMetaTag([
    'name'    => 'description',
    'content' => $this->params['meta_description'] ?? '',
]);
$this->registerMetaTag(
    ['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']
);
$this->registerLinkTag([
    'rel'  => 'icon',
    'type' => 'image/x-icon',
    'href' => Yii::getAlias('@web/favicon.ico'),
]);
$this->registerJsFile('https://kit.fontawesome.com/7fc0456012.js');
$this->registerJsFile('@web/js/app.js', ['position' => yii\web\View::POS_END]);
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php
    $this->head();
    ?>
</head>
<body class="d-flex flex-column h-100">
<div class="spinner d-none"></div>
<?php
$this->beginBody();
?>
<header id="header">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <?=
                Html::img(
                    '/favicon.ico',
                    ['alt' => 'Books image logo', 'width' => 30]
                );
                ?>
                <?= Yii::$app->name; ?>
            </a>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link <?= Url::current() == '/books' ? 'active' : ''; ?>"
                       aria-current="page" href="/books">Books</a>
                </div>
            </div>
            <div class="justify-content-end">
                <?php
                if (!Yii::$app->user->getIsGuest()) {
                    $form = ActiveForm::begin([
                        'action' => ['/logout'],
                        'method' => 'post',
                    ]);
                    echo Html::submitButton(
                        'Logout',
                        ['class' => 'btn btn-warning px-sm-5']
                    );
                    ActiveForm::end();
                }
                ?>
            </div>
        </div>
    </nav>
</header>
<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php
        if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(
                ['links' => $this->params['breadcrumbs']]
            ) ?>
        <?php
        endif; ?>
        <?= Alert::widget(); ?>
        <?= $content ?>
    </div>
</main>
<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted mx-auto">
            <div class="col-12 text-center">
                &copy; Douglas Vicentini <?= date('Y'); ?></div>
        </div>
    </div>
</footer>
<?php
$this->endBody();
?>
</body>
</html>
<?php
$this->endPage();
?>
