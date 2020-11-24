<?php declare(strict_types=1);

namespace Tale\Functional;

function shift(callable $fn, iterable $items)
{
    $array = unwind($items);
    $item = array_shift($array);
    return $fn($item, $array);
}
