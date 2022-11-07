<?php

namespace Localtests\Yandextrackersdk\Task;

interface TaskManagerInterface
{
    public function createTask();

    public function searchTask($params = []);

    public function deleteTask();

    public function editTask();

    public function getTaskCount($params = []);
}
