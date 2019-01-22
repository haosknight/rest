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
     * Метод формирует массив моделей
     * @return array
     */
    protected function getAllTasks()
    {
        if (!Yii::$app->cache->get('tasks')) {
            $tasks = [];
            // Генерация списка задач - трудоемкая операция,
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
            // поэтому записываем в кеш результаты генерации на 59 минут.
            // Перечень задач обновляется не чаще одного раза в час, поэтому для
            // поддержки актуальности данных выбран период хранения данных в кеше - 59 минут.
            Yii::$app->cache->set('tasks',$tasks, 60 * 59);
        } else {
            $tasks = Yii::$app->cache->get('tasks');
        }

        return $tasks;
    }

    /**
     * @return array
     */
    public function getTasks() {
        $allTasks = $this->getAllTasks();
        $tasks = [];
        foreach ($allTasks as $task) {
            array_push($tasks, [
                'id' => $task->id,
                'title' => $task->title,
                'date' => $task->date,
            ]);
        }
        return $tasks;
    }

    /**
     * @param $id integer
     *
     * @return array|bool
     */
    public function getTask($id) {
        $allTasks = $this->getAllTasks();
        //$task = $allTasks[$id-1]; //Можно было сделать так, но я решил делать через идентификатор
        $task = [];
        foreach ($allTasks as $t) {
            if ($t['id'] = $id) {
                $task = $t;
            }
        }
        if (empty($task)) {
            Yii::$app->session->setFlash('danger', 'Идентификатор задачи находиться вне диапазона');
            return false;
        }
        return $task;
    }
}
