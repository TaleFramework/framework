<?php declare(strict_types=1);

namespace Tale\Functional;

use Exception;
use JetBrains\PhpStorm\Pure;
use Tale\Functional\Maybe\Some;
use Tale\Functional\Result\Error;
use Tale\Functional\Result\Ok;

#[Pure]
function error(Exception $exception): Error
{
    return new Error($exception);
}
