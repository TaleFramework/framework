<?php declare(strict_types=1);

namespace Tale\Functional;

function find_key(callable $fn, iterable $items): int|string|null
{
    foreach ($items as $key => $item) {
        if ($fn($item)) {
            return $key;
        }
    }
    return null;
}
