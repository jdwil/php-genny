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

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Traits\DocBlockTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NestedNodeTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NodeBehaviorTrait;
use PhpParser\Comment\Doc;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Nop;

class Interface_ extends AbstractNode implements HasNodeBehaviorInterface
{
    use NodeBehaviorTrait;
    use NestedNodeTrait;
    use DocBlockTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string[]
     */
    protected $extends;

    /**
     * @var array
     */
    protected $nodes;

    /**
     * @param string $name
     * @return Interface_
     */
    public static function new(
        string $name
    ): Interface_ {
        $ret = new static();
        $ret->name = $name;
        $ret->extends = [];

        return $ret;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Builder) {
            throw new \Exception('Parent of Interface_ must be an instance of Builder');
        }

        return $this->parent;
    }

    /**
     * @return Interface_
     */
    public function lineBreak(): Interface_
    {
        $this->nodes[] = Node::new(Nop::class, []);

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function extends(string $name)
    {
        $this->extends[] = $name;

        return $this;
    }

    /**
     * @param string $name
     * @param AbstractNode $value
     * @return ClassConstant
     */
    public function constant(string $name, AbstractNode $value): ClassConstant
    {
        $constant = ClassConstant::new($name, $value);
        $constant->setParent($this);
        $this->nodes[] = $constant;

        return $constant;
    }

    /**
     * @param string $name
     * @return Method
     */
    public function method(string $name): Method
    {
        $method = Method::new($name);
        $method->setParent($this);
        $this->nodes[] = $method;

        return $method;
    }

    /**
     * @return \PhpParser\Node\Stmt\Interface_
     */
    public function getStatements(): \PhpParser\Node\Stmt\Interface_
    {
        $ret = new \PhpParser\Node\Stmt\Interface_(
            $this->name,
            [
                'extends' => array_map(function (string $name) {
                    return new Name($name);
                }, $this->extends),
                'stmts' => array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $this->nodes)
            ]
        );

        if ($this->hasComment()) {
            $ret->setDocComment(new Doc($this->getComments()));
        }

        return $ret;
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }
}
