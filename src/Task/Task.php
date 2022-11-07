<?php

namespace Localtests\Yandextrackersdk\Task;

use Localtests\Yandextrackersdk\Employee\Employee;
use DateTime;

class Task
{
    private string $self;
    private string $id;
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
    public function __construct(array $params = []){

    }
    /**
     * TODO
     *
     * private ?Employee $assignee;
     *
     * type Array
     * (
     * [self] => https://api.tracker.yandex.net/v2/issuetypes/2
     * [id] => 2
     * [key] => task
     * [display] => Задача
     * )
     * priority Array
     * (
     * [self] => https://api.tracker.yandex.net/v2/priorities/3
     * [id] => 3
     * [key] => normal
     * [display] => Средний
     * )
     * commentWithoutExternalMessageCount ??
     * votes int
     * queue Array
     * (
     * [self] => https://api.tracker.yandex.net/v2/queues/ORG
     * [id] => 1
     * [key] => ORG
     * [display] => org-igor-programm
     * )
     * status Array
     * (
     * [self] => https://api.tracker.yandex.net/v2/statuses/1
     * [id] => 1
     * [key] => open
     * [display] => Открыт
     * )
     * favorite false
     */
}
