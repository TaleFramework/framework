<?php declare(strict_types=1);

namespace Tale\Functional;

function cond_and(mixed $lhs, mixed $rhs): bool
{
    return $lhs && $rhs;
}
