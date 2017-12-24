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

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\BinaryOpTrait;
use JDWil\PhpGenny\ValueObject\InternalType;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ConstFetch;
use PhpParser\Node\Name;

class Type extends AbstractNode implements ResultTypeInterface
{
    use BinaryOpTrait;

    const NULL = 'null';
    const FALSE = 'false';
    const TRUE = 'true';
    const ARRAY = 'array';

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

    /**
     * @param string $name
     * @return Type
     */
    public static function constant(string $name): Type
    {
        return static::buildType($name);
    }

    public static function array(array $values = [], bool $shortHand = true)
    {
        return static::buildType(self::ARRAY, $values, [
            'kind' => $shortHand ? Array_::KIND_SHORT : Array_::KIND_LONG
        ]);
    }

    /**
     * @param array ...$vars
     * @return List_
     */
    public static function list(...$vars): List_
    {
        return List_::new(...$vars);
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
