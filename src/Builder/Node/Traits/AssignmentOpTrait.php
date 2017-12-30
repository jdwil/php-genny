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
 * @method preIncrement()
 * @method postIncrement()
 * @method preDecrement()
 * @method postDecrement()
 * @method assignReference(AbstractNode $value)
 */
trait AssignmentOpTrait
{
    public function __call($name, $arguments)
    {
        return AssignmentOp::$name($this->validateAssignmentOpClass(), $arguments[0] ?? null);
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
