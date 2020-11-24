<?php declare(strict_types=1);

namespace Tale\Functional;

function try_apply(callable $fn, iterable $args): ResultInterface
{
    $argArray = unwind($args);
    try {
        return ok($fn(...$argArray));
    } catch (\Exception $ex) {
        return error($ex);
    }
}
