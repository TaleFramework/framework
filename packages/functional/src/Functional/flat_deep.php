<?php declare(strict_types=1);

namespace Tale\Functional;

function flat_deep(iterable $items): iterable
{
    foreach ($items as $item) {
        if (is_iterable($item)) {
            yield from flat_deep($item);
            continue;
        }
        yield $item;
    }
}
