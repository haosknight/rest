<?php

namespace app\modules\v1\controllers;

use app\modules\v1\models\Task;
use yii\rest\Controller;

/**
 * Default controller for the `v1` module
 */
class TaskController extends Controller
{
    /**
     * @return array
     */
    public function actions()
    {
        $actions = parent::actions();

        // отключить действия "delete", "update", "create", "view"
        unset($actions['delete'], $actions['update'], $actions['create'], $actions['view']);

        return $actions;
    }

    /**
     * Обработчик запросов веб-сервера
     *
     * @param null|integer $id
     * @return array|bool
     */
    public function actionIndex($id = null)
    {
        // Проверяем, передана ли строка поиска и присваем, если передана
        $titleSearch = isset($_GET['title']) ? $_GET['title'] : null;

        //Устанавливаем формат ответа
        $response = \Yii::$app->response;
        $response->format = $response::FORMAT_JSON;

        // Создаем модель для обращения к ее методам (не стал использовать статичные методы)
        $taskModel = new Task();

        // Получаем GET параметры запроса для вывода определенного перечня задач
        $get = \Yii::$app->request->get();
        $start = empty($get['start']) ? 0 : $get['start'];
        $rowsPerPage = \Yii::$app->params['rowsPerPage'];
        $limit = empty($get['limit']) ? (empty($rowsPerPage) ? 0 : $rowsPerPage) : $get['limit'];

        // Возвращаем результат обработки запроса методами модели
        return empty($id) ? $taskModel->getTasks($start, $limit, $titleSearch) : $taskModel->getTask($id);
    }
}
