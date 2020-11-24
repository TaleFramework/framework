<?php declare(strict_types=1);

namespace Tale\TypeInfo;

use Tale\TypeInfoInterface;

final class GenericTypeInfo implements TypeInfoInterface
{
    /**
     * GenericTypeInfo constructor.
     * @param TypeInfoInterface $type
     * @param array<TypeInfoInterface> $parameters
     */
    public function __construct(
        private TypeInfoInterface $type,
        private array $parameters,
    ) {}

    /**
     * @return TypeInfoInterface
     */
    public function getType(): TypeInfoInterface
    {
        return $this->type;
    }

    /**
     * @return array<TypeInfoInterface>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function serialize(): ?string
    {
        return serialize([$this->type, $this->parameters]);
    }

    public function unserialize($serialized): void
    {
        [$this->type, $this->parameters] = unserialize($serialized, ['allowed_classes' => []]);
    }
}
