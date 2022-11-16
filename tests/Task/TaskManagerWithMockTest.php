<?php

namespace Localtests\Yandextrackersdk\Test\Task;

use GuzzleHttp\Exception\GuzzleException;
use Localtests\Yandextrackersdk\Employee\Employee;
use Localtests\Yandextrackersdk\Exception\ForbiddenException;
use Localtests\Yandextrackersdk\Exception\UnauthorizedException;
use Localtests\Yandextrackersdk\Queue\Queue;
use Localtests\Yandextrackersdk\Task\Task;
use Localtests\Yandextrackersdk\Task\TaskManager;
use Localtests\Yandextrackersdk\Request\RequestManager;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

final class TaskManagerWithMockTest extends TestCase
{
    protected TaskManager $taskManager;

    public function requestDataProvider()
    {
        return [['5221186']];
    }

    /**
     * @dataProvider requestDataProvider
     */
    public function testGetTaskCount($tasksCount)
    {
        $requestManagerMock = $this->createMock(RequestManager::class);
        $requestManagerMock->expects($this->any())
            ->method('get')
            ->willReturn($tasksCount);

        $this->taskManager = new TaskManager($requestManagerMock);

        $countTasks = $this->taskManager->getTaskCount();
        $this->assertEquals(5221186, $countTasks, 'Не получилось получить количество задач');
    }
}
