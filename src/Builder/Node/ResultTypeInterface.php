<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\ValueObject\InternalType;

interface ResultTypeInterface
{
    /**
     * @return InternalType|string
     */
    public function getResultType();
}
