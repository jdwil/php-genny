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

namespace JDWil\PhpGenny\Builder\Node\Traits;

use JDWil\PhpGenny\Builder\Node\AbstractNode;
use JDWil\PhpGenny\Builder\Node\Node;
use JDWil\PhpGenny\Builder\Node\PropertyReference;
use JDWil\PhpGenny\Builder\Node\StaticPropertyReference;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;

/**
 * Trait ObjectBehaviorTrait
 */
trait ObjectBehaviorTrait
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string|Variable|\PhpParser\Node\Expr\Variable $name
     * @return PropertyReference
     */
    public function property($name): PropertyReference
    {
        if ($name instanceof AbstractNode) {
            $name = $name->getStatements();
        }

        return PropertyReference::new($this->name, $name);
    }

    /**
     * @param string|Variable|\PhpParser\Node\Expr\Variable $method
     * @param array ...$params
     * @return Node
     * @throws \Exception
     */
    public function call($method, ...$params): Node
    {
        if ($method instanceof AbstractNode) {
            $method = $method->getStatements();
        }

        return Node::new(
            MethodCall::class,
            [
                $this->validateThisIsAnAbstractNode()->getStatements(),
                $method,
                array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $params)
            ]
        );
    }

    /**
     * @param string|Variable|\PhpParser\Node\Expr\Variable $name
     * @return StaticPropertyReference
     */
    public function staticProperty($name): StaticPropertyReference
    {
        if ($name instanceof AbstractNode) {
            $name = $name->getStatements();
        }

        return StaticPropertyReference::new($this->name, $name);
    }

    /**
     * @param string|Variable|\PhpParser\Node\Expr\Variable $method
     * @param array ...$params
     * @return Node
     * @throws \Exception
     */
    public function staticCall($method, ...$params): Node
    {
        if ($method instanceof AbstractNode) {
            $method = $method->getStatements();
        }

        return Node::new(
            StaticCall::class,
            [
                $this->validateThisIsAnAbstractNode()->getStatements(),
                $method,
                array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $params)
            ]
        );
    }

    /**
     * @return AbstractNode
     * @throws \Exception
     */
    protected function validateThisIsAnAbstractNode(): AbstractNode
    {
        $ret = $this;

        if (!$ret instanceof AbstractNode) {
            throw new \Exception('ObjectBehaviorTrait can only be used on an AbstractNode');
        }

        return $ret;
    }
}
