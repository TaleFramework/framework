<?php declare(strict_types=1);

namespace Tale\Ansi;

use JetBrains\PhpStorm\Pure;
use Stringable;
use function Symfony\Component\VarDumper\Dumper\esc;

final class ControlSequence implements Stringable
{
    /**
     * Sequence constructor.
     * @param string $controlFunction
     * @param string[] $parameters
     * @param string $finalByte
     */
    public function __construct(
        private string $controlFunction,
        private array $parameters = [],
        private string $finalByte = FinalByte::NONE,
    ) {}

    #[Pure]
    public function __toString(): string
    {
        return "{$this->controlFunction}["
            . implode(';', $this->parameters)
            . $this->finalByte;
    }

    #[Pure]
    public static function escape(array $parameters = [], string $finalByte = FinalByte::NONE): self
    {
        return new self(Control0::ESC, $parameters, $finalByte);
    }

    #[Pure]
    public static function escapeSelectGraphicRendition(array $parameters = []): self
    {
        return self::escape($parameters, FinalByte::SGR);
    }

    #[Pure]
    public static function escapeEraseDisplay(array $parameters = []): self
    {
        return self::escape($parameters, FinalByte::ED);
    }

    #[Pure]
    public static function escapeEraseLine(array $parameters = []): self
    {
        return self::escape($parameters, FinalByte::EL);
    }
}
