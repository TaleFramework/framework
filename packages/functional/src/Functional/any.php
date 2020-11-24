<?php declare(strict_types=1);

namespace Tale\Functional;

function any(callable $fn, iterable $items): bool
{
    foreach ($items as $item) {
        if ($fn($item)) {
            return true;
        }
    }
    return false;
}
