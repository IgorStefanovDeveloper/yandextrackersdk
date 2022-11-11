<?php

namespace Localtests\Yandextrackersdk\Employee;

use Localtests\Yandextrackersdk\Environment\SerializableObj;

final class Employee extends SerializableObj
{
    private string $display;

    public function __construct(array $params = [])
    {
        if (is_array($params)) {
            if (isset($params['self'])) $this->setSelf($params['self']);
            if (isset($params['id'])) $this->setId($params['id']);
            if (isset($params['display'])) $this->display = $params['display'];
        }
    }

    public function getDisplay(): string
    {
        return $this->display;
    }

    public function setDisplay(string $value): void
    {
        $this->display = $value;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
