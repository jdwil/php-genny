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
use PhpParser\Node\Expr\Cast\Array_;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\Cast\Double;
use PhpParser\Node\Expr\Cast\Int_;
use PhpParser\Node\Expr\Cast\Object_;
use PhpParser\Node\Expr\Cast\String_;

class Cast extends AbstractNode implements ResultTypeInterface
{
    use BinaryOpTrait;

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
