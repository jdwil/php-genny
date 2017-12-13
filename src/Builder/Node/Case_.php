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

class Case_ extends Builder
{
    /**
     * @var AbstractNode|null
     */
    protected $condition;

    /**
     * @param AbstractNode|null $condition
     * @return Case_
     */
    public static function new(AbstractNode $condition = null): Case_
    {
        $ret = new static();
        $ret->condition = $condition;

        return $ret;
    }

    /**
     * @return Switch_
     * @throws \Exception
     */
    public function done(): Switch_
    {
        if (!$this->parent instanceof Switch_) {
            throw new \Exception('Parent of Case_ must be a Switch_');
        }

        return $this->parent;
    }

    public function getStatements()
    {
        $condition = null === $this->condition ?
            null :
            $this->condition->getStatements()
        ;

        return new \PhpParser\Node\Stmt\Case_($condition, parent::getStatements());
    }
}
