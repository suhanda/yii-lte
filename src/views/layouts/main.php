<?php
/* @var $this \yii\web\View */

use suhanda\AdminLte\helpers\Html;
use yii\helpers\ArrayHelper;
use suhanda\AdminLte\assets\AdminLteAssets;
use yii\widgets\Breadcrumbs;

/* @var $theme \suhanda\AdminLte\Theme */
$theme = $this->theme;

AdminLteAssets::register($this);

$subTitle = ArrayHelper::getValue($this->params, 'subTitle', '');

$this->beginPage();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="//oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!-- ADD THE CLASS sidedar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->
<?= Html::beginTag('body', [
    'class' => $theme->getBodyCss()
]) ?>
<!--<body class="hold-transition layout-boxed skin-black sidebar-mini">-->
<?php $this->beginBody() ?>

<!-- Site wrapper -->
<div class="wrapper">

    <?= $this->render('//layouts/_header') ?>
    <!-- =============================================== -->
    <?= $this->render('//layouts/_mainSideBar') ?>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content-header">
            <?= Html::tag('h1', $this->title . (!empty($subTitle) ? "<small>{$subTitle}</small>" : '')) ?>
            <?= Breadcrumbs::widget([
                'links'        => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'encodeLabels' => false,
                'homeLink'     => [
                    'label' => '<i class="fa fa-dashboard"></i> Home',
                    'url'   => Yii::$app->homeUrl,
                ]
            ]) ?>
        </section>
        <section class="content"><?= $content ?></section>
    </div>
    <!-- /.content-wrapper -->

    <?= $this->render('//layouts/_footer'); ?>
</div>
<!-- ./wrapper -->
<?php $this->endBody() ?>
<?= Html::endTag('body'); ?>
</html>
<?php $this->endPage() ?>
