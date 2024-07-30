<?php
declare(strict_types=1);

namespace App\lesson_23_07_2024\V2\Router;

class Router
{
    public function __construct(private readonly array $configDependencies) {}

    private function resolve(string $className): ?object
    {
        if (isset($this->configDependencies[$className])) {
            $classConfig = $this->configDependencies[$className];

            $dependencies = array_map(function ($dependency) {
                return $this->resolve($dependency);
            }, $classConfig['dependencies'] ?? []);

            $parameters = $classConfig['parameters'] ?? [];

            $constructorArgs = array_merge($dependencies, $parameters);

            return new $className(...$constructorArgs);
        }

        return null;
    }

    public function dispatch(
        string $className,
        string $actionName,
        array $post,
    ): mixed
    {
        $controller = $this->resolve($className);

        return $controller->$actionName($post);
    }

}
