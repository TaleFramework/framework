<?php declare(strict_types=1);

namespace Tale\Functional;

function hold(): Placeholder
{
    return Placeholder::getInstance();
}
