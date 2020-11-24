<?php declare(strict_types=1);

namespace Tale\Functional;

use JetBrains\PhpStorm\Pure;

#[Pure]
function is_placeholder($value): bool
{
    return is_object($value) && $value instanceof Placeholder;
}
