<?php declare(strict_types=1);

namespace Tale\Functional;

function try_call(callable $fn, ...$args): ResultInterface
{
    try {
        return ok($fn(...$args));
    } catch (\Exception $ex) {
        return error($ex);
    }
}
