<?php

namespace Localtests\Yandextrackersdk\Employee;

final class Employee
{
    private string $self;
    private string $id;
    private string $display;

    public function __construct(array $params = [])
    {
        if(is_array($params)){
            $this->self = $params['self'];
            $this->id = $params['id'];
            $this->display = $params['display'];
        }
    }

    public function getEmployeeDataArray():array {
        return ['self' => $this->self, 'id' => $this->id, 'display' => $this->display];
    }
}
