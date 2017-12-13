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

use JDWil\PhpGenny\ValueObject\Visibility;
use PhpParser\Node\Stmt\Class_;

trait VisibilityTrait
{
    protected $visibility;

    public function makePrivate()
    {
        $this->visibility = Visibility::isPrivate();

        return $this;
    }

    public function makeProtected()
    {
        $this->visibility = Visibility::isProtected();

        return $this;
    }

    public function makePublic()
    {
        $this->visibility = Visibility::isPublic();

        return $this;
    }

    protected function addVisibilityFlags(int $flags): int
    {
        switch ((string) $this->visibility) {
            case Visibility::PUBLIC:
                $flags ^= Class_::MODIFIER_PUBLIC;
                break;

            case Visibility::PROTECTED:
                $flags ^= Class_::MODIFIER_PROTECTED;
                break;

            case Visibility::PRIVATE:
                $flags ^= Class_::MODIFIER_PRIVATE;
                break;
        }

        return $flags;
    }
}
