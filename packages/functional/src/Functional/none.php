<?php declare(strict_types=1);

namespace Tale\Functional;

use JetBrains\PhpStorm\Pure;
use Tale\Functional\Maybe\None;
use Tale\Functional\Maybe\Some;

#[Pure]
function none(): None
{
    return new None();
}
