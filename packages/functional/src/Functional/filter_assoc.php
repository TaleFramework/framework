<?php declare(strict_types=1);

namespace Tale\Functional;

function filter_assoc(callable $fn, iterable $items): iterable
{
    foreach ($items as $key => $item) {
        if ($fn($item)) {
            yield $key => $item;
        }
    }
}
