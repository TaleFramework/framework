<?php declare(strict_types=1);

namespace Tale\Functional;

function head(iterable $items)
{
    foreach ($items as $key => $item) {
        return $item;
    }
    return null;
}
