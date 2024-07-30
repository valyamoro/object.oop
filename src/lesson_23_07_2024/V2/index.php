<?php
declare(strict_types=1);

use App\lesson_23_07_2024\V2\Router\Router;

require __DIR__ . '/../../../vendor/autoload.php';

$dependenciesConfig = require __DIR__ . '/config/dependencies.php';
$router = new Router($dependenciesConfig);

$data = [
    'id' => '1',
    'name' => 'role_1',
];

try {
    $result = $router->dispatch(
        App\lesson_23_07_2024\V2\Controllers\RoleController::class,
        'show',
        $data,
    );

    print_r($result);
} catch (\Exception $exception) {
    echo $exception->getMessage() . ' : ' . $exception->getCode();
}
