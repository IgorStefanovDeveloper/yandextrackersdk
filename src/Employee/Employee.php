<?php

namespace Localtests\Yandextrackersdk\Employee;

use Localtests\Yandextrackersdk\Environment\SerializableObj;

final class Employee extends SerializableObj
{
    protected string $display;

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
