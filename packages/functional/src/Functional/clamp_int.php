<?php declare(strict_types=1);

namespace Tale\Functional;

use JetBrains\PhpStorm\Pure;

#[Pure]
function clamp_int(int $min, int $max, int $value): int
{
    return (int)max($min, min($value, $max));
}
