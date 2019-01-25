<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\Task;
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
        //$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        // подготовить и вернуть провайдер данных для действия "index"
    }

    public function actionIndex($id = null)
    {
        $titleSearch = isset($_GET['title']) ? $_GET['title'] : null;
        $response = \Yii::$app->response;
        $response->format = $response::FORMAT_JSON;
        $taskModel = new Task();
        $get = \Yii::$app->request->get();
        $start = empty($get['start']) ? 0 : $get['start'];
        $rowsPerPage = \Yii::$app->params['rowsPerPage'];
        $limit = empty($get['limit']) ? (empty($rowsPerPage) ? 0 : $rowsPerPage) : $get['limit'];
        return empty($id) ? $taskModel->getTasks($start, $limit, $titleSearch) : $taskModel->getTask($id);
    }
}
