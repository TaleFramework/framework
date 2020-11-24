<?php declare(strict_types=1);

namespace Tale\Serializer\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class Discriminate
{
    public function __construct(
        private string $propertyName,
        private array $classMap,
    ) {}
}
