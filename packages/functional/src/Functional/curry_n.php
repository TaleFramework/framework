<?php declare(strict_types=1);

namespace Tale\Functional;

function curry_n(int $length, callable $fn): callable
{
    return new CurriedFunction($length, $fn);
}
