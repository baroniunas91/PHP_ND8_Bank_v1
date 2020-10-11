<?php
$employees = [
    ['name' => 'Jonas', 'psw' => md5(1234)],
    ['name' => 'Petras', 'psw' => md5(741)],
    ['name' => 'Inga', 'psw' => md5('labas12')]
];

file_put_contents('employeesData.json', json_encode($employees));