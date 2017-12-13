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
