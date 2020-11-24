<?php declare(strict_types=1);

namespace Tale\Serializer;

use Tale\Serializer;
use Tale\TypeInfo;
use Tale\TypeInfoInterface;

interface NormalizerInterface
{
    public function supports(string $format, TypeInfoInterface $typeInfo): bool;
    public function normalize(Context $context, mixed $value, TypeInfoInterface $typeInfo): mixed;
    public function denormalize(Context $context, mixed $data, TypeInfoInterface $typeInfo): mixed;
}
