<?php declare(strict_types=1);

namespace Tale\Functional;

/**
 * @internal
 */
final class Placeholder
{
    private static ?self $instance;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        return self::$instance = self::$instance ?? new self();
    }
}
