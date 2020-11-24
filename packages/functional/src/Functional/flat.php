<?php declare(strict_types=1);

namespace Tale\Functional;

use Generator;
use JetBrains\PhpStorm\Pure;

#[Pure]
function flat(iterable $items): Generator
{
    foreach ($items as $item) {
        if (is_iterable($item)) {
            yield from $item;
            continue;
        }
        yield $item;
    }
}
