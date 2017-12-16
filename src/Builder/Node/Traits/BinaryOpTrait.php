<?php
/**
 * Copyright (c) 2017 JD Williams
 *
 * This file is part of PHP-Genny, a library built by JD Williams. PHP-Genny is free software; you can
 * redistribute it and/or modify it under the terms of the GNU General Public License as published by the
 * Free Software Foundation; either version 3 of the License, or (at your option) any later version.
 *
 * PHP-Genny is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the
 * implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General
 * Public License for more details. You should have received a copy of the GNU Lesser General Public
 * License along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * You should have received a copy of the GNU General Public License along with Unify. If not, see
 * <http://www.gnu.org/licenses/>.
 */

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
        return BinaryOp::_concat($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function plus(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_add($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function minus(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_subtract($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function dividedBy(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_divide($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function multipliedBy(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_multiply($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function mod(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_mod($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isEqualTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_equal($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isNotEqualTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_notEqual($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isIdenticalTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_identical($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isNotIdenticalTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_notIdentical($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isLessThan(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_lessThan($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isLessThanOrEqualTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_lessThanOrEqual($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isGreaterThan(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_greaterThan($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function isGreaterThanOrEqualTo(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_greaterThanOrEqual($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function spaceship(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_spaceship($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function coalesce(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_coalesce($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function bitwiseAnd(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_bitwiseAnd($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function bitwiseOr(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_bitwiseOr($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function bitwiseXor(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_bitwiseXor($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function logicalAnd(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_logicalAnd($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function logicalOr(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_logicalOr($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function logicalXor(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_logicalXor($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function shiftLeft(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_shiftLeft($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function shiftRight(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_shiftRight($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function toThePowerOf(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_pow($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function booleanAnd(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_booleanAnd($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function booleanOr(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_booleanOr($this->validateBinaryOpClass(), $node);
    }

    /**
     * @param AbstractNode $node
     * @return BinaryOp
     * @throws \Exception
     */
    public function instanceOf(AbstractNode $node): BinaryOp
    {
        return BinaryOp::_instanceOf($this->validateBinaryOpClass(), $node);
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
