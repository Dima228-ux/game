<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
?>
<header>

    <?php
    NavBar::begin([
        'brandLabel' => 'Game',
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Home', 'url' => ['/site/get-applications']],
            ['label' => 'Rooms', 'url' => ['/rooms/get-rooms']],
            ['label' => 'Statistic', 'url' => ['/statistics/get-statistics']],
            '<li>'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'

        ],
    ]);
    NavBar::end();
    ?>
</header>