<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node\Traits;

use JDWil\PhpGenny\Builder\Node\AbstractNode;
use JDWil\PhpGenny\Builder\Node\AssignmentOp;

/**
 * Trait AssignmentOpTrait
 *
 * @method equals(AbstractNode $value)
 * @method bitwiseAndEquals(AbstractNode $value)
 * @method bitwiseOrEquals(AbstractNode $value)
 * @method bitwiseXorEquals(AbstractNode $value)
 * @method dotEquals(AbstractNode $value)
 * @method divideEquals(AbstractNode $value)
 * @method minusEquals(AbstractNode $value)
 * @method modEquals(AbstractNode $value)
 * @method multiplyEquals(AbstractNode $value)
 * @method plusEquals(AbstractNode $value)
 * @method powEquals(AbstractNode $value)
 * @method shiftLeftEquals(AbstractNode $value)
 * @method shiftRightEquals(AbstractNode $value)
 */
trait AssignmentOpTrait
{
    public function __call($name, $arguments)
    {
        return AssignmentOp::$name($this->validateAssignmentOpClass(), $arguments[0]);
    }

    private function validateAssignmentOpClass(): AbstractNode
    {
        $c = $this;
        if (!$c instanceof AbstractNode) {
            throw new \Exception('BinaryOp Trait can only be used by AbstractNodes');
        }

        return $c;
    }
}
