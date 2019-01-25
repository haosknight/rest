<?php
namespace app\modules\v1\models;

use Yii;
use yii\base\Model;

/**
 * Модель предназначенная для предоставления данных о задачах
 */
class Task extends Model
{
    public $id;
    public $title;
    public $date;
    public $author;
    public $status;
    public $description;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'title', 'date', 'author', 'status', 'description'], 'require'],
            ['id', 'integer'],
        ];
    }


    /**
     * Метод формирует массив моделей с задачами
     *
     * @return array
     */
    protected function getAllTasks()
    {
        // Если кэш задач пуст
        if (!Yii::$app->cache->get('tasks')) {
            $tasks = [];
            // Генерация списка задач - "трудоемкая операция",
            for($c=1;$c<=1000;$c++) {
                $task = new Task;
                $task->id = $c;
                $task->title = 'Задача '.$c;
                $task->date = 'Текущая дата + '.$c.' часов';
                $task->author = 'Автор '.$c;
                $task->status = 'Статус '.$c;
                $task->description = 'Описание '.$c;
                array_push($tasks, $task);
            }
            // поэтому записываем в кэш результаты генерации на 59 минут.
            // Перечень задач обновляется не чаще одного раза в час, поэтому для
            // поддержки актуальности данных выбран период хранения данных в кеше - 59 минут.
            Yii::$app->cache->set('tasks',$tasks, 60 * 59);
        } else {
            // Если задачи в кеше, то возвращаем из кэша
            $tasks = Yii::$app->cache->get('tasks');
        }

        return $tasks;
    }

    /**
     * Метод формирует перечень задач в зависимости от запроса
     *
     * @param int $start Стартовая задача
     * @param int $limit Количество задач
     * @param null $titleSearch Поисковый запрос
     *
     * @return array
     */
    public function getTasks($start = 0, $limit = 0, $titleSearch = null) {
        // Получаем полный перечень задач
        $allTasks = $this->getAllTasks();
        // Пустой массив для последующего наполнения задачами удовлетворяющими запросу
        $tasks = [];
        // Если лимит не установлен, то выводим все задачи
        if ($limit === 0) $limit = count($allTasks);

        $count = 0;
        foreach ($allTasks as $task) {
            // Добавляем задачу при условии отсутствия поискового запроса, либо удовлетворения поисковому запросу
            if (empty($titleSearch) || mb_stripos($task->title, $titleSearch) !== false) {
                $count++;
                // Проверяем по счетчику достижение стартовой задачи
                if ($count>$start) {
                    // Проверяем по счетчику достижения лимита задач
                    if ($count<=$limit+$start) {
                        // Добавляем задачу в массив при удовлетворении всем условиям
                        array_push($tasks, [
                            'id' => $task->id,
                            'title' => $task->title,
                            'date' => $task->date,
                        ]);
                    }
                }
            }
        }

        return ["success" => true, "totalCount" => $count, "tasks" => $tasks];
    }

    /**
     * Метод формирует и возвращает информацию о задачи по ее идентификатору
     *
     * @param integer $id Идентификатор задачи
     * @return array|bool
     */
    public function getTask($id) {
        // Получаем полный перечень задач
        $allTasks = $this->getAllTasks();
        //$task = $allTasks[$id-1]; //Можно было сделать так, но я решил делать через идентификатор
        $task = [];

        // Находим задачу по идентификатору
        foreach ($allTasks as $t) {
            if ($t['id'] == $id) {
                $task = $t;
            }
        }

        // Если задача отсутствует - сообщаем об этом
        if (empty($task)) {
            Yii::$app->session->setFlash('danger', 'Идентификатор задачи находиться вне диапазона');
            return false;
        }

        return ["success" => true, "totalCount" => count($allTasks), "tasks" => [$task]];
    }
}
