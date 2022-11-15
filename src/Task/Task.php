<?php

namespace Localtests\Yandextrackersdk\Task;

use Localtests\Yandextrackersdk\Employee\Employee;
use Localtests\Yandextrackersdk\Environment\SerializableObj;
use DateTime;
use Localtests\Yandextrackersdk\Queue\Queue;

class Task extends SerializableObj
{
    private string $key;
    private int $version;
    private string $summary;
    private DateTime $statusStartTime;
    private ?Employee $updatedBy;
    private ?string $description = null;
    private DateTime $createdAt;
    private Employee $createdBy;
    private DateTime $updatedAt;
    private ?Employee $assignee;
    private TaskType $type;
    private TaskStatus $status;
    private TaskPriority $priority;
    private int $votes;
    private Queue $queue;

    public function __construct(array $params = [])
    {
        $this->createTask($params);
    }

    public function createTask(array $params = []): Task
    {
        foreach ($params as $key => $param) {
            $this->$key = $param;
        }

        return $this;
    }

    public function jsonSerialize(): mixed
    {
        $resultArray = [];

        foreach (get_object_vars($this) as $key => $var) {
            if (isset($var)) {
                if (is_object($var)) {
                    /**
                     * SerializableObj $var
                     */
                    $resultArray[$key] = $var->jsonSerialize();
                } else {
                    $resultArray[$key] = $var;
                }
            }
        }

        return $resultArray;
    }

    public function getSummery(): string
    {
        return $this->summary;
    }

    public function getDescription(): string
    {
        return $this->description;
    }


    public function getAssignee(): Employee
    {
        return $this->assignee;
    }

    /**
     * @return Queue
     */
    public function getQueue(): Queue
    {
        return $this->queue;
    }
}
