<?php

namespace Localtests\Yandextrackersdk\Test\Employee;

use Localtests\Yandextrackersdk\Employee\Employee;
use PHPUnit\Framework\TestCase;

final class EmployeeTest extends TestCase
{
    protected Employee $employee;

    protected array $data;

    protected function setUp(): void
    {
        $this->data = [
            'id' => getenv('EMPLOYEE_ID'),
            'self' => getenv('EMPLOYEE_SELF'),
            'display' => getenv('EMPLOYEE_DISPLAY')
        ];

        $this->employee = new Employee($this->data);
    }

    public function testJsonSerialize()
    {
        $this->assertEquals(json_encode($this->employee->jsonSerialize()), json_encode($this->data));
    }


}
