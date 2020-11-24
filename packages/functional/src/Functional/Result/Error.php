<?php declare(strict_types=1);

namespace Tale\Functional\Result;

use Exception;
use RuntimeException;
use Tale\Functional\ResultInterface;

final class Error implements ResultInterface
{
    private Exception $exception;

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }
    public function isOk(): bool
    {
        return false;
    }

    public function isError(): bool
    {
        return true;
    }

    /**
     * @return T
     */
    public function getValue(): mixed
    {
        throw new RuntimeException(
            'Can\'t retrieve a value from a Error ResultInterface result. ' .
            'Use isOk() to check if it has a valid result.',
        );
    }

    public function getException(): Exception
    {
        return $this->exception;
    }
}
