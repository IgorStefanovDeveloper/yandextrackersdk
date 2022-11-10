<?php

namespace Localtests\Yandextrackersdk\Request;

interface RequestInterface
{
    public function get(string $url, array $parameters = []);

    public function post(string $url, array $parameters = []);

    public function delete(string $url, array $parameters = []);

    public function patch(string $url, array $parameters = []);
}
