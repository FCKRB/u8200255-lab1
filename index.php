<?php

namespace lab1\classes;

require 'vendor/autoload.php';

use Symfony\Component\Validator\Validation;

$validator = Validation::createValidatorBuilder()
    ->addMethodMapping('loadValidatorMetadata')
    ->getValidator();

$em1 = new Employee(1, 'Anton', 1000, "2020-01-01");
$em2 = new Employee(2, 'Andrey', 1000, "2022-02-02");
$em3 = new Employee(3, 'Igor', 1000, "2022-03-03");

$em4 = new Employee(4, 'Yuriy', 4000, "2022-04-04");
$em5 = new Employee(5, 'Vladimir', 3000, "2022-05-05");
$em6 = new Employee(6, 'Denis', 2000, "2022-06-06");

// for validate test
$em7 = new Employee(-1, 'A', -1000, "2-06");

$ems = [$em1, $em2, $em3, $em4, $em5, $em6, $em7];
foreach ($ems as $em) {
    $errors = $validator->validate($em);
    if (count($errors) > 0) {
        $errorsString = (string) $errors;
        echo "{$errorsString}\n";
    } else {
        echo "The em{$em->getId()} is valid!\n";
    }
}

echo "em1, experience: {$em1->getExperience()} years\n";
echo "em2, experience: {$em2->getExperience()} years\n";

$dp1 = new Department([$em1,$em2,$em3], 'front');
$dp2 = new Department([$em4,$em5,$em6], 'back');


// найдем минимальную и максимальную зарплату среди отделов
$dps = [$dp1, $dp2];
$salaries = [];
foreach ($dps as &$dp) {
    $salaries[] = $dp->salariesAmount();
}
$minSalary = min($salaries);
$maxSalary = max($salaries);

// найдем отделы с максимальной и минимальной зарплатой
$minDps = $maxDps = [];
for ($i = 0; $i < count($salaries); $i++) {
    if ($salaries[$i] == $minSalary) {
        $minDps[] = $i;
    }
    if ($salaries[$i] == $maxSalary) {
        $maxDps[] = $i;
    }
}


echo("Department with the lowest salary:\n");
// если таких отделов много, выведем тот отдел, который имеет большее сотрудников
if (count($minDps) > 1) {
    // найдем максимальное кол-во сотрудников в отделах
    $maxEmployees = 0;
    foreach ($minDps as $i) {
        $current = $dps[$i]->employeesAmount();
        $maxEmployees = $current > $maxEmployees ? $current : $maxEmployees;
    }

    // найдем отделы с максимальным числом сотрудников
    $result = [];
    foreach ($minDps as $i) {
        $current = $dps[$i]->employeesAmount();
        if ($current == $maxEmployees) {
            $result[] = $i;
        }
    }

    foreach ($result as $i) {
        $dps[$i]->printInfo();
    }
} else {
    foreach ($minDps as $i) {
        $dps[$i]->printInfo();
    }
}

// аналогично с предыдущим if
echo("Department with the highest salary:\n");
if (count($maxDps) > 1) {
    $maxEmployees = 0;
    foreach ($maxDps as $i) {
        $current = $dps[$i]->employeesAmount();
        $maxEmployees = $current > $maxEmployees ? $current : $maxEmployees;
    }

    $result = [];
    foreach ($maxDps as $i) {
        $current = $dps[$i]->employeesAmount();
        if ($current == $maxEmployees) {
            $result[] = $i;
        }
    }

    foreach ($result as $i) {
        $dps[$i]->printInfo();
    }
} else {
    foreach ($maxDps as $i) {
        $dps[$i]->printInfo();
    }
}
