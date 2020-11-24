<?php declare(strict_types=1);

namespace Tale\Functional;

function key_equals($key, $value, iterable $items): bool
{
    foreach ($items as $itemKey => $item) {
        if ($itemKey === $key && $item === $value) {
            return true;
        }
    }
    return false;
}

