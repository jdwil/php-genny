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

use JDWil\PhpGenny\ValueObject\InternalType;
use PhpParser\Node\Param;

/**
 * Class Parameter
 */
class Parameter extends AbstractNode
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var InternalType|string
     */
    protected $type;

    /**
     * @var bool
     */
    protected $byRef;

    /**
     * @var bool
     */
    protected $variadic;

    /**
     * @var AbstractNode
     */
    protected $default;

    /**
     * @param string $name
     * @return Parameter
     */
    public static function named(string $name): Parameter
    {
        $ret = new Parameter();
        $ret->name = $name;

        return $ret;
    }

    /**
     * @param InternalType|string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return $this
     */
    public function makeByRef()
    {
        $this->byRef = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function makeVariadic()
    {
        $this->variadic = true;

        return $this;
    }

    /**
     * @param AbstractNode $default
     * @return $this
     */
    public function setDefault(AbstractNode $default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @return Param
     */
    public function getStatements(): Param
    {
        $default = $this->default ?
            $this->default->getStatements() :
            null
        ;

        return new Param($this->name, $default, (string) $this->type, $this->byRef, $this->variadic);
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [
            'default' => $this->default
        ];
    }
}
