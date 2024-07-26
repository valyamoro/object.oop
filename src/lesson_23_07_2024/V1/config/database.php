<?php

return [
    'database' => 'mysql',
    'host' => 'MySQL-8.2',
    'database_name' => 'lesson_23_07_2024',
    'charset' => 'utf8',
    'username' => 'root',
    'password' => '',
    'options' => [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    ],
];
