<?php

namespace App\Kernel;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use ReflectionNamedType;

class ObjectFactory
{
    /**
     * Create an instance of a class and inject its dependencies
     *
     * @param string $class The class name
     * @param array $parameters Additional parameters to be passed to the class constructor
     *
     * @return object The created instance
     *
     * @throws ReflectionException
     */
    public static function createInstance(string $class, array $parameters = []): object
    {
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if (!$constructor) {
            return new $class();
        }

        $dependencies = self::resolveDependencies($constructor, $parameters);

        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * Resolve dependencies for a class constructor
     *
     * @param ReflectionMethod $constructor The constructor method reflection
     * @param array $parameters Additional parameters to be passed to the constructor
     *
     * @return array The resolved dependencies
     *
     * @throws ReflectionException
     */
    private static function resolveDependencies(ReflectionMethod $constructor, array $parameters = []): array
    {
        $dependencies = [];

        foreach ($constructor->getParameters() as $parameter) {
            if (array_key_exists($parameter->getName(), $parameters)) {
                // Check if the parameter value is provided in the $parameters array
                $dependencies[] = $parameters[$parameter->getName()];
            } elseif ($parameter->isDefaultValueAvailable()) {
                // If the parameter has a default value, use the default value
                $dependencies[] = $parameter->getDefaultValue();
            } else {
                // Resolve the dependency recursively
                $dependencyClass = $parameter->getType();

                if (!($dependencyClass instanceof ReflectionNamedType)) {
                    throw new ReflectionException("Unable to resolve dependency for parameter: " . $parameter->getName());
                }

                $dependencies[] = self::createInstance($dependencyClass->getName(), $parameters);
            }
        }

        return $dependencies;
    }
}
