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
use JDWil\PhpGenny\ValueObject\InternalType;

/**
 * Class Variable
 */
class Variable extends AbstractNode implements ResultTypeInterface
{
    use BinaryOpTrait;
    use AssignmentOpTrait;
    use ArrayAccessTrait;
    use ObjectBehaviorTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var InternalType|string
     */
    protected $type;

    public static function named(string $name): Variable
    {
        $ret = new Variable();
        $ret->name = $name;

        return $ret;
    }

    /**
     * @return \PhpParser\Node\Expr\Variable
     */
    public function getStatements(): \PhpParser\Node\Expr\Variable
    {
        return new \PhpParser\Node\Expr\Variable($this->name);
    }

    /**
     * @return InternalType|string
     */
    public function getResultType()
    {
        return $this->type;
    }

    /**
     * @param InternalType|string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [];
    }
}
