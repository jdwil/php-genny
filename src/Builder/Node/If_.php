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

class If_ extends Builder
{
    /**
     * @var AbstractNode
     */
    protected $condition;

    /**
     * @var ElseIf_[]
     */
    protected $elseIfs;

    /**
     * @var Else_
     */
    public $else;

    public static function new(AbstractNode $condition)
    {
        $ret = new static();
        $ret->condition = $condition;
        $ret->elseIfs = [];

        return $ret;
    }

    /**
     * @param AbstractNode $condition
     * @return ElseIf_
     */
    public function elseIf(AbstractNode $condition): ElseIf_
    {
        $ret = ElseIf_::new($condition);
        $ret->setParent($this);
        $this->elseIfs[] = $ret;

        return $ret;
    }

    /**
     * @return Else_
     */
    public function else(): Else_
    {
        $ret = Else_::new();
        $ret->setParent($this);
        $this->else = $ret;

        return $ret;
    }

    /**
     * @return AbstractNode
     */
    public function getCondition(): AbstractNode
    {
        return $this->condition;
    }

    /**
     * @return Builder|Foreach_
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Builder) {
            throw new \Exception('If_ must be child of Builder');
        }

        return $this->parent;
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [
            'nodes' => parent::getNodes(),
            'condition' => $this->condition,
            'elseIfs' => $this->elseIfs,
            'else' => $this->else
        ];
    }

    public function getStatements()
    {
        $else = null === $this->else ?
            null :
            $this->else->getStatements()
        ;

        return new \PhpParser\Node\Stmt\If_(
            $this->condition->getStatements(),
            [
                'stmts' => array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $this->nodes),
                'elseifs' => array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $this->elseIfs),
                'else' => $else
            ]
        );
    }
}
