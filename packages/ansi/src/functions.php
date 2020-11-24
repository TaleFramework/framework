<?php declare(strict_types=1);

namespace Tale;

use JetBrains\PhpStorm\Pure;
use Tale\Ansi\ControlSequence;
use Tale\Ansi\FinalByte;
use Tale\Ansi\FormattedString;

#[Pure]
function ansi_control_sequence(
    string $controlFunction,
    array $parameters = [],
    string $finalByte = FinalByte::NONE,
): ControlSequence {
    return new ControlSequence($controlFunction, $parameters, $finalByte);
}

#[Pure]
function ansi_escape(array $parameters = [], string $finalByte = FinalByte::NONE): ControlSequence
{
    return ControlSequence::escape($parameters, $finalByte);
}

#[Pure]
function ansi_escape_sgr(array $parameters = []): ControlSequence
{
    return ControlSequence::escapeSelectGraphicRendition($parameters);
}

#[Pure]
function ansi_escape_ed(array $parameters = []): ControlSequence
{
    return ControlSequence::escapeEraseDisplay($parameters);
}

#[Pure]
function ansi_escape_el(array $parameters = []): ControlSequence
{
    return ControlSequence::escapeEraseLine($parameters);
}

#[Pure]
function ansi_format(string $content): FormattedString
{
    return new FormattedString($content);
}
