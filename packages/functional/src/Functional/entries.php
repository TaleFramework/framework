<?php declare(strict_types=1);

namespace Tale\Functional;

function entries(iterable $items): iterable
{
    foreach ($items as $key => $item) {
        yield [$key, $item];
    }
}
