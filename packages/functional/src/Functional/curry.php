<?php declare(strict_types=1);

namespace Tale\Functional;

use ReflectionException;
use ReflectionFunction;
use SplObjectStorage;

/**
 * @param callable $fn
 * @return callable
 * @throws ReflectionException
 */
function curry(callable $fn): callable
{
    $reflection = new ReflectionFunction($fn);
    return new CurriedFunction($reflection->getNumberOfParameters(), $fn);
}
