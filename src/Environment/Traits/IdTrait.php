<?php

namespace Localtests\Yandextrackersdk\Environment\Traits;

trait IdTrait
{
    protected string $id;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $value): void
    {
        $this->id = $value;
    }
}
