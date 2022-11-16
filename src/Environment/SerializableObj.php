<?php

namespace Localtests\Yandextrackersdk\Environment;

use JsonSerializable;
use Localtests\Yandextrackersdk\Environment\Traits\IdTrait;
use Localtests\Yandextrackersdk\Environment\Traits\SelfTrait;

abstract class SerializableObj implements JsonSerializable
{
    use IdTrait;
    use SelfTrait;

    abstract function jsonSerialize(): mixed;

    public function __construct(array $params = [])
    {
        $this->init($params);
    }

    public function init(array $params){
        foreach ($params as $key => $param){
            $this->$key = $param;
        }
    }
}
