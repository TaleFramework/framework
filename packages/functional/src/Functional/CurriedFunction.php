<?php declare(strict_types=1);

namespace Tale\Functional;

use Closure;
use SplObjectStorage;

final class CurriedFunction
{
    private Closure $fn;

    public function __construct(int $length, callable $fn)
    {
        $this->fn = Closure::fromCallable(arity($length, $this->curryN($length, [], $fn)));
    }

    public function __invoke(...$args)
    {
        return ($this->fn)(...$args);
    }

    private function curryN(int $length, array $received, callable $fn): callable
    {
        return function (...$args) use ($length, $received, $fn) {
            $combined = [];
            $argsIdx = 0;
            $argLength = count($args);
            $receivedLength = count($received);
            $left = $length;
            for ($combinedIdx = 0; $combinedIdx < $receivedLength || $argsIdx < $argLength; $combinedIdx++) {
                $result = null;
                if ($combinedIdx < $receivedLength &&
                    (!is_placeholder($received[$combinedIdx]) || $argsIdx >= $argLength)) {
                    $result = $received[$combinedIdx];
                } else {
                    $result = $args[$argsIdx];
                    ++$argsIdx;
                }
                $combined[$combinedIdx] = $result;
                if (!is_placeholder($result)) {
                    --$left;
                }
            }
            return $left <= 0 ? $fn(...$combined) : arity($left, $this->curryN($length, $combined, $fn));
        };
    }
}
