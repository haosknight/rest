<?php

/* @var $this yii\web\View */

$this->title = 'Тест веб-сервиса';
$this->registerCssFile("js/ext-6.6.0/build/classic/theme-neptune/resources/theme-neptune-all.css");
$this->registerJsFile("js/ext-6.6.0/build/ext-all-debug.js");
$this->registerJsFile("js/ext-6.6.0/build/classic/theme-neptune/theme-neptune.js");
$this->registerJsFile("js/app.js");
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Тестовый проект</h1>

        <p class="lead">Фронтенд для веб-севиса</p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                <div id="grid"></div>
            </div>
        </div>

    </div>
</div>
