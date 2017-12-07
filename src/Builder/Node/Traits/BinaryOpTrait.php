<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node\Traits;

use JDWil\PhpGenny\Builder\Node\AbstractNode;
use JDWil\PhpGenny\Builder\Node\BinaryOp;
use PhpParser\Node\Expr\AssignOp\BitwiseXor;

trait BinaryOpTrait
{
    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function concat(AbstractNode $node): BinaryOp
    {
        return BinaryOp::concat($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function plus(AbstractNode $node): BinaryOp
    {
        return BinaryOp::add($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function minus(AbstractNode $node): BinaryOp
    {
        return BinaryOp::subtract($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function dividedBy(AbstractNode $node): BinaryOp
    {
        return BinaryOp::divide($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function multipliedBy(AbstractNode $node): BinaryOp
    {
        return BinaryOp::multiply($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function mod(AbstractNode $node): BinaryOp
    {
        return BinaryOp::mod($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function isEqualTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::equal($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function isNotEqualTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::notEqual($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function isIdenticalTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::identical($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function isNotIdenticalTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::notIdentical($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function isLessThan(AbstractNode $node): BinaryOp
    {
        return BinaryOp::lessThan($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function isLessThanOrEqualTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::lessThanOrEqual($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function isGreaterThan(AbstractNode $node): BinaryOp
    {
        return BinaryOp::greaterThan($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function isGreaterThanOrEqualTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::greaterThanOrEqual($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function spaceship(AbstractNode $node): BinaryOp
    {
        return BinaryOp::spaceship($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function coalesce(AbstractNode $node): BinaryOp
    {
        return BinaryOp::coalesce($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function bitwiseAnd(AbstractNode $node): BinaryOp
    {
        return BinaryOp::bitwiseAnd($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function bitwiseOr(AbstractNode $node): BinaryOp
    {
        return BinaryOp::bitwiseOr($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function bitwiseXor(AbstractNode $node): BinaryOp
    {
        return BinaryOp::bitwiseXor($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function logicalAnd(AbstractNode $node): BinaryOp
    {
        return BinaryOp::logicalAnd($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function logicalOr(AbstractNode $node): BinaryOp
    {
        return BinaryOp::logicalOr($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function logicalXor(AbstractNode $node): BinaryOp
    {
        return BinaryOp::logicalXor($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function shiftLeft(AbstractNode $node): BinaryOp
    {
        return BinaryOp::shiftLeft($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function shiftRight(AbstractNode $node): BinaryOp
    {
        return BinaryOp::shiftRight($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function toThePowerOf(AbstractNode $node): BinaryOp
    {
        return BinaryOp::pow($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function booleanAnd(AbstractNode $node): BinaryOp
    {
        return BinaryOp::booleanAnd($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     */
    public function booleanOr(AbstractNode $node): BinaryOp
    {
        return BinaryOp::booleanOr($this->validateBinaryOpClass(), $node);
    }

    /**
     * @return AbstractNode
     * @throws \Exception
     */
    private function validateBinaryOpClass(): AbstractNode
    {
        $c = $this;
        if (!$c instanceof AbstractNode) {
            throw new \Exception('BinaryOp Trait can only be used by AbstractNodes');
        }

        return $c;
    }
}
