<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Router;

use App\lesson_23_07_2024\V1\Models\Model;
use App\lesson_23_07_2024\V2\Collections\Collection;
use App\lesson_23_07_2024\V2\Database\PDODriver;

class Router
{
    public function __construct(
        private readonly array $configDependencies,
        private readonly PDODriver $PDODriver,
    ) {}

    private function resolve(string $className): ?object
    {
        if (isset($this->configDependencies[$className])) {
            $dependencies = array_map(function ($dependency) {
                if ($dependency === PDODriver::class) {
                    return $this->PDODriver;
                }

                return $this->resolve($dependency);
            }, $this->configDependencies[$className]['dependencies']);

            return new $className(...$dependencies);
        }

        return null;
    }

    public function dispatch(string $className, string $actionName, array $post): mixed
    {
        $controllerClass = 'App\lesson_23_07_2024\V2\Controllers\\' . $className . 'Controller';

        $controller = $this->resolve($controllerClass);

        return $controller->$actionName($post);
    }

}
