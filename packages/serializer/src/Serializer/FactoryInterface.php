<?php declare(strict_types=1);

namespace Tale\Serializer;

use Tale\TypeInfoInterface;

interface FactoryInterface
{
    public function supports(TypeInfoInterface $typeInfo): bool;
    public function createInstance(TypeInfoInterface $typeInfo, array $parameters): mixed;
}
