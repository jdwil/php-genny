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
            case self::PROTECTED:
                return Class_::MODIFIER_PROTECTED;
            case self::PRIVATE:
                return Class_::MODIFIER_PRIVATE;
            default:
                return Class_::MODIFIER_PUBLIC;
        }
    }
}
