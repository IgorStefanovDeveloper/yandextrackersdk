<?php

namespace Localtests\Yandextrackersdk\Task;

interface TaskManagerInterface
{
    public function getTaskHistory(string $key);

    public function getTaskByKey(string $key);

    public function getTaskCount(array $params = []);

    public function getTaskLinks(string $key);

    public function getTaskObjByKey(string $key);

    public function createTask(array $params = []);

    public function editTask(string $key, array $params = []);

    public function moveTaskToQueue(string $taskKey, string $queueKey);

    public function getTaskTransitions(string $key);

    public function getTaskPriorities();

    public function tieTask(string $issueId, string $relationship, string $secondIssueId);

    public function findTaskByQuery(array $params = []);

    public function findTask(string $queueKey, string $perPage = '0', string $page = '1', array $where = []);

    public function searchReleaseTasks(string $scrollToken);

    public function createChecklistForTask(string $idIssue, array $params = []);

    public function taskTransitions(string $idIssue, string $transitionId);
}
