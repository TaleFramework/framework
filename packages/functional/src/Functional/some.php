<?php declare(strict_types=1);

namespace Tale\Functional;

use JetBrains\PhpStorm\Pure;
use Tale\Functional\Maybe\Some;

#[Pure]
function some($value): Some
{
    return new Some($value);
}
