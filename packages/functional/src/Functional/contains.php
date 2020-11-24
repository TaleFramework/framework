<?php declare(strict_types=1);

namespace Tale\Functional;

function contains($value, iterable $items): bool
{
    foreach ($items as $item) {
        if ($item === $value) {
            return true;
        }
    }
    return false;
}
