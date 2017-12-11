<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\ValueObject\InternalType;
use PhpParser\Node\Expr\Cast\Array_;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\Cast\Double;
use PhpParser\Node\Expr\Cast\Int_;
use PhpParser\Node\Expr\Cast\Object_;
use PhpParser\Node\Expr\Cast\String_;

class Cast extends AbstractNode implements ResultTypeInterface
{
    const STRING = 'string';
    const INT = 'int';
    const FLOAT = 'float';
    const ARRAY = 'array';
    const BOOL = 'bool';
    const OBJECT = 'object';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var AbstractNode
     */
    protected $argument;

    public static function toString(AbstractNode $node)
    {
        return static::buildCast(self::STRING, $node);
    }

    public static function toFloat(AbstractNode $node)
    {
        return static::buildCast(self::FLOAT, $node);
    }

    public static function toInt(AbstractNode $node)
    {
        return static::buildCast(self::INT, $node);
    }

    public static function toArray(AbstractNode $node)
    {
        return static::buildCast(self::ARRAY, $node);
    }

    public static function toBool(AbstractNode $node)
    {
        return static::buildCast(self::BOOL, $node);
    }

    public static function toObject(AbstractNode $node)
    {
        return static::buildCast(self::OBJECT, $node);
    }

    private static function buildCast(string $type, AbstractNode $node)
    {
        $ret = new static();
        $ret->type = $type;
        $ret->argument = $node;

        return $ret;
    }

    public function getStatements()
    {
        switch ($this->type) {
            case self::STRING:
                return new String_($this->argument->getStatements());
            case self::INT:
                return new Int_($this->argument->getStatements());
            case self::FLOAT:
                return new Double($this->argument->getStatements());
            case self::ARRAY:
                return new Array_($this->argument->getStatements());
            case self::BOOL:
                return new Bool_($this->argument->getStatements());
            case self::OBJECT:
                return new Object_($this->argument->getStatements());
            default:
                return new String_($this->argument->getStatements());
        }
    }

    /**
     * @return InternalType|string
     */
    public function getResultType()
    {
        return InternalType::{$this->type}();
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [
            'argument' => $this->argument
        ];
    }
}
