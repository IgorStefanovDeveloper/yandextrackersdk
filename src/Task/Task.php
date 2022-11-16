<?php

namespace Localtests\Yandextrackersdk\Task;

use Localtests\Yandextrackersdk\Employee\Employee;
use Localtests\Yandextrackersdk\Environment\SerializableObj;
use DateTime;
use Localtests\Yandextrackersdk\Queue\Queue;

class Task extends SerializableObj
{
    protected string $key;
    protected int $version;
    protected string $summary;
    protected DateTime $statusStartTime;
    protected ?Employee $updatedBy;
    protected ?string $description = null;
    protected DateTime $createdAt;
    protected Employee $createdBy;
    protected DateTime $updatedAt;
    protected ?Employee $assignee;
    protected TaskType $type;
    protected TaskStatus $status;
    protected TaskPriority $priority;
    protected int $votes;
    protected Queue $queue;

    public function __construct(array $params = [])
    {
        $this->updatedBy = new Employee();
        $this->assignee = new Employee();
        $this->queue = new Queue();
        $this->type = new TaskType();
        $this->status = new TaskStatus();
        $this->priority = new TaskPriority();

        parent::__construct($params);
    }

    public function init(array $params = []): Task
    {
        $objectKey = ['updatedBy', 'createdAt', 'createdBy', 'updatedAt', 'assignee', 'type', 'status', 'priority', 'queue'];
        foreach ($params as $key => $param) {
            if (in_array($key, $objectKey)) {
                /**
                 * SerializableObj $var
                 */
                $this->$key->init($param);
            } else {
                $this->$key = $param;
            }
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
                    $arr = $var->jsonSerialize();
                    if (!empty($arr)) {
                        $resultArray[$key] = $var->jsonSerialize();
                    }
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
