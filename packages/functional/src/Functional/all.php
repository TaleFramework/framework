<?php declare(strict_types=1);

namespace Tale\Functional;

function all(callable $fn, iterable $items): bool
{
    foreach ($items as $item) {
        if (!$fn($item)) {
            return false;
        }
    }
    return true;
}
