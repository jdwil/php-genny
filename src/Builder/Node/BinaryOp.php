<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\ValueObject\InternalType;
use PhpParser\Node\Expr\BinaryOp\BitwiseAnd;
use PhpParser\Node\Expr\BinaryOp\BitwiseOr;
use PhpParser\Node\Expr\BinaryOp\BitwiseXor;
use PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use PhpParser\Node\Expr\BinaryOp\BooleanOr;
use PhpParser\Node\Expr\BinaryOp\Coalesce;
use PhpParser\Node\Expr\BinaryOp\Div;
use PhpParser\Node\Expr\BinaryOp\Equal;
use PhpParser\Node\Expr\BinaryOp\Greater;
use PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;
use PhpParser\Node\Expr\BinaryOp\Identical;
use PhpParser\Node\Expr\BinaryOp\LogicalAnd;
use PhpParser\Node\Expr\BinaryOp\LogicalOr;
use PhpParser\Node\Expr\BinaryOp\LogicalXor;
use PhpParser\Node\Expr\BinaryOp\Minus;
use PhpParser\Node\Expr\BinaryOp\Mod;
use PhpParser\Node\Expr\BinaryOp\Mul;
use PhpParser\Node\Expr\BinaryOp\NotEqual;
use PhpParser\Node\Expr\BinaryOp\NotIdentical;
use PhpParser\Node\Expr\BinaryOp\Plus;
use PhpParser\Node\Expr\BinaryOp\Pow;
use PhpParser\Node\Expr\BinaryOp\ShiftLeft;
use PhpParser\Node\Expr\BinaryOp\ShiftRight;
use PhpParser\Node\Expr\BinaryOp\Smaller;
use PhpParser\Node\Expr\BinaryOp\SmallerOrEqual;
use PhpParser\Node\Expr\BinaryOp\Spaceship;
use PhpParser\Node\Expr\Instanceof_;
use TheSeer\Tokenizer\Exception;

class BinaryOp extends AbstractNode implements ResultTypeInterface
{
    const PLUS = 0;
    const MINUS = 1;
    const DIVIDE = 2;
    const MULTIPLY = 3;
    const BITWISE_AND = 4;
    const BITWISE_OR = 5;
    const BITWISE_XOR = 6;
    const BOOLEAN_AND = 7;
    const BOOLEAN_OR = 8;
    const COALESCE = 9;
    const CONCAT = 10;
    const EQUAL = 11;
    const GREATER_THAN = 12;
    const GREATER_THAN_OR_EQUAL = 13;
    const IDENTICAL = 14;
    const LOGICAL_AND = 15;
    const LOGICAL_OR = 16;
    const MOD = 17;
    const NOT_EQUAL = 18;
    const NOT_IDENTICAL = 19;
    const POW = 20;
    const SHIFT_LEFT = 21;
    const SHIFT_RIGHT = 22;
    const LESS_THAN = 23;
    const LESS_THAN_OR_EQUAL = 24;
    const SPACESHIP = 25;
    const LOGICAL_XOR = 26;
    const INSTANCE_OF = 27;

    /**
     * @var AbstractNode
     */
    protected $left;

    /**
     * @var AbstractNode
     */
    protected $right;

    /**
     * @var string
     */
    protected $type;

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function add(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::PLUS, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function subtract(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::MINUS, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function divide(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::DIVIDE, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function multiply(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::MULTIPLY, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function mod(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::MOD, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function bitwiseAnd(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::BITWISE_AND, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function bitwiseOr(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::BITWISE_OR, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function bitwiseXor(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::BITWISE_XOR, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function coalesce(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::COALESCE, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function concat(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::CONCAT, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function equal(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::EQUAL, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function greaterThan(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::GREATER_THAN, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function greaterThanOrEqual(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::GREATER_THAN_OR_EQUAL, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function identical(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::IDENTICAL, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function notIdentical(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::NOT_IDENTICAL, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function logicalAnd(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::LOGICAL_AND, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function logicalOr(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::LOGICAL_OR, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function logicalXor(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::LOGICAL_XOR, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function notEqual(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::NOT_EQUAL, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function shiftLeft(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::SHIFT_LEFT, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function shiftRight(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::SHIFT_RIGHT, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function lessThan(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::LESS_THAN, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function lessThanOrEqual(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::LESS_THAN_OR_EQUAL, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function pow(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::POW, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function spaceship(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::SPACESHIP, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function booleanAnd(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::BOOLEAN_AND, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function booleanOr(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::BOOLEAN_OR, $left, $right);
    }

    /**
     * @param AbstractNode $left
     * @param AbstractNode $right
     * @return BinaryOp
     */
    public static function instanceOf(AbstractNode $left, AbstractNode $right): BinaryOp
    {
        return self::createBinaryOp(self::INSTANCE_OF, $left, $right);
    }

    /**
     * @return InternalType|static
     */
    public function getResultType()
    {
        switch ($this->type) {
            case self::PLUS:
            case self::MINUS:
            case self::DIVIDE:
            case self::MULTIPLY:
            case self::MOD:
                // @todo check for floats
                return InternalType::int();

            case self::BITWISE_XOR:
            case self::BITWISE_OR:
            case self::BITWISE_AND:
            case self::LOGICAL_XOR:
            case self::LOGICAL_OR:
            case self::LOGICAL_AND:
                return InternalType::int();

            case self::CONCAT:
                return InternalType::string();

            case self::GREATER_THAN:
            case self::LESS_THAN:
            case self::GREATER_THAN_OR_EQUAL:
            case self::LESS_THAN_OR_EQUAL:
            case self::IDENTICAL:
            case self::NOT_IDENTICAL:
            case self::INSTANCE_OF:
                return InternalType::bool();

            default:
                return InternalType::mixed();
        }
    }

    public function getStatements()
    {
        switch ($this->type) {
            case self::PLUS:
                return $this->createPhpParserBinaryOp(Plus::class);
            case self::MINUS:
                return $this->createPhpParserBinaryOp(Minus::class);
            case self::DIVIDE:
                return $this->createPhpParserBinaryOp(Div::class);
            case self::MULTIPLY:
                return $this->createPhpParserBinaryOp(Mul::class);
            case self::BITWISE_AND:
                return $this->createPhpParserBinaryOp(BitwiseAnd::class);
            case self::BITWISE_OR:
                return $this->createPhpParserBinaryOp(BitwiseOr::class);
            case self::BITWISE_XOR:
                return $this->createPhpParserBinaryOp(BitwiseXor::class);
            case self::BOOLEAN_AND:
                return $this->createPhpParserBinaryOp(BooleanAnd::class);
            case self::BOOLEAN_OR:
                return $this->createPhpParserBinaryOp(BooleanOr::class);
            case self::COALESCE:
                return $this->createPhpParserBinaryOp(Coalesce::class);
            case self::CONCAT:
                return $this->createPhpParserBinaryOp(\PhpParser\Node\Expr\BinaryOp\Concat::class);
            case self::GREATER_THAN:
                return $this->createPhpParserBinaryOp(Greater::class);
            case self::GREATER_THAN_OR_EQUAL:
                return $this->createPhpParserBinaryOp(GreaterOrEqual::class);
            case self::IDENTICAL:
                return $this->createPhpParserBinaryOp(Identical::class);
            case self::NOT_IDENTICAL:
                return $this->createPhpParserBinaryOp(NotIdentical::class);
            case self::LOGICAL_AND:
                return $this->createPhpParserBinaryOp(LogicalAnd::class);
            case self::LOGICAL_OR:
                return $this->createPhpParserBinaryOp(LogicalOr::class);
            case self::LOGICAL_XOR:
                return $this->createPhpParserBinaryOp(LogicalXor::class);
            case self::MOD:
                return $this->createPhpParserBinaryOp(Mod::class);
            case self::NOT_EQUAL:
                return $this->createPhpParserBinaryOp(NotEqual::class);
            case self::POW:
                return $this->createPhpParserBinaryOp(Pow::class);
            case self::SHIFT_LEFT:
                return $this->createPhpParserBinaryOp(ShiftLeft::class);
            case self::SHIFT_RIGHT:
                return $this->createPhpParserBinaryOp(ShiftRight::class);
            case self::LESS_THAN:
                return $this->createPhpParserBinaryOp(Smaller::class);
            case self::LESS_THAN_OR_EQUAL:
                return $this->createPhpParserBinaryOp(SmallerOrEqual::class);
            case self::SPACESHIP:
                return $this->createPhpParserBinaryOp(Spaceship::class);
            case self::EQUAL:
                return $this->createPhpParserBinaryOp(Equal::class);
            case self::INSTANCE_OF:
                return $this->createPhpParserBinaryOp(Instanceof_::class);
            default:
                throw new Exception('Unknown BinaryOp type: ' . $this->type);
        }
    }

    protected function createPhpParserBinaryOp(string $type)
    {
        return new $type($this->left->getStatements(), $this->right->getStatements());
    }

    protected static function createBinaryOp(int $type, AbstractNode $left, AbstractNode $right)
    {
        $ret = new BinaryOp();
        $ret->type = $type;
        $ret->left = $left;
        $ret->right = $right;

        return $ret;
    }
}
