<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node\Traits;

use JDWil\PhpGenny\Builder\Node\AbstractNode;

/**
 * Trait NestedNodeTrait
 */
trait NestedNodeTrait
{
    /**
     * @var AbstractNode
     */
    protected $parent;

    /**
     * @param AbstractNode $parent
     */
    public function setParent(AbstractNode $parent)
    {
        $this->parent = $parent;
    }
}
