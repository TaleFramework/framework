<?php declare(strict_types=1);

namespace Tale\Functional;

function pop(callable $fn, iterable $items)
{
    $array = unwind($items);
    $item = array_pop($array);
    return $fn($item, $array);
}
