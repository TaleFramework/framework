<?php

namespace Some\Namespace;

use Some\ClassName;
use Some\Other\ClassName as Other;

class SomeClass
{
    /**
     * @param string|null $a
     * @param Other $b
     * @param array<ClassName> $c
     * @param int $opt
     */
    public function someMethod(?string $a, Other $b, ClassName $c, int $opt = 10)
    {
    }
}
