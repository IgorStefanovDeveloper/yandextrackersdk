<?php

namespace Localtests\Yandextrackersdk\Task;

use Localtests\Yandextrackersdk\Environment\SerializableObj;

class TaskType extends SerializableObj
{
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
