<?php

namespace Localtests\Yandextrackersdk;

use Localtests\Yandextrackersdk\Task\TaskManagerInterface;

final class Tracker
{
    private TaskManagerInterface $taskManager;

    public function __construct(TaskManagerInterface $taskManager)
    {
        $this->taskManager = $taskManager;
    }
}
