<?php declare(strict_types=1);

namespace Tale;

use _HumbugBoxf99c1794c57d\Nette\PhpGenerator\ClassType;
use JetBrains\PhpStorm\Pure;
use PHPStan\Type\UnionType;
use Tale\TypeInfo\BuiltinTypeInfo;
use Tale\TypeInfo\ClassTypeInfo;
use Tale\TypeInfo\GenericTypeInfo;
use Tale\TypeInfo\UnionTypeInfo;

/**
 * TypeInfo is a basic DTO for type information.
 *
 * It can represent internal types, classes and generic types.
 */
final class TypeInfo
{
    private function __construct() {}

    #[Pure]
    public static function createBuiltIn(string $name): BuiltinTypeInfo
    {
        return new BuiltinTypeInfo($name);
    }

    #[Pure]
    public static function isBuiltin(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof BuiltinTypeInfo;
    }

    #[Pure]
    public static function createMixed(): BuiltinTypeInfo
    {
        return self::createBuiltIn(BuiltinTypeInfo::NAME_MIXED);
    }

    #[Pure]
    public static function isMixed(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof BuiltinTypeInfo && $typeInfo->getName() === BuiltinTypeInfo::NAME_MIXED;
    }

    #[Pure]
    public static function containsMixed(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isMixed'], $typeInfo);
    }

    #[Pure]
    public static function createNull(): BuiltinTypeInfo
    {
        return self::createBuiltIn(BuiltinTypeInfo::NAME_NULL);
    }

    #[Pure]
    public static function isNull(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof BuiltinTypeInfo && $typeInfo->getName() === BuiltinTypeInfo::NAME_NULL;
    }

    #[Pure]
    public static function containsNull(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isNull'], $typeInfo);
    }

    #[Pure]
    public static function createBool(): BuiltinTypeInfo
    {
        return self::createBuiltIn(BuiltinTypeInfo::NAME_BOOL);
    }

    #[Pure]
    public static function isBool(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof BuiltinTypeInfo && $typeInfo->getName() === BuiltinTypeInfo::NAME_BOOL;
    }

    #[Pure]
    public static function containsBool(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isBool'], $typeInfo);
    }

    #[Pure]
    public static function createInt(): BuiltinTypeInfo
    {
        return self::createBuiltIn(BuiltinTypeInfo::NAME_INT);
    }

    #[Pure]
    public static function isInt(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof BuiltinTypeInfo && $typeInfo->getName() === BuiltinTypeInfo::NAME_INT;
    }

    #[Pure]
    public static function containsInt(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isInt'], $typeInfo);
    }

    #[Pure]
    public static function createFloat(): BuiltinTypeInfo
    {
        return self::createBuiltIn(BuiltinTypeInfo::NAME_FLOAT);
    }

    #[Pure]
    public static function isFloat(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof BuiltinTypeInfo && $typeInfo->getName() === BuiltinTypeInfo::NAME_FLOAT;
    }

    #[Pure]
    public static function containsFloat(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isFloat'], $typeInfo);
    }

    #[Pure]
    public static function createString(): BuiltinTypeInfo
    {
        return self::createBuiltIn(BuiltinTypeInfo::NAME_STRING);
    }

    #[Pure]
    public static function isString(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof BuiltinTypeInfo && $typeInfo->getName() === BuiltinTypeInfo::NAME_STRING;
    }

    #[Pure]
    public static function containsString(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isString'], $typeInfo);
    }

    #[Pure]
    public static function createArray(): BuiltinTypeInfo
    {
        return self::createBuiltIn(BuiltinTypeInfo::NAME_ARRAY);
    }

    #[Pure]
    public static function isArray(TypeInfoInterface $typeInfo): bool
    {
        return ($typeInfo instanceof BuiltinTypeInfo && $typeInfo->getName() === BuiltinTypeInfo::NAME_ARRAY);
    }

    #[Pure]
    public static function containsArray(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isArray'], $typeInfo);
    }

    #[Pure]
    public static function createObject(): BuiltinTypeInfo
    {
        return self::createBuiltIn(BuiltinTypeInfo::NAME_OBJECT);
    }

    #[Pure]
    public static function isObject(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof BuiltinTypeInfo && $typeInfo->getName() === BuiltinTypeInfo::NAME_OBJECT;
    }

    #[Pure]
    public static function containsObject(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isObject'], $typeInfo);
    }

    #[Pure]
    public static function createResource(): BuiltinTypeInfo
    {
        return self::createBuiltIn(BuiltinTypeInfo::NAME_RESOURCE);
    }

    #[Pure]
    public static function isResource(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof BuiltinTypeInfo && $typeInfo->getName() === BuiltinTypeInfo::NAME_RESOURCE;
    }

    #[Pure]
    public static function containsResource(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isResource'], $typeInfo);
    }

    #[Pure]
    public static function createIterable(): BuiltinTypeInfo
    {
        return self::createBuiltIn('iterable');
    }

    #[Pure]
    public static function isIterable(TypeInfoInterface $typeInfo): bool
    {
        return ($typeInfo instanceof BuiltinTypeInfo && $typeInfo->getName() === BuiltinTypeInfo::NAME_ITERABLE);
    }

    #[Pure]
    public static function containsIterable(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isIterable'], $typeInfo);
    }

    #[Pure]
    public static function createCallable(): BuiltinTypeInfo
    {
        return self::createBuiltIn(BuiltinTypeInfo::NAME_CALLABLE);
    }

    #[Pure]
    public static function isCallable(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof BuiltinTypeInfo && $typeInfo->getName() === BuiltinTypeInfo::NAME_CALLABLE;
    }

    #[Pure]
    public static function containsCallable(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isCallable'], $typeInfo);
    }

    #[Pure]
    public static function createVoid(): BuiltinTypeInfo
    {
        return self::createBuiltIn(BuiltinTypeInfo::NAME_VOID);
    }

    #[Pure]
    public static function isVoid(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof BuiltinTypeInfo && $typeInfo->getName() === BuiltinTypeInfo::NAME_VOID;
    }

    #[Pure]
    public static function containsVoid(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isVoid'], $typeInfo);
    }

    /**
     * @param TypeInfoInterface $type
     * @param array<TypeInfoInterface> $parameters
     * @return GenericTypeInfo
     */
    #[Pure]
    public static function createGeneric(TypeInfoInterface $type, array $parameters): GenericTypeInfo
    {
        return new GenericTypeInfo($type, $parameters);
    }

    #[Pure]
    public static function isGeneric(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof GenericTypeInfo;
    }

    #[Pure]
    public static function containsGeneric(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isGeneric'], $typeInfo);
    }

    public static function createArrayOf(
        TypeInfoInterface $typeInfo, TypeInfoInterface $keyTypeInfo = null)
    : GenericTypeInfo {
        $keyTypeInfo ??= self::createUnion([self::createString(), self::createInt()]);
        return self::createGeneric(self::createArray(), [$keyTypeInfo, $typeInfo]);
    }

    public static function createIterableOf(
        TypeInfoInterface $typeInfo, TypeInfoInterface $keyTypeInfo = null)
    : GenericTypeInfo {
        $keyTypeInfo ??= self::createUnion([self::createString(), self::createInt()]);
        return self::createGeneric(self::createIterable(), [$typeInfo, $keyTypeInfo]);
    }

    /**
     * @param string $className
     * @return ClassTypeInfo
     */
    #[Pure]
    public static function createClass(string $className): ClassTypeInfo
    {
        return new ClassTypeInfo($className);
    }

    #[Pure]
    public static function isClass(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof ClassTypeInfo;
    }

    #[Pure]
    public static function containsClass(TypeInfoInterface $typeInfo): bool
    {
        return self::contains([self::class, 'isClass'], $typeInfo);
    }

    #[Pure]
    public static function createUnion(array $types): TypeInfoInterface
    {
        return match (count($types)) {
            0 => self::createVoid(),
            1 => $types[0],
            default => new UnionTypeInfo($types),
        };
    }

    #[Pure]
    public static function add(TypeInfoInterface $addTypeInfo, TypeInfoInterface $typeInfo): TypeInfoInterface
    {
        if (self::containsType($addTypeInfo, $typeInfo)) {
            return $typeInfo;
        }
        return self::createUnion([$typeInfo, $addTypeInfo]);
    }

    public static function remove(TypeInfoInterface $removeTypeInfo, TypeInfoInterface $typeInfo): TypeInfoInterface
    {
        if (!self::containsType($removeTypeInfo, $typeInfo)) {
            return $typeInfo;
        }
        return self::drop(
            fn (TypeInfoInterface $childTypeInfo) => self::equals($childTypeInfo, $removeTypeInfo),
            $typeInfo,
        );
    }

    #[Pure]
    public static function isUnion(TypeInfoInterface $typeInfo): bool
    {
        return $typeInfo instanceof UnionTypeInfo;
    }

    public static function keep(callable $filter, TypeInfoInterface $typeInfo): TypeInfoInterface
    {
        if (!$typeInfo instanceof UnionTypeInfo) {
            return $filter($typeInfo) ? $typeInfo : self::createVoid();
        }
        return self::createUnion(array_filter($typeInfo->getTypes(), $filter));
    }

    public static function drop(callable $filter, TypeInfoInterface $typeInfo): TypeInfoInterface
    {
        return self::keep(fn (TypeInfoInterface $childType) => !$filter($childType), $typeInfo);
    }

    #[Pure]
    public static function contains(callable $filter, TypeInfoInterface $typeInfo): bool
    {
        if ($typeInfo instanceof GenericTypeInfo) {
            return $filter($typeInfo->getType());
        }
        if (!$typeInfo instanceof UnionTypeInfo) {
            return $filter($typeInfo);
        }
        return count(array_filter($typeInfo->getTypes(), $filter)) > 0;
    }

    #[Pure]
    public static function containsType(TypeInfoInterface $searchTypeInfo, TypeInfoInterface $typeInfo): bool
    {
        return self::contains(
            fn (TypeInfoInterface $childTypeInfo) => self::equals($childTypeInfo, $searchTypeInfo),
            $typeInfo,
        );
    }

    #[Pure]
    public static function isNullable(TypeInfoInterface $typeInfo): bool
    {
        if (!($typeInfo instanceof UnionTypeInfo)) {
            return false;
        }
        foreach ($typeInfo->getTypes() as $type) {
            if (self::isNull($type)) {
                return true;
            }
        }
        return false;
    }

    public static function nullable(TypeInfoInterface $typeInfo): TypeInfoInterface
    {
        return self::isNullable($typeInfo) ? $typeInfo : self::createUnion([$typeInfo, self::createNull()]);
    }

    public static function notNullable(TypeInfoInterface $typeInfo): TypeInfoInterface
    {
        return $typeInfo instanceof UnionTypeInfo && self::isNullable($typeInfo)
            ? self::drop([self::class, 'isNull'], $typeInfo)
            : $typeInfo;
    }

    public static function merge(TypeInfoInterface $a, TypeInfoInterface $b): TypeInfoInterface
    {
        $builtInType = $a instanceof BuiltinTypeInfo ? $a : ($b instanceof BuiltinTypeInfo ? $b : null);
        $genericType = $a instanceof GenericTypeInfo ? $a : ($b instanceof GenericTypeInfo ? $b : null);
        $classNameType = $a instanceof ClassTypeInfo ? $a : ($b instanceof ClassTypeInfo ? $b : null);
        $unionType = $a instanceof UnionTypeInfo ? $a : ($b instanceof UnionTypeInfo ? $b : null);
        $mostImportantType = $unionType ?? ($genericType ?? ($classNameType ?? $builtInType));
        $nullable = self::isNullable($a) || self::isNullable($b);
        return $nullable ? self::nullable($mostImportantType) : $mostImportantType;
    }

    public static function equals(TypeInfoInterface $compareInfo, TypeInfoInterface $typeInfo): bool
    {
        if ($compareInfo instanceof BuiltinTypeInfo) {
            return $typeInfo instanceof BuiltinTypeInfo && $compareInfo->getName() === $typeInfo->getName();
        }
        if (!$compareInfo instanceof UnionTypeInfo) {
            if (!$typeInfo instanceof GenericTypeInfo
                || !self::equals($typeInfo->getType(), $compareInfo->getType())) {
                return false;
            }
            $parameters = $typeInfo->getParameters();
            foreach ($compareInfo->getParameters() as $i => $parameter) {
                if (!isset($parameters[$i]) || !self::equals($parameter, $parameters[$i])) {
                    return false;
                }
            }
            return true;
        }
        return $typeInfo instanceof UnionTypeInfo
            && count(array_filter(
                $compareInfo->getTypes(),
                static fn (TypeInfoInterface $compareChildInfo) => self::containsType(
                    $compareChildInfo,
                    $typeInfo,
                ),
            )) === $compareInfo->getTypes();
    }
}
