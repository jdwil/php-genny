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
use JDWil\PhpGenny\Builder\Node\Traits\BinaryOpTrait;
use PhpParser\Node\Expr\ArrayDimFetch;

class Array_ extends AbstractNode
{
    use AssignmentOpTrait;
    use BinaryOpTrait;

    const DIM_FETCH = 'dim_fetch';

    protected $type;

    /**
     * @var AbstractNode
     */
    protected $var;

    /**
     * @var AbstractNode|null
     */
    protected $index;

    public static function fetchDimension(AbstractNode $var, AbstractNode $index = null)
    {
        $ret = new static();
        $ret->type = self::DIM_FETCH;
        $ret->var = $var;
        $ret->index = $index;

        return $ret;
    }

    public function getStatements()
    {
        switch ($this->type) {
            case self::DIM_FETCH:
                $index = null === $this->index ? null : $this->index->getStatements();
                return new ArrayDimFetch($this->var->getStatements(), $index);
        }

        return [];
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [
            'var' => $this->var,
            'index' => $this->index
        ];
    }
}
