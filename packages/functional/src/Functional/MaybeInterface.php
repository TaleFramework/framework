<?php declare(strict_types=1);

namespace Tale\Functional;

interface MaybeInterface
{
    public function isSome(): bool;
    public function isNone(): bool;
    public function getValue(): mixed;
}
