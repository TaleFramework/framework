<?php declare(strict_types=1);

namespace Tale\Functional\Maybe;

use Tale\Functional\MaybeInterface;

/**
 * @template T
 */
final class None implements MaybeInterface
{
    public function isSome(): bool
    {
        return false;
    }

    public function isNone(): bool
    {
        return true;
    }

    /**
     * @return T
     */
    public function getValue()
    {
        throw new \RuntimeException(
            'Can\'t retrieve a value from a None MaybeInterface result. ' .
            'Use isSome() to check if it has a valid result.',
        );
    }
}
