<?php declare(strict_types=1);

namespace Tale\TypeInfo;

use Tale\TypeInfoInterface;

final class BuiltinTypeInfo implements TypeInfoInterface
{
    public const NAME_MIXED = 'mixed';
    public const NAME_NULL = 'null';
    public const NAME_BOOL = 'bool';
    public const NAME_INT = 'int';
    public const NAME_FLOAT = 'float';
    public const NAME_STRING = 'string';
    public const NAME_ARRAY = 'array';
    public const NAME_OBJECT = 'object';
    public const NAME_RESOURCE = 'resource';
    public const NAME_CALLABLE = 'callable';
    public const NAME_ITERABLE = 'iterable';
    public const NAME_VOID = 'void';

    /**
     * The type names that are seen as "built in".
     */
    public const NAMES = [
        self::NAME_MIXED,
        self::NAME_NULL,
        self::NAME_BOOL,
        self::NAME_INT,
        self::NAME_FLOAT,
        self::NAME_STRING,
        self::NAME_ARRAY,
        self::NAME_OBJECT,
        self::NAME_RESOURCE,
        self::NAME_CALLABLE,
        self::NAME_ITERABLE,
        self::NAME_VOID,
    ];

    public function __construct(
        private string $name,
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function serialize(): ?string
    {
        return serialize($this->name);
    }

    public function unserialize($serialized): void
    {
        $this->name = unserialize($serialized, ['allowed_classes' => []]);
    }
}
