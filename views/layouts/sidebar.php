<?php

use app\models\User;
/** @var TYPE_NAME $assetDir */

$isGuest = Yii::$app->user->isGuest;

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="<?= $assetDir ?>/img/AdminLTELogo.png" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Chat</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Авторизация', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => $isGuest],
                    ['label' => 'Чат', 'url' => ['site/index'], 'icon' => 'sms'],
                    [
                        'label' => 'Пользователи',
                        'url' => ['user/index'],
                        'icon' => 'users',
                        'visible' => Yii::$app->user->can(User::ROLE_ADMIN)
                    ],
                    [
                        'label' => 'Некорректные сообщения',
                        'url' => ['incorrect/index'],
                        'icon' => 'envelope',
                        'visible' => Yii::$app->user->can(User::ROLE_ADMIN)
                    ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>