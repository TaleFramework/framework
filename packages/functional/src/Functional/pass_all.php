<?php declare(strict_types=1);

namespace Tale\Functional;

/**
 * @template T
 *
 * @param iterable<T> $fns
 * @return callable
 */
function pass_any(iterable $fns): callable
{
    return static function (mixed $value) use ($fns) {
        foreach ($fns as $fn) {
            if (!$fn($value)) {
                return false;
            }
        }
        return true;
    };
}
