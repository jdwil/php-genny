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

namespace JDWil\PhpGenny\Builder\Node;

use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\AssignOp\BitwiseAnd;
use PhpParser\Node\Expr\AssignOp\BitwiseOr;
use PhpParser\Node\Expr\AssignOp\BitwiseXor;
use PhpParser\Node\Expr\AssignOp\Concat;
use PhpParser\Node\Expr\AssignOp\Div;
use PhpParser\Node\Expr\AssignOp\Minus;
use PhpParser\Node\Expr\AssignOp\Mod;
use PhpParser\Node\Expr\AssignOp\Mul;
use PhpParser\Node\Expr\AssignOp\Plus;
use PhpParser\Node\Expr\AssignOp\Pow;
use PhpParser\Node\Expr\AssignOp\ShiftLeft;
use PhpParser\Node\Expr\AssignOp\ShiftRight;
use PhpParser\Node\Expr\AssignRef;
use PhpParser\Node\Expr\PostDec;
use PhpParser\Node\Expr\PostInc;
use PhpParser\Node\Expr\PreDec;
use PhpParser\Node\Expr\PreInc;

/**
 * Class AssignmentOp
 *
 * @method static equals(AbstractNode $variable, AbstractNode $value)
 * @method static bitwiseAndEquals(AbstractNode $variable, AbstractNode $value)
 * @method static bitwiseOrEquals(AbstractNode $variable, AbstractNode $value)
 * @method static bitwiseXorEquals(AbstractNode $variable, AbstractNode $value)
 * @method static dotEquals(AbstractNode $variable, AbstractNode $value)
 * @method static divideEquals(AbstractNode $variable, AbstractNode $value)
 * @method static minusEquals(AbstractNode $variable, AbstractNode $value)
 * @method static modEquals(AbstractNode $variable, AbstractNode $value)
 * @method static multiplyEquals(AbstractNode $variable, AbstractNode $value)
 * @method static plusEquals(AbstractNode $variable, AbstractNode $value)
 * @method static powEquals(AbstractNode $variable, AbstractNode $value)
 * @method static shiftLeftEquals(AbstractNode $variable, AbstractNode $value)
 * @method static shiftRightEquals(AbstractNode $variable, AbstractNode $value)
 * @method static postIncrement()
 * @method static preIncrement()
 * @method static postDecrement()
 * @method static preDecrement()
 * @method static assignReference(AbstractNode $variable, AbstractNode $value)
 */
class AssignmentOp extends AbstractNode
{
    const EQUALS = Assign::class;
    const BITWISEANDEQUALS = BitwiseAnd::class;
    const BITWISEOREQUALS = BitwiseOr::class;
    const BITWISEXOREQUALS = BitwiseXor::class;
    const DOTEQUALS = Concat::class;
    const DIVIDEEQUALS = Div::class;
    const MINUSEQUALS = Minus::class;
    const MODEQUALS = Mod::class;
    const MULTIPLYEQUALS = Mul::class;
    const PLUSEQUALS = Plus::class;
    const POWEQUALS = Pow::class;
    const SHIFTLEFTEQUALS = ShiftLeft::class;
    const SHIFTRIGHTEQUALS = ShiftRight::class;
    const POSTINCREMENT = PostInc::class;
    const PREINCREMENT = PreInc::class;
    const POSTDECREMENT = PostDec::class;
    const PREDECREMENT = PreDec::class;
    const ASSIGNREFERENCE = AssignRef::class;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var AbstractNode
     */
    protected $variable;

    /**
     * @var AbstractNode
     */
    protected $value;

    public static function __callStatic($name, $arguments)
    {
        $const = 'self::' . strtoupper($name);
        if (defined($const)) {
            return self::createAssignmentOp(constant($const), $arguments[0], $arguments[1]);
        }

        throw new \Exception('Unknown assignment type: ' . $name);
    }

    public function getStatements()
    {
        if (null !== $this->value) {
            return new $this->type($this->variable->getStatements(), $this->value->getStatements());
        }

        return new $this->type($this->variable->getStatements());
    }

    protected static function createAssignmentOp(string $type, AbstractNode $variable, AbstractNode $value = null)
    {
        $ret = new AssignmentOp();
        $ret->type = $type;
        $ret->variable = $variable;
        $ret->value = $value;

        return $ret;
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [
            'variable' => $this->variable,
            'value' => $this->value
        ];
    }
}
