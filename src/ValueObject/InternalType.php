<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\ValueObject;

use JDWil\PhpGenny\Type\Class_;

class InternalType
{
    const INT = 'int';
    const STRING = 'string';
    const FLOAT = 'float';
    const BOOL = 'bool';
    const ARRAY = 'array';
    const OBJECT = 'stdClass';
    const MIXED = 'mixed';
    const NULL = 'null';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var InternalType|Class_|string
     */
    protected $arrayType;

    private function __construct() {}

    public static function null()
    {
        $ret = new static();
        $ret->type = self::NULL;

        return $ret;
    }

    public static function int()
    {
        $ret = new static();
        $ret->type = self::INT;

        return $ret;
    }

    public static function string()
    {
        $ret = new static();
        $ret->type = self::STRING;

        return $ret;
    }

    public static function float()
    {
        $ret = new static();
        $ret->type = self::FLOAT;

        return $ret;
    }

    public static function bool()
    {
        $ret = new static();
        $ret->type = self::BOOL;

        return $ret;
    }

    public static function array()
    {
        $ret = new static();
        $ret->type = self::ARRAY;

        return $ret;
    }

    public static function arrayOf($type)
    {
        $ret = new static();
        $ret->type = self::ARRAY;
        $ret->arrayType = $type;

        return $ret;
    }

    /**
     * @return InternalType
     */
    public static function mixed(): InternalType
    {
        $ret = new static();
        $ret->type = self::MIXED;

        return $ret;
    }

    public function __toString(): string
    {
        return $this->type;
    }

    public function getArrayType()
    {
        if (!self::ARRAY === $this->type) {
            throw new \Exception('Only arrays can have an array type.');
        }

        return $this->arrayType;
    }

    public function isArray(): bool
    {
        return self::ARRAY === $this->type;
    }

    public function isString(): bool
    {
        return self::STRING === $this->type;
    }

    public function isInt(): bool
    {
        return self::INT === $this->type;
    }

    public function isNull(): bool
    {
        return self::NULL === $this->type;
    }
}
