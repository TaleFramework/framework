<?php declare(strict_types=1);

namespace Tale\Serializer\Factory;

use JetBrains\PhpStorm\Pure;
use ReflectionClass;
use ReflectionException;
use Tale\Serializer\Exception\FactoryException;
use Tale\Serializer\FactoryInterface;
use Tale\TypeInfo;
use Tale\TypeInfo\ClassTypeInfo;
use Tale\TypeInfoInterface;

final class StandardFactory implements FactoryInterface
{
    #[Pure]
    public function supports(TypeInfoInterface $typeInfo): bool
    {
        return TypeInfo::containsClass($typeInfo);
    }

    /**
     * @param TypeInfoInterface $typeInfo
     * @param array $parameters
     * @return mixed
     * @throws ReflectionException
     */
    public function createInstance(TypeInfoInterface $typeInfo, array $parameters): mixed
    {
        $classType = $typeInfo instanceof ClassTypeInfo
            ? $typeInfo
            : ($typeInfo instanceof TypeInfo\GenericTypeInfo
                ? $typeInfo->getType()
                // Assume it's a union
                : TypeInfo::keep([TypeInfo::class, 'isClass'], $typeInfo)
            );

        if (!$classType instanceof ClassTypeInfo) {
            throw new FactoryException(
                'Failed to instantiate class: Ambigious class type',
            );
        }
        $className = $classType->getClassName();
        $reflection = new ReflectionClass($className);
        $constructor = $reflection->getConstructor();
        if ($constructor && $constructor->getNumberOfRequiredParameters() > count($parameters)) {
            throw new FactoryException(
                'Failed to instantiate class: Class has required parameters that can\'t be guessed',
            );
        }
        tale_dump('inst', $parameters);
        dump('inst', new \ArrayObject(...$parameters));
        return $reflection->newInstanceArgs($parameters);
    }
}
