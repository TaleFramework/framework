<?php declare(strict_types=1);

final class EraseLine
{
    private function __construct() {}

    /**
     * Erases from the current cursor position to the end of the current line.
     * @type string
     */
    public const TO_EOL = '0';

    /**
     * Erases from the current cursor position to the start of the current line.
     * @type string
     */
    public const TO_SOL = '1';

    /**
     * Erases the entire current line.
     * @type string
     */
    public const ALL = '2';
}
