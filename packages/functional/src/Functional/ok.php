<?php declare(strict_types=1);

namespace Tale\Functional;

use JetBrains\PhpStorm\Pure;
use Tale\Functional\Maybe\Some;
use Tale\Functional\Result\Ok;

#[Pure]
function ok(mixed $value): Ok
{
    return new Ok($value);
}
