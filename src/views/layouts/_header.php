<?php
use yii\helpers\Url;
use yii\lte\widgets\NavBar;
use yii\lte\widgets\NavBarMenu;

?>
<header class="main-header">
    <!-- Logo -->
    <a href="<?= Url::home() ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <?php NavBar::begin(); ?>
    <div class="navbar-custom-menu">
        <?= NavBarMenu::widget([
            'items' => $this->theme->topMenuItems
        ]); ?>
    </div>
    <?php NavBar::end() ?>
</header>