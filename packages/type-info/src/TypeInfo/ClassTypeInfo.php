<?php declare(strict_types=1);

namespace Tale\TypeInfo;

use ReflectionClass;
use ReflectionException;
use Tale\TypeInfoInterface;

final class ClassTypeInfo implements TypeInfoInterface
{
    public function __construct(
        private string $className,
    ) {}

    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return ReflectionClass
     * @throws ReflectionException
     */
    public function reflect(): ReflectionClass
    {
        return new ReflectionClass($this->className);
    }

    public function serialize(): ?string
    {
        return serialize($this->className);
    }

    public function unserialize($serialized): void
    {
        $this->className = unserialize($serialized, ['allowed_classes' => []]);
    }
}
