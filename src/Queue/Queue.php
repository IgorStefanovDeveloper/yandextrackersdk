<?php

namespace Localtests\Yandextrackersdk\Queue;

use Localtests\Yandextrackersdk\Environment\SerializableObj;

class Queue extends SerializableObj
{
    private string $key;
    private string $display;

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

}
