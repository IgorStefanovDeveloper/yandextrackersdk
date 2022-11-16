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

    public function searchTask($params = [])
    {
    }

    public function deleteTask()
    {
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
        return $this->requestManager->get(self::ISSUE_PATH . $key);
    }

    /**
     * Узнать количество задач
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/count-issues.html
     * @param $params array параметры фильтрации
     * @return mixed
     */
    public function getTaskCount($params = [])
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
     * Редактировать задачу
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/patch-issue.html
     * @param string $key ключ задачи
     * @param array $params измененные параметры задачи
     * @return array
     */
    public function editTask(string $key, array $params = []): array
    {
        return $this->requestManager->patch(self::ISSUE_PATH . $key, [RequestOptions::JSON => $params]);
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
     public function getTaskPriorities(){
         return $this->requestManager->get("/v2/priorities");
     }

//https://yandex.ru/dev/connect/tracker/api/concepts/issues/link-issue.html



}

/*
 * TODO
 * https://yandex.ru/dev/connect/tracker/api/concepts/issues/search-issues.html
 * https://yandex.ru/dev/connect/tracker/api/concepts/issues/search-release.html
 * https://yandex.ru/dev/connect/tracker/api/concepts/issues/add-checklist-item.html
 * https://yandex.ru/dev/connect/tracker/api/concepts/issues/new-transition.html
 */
