<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\ValueObject;
use PhpParser\Node\Stmt\Class_;

/**
 * Class Visibility
 *
 * Enum for property visibility.
 */
class Visibility
{
    const PUBLIC = 'public';
    const PROTECTED = 'protected';
    const PRIVATE = 'private';

    /**
     * @var string
     */
    protected $value;

    private function __construct() {}

    /**
     * @return Visibility
     */
    public static function isPublic(): Visibility
    {
        $ret = new static();
        $ret->value = self::PUBLIC;

        return $ret;
    }

    /**
     * @return Visibility
     */
    public static function isPrivate(): Visibility
    {
        $ret = new static();
        $ret->value = self::PRIVATE;

        return $ret;
    }

    /**
     * @return Visibility
     */
    public static function isProtected(): Visibility
    {
        $ret = new static();
        $ret->value = self::PROTECTED;

        return $ret;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function toPhpParserConstant(): int
    {
        switch ($this->value) {
            case self::PUBLIC:
                return Class_::MODIFIER_PUBLIC;
            case self::PROTECTED:
                return Class_::MODIFIER_PROTECTED;
            case self::PRIVATE:
                return Class_::MODIFIER_PRIVATE;
        }
    }
}
