<?php

/**
 * HTML разметка для вывода элементов с помощью extJS
 *
 * @var $this yii\web\View
 */

$this->title = 'Тест веб-сервиса';
$this->registerCssFile("js/ext-6.6.0/build/classic/theme-neptune/resources/theme-neptune-all.css");
$this->registerJsFile("js/ext-6.6.0/build/ext-all-debug.js");
$this->registerJsFile("js/ext-6.6.0/build/classic/theme-neptune/theme-neptune.js");
$this->registerJsFile("js/app.js");
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-2">
                &nbsp;
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-lg-3">
                        &nbsp;
                    </div>
                    <div class="col-lg-6">
                        <div id="search">&nbsp;</div>
                    </div>
                    <div class="col-lg-3">
                        &nbsp;
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div id="grid">&nbsp;</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                &nbsp;
            </div>
        </div>
    </div>
</div>
