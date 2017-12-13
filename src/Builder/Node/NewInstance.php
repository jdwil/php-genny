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

use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;

class NewInstance extends AbstractNode
{
    /**
     * @var mixed
     */
    protected $name;

    /**
     * @var array
     */
    protected $arguments;

    /**
     * @param $name
     * @param array $arguments
     * @return NewInstance
     */
    public static function of($name, array $arguments = []): NewInstance
    {
        $ret = new static();
        $ret->name = $name;
        $ret->arguments = $arguments;

        return $ret;
    }

    /**
     * @return New_
     * @throws \Exception
     */
    public function getStatements(): New_
    {
        if ($this->name instanceof \JDWil\PhpGenny\Type\Class_) {
            $name = $this->name->getName();
        } else if ($this->name instanceof Class_) {
            $name = $this->name->getName();
        } else if (is_string($this->name)) {
            $name = $this->name;
        } else {
            throw new \Exception('Unknown type for class name');
        }

        return new New_(new Name($name), array_map(function ($arg) {
            if ($arg instanceof AbstractNode) {
                return $arg->getStatements();
            }

            return $arg;
        }, $this->arguments));
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [];
    }
}
