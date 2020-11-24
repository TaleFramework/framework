<?php declare(strict_types=1);

namespace Tale\Functional;

function fold_right(callable $fn, iterable $items): iterable
{
    $reversedItems = array_reverse(unwind($items), false);
    $hasCarry = false;
    $carry = null;
    foreach ($reversedItems as $item) {
        if (!$hasCarry) {
            $carry = $item;
            $hasCarry = true;
            continue;
        }
        $carry = $fn($carry, $item);
    }
    return $carry;
}
