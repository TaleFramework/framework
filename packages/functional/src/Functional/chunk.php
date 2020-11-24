<?php declare(strict_types=1);

namespace Tale\Functional;

function chunk(int $chunkLength, iterable $items): iterable
{
    $chunk = [];
    foreach ($items as $item) {
        $chunk[] = $item;
        if (count($chunk) >= $chunkLength) {
            yield $chunk;
            $chunk = [];
        }
    }
    if (count($chunk) > 0) {
        yield $chunk;
    }
}
