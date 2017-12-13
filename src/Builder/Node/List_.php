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
use PhpParser\Node\Expr\ArrayItem;

class List_ extends AbstractNode
{
    use AssignmentOpTrait;

    /**
     * @var array
     */
    protected $vars;

    /**
     * @param array ...$vars
     * @return List_
     */
    public static function new(...$vars): List_
    {
        $ret = new List_();
        $ret->vars = $vars;

        return $ret;
    }

    /**
     * @return \PhpParser\Node\Expr\List_
     */
    public function getStatements()
    {
        return new \PhpParser\Node\Expr\List_(array_map(function ($item) {
            if ($item instanceof AbstractNode) {
                return new ArrayItem($item->getStatements());
            }

            return new ArrayItem($item);
        }, $this->vars));
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return $this->vars;
    }
}
