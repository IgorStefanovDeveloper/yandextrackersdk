<?php

namespace Localtests\Yandextrackersdk\Test\Task;

use Localtests\Yandextrackersdk\Task\Task;
use PHPUnit\Framework\TestCase;

final class TaskTest extends TestCase
{
    public function taskProvider(): array
    {
        return [
            [
                [
                    "summary" => "название задачи",
                    "queue" => [
                        "id" => "111",
                        "key" => "test"
                    ],
                    "parent" => [
                        "id" => "593cd0acef7e8a332414f28e",
                        "key" => "JUNE-2"
                    ],
                    "description" => "текстовое описание",
                    "sprint" => [
                        "id" => "5317"
                    ],
                    "type" => [
                        "id" => "2",
                        "key" => "task"
                    ],
                    "priority" => [
                        "id" => "2",
                        "key" => "normal"
                    ],
                    "followers" => ["login", ["id" => "19904929"]],
                    "assignee" => ["login", ["id" => "19904929"]],
                    "unique" => "123qwe"
                ]
            ]
        ];
    }

    /**
     * @dataProvider taskProvider
     */
    public function testTaskConstructor($taskData)
    {
        $task = new Task($taskData);

        $this->assertEquals($task->getSummery(), $taskData['summary'], 'В созданном объекте некоректные данные');
        $this->assertEquals($task->getDescription(), $taskData['description'], 'В созданном объекте некоректные данные');
        $this->assertEquals($task->getAssignee()->jsonSerialize(), $taskData['assignee'], 'В созданном объекте некоректные данные');
        $this->assertEquals($task->getQueue()->jsonSerialize(), $taskData['queue'], 'В созданном объекте некоректные данные');
    }
}
