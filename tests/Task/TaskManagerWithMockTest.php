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

    public function requestTieTaskDataProvider()
    {
        return [[
            [
                "self" => "https://api.tracker.yandex.net/v2/issues/TEST-1/links/1048570",
                "id" => 1048570,
                "type" => [
                    "self" => "https://api.tracker.yandex.net/v2/linktypes/relates",
                    "id" => "relates",
                    "inward" => "relates",
                    "outward" => "relates"
                ],
                "direction" => "inward",
                "object" => [
                    "self" => "https://api.tracker.yandex.net/v2/issues/STARTREK-2",
                    "id" => "4ff3e8dae4b0e2ac27f6eb43",
                    "key" => "TREK-2",
                    "display" => "NEW!!!"
                ],
                "createdBy" => [
                    "self" => "https://api.tracker.yandex.net/v2/users/1120000000004859",
                    "id" => "<id сотрудника>",
                    "display" => "<отображаемое имя сотрудника>"
                ],
                "updatedBy" => [
                    "self" => "https://api.tracker.yandex.net/v2/users/1120000000049224",
                    "id" => "<id сотрудника>",
                    "display" => "<отображаемое имя сотрудника>"
                ],
                "createdAt" => "2014-06-18T12:06:02.401+0000",
                "updatedAt" => "2014-06-18T12:06:02.401+0000"
            ]
        ]];
    }

    /**
     * @dataProvider requestTieTaskDataProvider
     */
    public function testTieTask($tieResult)
    {
        $requestManagerMock = $this->createMock(RequestManager::class);
        $requestManagerMock->expects($this->any())
            ->method('post')
            ->willReturn($tieResult);

        $this->taskManager = new TaskManager($requestManagerMock);

        $tieTasks = $this->taskManager->tieTask('TEST-1', 'relates', 'TREK-2');

        $this->assertIsArray($tieTasks, 'Не получилось cвязать задачи');
        $this->assertEquals('TREK-2', $tieTasks["object"]["key"]);
    }

    public function checklistDataProvider()
    {
        return [[
            [
                "self" => "https://api.tracker.yandex.net/v2/issues/ORG-3",
                "id" => "5f981c00b982f0755dbdc13d",
                "key" => "ORG-3",
                "summary" => "Название задачи",
                "description" => "Описание задачи",
                "checklistItems" => [
                    [
                        "id" => "5fde5f0a1aee261dd3b62edb",
                        "text" => "пункт чеклиста",
                        "textHtml" => "текст пункта в формате HTML",
                        "checked" => false,
                        "checklistItemType" => "standard"
                    ]
                ],
            ]
        ]];
    }

    /**
     * @dataProvider checklistDataProvider
     */
    public function testCreateChecklistForTask($checklist)
    {
        $requestManagerMock = $this->createMock(RequestManager::class);
        $requestManagerMock->expects($this->any())
            ->method('post')
            ->willReturn($checklist);

        $this->taskManager = new TaskManager($requestManagerMock);

        $issueId = "ORG-3";

        $checklistData = [
            [
                "text" => "пункт чеклиста",
                "checked" => false,
            ]
        ];

        $createCheckList = $this->taskManager->createChecklistForTask($issueId, $checklist);

        $this->assertCount(1, $createCheckList["checklistItems"]);
        $this->assertEquals($issueId, $createCheckList["key"]);
        $this->assertEquals($checklistData[0]['text'], $createCheckList["checklistItems"][0]['text']);
        $this->assertEquals($checklistData[0]['checked'], $createCheckList["checklistItems"][0]['checked']);
    }
}
