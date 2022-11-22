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

    private const OBJ_KEY = ['updatedBy', 'createdBy', 'assignee', 'type', 'status', 'priority', 'queue'];
    private const DATA_KEY = ['statusStartTime', 'createdAt', 'updatedAt'];

    public function __construct(array $params = [])
    {
        $this->updatedBy = new Employee();
        $this->createdBy = new Employee();
        $this->assignee = new Employee();
        $this->queue = new Queue();
        $this->type = new TaskType();
        $this->status = new TaskStatus();
        $this->priority = new TaskPriority();

        $this->statusStartTime = new DateTime();
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
        parent::__construct($params);
    }

    public function init(array $params = []): Task
    {
        $objectKey = ['updatedBy', 'createdBy', 'assignee', 'type', 'status', 'priority', 'queue'];

        $dataKey = ['statusStartTime', 'createdAt', 'updatedAt'];

        foreach ($params as $key => $param) {

            if (in_array($key, self::OBJ_KEY)) {
                /**
                 * SerializableObj $this->$key
                 */
                $this->$key->init($param);
            } elseif (in_array($key, self::DATA_KEY)) {
                /**
                 * DateTime $this->$key
                 */
                $this->$key->createFromFormat(DateTime::ISO8601, $param);
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
                if (in_array($key, self::OBJ_KEY)) {
                    /**
                     * SerializableObj $var
                     */
                    $arr = $var->jsonSerialize();
                    if (!empty($arr)) {
                        $resultArray[$key] = $var->jsonSerialize();
                    }
                } elseif (in_array($key, self::DATA_KEY)) {
                    /*
                     * "errorMessages":["Поля [statusStartTime, created, updated] только для чтения."]
                     */
                    //$resultArray[$key] = $var->format(DateTime::ISO8601);
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

    public function setSummery(string $value)
    {
        $this->summary = $value;
    }

    public function setDescription(string $value)
    {
        $this->description = $value;
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
