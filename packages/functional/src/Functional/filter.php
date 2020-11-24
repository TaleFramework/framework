<?php declare(strict_types=1);

namespace Tale\Functional;

function filter(callable $fn, iterable $items): iterable
{
    foreach ($items as $item) {
        if ($fn($item)) {
            yield $item;
        }
    }
}
