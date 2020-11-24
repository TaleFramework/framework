<?php declare(strict_types=1);

namespace Tale\Functional;

use Generator;

function tail(iterable $items): Generator
{
    $first = true;
    foreach ($items as $key => $item) {
        if ($first) {
            $first = false;
            continue;
        }
        yield $key => $item;
    }
}
