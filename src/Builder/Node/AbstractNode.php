<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

abstract class AbstractNode
{
    protected function __construct() {}

    abstract public function getStatements();
}
