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

class For_ extends Builder
{
    /**
     * @var AbstractNode|null
     */
    protected $init;

    /**
     * @var AbstractNode|null
     */
    protected $condition;

    /**
     * @var AbstractNode|null
     */
    protected $loop;

    public static function new(AbstractNode $init, AbstractNode $condition, AbstractNode $loop): For_
    {
        $ret = new static();
        $ret->init = $init;
        $ret->condition = $condition;
        $ret->loop = $loop;

        return $ret;
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Builder) {
            throw new \Exception('Parent of For_ must be a Builder');
        }

        return $this->parent;
    }

    public function getStatements()
    {
        $params = [];
        if (null !== $this->init) {
            if (is_array($this->init)) {
                $params['init'] = array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $this->init);
            } else {
                $params['init'] = [$this->init->getStatements()];
            }
        }

        if (null !== $this->condition) {
            if (is_array($this->condition)) {
                $params['cond'] = array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $this->condition);
            } else {
                $params['cond'] = [$this->condition->getStatements()];
            }
        }

        if (null !== $this->loop) {
            if (is_array($this->loop)) {
                $params['loop'] = array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $this->loop);
            } else {
                $params['loop'] = [$this->loop->getStatements()];
            }
        }

        $params['stmts'] = array_map(function (AbstractNode $node) {
            return $node->getStatements();
        }, $this->nodes);

        return new \PhpParser\Node\Stmt\For_($params);
    }
}
