<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node\Traits;

use JDWil\PhpGenny\Builder\Node\AbstractNode;
use JDWil\PhpGenny\Builder\Node\BinaryOp;

trait BinaryOpTrait
{
    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function concat(AbstractNode $node): BinaryOp
    {
        return BinaryOp::concat($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function plus(AbstractNode $node): BinaryOp
    {
        return BinaryOp::add($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function minus(AbstractNode $node): BinaryOp
    {
        return BinaryOp::subtract($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function dividedBy(AbstractNode $node): BinaryOp
    {
        return BinaryOp::divide($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function multipliedBy(AbstractNode $node): BinaryOp
    {
        return BinaryOp::multiply($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function mod(AbstractNode $node): BinaryOp
    {
        return BinaryOp::mod($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isEqualTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::equal($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isNotEqualTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::notEqual($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isIdenticalTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::identical($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isNotIdenticalTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::notIdentical($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isLessThan(AbstractNode $node): BinaryOp
    {
        return BinaryOp::lessThan($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isLessThanOrEqualTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::lessThanOrEqual($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isGreaterThan(AbstractNode $node): BinaryOp
    {
        return BinaryOp::greaterThan($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isGreaterThanOrEqualTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::greaterThanOrEqual($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function spaceship(AbstractNode $node): BinaryOp
    {
        return BinaryOp::spaceship($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function coalesce(AbstractNode $node): BinaryOp
    {
        return BinaryOp::coalesce($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function bitwiseAnd(AbstractNode $node): BinaryOp
    {
        return BinaryOp::bitwiseAnd($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function bitwiseOr(AbstractNode $node): BinaryOp
    {
        return BinaryOp::bitwiseOr($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function bitwiseXor(AbstractNode $node): BinaryOp
    {
        return BinaryOp::bitwiseXor($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function logicalAnd(AbstractNode $node): BinaryOp
    {
        return BinaryOp::logicalAnd($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function logicalOr(AbstractNode $node): BinaryOp
    {
        return BinaryOp::logicalOr($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function logicalXor(AbstractNode $node): BinaryOp
    {
        return BinaryOp::logicalXor($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function shiftLeft(AbstractNode $node): BinaryOp
    {
        return BinaryOp::shiftLeft($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function shiftRight(AbstractNode $node): BinaryOp
    {
        return BinaryOp::shiftRight($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function toThePowerOf(AbstractNode $node): BinaryOp
    {
        return BinaryOp::pow($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function booleanAnd(AbstractNode $node): BinaryOp
    {
        return BinaryOp::booleanAnd($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function booleanOr(AbstractNode $node): BinaryOp
    {
        return BinaryOp::booleanOr($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function instanceOf(AbstractNode $node): BinaryOp
    {
        return BinaryOp::instanceOf($this->validateBinaryOpClass(), $node);
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
