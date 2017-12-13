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

namespace JDWil\PhpGenny\Type;

/**
 * Class File
 */
class File
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var bool
     */
    protected $strict;

    /**
     * @var Class_[]
     */
    protected $classes;

    /**
     * @var Interface_[]
     */
    protected $interfaces;

    /**
     * @var Trait_[]
     */
    protected $traits;

    /**
     * @var Function_[]
     */
    protected $functions;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->classes = [];
        $this->interfaces = [];
        $this->traits = [];
        $this->functions = [];
    }

    /**
     * @param Class_ $class
     */
    public function addClass(Class_ $class)
    {
        $this->classes[] = $class;
    }

    /**
     * @param Class_ $class
     */
    public function removeClass(Class_ $class)
    {
        $key = array_search($class, $this->classes, true);
        if ($key !== false) {
            array_splice($this->classes, $key, 1);
        }
    }

    /**
     * @param Interface_ $interface
     */
    public function addInterface(Interface_ $interface)
    {
        $this->interfaces[] = $interface;
    }

    /**
     * @param Interface_ $interface
     */
    public function removeInterface(Interface_ $interface)
    {
        $key = array_search($interface, $this->interfaces, true);
        if ($key !== false) {
            array_splice($this->interfaces, $key, 1);
        }
    }

    /**
     * @param Trait_ $trait
     */
    public function addTrait(Trait_ $trait)
    {
        $this->traits[] = $trait;
    }

    /**
     * @param Trait_ $trait
     */
    public function removeTrait(Trait_ $trait)
    {
        $key = array_search($trait, $this->traits, true);
        if ($key !== false) {
            array_splice($this->traits, $key, 1);
        }
    }

    /**
     * @param Function_ $function
     */
    public function addFunction(Function_ $function)
    {
        $this->functions[] = $function;
    }

    /**
     * @param Function_ $function
     */
    public function removeFunction(Function_ $function)
    {
        $key = array_search($function, $this->functions, true);
        if ($key !== false) {
            array_splice($this->functions, $key, 1);
        }
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return bool
     */
    public function isStrict(): bool
    {
        return $this->strict;
    }

    /**
     * @return Class_[]
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * @return Interface_[]
     */
    public function getInterfaces(): array
    {
        return $this->interfaces;
    }

    /**
     * @return Trait_[]
     */
    public function getTraits(): array
    {
        return $this->traits;
    }

    /**
     * @return Function_[]
     */
    public function getFunctions(): array
    {
        return $this->functions;
    }
}
