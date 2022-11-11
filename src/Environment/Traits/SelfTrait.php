<?php

namespace Localtests\Yandextrackersdk\Environment\Traits;

trait SelfTrait
{
    protected string $self;

    public function getSelf(): string
    {
        return $this->self;
    }

    public function setSelf(string $value): void
    {
        $this->self = $value;
    }
}
