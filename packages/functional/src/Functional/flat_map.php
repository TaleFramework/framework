<?php declare(strict_types=1);

namespace Tale\Functional;

function flat_map(callable $fn, iterable $items): iterable
{
    return flat(map($fn, $items));
}
