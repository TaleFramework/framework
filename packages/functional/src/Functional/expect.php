<?php declare(strict_types=1);

namespace Tale\Functional;

use Exception;

/**
 * @param ResultInterface $result
 * @return mixed
 * @throws Exception
 */
function expect(ResultInterface $result): mixed
{
    if ($result->isError()) {
        throw $result->getException();
    }
    return $result->getValue();
}
