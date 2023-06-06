<?php

namespace lab1\classes;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Employee
{
    public function __construct(protected int $id, protected string $name, protected int $salary, protected string $joinDate)
    {
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addPropertyConstraint('id', new Assert\NotBlank());
        $metadata->addPropertyConstraint(
            'id',
            new Assert\PositiveOrZero()
        );
        $metadata->addPropertyConstraint('name', new Assert\NotBlank());
        $metadata->addPropertyConstraint(
            'name',
            new Assert\Length(['min' => 3])
        );
        $metadata->addPropertyConstraint('salary', new Assert\NotBlank());
        $metadata->addPropertyConstraint(
            'salary',
            new Assert\PositiveOrZero()
        );
        $metadata->addPropertyConstraint('joinDate', new Assert\NotBlank());
        $metadata->addPropertyConstraint(
            'joinDate',
            new Assert\Date()
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSalary(): int
    {
        return $this->salary;
    }

    public function getJoinTime(): string
    {
        return $this->joinDate;
    }

    public function getExperience(): int
    {
        $now = time();
        $datediff = $now - strtotime($this->joinDate);

        return floor($datediff / (60 * 60 * 24 * 365));
    }

    public function printInfo(): void
    {
        echo "id: {$this->id} name: {$this->name} salary: {$this->salary} joinDate: {$this->joinDate}\n";
    }
}
