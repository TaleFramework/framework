<?php declare(strict_types=1);

namespace Tale\Ansi;

final class EraseDisplay
{
    private function __construct() {}

    /**
     * Erases the screen from the current line down to the bottom of the screen.
     * @type string
     */
    public const DOWN = '0';

    /**
     * Erases the screen from the current line up to the top of the screen.
     * @type string
     */
    public const UP = '1';

    /**
     * Erases the screen with the background colour and moves the cursor to home.
     * @type string
     */
    public const ALL = '2';
}
