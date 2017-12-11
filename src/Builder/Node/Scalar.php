<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\BinaryOpTrait;
use JDWil\PhpGenny\ValueObject\InternalType;
use PhpParser\Node\Scalar\DNumber;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;

class Scalar extends AbstractNode implements ResultTypeInterface
{
    use BinaryOpTrait;

    protected $value;
    protected $type;

    public static function string(string $value)
    {
        $ret = new Scalar();
        $ret->value = $value;
        $ret->type = String_::class;

        return $ret;
    }

    public static function float(float $value)
    {
        $ret = new Scalar();
        $ret->value = $value;
        $ret->type = DNumber::class;

        return $ret;
    }

    public static function int(int $value)
    {
        $ret = new Scalar();
        $ret->value = $value;
        $ret->type = LNumber::class;

        return $ret;
    }

    /**
     * @return InternalType|string
     */
    public function getResultType()
    {
        switch ($this->type) {
            case String_::class:
                return InternalType::string();
            case DNumber::class:
                return InternalType::float();
            case LNumber::class:
                return InternalType::int();
            default:
                return InternalType::string();
        }
    }

    public function getStatements()
    {
        return new $this->type($this->value);
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [];
    }
}
