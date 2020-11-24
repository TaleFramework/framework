<?php declare(strict_types=1);

namespace Tale\TypeInfo\Reader;

use Hoa\File\Generic;
use JetBrains\PhpStorm\Pure;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionProperty;
use Tale\TypeInfo;
use Tale\TypeInfo\BuiltinTypeInfo;
use Tale\TypeInfo\ClassTypeInfo;
use Tale\TypeInfo\GenericTypeInfo;
use Tale\TypeInfoInterface;
use Tale\TypeInfo\ParameterInfo;
use Tale\TypeInfo\ReaderInterface;

final class ChainReader implements ReaderInterface
{
    /**
     * @param iterable<ReaderInterface> $readers
     */
    public function __construct(
        private iterable $readers,
    ) {}

    public function readParameters(ReflectionMethod|ReflectionFunction $function): iterable
    {
        $mergedParams = [];
        foreach ($this->readers as $reader) {
            $readerParams = $reader->readParameters($function);
            foreach ($readerParams as $name => $param) {
                if (isset($mergedParams[$name])) {
                    $mergedParams[$name] = ParameterInfo::merge($mergedParams[$name], $param);
                    continue;
                }
                $mergedParams[$name] = $param;
            }
        }
        yield from $mergedParams;
    }

    public function readReturnValue(ReflectionMethod|ReflectionFunction $function): TypeInfoInterface
    {
        $returnValueType = null;
        foreach ($this->readers as $reader) {
            $returnValueType = $reader->readReturnValue($function);
        }
        return $returnValueType;
    }

    public function readProperty(ReflectionProperty $property): TypeInfoInterface
    {
        $propertyType = null;
        foreach ($this->readers as $reader) {
            $propertyType = $reader->readProperty($property);
        }
        return $propertyType;
    }
}
