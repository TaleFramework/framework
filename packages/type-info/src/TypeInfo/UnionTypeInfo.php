<?php declare(strict_types=1);

namespace Tale\TypeInfo;

use Generator;
use JetBrains\PhpStorm\Pure;
use Tale\TypeInfoInterface;

final class UnionTypeInfo implements TypeInfoInterface
{
    /**
     * @var array<TypeInfoInterface> $types
     */
    private array $types;

    /**
     * UnionTypeInfo constructor.
     * @param array<TypeInfoInterface> $types
     */
    #[Pure]
    public function __construct(array $types)
    {
        $this->types = iterator_to_array($this->flatten($types));
    }

    /**
     * @return array<TypeInfoInterface>
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    public function serialize(): ?string
    {
        return serialize($this->types);
    }

    public function unserialize($serialized): void
    {
        $this->types = unserialize($serialized, ['allowed_classes' => []]);
    }

    /**
     * @param array $types
     * @return Generator<int, TypeInfoInterface, void, voi>
     */
    #[Pure]
    private function flatten(array $types): iterable
    {
        foreach ($types as $type) {
            if ($type instanceof self) {
                foreach ($type->getTypes() as $childType) {
                    yield $childType;
                }
                continue;
            }
            yield $type;
        }
    }
}
