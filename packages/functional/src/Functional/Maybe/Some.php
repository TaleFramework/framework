<?php declare(strict_types=1);

namespace Tale\Functional\Maybe;

use Tale\Functional\MaybeInterface;

/**
 * @template T
 */
final class Some implements MaybeInterface
{
    /**
     * @var T
     */
    private $value;

    /**
     * @param T $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function isSome(): bool
    {
        return true;
    }

    public function isNone(): bool
    {
        return false;
    }

    /**
     * @return T
     */
    public function getValue()
    {
        return $this->value;
    }
}
