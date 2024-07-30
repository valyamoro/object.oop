<?php
declare(strict_types=1);

use App\lesson_23_07_2024\V2\Database\DatabaseConfiguration;
use App\lesson_23_07_2024\V2\Database\DatabasePDOConnection;
use App\lesson_23_07_2024\V2\Database\PDODriver;
use App\lesson_23_07_2024\V2\Router\Router;

require __DIR__ . '/../../../vendor/autoload.php';

$databaseConfig = require __DIR__ . '/config/database.php';

$databaseConfiguration = new DatabaseConfiguration(...$databaseConfig);
$databasePdoConnection = new DatabasePDOConnection($databaseConfiguration);
$pdoDriver = new PDODriver($databasePdoConnection);

$dependenciesConfig = require __DIR__ . '/config/dependencies.php';
$router = new Router($dependenciesConfig, $pdoDriver);

$data = [
    'id' => '5',
    'title' => 'article 2',
    'body' => 'wdqdwdqw',
    'category_id' => '17',
    'user_id' => '18',
];

$result = $router->dispatch('Article', 'delete', $data);

if ($result === null) {
    echo 'Произошла ошибка!';
} else {
    print_r($result);
}
