<?php declare(strict_types=1);

namespace Tale\Serializer\Json\Normalizer;

use Hoa\File\Generic;
use JetBrains\PhpStorm\Pure;
use ReflectionClass;
use Tale\Serializer;
use Tale\Serializer\Context;
use Tale\Serializer\NormalizerInterface;
use Tale\TypeInfo;
use Tale\TypeInfo\ClassTypeInfo;
use Tale\TypeInfo\GenericTypeInfo;
use Tale\TypeInfoInterface;

final class IterableNormalizer implements NormalizerInterface
{
    #[Pure]
    public function supports(string $format, TypeInfoInterface $typeInfo): bool
    {
        return $format === 'json' && (
            // Normal arrays
            TypeInfo::containsArray($typeInfo)
            // "iterable" types
            || TypeInfo::containsIterable($typeInfo)
            // Classes that are iterable (\Iterator, \IteratorAggregate)
            || ($typeInfo instanceof ClassTypeInfo
                && (new ReflectionClass($typeInfo->getClassName()))->isIterable()
            )
            // Iterable classes with generic information (SomeClass<ValueType> or SomeClass<KeyType, ValueType>)
            || ($typeInfo instanceof GenericTypeInfo
                && $typeInfo->getType() instanceof ClassTypeInfo
                && (new ReflectionClass($typeInfo->getType()->getClassName()))->isIterable()
            )
        );
    }

    public function normalize(Context $context, mixed $value, TypeInfoInterface $typeInfo): mixed
    {
        $parameters = $typeInfo instanceof GenericTypeInfo
            ? $typeInfo->getParameters()
            : [];
        $keyType = count($parameters) > 1
            ? $parameters[0]
            : TypeInfo::createUnion([TypeInfo::createString(), TypeInfo::createInt()]);
        $valueType = count($parameters) > 1
            ? $parameters[1]
            : (count($parameters) > 0
                ? $parameters[0]
                : TypeInfo::createMixed()
            );
        $normalizedArray = [];
        foreach ($value as $key => $item) {
            $normalizedArray[$context->normalize($key, $keyType)] = $context->normalize($item, $valueType);
        }
        return $normalizedArray;
    }

    public function denormalize(Context $context, mixed $data, TypeInfoInterface $typeInfo): mixed
    {
        $parameters = $typeInfo instanceof GenericTypeInfo
            ? $typeInfo->getParameters()
            : [];
        $keyType = count($parameters) > 1
            ? $parameters[0]
            : TypeInfo::createUnion([TypeInfo::createString(), TypeInfo::createInt()]);
        $valueType = count($parameters) > 1
            ? $parameters[1]
            : (count($parameters) > 0
                ? $parameters[0]
                : TypeInfo::createMixed()
            );
        $denormalizedArray = [];
        foreach ($data as $key => $value) {
            $denormalizedArray[$context->denormalize($key, $keyType)] = $context->denormalize($value, $valueType);
        }
        if (TypeInfo::containsClass($typeInfo)) {
            tale_dump('denorm', $denormalizedArray);
            return $context->createInstance($typeInfo, [$denormalizedArray]);
        }
        return $denormalizedArray;
    }
}
