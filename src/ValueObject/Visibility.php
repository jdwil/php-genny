<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\ValueObject;

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
}
