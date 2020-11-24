<?php declare(strict_types=1);

namespace Tale\Functional;

function fold(callable $fn, iterable $items): iterable
{
    $hasCarry = false;
    $carry = null;
    foreach ($items as $item) {
        if (!$hasCarry) {
            $carry = $item;
            $hasCarry = true;
            continue;
        }
        $carry = $fn($carry, $item);
    }
    return $carry;
}
