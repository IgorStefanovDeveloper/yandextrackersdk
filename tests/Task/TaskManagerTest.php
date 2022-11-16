<?php

namespace Localtests\Yandextrackersdk\Test\Task;

use Localtests\Yandextrackersdk\Employee\Employee;
use Localtests\Yandextrackersdk\Queue\Queue;
use Localtests\Yandextrackersdk\Task\Task;
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
        $this->assertGreaterThan(0, $this->taskManager->getTaskCount(), 'Не получилось получить количество задач');
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

    /*
    public function testCreateTask()
    {
        //Создать задачу с заголовком, описанием и испольнителем.
        $assignee = new Employee(['id' => getenv('EMPLOYEE_ID'), 'self' => getenv('EMPLOYEE_SELF'), 'display' => getenv('EMPLOYEE_DISPLAY')]);

        $queue = new Queue(["key" => getenv('QUEUE_KEY')]);

        $taskData = [
            'summary' => 'exampleSummary',
            'description' => 'description',
            'assignee' => $assignee,
            'queue' => $queue
        ];

        $task = new Task($taskData);

        $this->assertEquals($task->getSummery(), $taskData['summary'], 'В созданном объекте некоректные данные');
        $this->assertEquals($task->getDescription(), $taskData['description'], 'В созданном объекте некоректные данные');
        $this->assertEquals($task->getAssignee()->jsonSerialize(), $taskData['assignee']->jsonSerialize(), 'В созданном объекте некоректные данные');
        $this->assertEquals($task->getQueue()->jsonSerialize(), $taskData['queue']->jsonSerialize(), 'В созданном объекте некоректные данные');

        $jsonTask = json_encode($task->jsonSerialize());
        $this->assertIsString($jsonTask, 'Неполучилось сформировать json тело для создания задачи');

        //Тест создает новую задачу
        if (false) {
            $result = $this->taskManager->createTask($task->jsonSerialize());

            $this->assertIsArray($result, 'Не получилось создать задачу');
        }
    }
    */

    public function testEditTask()
    {
        $issueKey = getenv('ISSUE_ID');

        $taskData = [
            'summary' => 'exampleSummary from testEditTask11',
            'description' => 'description from testEditTask11',
        ];

        $task = new Task($taskData);

        $task = $this->taskManager->editTask($issueKey, $task->jsonSerialize());

        $this->assertIsArray($task, 'Не получилось изменить задачу');
        $this->assertEquals($taskData['summary'], $task['summary'], 'Не получилось изменить задачу');
        $this->assertEquals($taskData['description'], $task['description'], 'Не получилось изменить задачу');
    }

    public function testMoveTaskToQueue()
    {
        $issueKey = getenv('ISSUE_ID');
        $queueKey = getenv('QUEUE_KEY');
        $queueKeyForMove = getenv('QUEUE_KEY_MOVE');

        $moveTo = $this->taskManager->moveTaskToQueue($issueKey, $queueKeyForMove);

        $this->assertIsArray($moveTo, 'Не удалось переместить задачу');
        $this->assertEquals($moveTo['previousQueue']['key'], $queueKey);

        $moveBack = $this->taskManager->moveTaskToQueue($moveTo['key'], $queueKey);

        $this->assertIsArray($moveBack, 'Не удалось переместить задачу');
        $this->assertEquals($moveBack['key'], $issueKey);
    }

    public function testGetTaskTransitions()
    {
        $issueKey = getenv('ISSUE_ID');

        $transitions = $this->taskManager->getTaskTransitions($issueKey);

        $this->assertIsArray($transitions, 'Не удалось получить переходы задачи');
    }

    public function testGetTaskPriorities()
    {
        $prioritises = $this->taskManager->getTaskPriorities();

        $this->assertIsArray($prioritises, 'Не удалось получить приоритеты задач');
    }
}
