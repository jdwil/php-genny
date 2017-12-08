<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node\Traits;

use JDWil\PhpGenny\Builder\Node\AbstractNode;
use JDWil\PhpGenny\Builder\Node\Array_;

trait ArrayAccessTrait
{
    /**
     * @param AbstractNode $index
     * @return Array_
     * @throws \Exception
     */
    public function arrayIndex(AbstractNode $index): Array_
    {
        return Array_::fetchDimension($this->validateInstanceOfAbstractNode(), $index);
    }

    /**
     * @return AbstractNode
     * @throws \Exception
     */
    public function validateInstanceOfAbstractNode(): AbstractNode
    {
        $ret = $this;
        if (!$ret instanceof AbstractNode) {
            throw new \Exception('ArrayAccessTrait can only be used on AbstractNodes');
        }

        return $ret;
    }
}
