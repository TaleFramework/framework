<?php declare(strict_types=1);

namespace Tale\Functional;

function either(callable $lhs, callable $rhs)
{
    return fn ($value) => $lhs($value) || $rhs($value);
}
