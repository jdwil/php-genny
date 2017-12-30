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

use JDWil\PhpGenny\Builder\Node\Traits\AssignmentOpTrait;
use JDWil\PhpGenny\Builder\Node\Traits\ObjectBehaviorTrait;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Name;

class Reference extends AbstractNode
{
    use AssignmentOpTrait;
    use ObjectBehaviorTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \JDWil\PhpGenny\Type\Class_|\JDWil\PhpGenny\Type\Interface_
     */
    protected $referenceObject;

    public static function self()
    {
        return static::buildStaticReference('self');
    }

    public static function parent()
    {
        return static::buildStaticReference('parent');
    }

    public static function static()
    {
        return static::buildStaticReference('static');
    }

    public static function class($name)
    {
        if (is_string($name)) {
            return static::buildStaticReference($name);
        }

        $ret = new static;
        $ret->referenceObject = $name;

        return $ret;
    }

    public function getStatements()
    {
        if (null !== $this->name) {
            return new Name($this->name);
        }

        return new Name($this->referenceObject->getName());
    }

    /**
     * @param string $name
     * @return Node
     */
    public function staticProperty(string $name): Node
    {
        return Node::new(StaticPropertyFetch::class, [$this->getStatements(), $name]);
    }

    /**
     * @param string $name
     * @return Node
     */
    public function constant(string $name): Node
    {
        return Node::new(ClassConstFetch::class, [$this->getStatements(), $name]);
    }

    public function getNodes(): array
    {
        return [
            'referenceObject' => $this->referenceObject
        ];
    }

    /**
     * @return \JDWil\PhpGenny\Type\Class_|\JDWil\PhpGenny\Type\Interface_|null
     */
    public function getReferenceObject()
    {
        return $this->referenceObject;
    }

    /**
     * @param string $name
     * @return Reference
     */
    protected static function buildStaticReference(string $name): Reference
    {
        $ret = new static();
        $ret->name = $name;

        return $ret;
    }
}
