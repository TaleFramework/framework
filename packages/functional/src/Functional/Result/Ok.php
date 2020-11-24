<?php declare(strict_types=1);

namespace Tale\Functional\Result;

use Exception;
use Tale\Functional\ResultInterface;

/**
 * @template T
 */
final class Ok implements ResultInterface
{
    /**
     * @param T $value
     */
    public function __construct(
        private mixed $value,
    ) {}

    public function isOk(): bool
    {
        return true;
    }

    public function isError(): bool
    {
        return false;
    }

    /**
     * @return T
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getException(): Exception
    {
        throw new \RuntimeException(
            'Can\'t get an exception from a result that is not an error',
        );
    }
}
