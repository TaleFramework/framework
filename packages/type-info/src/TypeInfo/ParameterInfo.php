<?php declare(strict_types=1);

namespace Tale\TypeInfo;

use JetBrains\PhpStorm\Pure;
use Serializable;
use Tale\TypeInfo;
use Tale\TypeInfoInterface;

/**
 * A parameter describes basic parameter information of a function.
 *
 * This is mostly a DTO to store the information of classes constructor parameters.
 */
final class ParameterInfo implements Serializable
{
    /**
     * Creates a new Parameter instance.
     *
     * @param string $name The name of the parameter without the dollar sign. ($)
     * @param TypeInfoInterface $typeInfo The type information of the parameter.
     * @param bool $optional Whether this parameter is optional or not.
     * @param mixed $defaultValue The default value of the parameter
     */
    public function __construct(
        private string $name,
        private TypeInfoInterface $typeInfo,
        private bool $optional,
        private mixed $defaultValue
    ) {}

    /**
     * Returns the name of the parameter without the dollar sign ($).
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the type information of this parameter.
     *
     * @return TypeInfoInterface
     */
    public function getTypeInfo(): TypeInfoInterface
    {
        return $this->typeInfo;
    }

    /**
     * Returns whether this parameter is optional or not.
     *
     * @return bool
     */
    public function isOptional(): bool
    {
        return $this->optional;
    }

    /**
     * Returns the default value of the parameter.
     *
     * @return mixed
     */
    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
    }

    /**
     * Serializes the parameter with the PHP serialization mechanism.
     *
     * @return string The serialized string.
     */
    public function serialize(): string
    {
        return serialize([
            $this->name,
            $this->typeInfo,
            $this->optional,
            $this->defaultValue,
        ]);
    }

    /**
     * Unserializes the parameter info from a PHP serialization string.
     *
     * @param string $serialized The serialized parameter data.
     */
    public function unserialize($serialized): void
    {
        [
            $this->name,
            $this->typeInfo,
            $this->optional,
            $this->defaultValue,
        ] = unserialize($serialized, ['allowed_classes' => [Serializable::class]]);
    }

    /**
     * @param ParameterInfo $a
     * @param ParameterInfo $b
     * @return ParameterInfo
     */
    public static function merge(self $a, self $b): self
    {
        return new self(
            $a->getName(),
            TypeInfo::merge($a->getTypeInfo(), $b->getTypeInfo()),
            $a->isOptional() || $b->isOptional(),
            $a->getDefaultValue() ?? $b->getDefaultValue(),
        );
    }
}
