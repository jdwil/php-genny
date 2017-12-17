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

use JDWil\PhpGenny\Builder\Node\Traits\ArrayAccessTrait;
use JDWil\PhpGenny\Builder\Node\Traits\AssignmentOpTrait;
use JDWil\PhpGenny\Builder\Node\Traits\BinaryOpTrait;
use JDWil\PhpGenny\Builder\Node\Traits\ObjectBehaviorTrait;
use PhpParser\Node\Expr\StaticPropertyFetch;

/**
 * Class StaticPropertyReference
 */
class StaticPropertyReference extends AbstractNode
{
    use BinaryOpTrait;
    use AssignmentOpTrait;
    use ArrayAccessTrait;
    use ObjectBehaviorTrait;

    /**
     * @var string
     */
    protected $property;

    /**
     * @param string $variable
     * @param string $property
     * @return StaticPropertyReference
     */
    public static function new(string $variable, string $property): StaticPropertyReference
    {
        $ret = new static();
        $ret->name = $variable;
        $ret->property = $property;

        return $ret;
    }

    /**
     * @return StaticPropertyFetch
     */
    public function getStatements(): StaticPropertyFetch
    {
        return new StaticPropertyFetch(new \PhpParser\Node\Expr\Variable($this->name), $this->property);
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [];
    }
}
