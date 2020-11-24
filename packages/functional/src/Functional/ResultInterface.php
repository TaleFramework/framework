<?php declare(strict_types=1);

namespace Tale\Functional;

/**
 * @template T
 */
interface ResultInterface
{
    public function isOk(): bool;
    public function isError(): bool;

    /**
     * @return T
     */
    public function getValue(): mixed;
    public function getException(): \Exception;
}
