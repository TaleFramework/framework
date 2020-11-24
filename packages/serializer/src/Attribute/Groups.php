<?php declare(strict_types=1);

namespace Tale\Serializer\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Groups
{
    public function __construct(
        private string $names,
    ) {}
}
