<?php declare(strict_types=1);

namespace Tale\Functional;

function get_key($key, iterable $items): MaybeInterface
{
    foreach ($items as $itemKey => $item) {
        if ($itemKey === $key) {
            return some($item);
        }
    }
    return none();
}
