<?php declare(strict_types=1);

namespace Tale\Functional;

function binary(callable $fn): callable
{
    return arity(2, $fn);
}
