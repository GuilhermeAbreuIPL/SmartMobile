<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>

<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/navbar.css') ?>">
<link rel="stylesheet" href="<?= Yii::getAlias('@web/css/footer.css') ?>">

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<?php
    $hideNavbarAndFooter = in_array(Yii::$app->controller->action->id, ['login', 'signup']);
?>

<?php
$hideFooter = (Yii::$app->controller->id === 'fatura' && Yii::$app->controller->action->id === 'index') ||
              (Yii::$app->controller->id === 'fatura' && Yii::$app->controller->action->id === 'view') ||
              (Yii::$app->controller->id === 'carrinho' && Yii::$app->controller->action->id === 'index');
?>

<?php if (!$hideNavbarAndFooter): ?>
    <!-- Navbar -->
    <header>
        <?= $this->render('navbar') ?>
    </header>
<?php endif; ?>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?php if (!$hideNavbarAndFooter && !$hideFooter): ?>
    <!-- Footer -->
    <footer>
        <?= $this->render('footer') ?>
    </footer>
<?php endif; ?>

<script src="<?= Yii::getAlias('@web/js/navbar.js') ?>"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage(); ?>
