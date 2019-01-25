<?php

namespace app\modules\v1;

/**
 * Класс модуля первой версии веб-сервиса
 */
class apiV1Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\v1\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
