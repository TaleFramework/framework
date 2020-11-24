<?php declare(strict_types=1);

namespace Tale\Functional;

/**
 * @template T
 * @param T $value
 * @return T
 */
function id(mixed $value): mixed
{
    return $value;
}
