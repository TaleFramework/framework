<?php declare(strict_types=1);

namespace Tale\Serializer\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class XmlRoot
{
    public function __construct(
        private string $name,
    ) {}

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
