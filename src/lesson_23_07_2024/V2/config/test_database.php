<?php

return [
    'port' => 'mysql',
    'host' => 'MySQL-8.2',
    'dbname' => 'object.oop_test',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'options' => [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        \PDO::MYSQL_ATTR_INIT_COMMAND => "Set names 'utf8'",
    ],
];