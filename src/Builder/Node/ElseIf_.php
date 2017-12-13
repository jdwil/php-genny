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

/**
 * Class ElseIf_
 */
class ElseIf_ extends Builder
{
    /**
     * @var AbstractNode
     */
    protected $condition;

    /**
     * @param AbstractNode $condition
     * @return ElseIf_
     */
    public static function new(AbstractNode $condition): ElseIf_
    {
        $ret = new static();
        $ret->condition = $condition;

        return $ret;
    }

    /**
     * @return Else_
     * @throws \Exception
     */
    public function else(): Else_
    {
        if (!$this->parent instanceof If_) {
            throw new \Exception('Parent of ElseIf_ must be If_');
        }

        $ret = Else_::new();
        $ret->setParent($this->parent);
        $this->parent->else = $ret;

        return $ret;
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof If_) {
            throw new \Exception('ElseIf_ must be nested in If_');
        }

        return $this->parent->parent;
    }

    /**
     * @return \PhpParser\Node\Stmt\ElseIf_
     */
    public function getStatements(): \PhpParser\Node\Stmt\ElseIf_
    {
        return new \PhpParser\Node\Stmt\ElseIf_(
            $this->condition->getStatements(),
            array_map(function (AbstractNode $node) {
                return $node->getStatements();
            }, $this->nodes)
        );
    }
}
