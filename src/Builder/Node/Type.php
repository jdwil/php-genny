<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name;

class Type extends AbstractNode
{
    const NULL = 'null';
    const FALSE = 'false';
    const TRUE = 'true';

    protected $type;

    public static function null()
    {
        return static::buildType(self::NULL);
    }

    public static function true()
    {
        return static::buildType(self::TRUE);
    }

    public static function false()
    {
        return static::buildType(self::FALSE);
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return self::NULL === $this->type;
    }

    public function getStatements()
    {
        return new ConstFetch(new Name($this->type));
    }

    private static function buildType(string $type)
    {
        $ret = new static();
        $ret->type = $type;

        return $ret;
    }
}
