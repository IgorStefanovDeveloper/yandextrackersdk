<?php

namespace Localtests\Yandextrackersdk\Queue;

use Localtests\Yandextrackersdk\Environment\SerializableObj;

class Queue extends SerializableObj
{
    protected string $key;
    protected string $display;

    public function __construct(array $params = [])
    {
        if (is_array($params)) {
            if (isset($params['self'])) $this->setSelf($params['self']);
            if (isset($params['id'])) $this->setId($params['id']);
            if (isset($params['display'])) $this->display = $params['display'];
            if (isset($params['key'])) $this->key = $params['key'];
        }
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

}
