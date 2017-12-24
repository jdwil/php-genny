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
use JDWil\PhpGenny\Type\Traits\HasMethodsTrait;
use JDWil\PhpGenny\Type\Traits\HasNamespaceTrait;
use JDWil\PhpGenny\Type\Traits\HasPropertiesTrait;
use JDWil\PhpGenny\Type\Traits\HasTraitsTrait;
use JDWil\PhpGenny\ValueObject\InternalType;

/**
 * Class Class_
 */
class Class_ implements HasConstantsInterface, HasTraitsInterface, HasPropertiesInterface, HasMethodsInterface
{
    use HasNamespaceTrait;
    use HasConstantsTrait;
    use HasTraitsTrait;
    use HasPropertiesTrait;
    use HasMethodsTrait;

    /**
     * @var bool
     */
    protected $abstract;

    /**
     * @var bool
     */
    protected $final;

    /**
     * @var Class_|string
     */
    protected $extends;

    /**
     * @var Interface_[]|string[]
     */
    protected $implements;

    /**
     * Class_ constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->abstract = false;
        $this->final = false;
        $this->implements = [];
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return bool
     */
    public function isAbstract(): bool
    {
        return $this->abstract;
    }

    /**
     * @param bool $abstract
     */
    public function setAbstract(bool $abstract)
    {
        $this->abstract = $abstract;
        $this->pruneUnneededMethods();
    }

    /**
     * @return bool
     */
    public function isFinal(): bool
    {
        return $this->final;
    }

    /**
     * @param bool $final
     */
    public function setFinal(bool $final)
    {
        $this->final = $final;
    }

    /**
     * @return Class_|string
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * @param Class_|string $extends
     */
    public function setExtends($extends)
    {
        $this->extends = $extends;

        if ($extends instanceof self) {
            foreach ($extends->getImplements() as $implement) {
                $this->removeImplement($implement);
            }
        }
    }

    /**
     * @param Interface_ $implement
     * @return bool
     */
    public function hasImplement(Interface_ $implement): bool
    {
        foreach ($this->implements as $i) {
            if ($i->getFqn() === $implement->getFqn()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param Interface_ $implement
     */
    public function implements(Interface_ $implement)
    {
        if (null === $this->extends || !$this->extends->hasImplement($implement)) {
            $this->implements[] = $implement;
        }

        foreach ($implement->getMethods() as $method) {
            if (!$this->hasMethod($method)) {
                $this->addMethod($method->copy());
            }
        }
    }

    /**
     * @param Interface_ $implement
     */
    public function removeImplement(Interface_ $implement)
    {
        $key = array_search($implement, $this->implements, true);
        if ($key !== false) {
            array_splice($this->implements, $key, 1);
        }
    }

    /**
     * @return array
     */
    public function getImplements(): array
    {
        return $this->implements;
    }

    protected function pruneUnneededMethods()
    {
        /** @var Method[] $methods */
        $methods = [];

        foreach ($this->implements as $implement) {
            if ($implement instanceof Interface_) {
                $methods = array_merge($methods, (array) $implement->getMethods());
            }
        }

        foreach ($methods as $method) {
            foreach ($this->traits as $trait) {
                foreach ($trait->getMethods() as $tMethod) {
                    if ($tMethod === $method) {
                        $this->removeMethod($method);
                    }
                }
            }

            if ($this->abstract && empty($method->getBody()->getNodes())) {
                $this->removeMethod($method);
            }
        }
    }
}
