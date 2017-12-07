<?php
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
        return new $this->type($this->variable->getStatements(), $this->value->getStatements());
    }

    protected static function createAssignmentOp(string $type, AbstractNode $variable, AbstractNode $value)
    {
        $ret = new AssignmentOp();
        $ret->type = $type;
        $ret->variable = $variable;
        $ret->value = $value;

        return $ret;
    }
}
