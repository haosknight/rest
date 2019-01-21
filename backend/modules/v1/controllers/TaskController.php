<?php

namespace app\modules\v1\controllers;

use backend\modules\v1\models\Task;
use yii\rest\Controller;

/**
 * Default controller for the `v1` module
 */
class TaskController extends Controller
{
    public function actions()
    {
        $actions = parent::actions();

        // отключить действия "delete", "update" и "create"
        unset($actions['delete'], $actions['update'], $actions['create']);

        // настроить подготовку провайдера данных с помощью метода "prepareDataProvider()"
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        // подготовить и вернуть провайдер данных для действия "index"
    }

    public function actionIndex()
    {
        $response = \Yii::$app->response;
        $response->format = $response::FORMAT_JSON;
        $taskModel = new Task();
        return $taskModel->getTasks();
    }
}
