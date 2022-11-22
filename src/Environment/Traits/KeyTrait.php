<?php

namespace Localtests\Yandextrackersdk\Environment\Traits;

trait KeyTrait
{
    protected string $key;

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $value): void
    {
        $this->key = $value;
    }
}
