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
use JDWil\PhpGenny\Type\Traits\HasConstantsTrait;
use JDWil\PhpGenny\Type\Traits\HasNamespaceTrait;
use JDWil\PhpGenny\ValueObject\Visibility;

/**
 * Class Interface_
 */
class Interface_ implements NamespaceInterface, HasConstantsInterface
{
    use HasNamespaceTrait;
    use HasConstantsTrait;

    /**
     * @var Interface_[]|string[]
     */
    protected $extends;

    /**
     * @var Method[]
     */
    protected $methods;

    /**
     * Class_ constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->extends = [];
        $this->methods = [];
    }

    /**
     * @return Interface_[]
     */
    public function getExtends(): array
    {
        return $this->extends;
    }

    /**
     * @param Interface_ $extend
     */
    public function addExtend($extend)
    {
        $this->extends[] = $extend;
    }

    /**
     * @param Interface_ $extend
     */
    public function removeExtend(Interface_ $extend)
    {
        $key = array_search($extend, $this->extends, true);
        if ($key !== false) {
            array_splice($this->extends, $key, 1);
        }
    }

    /**
     * @param Method $method
     * @throws \Exception
     */
    public function addMethod(Method $method)
    {
        if ((string) $method->getVisibility() !== Visibility::PUBLIC) {
            throw new \Exception('Interface methods must be public');
        }

        $this->methods[] = $method;
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
     * @return Method[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }
}
