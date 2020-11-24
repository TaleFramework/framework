<?php declare(strict_types=1);

namespace Tale\Functional;

use ReflectionClass;
use ReflectionException;

/**
 * Creates a function that creates a new object from a class name.
 *
 * The function will make sure the returning function has the same arity as the constructor
 * of the class.
 *
 * ```
 * $createUser = construct(User::class);
 * $createUser('Torben', 'Köhn')
 * ```
 *
 * @param string $className
 * @return callable
 * @throws ReflectionException
 */
function construct(string $className): callable
{
    $reflection = new ReflectionClass($className);
    $ctor = $reflection->getConstructor();
    $paramCount = $ctor ? $ctor->getNumberOfParameters() : 0;
    return arity($paramCount, fn (...$args) => new $className(...$args));
}
