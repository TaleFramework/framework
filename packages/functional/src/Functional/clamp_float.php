<?php declare(strict_types=1);

namespace Tale\Functional;

use JetBrains\PhpStorm\Pure;

#[Pure]
function clamp_float(float $min, float $max, float $value): float
{
    return (float)max($min, min($value, $max));
}
