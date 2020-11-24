<?php declare(strict_types=1);

namespace Tale\TypeInfo;

use Tale\TypeInfoInterface;

interface ParserInterface
{
    public function parse(string $type, array $classAliasMap = []): TypeInfoInterface;
}
