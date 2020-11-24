<?php declare(strict_types=1);

namespace Tale\Functional;

function equals($value): callable
{
    return static fn ($givenValue) => $givenValue === $value;
}
