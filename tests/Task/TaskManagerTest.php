<?php

namespace Localtests\Yandextrackersdk\Test\Task;

use Localtests\Yandextrackersdk\Task\TaskManager;
use Localtests\Yandextrackersdk\Request\RequestManager;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

final class TaskManagerTest extends TestCase
{
    protected TaskManager $taskManager;

    protected function setUp(): void
    {
        $token = getenv('API_TOKEN');
        $orgId = getenv('ORG_ID');

        $client = new Client();
        $requestManager = new RequestManager($client, $token, $orgId);
        $this->taskManager = new TaskManager($requestManager);
    }

    public function testGetTaskCount()
    {
        $this->assertGreaterThan(0, $this->taskManager->getTaskCount(), 'Не получилось получить количество задач'); // больше чем
    }

    public function testGetTaskByKey()
    {
        $issueKey = getenv('ISSUE_ID');
        $taskArray = $this->taskManager->getTaskByKey($issueKey);
        $this->assertIsArray($taskArray, 'Не получилось получить задачу');
        $this->assertEquals($issueKey, $taskArray['key'], 'Не получилось получуть нужную задачу, ключи не совпадают');
    }

    public function testGetTaskHistory()
    {
        $issueKey = getenv('ISSUE_ID');
        $history = $this->taskManager->getTaskHistory($issueKey);
        $this->assertIsArray($history, 'Не получилось получить историю задачи');
        $this->assertEquals($issueKey, $history[0]['issue']['key'], 'Не получилось получить нужную задачу, ключи не совпадают');
    }

    public function testGetLinks()
    {
        $issueKey = getenv('ISSUE_ID');
        $links = $this->taskManager->getTaskLinks($issueKey);
        $this->assertIsArray($links, 'Не получилось получить ссылки задачи');
    }
}
