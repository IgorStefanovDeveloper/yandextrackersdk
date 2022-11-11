<?php

namespace Localtests\Yandextrackersdk\Task;

use Localtests\Yandextrackersdk\Request\RequestInterface;

final class TaskManager implements TaskManagerInterface
{
    private RequestInterface $requestManager;

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

    public function editTask()
    {
    }

    /**
     * Получить историю изменений задачи
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/get-changelog.html
     * @param string $key
     * @return mixed
     */
    public function getTaskHistory(string $key)
    {
        return $this->requestManager->get('/v2/issues/' . $key . '/changelog');
    }

    /**
     * Получить параметры задачи
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/get-issue.html
     * @param string $key
     * @return array
     */
    public function getTaskByKey(string $key): array
    {
        return $this->requestManager->get('/v2/issues/' . $key);
    }

    /**
     * Узнать количество задач
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/count-issues.html
     * @param $params array параметры фильтрации
     * @return mixed
     */
    public function getTaskCount($params = [])
    {
        return $this->requestManager->get('/v2/issues/_count', $params);
    }

    /**
     * Получить связи задачи
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/get-links.html
     * @param string $key
     * @return array
     */
    public function getTaskLinks(string $key): array
    {
        return $this->requestManager->get('/v2/issues/' . $key . "/links");
    }

    /**
     * Создать задачу
     * https://yandex.ru/dev/connect/tracker/api/concepts/issues/create-issue.html
     * @param array $params
     * @return array
     */
    public function createTask(array $params = []): array
    {
        return $this->requestManager->post('/v2/issues/', $params);
    }
}

/*
 * TODO
 * https://yandex.ru/dev/connect/tracker/api/concepts/issues/patch-issue.html
 * https://yandex.ru/dev/connect/tracker/api/concepts/issues/move-issue.html
 * https://yandex.ru/dev/connect/tracker/api/concepts/issues/search-issues.html
 * https://yandex.ru/dev/connect/tracker/api/concepts/issues/search-release.html
 * https://yandex.ru/dev/connect/tracker/api/concepts/issues/get-priorities.html
 * https://yandex.ru/dev/connect/tracker/api/concepts/issues/link-issue.html
 * https://yandex.ru/dev/connect/tracker/api/concepts/issues/add-checklist-item.html
 * https://yandex.ru/dev/connect/tracker/api/concepts/issues/get-transitions.html
 * https://yandex.ru/dev/connect/tracker/api/concepts/issues/new-transition.html
 */
