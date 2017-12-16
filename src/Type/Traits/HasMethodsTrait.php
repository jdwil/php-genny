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

namespace JDWil\PhpGenny\Type\Traits;

use JDWil\PhpGenny\Type\Class_;
use JDWil\PhpGenny\Type\Method;

/**
 * Trait HasMethodsTrait
 */
trait HasMethodsTrait
{
    /**
     * @var Method[]
     */
    protected $methods = [];

    /**
     * @param Method $method
     */
    public function addMethod(Method $method)
    {
        $this->methods[] = $method;

        if ($this instanceof Class_) {
            $this->pruneUnneededMethods();
        }
    }

    /**
     * @return Method[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param Method $method
     * @return bool
     */
    public function hasMethod(Method $method): bool
    {
        foreach ($this->methods as $m) {
            if ($m->getName() === $method->getName()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Method $method
     */
    public function removeMethod(Method $method)
    {
        $key = array_search($method, $this->methods, true);
        if ($key !== false) {
            array_splice($this->methods, $key, 1);
        }
    }

    /**
     * @param string $name
     * @return false|Method
     */
    public function getMethodByName(string $name)
    {
        foreach ($this->methods as $method) {
            if ($method->getName() === $name) {
                return $method;
            }
        }

        return false;
    }
}
