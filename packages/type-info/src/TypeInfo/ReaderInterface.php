<?php

namespace Tale\TypeInfo;

use ReflectionFunction;
use ReflectionMethod;
use ReflectionProperty;
use Tale\TypeInfoInterface;

interface ReaderInterface
{
    /**
     * Reads parameter types from a method.
     *
     * @param ReflectionMethod|ReflectionFunction $function
     * @return iterable<ParameterInfo>
     */
    public function readParameters(ReflectionMethod|ReflectionFunction $function): iterable;

    /**
     * @param ReflectionMethod|ReflectionFunction $function
     * @return TypeInfoInterface
     */
    public function readReturnValue(ReflectionMethod|ReflectionFunction $function): TypeInfoInterface;

    /**
     * @param ReflectionProperty $property
     * @return TypeInfoInterface
     */
    public function readProperty(ReflectionProperty $property): TypeInfoInterface;
}
