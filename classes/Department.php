<?php

namespace lab1\classes;

class Department
{
    public function __construct(protected array $employees, protected string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function salariesAmount(): int
    {
        $sum = 0;
        foreach ($this->employees as $employee) {
            $sum += $employee->getSalary();
        }

        return $sum;
    }

    public function employeesAmount(): int
    {
        return count($this->employees);
    }

    public function printInfo(): void
    {
        foreach ($this->employees as $employee) {
            $employee->printInfo();

        }
    }
}
