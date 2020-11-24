<?php declare(strict_types=1);

namespace Tale\TypeInfo\Reader;

use ReflectionException;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionType;
use ReflectionUnionType;
use Tale\TypeInfo;
use Tale\TypeInfo\ParameterInfo;
use Tale\TypeInfo\ParserInterface;
use Tale\TypeInfo\ReaderInterface;
use Tale\TypeInfoInterface;

final class ReflectionReader implements ReaderInterface
{
    public function __construct(
        private ParserInterface $parser
    ) {}

    /**
     * @param ReflectionMethod|ReflectionFunction $function
     * @return iterable<ParameterInfo>
     */
    public function readParameters(ReflectionMethod|ReflectionFunction $function): iterable
    {
        $reflParams = $function->getParameters();
        foreach ($reflParams as $param) {
            $name = $param->getName();
            $reflType = $param->getType();
            $type = $this->toTypeInfo($reflType);
            $defaultValue = null;
            $optional = $param->isOptional();
            if ($optional) {
                try {
                    $defaultValue = $param->getDefaultValue();
                } catch (ReflectionException) {}
            }

            yield $name => new ParameterInfo($name, $type, $optional, $defaultValue);
        }
    }

    public function readReturnValue(ReflectionMethod|ReflectionFunction $function): TypeInfoInterface
    {
        return $this->toTypeInfo($function->getReturnType());
    }

    public function readProperty(ReflectionProperty $property): TypeInfoInterface
    {
        return $this->toTypeInfo($property->getType());
    }

    /**
     * @param ReflectionType|null $type
     * @return TypeInfoInterface
     */
    private function toTypeInfo(?ReflectionType $type): TypeInfoInterface
    {
        if (!$type) {
            return TypeInfo::createMixed();
        }
        if ($type instanceof ReflectionUnionType) {
            $nullable = $type->allowsNull();
            $union = TypeInfo::createUnion(array_map([$this, 'toTypeInfo'], $type->getTypes()));
            return $nullable ? TypeInfo::nullable($union) : $union;
        }
        if ($type instanceof ReflectionNamedType) {
            $nullable = $type->allowsNull();
            $typeInfo = $this->parser->parse(($nullable ? '?' : '') . $type->getName());
            return $nullable ? TypeInfo::nullable($typeInfo) : $typeInfo;
        }
        return TypeInfo::createMixed();
    }
}
