<?php declare(strict_types=1);

namespace Tale\Functional;

function map(callable $fn, iterable $items): iterable
{
    foreach ($items as $key => $item) {
        yield $key => $fn($item);
    }
}
