<?php

namespace Localtests\Yandextrackersdk;

use GuzzleHttp\Client;
use Localtests\Yandextrackersdk\Request\RequestManager;
use Localtests\Yandextrackersdk\Task\TaskManager;
use Localtests\Yandextrackersdk\Task\TaskManagerInterface;

final class Tracker
{
    public TaskManagerInterface $taskManager;

    public function __construct(string $token, string $orgId)
    {
        $client = new Client();
        $requestManager = new RequestManager($client, $token, $orgId);
        $this->taskManager = new TaskManager($requestManager);
    }
}
