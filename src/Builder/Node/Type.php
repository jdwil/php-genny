<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\ValueObject\InternalType;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Expr\List_;
use PhpParser\Node\Name;

class Type extends AbstractNode implements ResultTypeInterface
{
    const NULL = 'null';
    const FALSE = 'false';
    const TRUE = 'true';
    const ARRAY = 'array';
    const LIST = 'list';

    protected $type;
    protected $params;
    protected $attributes;

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

    public static function array(array $values = [], bool $shortHand = true)
    {
        return static::buildType(self::ARRAY, $values, [
            'kind' => $shortHand ? Array_::KIND_SHORT : Array_::KIND_LONG
        ]);
    }

    public static function list(AbstractNode $subject)
    {
        return static::buildType(self::LIST, [$subject]);
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
        switch ($this->type) {
            case self::ARRAY:
                return new Array_(
                    array_map(function (AbstractNode $node) {
                        return $node->getStatements();
                    }, $this->params),
                    $this->attributes
                );

            case self::LIST:
                return new List_(array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $this->params));

            default:
                return new ConstFetch(new Name($this->type));
        }
    }

    private static function buildType(string $type, array $params = [], array $attributes = [])
    {
        $ret = new static();
        $ret->type = $type;
        $ret->params = $params;
        $ret->attributes = $attributes;

        return $ret;
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [];
    }

    /**
     * @return InternalType|string
     */
    public function getResultType()
    {
        switch ($this->type) {
            case self::TRUE:
            case self::FALSE:
                return InternalType::bool();
            case self::NULL:
                return InternalType::null();
            case self::ARRAY:
                return InternalType::array();
            default:
                return null;
        }
    }
}
