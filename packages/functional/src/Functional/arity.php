<?php declare(strict_types=1);

namespace Tale\Functional;

function arity(int $length, callable $fn): callable
{
    return match ($length) {
        // We define the parameters specifically to enable reading the parameter count via reflection later
        0 => static fn () => $fn(...func_get_args()),
        1 => static fn ($a0 = null) => $fn(...func_get_args()),
        2 => static fn ($a0 = null, $a1 = null) => $fn(...func_get_args()),
        3 => static fn ($a0 = null, $a1 = null, $a2 = null) => $fn(...func_get_args()),
        4 => static fn ($a0 = null, $a1 = null, $a2 = null, $a3 = null) => $fn(...func_get_args()),
        5 => static fn ($a0 = null, $a1 = null, $a2 = null, $a3 = null, $a4 = null) => $fn(...func_get_args()),
        6 => static fn (
                $a0 = null,
                $a1 = null,
                $a2 = null,
                $a3 = null,
                $a4 = null,
                $a5 = null
            ) => $fn(...func_get_args()),
        7 => static fn (
                $a0 = null,
                $a1 = null,
                $a2 = null,
                $a3 = null,
                $a4 = null,
                $a5 = null,
                $a6 = null
            ) => $fn(...func_get_args()),
        8 => static fn (
                $a0 = null,
                $a1 = null,
                $a2 = null,
                $a3 = null,
                $a4 = null,
                $a5 = null,
                $a6 = null,
                $a7 = null
            ) => $fn(...func_get_args()),
        9 => static fn (
                $a0 = null,
                $a1 = null,
                $a2 = null,
                $a3 = null,
                $a4 = null,
                $a5 = null,
                $a6 = null,
                $a7 = null,
                $a8 = null
            ) => $fn(...func_get_args()),
        10 => static fn (
                $a0 = null,
                $a1 = null,
                $a2 = null,
                $a3 = null,
                $a4 = null,
                $a5 = null,
                $a6 = null,
                $a7 = null,
                $a8 = null,
                $a9 = null
            ) => $fn(...func_get_args()),
        default =>
            throw new \InvalidArgumentException(
                'First argument to arity must be a non-negative integer no greater than 10',
            ),
    };
}
