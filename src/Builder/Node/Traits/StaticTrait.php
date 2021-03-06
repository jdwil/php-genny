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

use PhpParser\Node\Stmt\Class_;

trait StaticTrait
{
    /**
     * @var bool
     */
    protected $static;

    /**
     * @return $this
     */
    public function makeStatic()
    {
        $this->static = true;

        return $this;
    }

    /**
     * @param int $flags
     * @return int
     */
    protected function addStaticFlag(int $flags): int
    {
        if ($this->static) {
            $flags ^= Class_::MODIFIER_STATIC;
        }

        return $flags;
    }
}
