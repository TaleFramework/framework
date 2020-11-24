<?php declare(strict_types=1);

namespace Tale\TypeInfo;

use Tale\TypeInfoInterface;

interface GuesserInterface
{
    public function guessType(mixed $value): TypeInfoInterface;
}
