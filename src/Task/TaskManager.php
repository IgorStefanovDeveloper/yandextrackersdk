<?php

namespace Localtests\Yandextrackersdk\Task;

use GuzzleHttp\RequestOptions;
use Localtests\Yandextrackersdk\Request\RequestInterface;

final class TaskManager implements TaskManagerInterface
{
    private RequestInterface $requestManager;

    public const ISSUE_PATH = '/v2/issues/';

    public function __construct(RequestInterface $requestManager)
    {
        $this->requestManager = $requestManager;
    }

    /**
     * Получить историю изменений задачи
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/get-changelog.html
     * @param string $key ключ задачи
     * @return mixed
     */
    public function getTaskHistory(string $key)
    {
        return $this->requestManager->get(self::ISSUE_PATH . $key . '/changelog');
    }

    /**
     * Получить параметры задачи
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/get-issue.html
     * @param string $key ключ задачи
     * @return array
     */
    public function getTaskByKey(string $key): array
    {
        //TODO
        return $this->requestManager->get(self::ISSUE_PATH . $key);
    }

    /**
     * Получить параметры задачи
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/get-issue.html
     * @param string $key ключ задачи
     * @return Task экземпляр класса задача
     */
    public function getTaskObjByKey(string $key): Task
    {
        $task = new Task($this->requestManager->get(self::ISSUE_PATH . $key));

        return $task;
    }

    /**
     * Узнать количество задач
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/count-issues.html
     * @param $params array параметры фильтрации
     * @return mixed
     */
    public function getTaskCount(array $params = [])
    {
        return $this->requestManager->get(self::ISSUE_PATH . '_count', $params);
    }

    /**
     * Получить связи задачи
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/get-links.html
     * @param string $key ключ задачи
     * @return array
     */
    public function getTaskLinks(string $key): array
    {
        return $this->requestManager->get(self::ISSUE_PATH . $key . "/links");
    }

    /**
     * Создать задачу
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/create-issue.html
     * @param array $params параметры новой задачи
     * @return array новая задача
     */
    public function createTask(array $params = []): array
    {
        return $this->requestManager->post(self::ISSUE_PATH, [RequestOptions::JSON => $params]);
    }

    /**
     * Создать задачу
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/create-issue.html
     * @param array $params параметры новой задачи
     * @return array новая задача
     */
    public function createTaskObj(Task $task): array
    {
        return $this->requestManager->post(self::ISSUE_PATH, [RequestOptions::JSON => $task->jsonSerialize()]);
    }

    /**
     * Редактировать задачу
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/patch-issue.html
     * @param string $key ключ задачи
     * @param array $params измененные параметры задачи
     * @return array
     */
    public function editTask(string $key, array $params = []): array
    {
        //TODO
        return $this->requestManager->patch(self::ISSUE_PATH . $key, [RequestOptions::JSON => $params]);
    }

    /**
     * Редактировать задачу
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/patch-issue.html
     * @param string $key ключ задачи
     * @param array $params измененные параметры задачи
     * @return array
     */
    public function editTaskObj(Task $task): array
    {
        return $this->requestManager->patch(self::ISSUE_PATH . $task->getKey(), [RequestOptions::JSON => $task->jsonSerialize()]);
    }

    /**
     * Перенести задачу в другую очередь
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/move-issue.html
     * @param string $taskKey ключ задачи
     * @param string $queueKey ключ потока в который необходимо перенести задачу
     * @return array
     */
    public function moveTaskToQueue(string $taskKey, string $queueKey): array
    {
        return $this->requestManager->post(self::ISSUE_PATH . $taskKey . "/_move", [RequestOptions::QUERY => ['queue' => $queueKey]]);
    }


    /**
     * Получить переходы
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/get-transitions.html
     * @param string $key ключ задачи
     * @return array
     */
    public function getTaskTransitions(string $key): array
    {
        return $this->requestManager->get(self::ISSUE_PATH . $key . "/transitions");
    }

    /**
     * Получить приоритеты
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/get-priorities.html
     * @return void
     */
    public function getTaskPriorities()
    {
        return $this->requestManager->get("/v2/priorities");
    }

    /**
     * Связать задачи
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/link-issue.html
     * @param string $issueId ключ первой задачи
     * @param string $relationship тип связи
     * @param string $secondIssueId ключ второй задачи
     * @return void
     */
    public function tieTask(string $issueId, string $relationship, string $secondIssueId)
    {
        return $this->requestManager->post(self::ISSUE_PATH . $issueId . "/links?", [RequestOptions::QUERY => ['relationship' => $relationship, 'issue' => $secondIssueId]]);
    }

    /**
     * Найти задачи
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/search-issues.html
     */
    public function findTaskByQuery(array $params = []): array
    {
        $result = [];

        $tasks = $this->requestManager->post(self::ISSUE_PATH . "_search", [RequestOptions::JSON => $params]);


        foreach ($tasks as $task) {
            $result[] = new Task($task);
        }

        return $result;
    }

    /**
     * Найти задачи
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/search-issues.html
     * @param string $queueKey ключ очереди
     * @param int $perPage Количество тикетов на странице. Значение по умолчанию — 50, максимальное значение — 100.
     * @param int $page Номер страницы ответа. Значение по умолчанию — 1.
     * @param array $where Условия фильтра
     * @return array список задач
     */
    public function findTask(string $queueKey, string $perPage = '0', string $page = '1', array $where = []): array
    {
        $result = [];

        $params = ["query" => $queueKey, 'perPage' => $perPage, 'page' => $page];

        if (!empty($where)) {
            $params['filter'] = $where;
        }

        $tasks = $this->requestManager->post(self::ISSUE_PATH . "_search", [RequestOptions::QUERY => $params]);

        foreach ($tasks as $task) {
            $result[] = new Task($task);
        }

        return $result;
    }

    /**
     * Освободить ресурсы просмотра прокрутки
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/search-release.html
     * @param array $params
     * @return array
     */
    public function searchReleaseTasks(string $scrollToken): array
    {
        $this->requestManager->post('/v2/system/search/scroll/_clear', [RequestOptions::QUERY => ['srollId' => $scrollToken]]);
    }

    /**
     * Создать чеклист или добавить в него пункты
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/add-checklist-item.html
     */
    public function createChecklistForTask(string $idIssue, array $params = [])
    {
        return $this->requestManager->post(self::ISSUE_PATH . $idIssue . '/checklistItems', [RequestOptions::JSON => $params]);
    }

    /**
     * Выполнить переход в статус
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/new-transition.html
     */
    public function taskTransitions(string $idIssue, string $transitionId): array
    {
        return $this->requestManager->post(self::ISSUE_PATH . $idIssue . '/transitions/' . $transitionId . '/_execute');
    }
}
