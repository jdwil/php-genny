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
use JDWil\PhpGenny\Type\Trait_;
use JDWil\PhpGenny\ValueObject\Visibility;

/**
 * Trait HasTraitsTrait
 */
trait HasTraitsTrait
{
    /**
     * @var Trait_[]
     */
    protected $traits = [];

    /**
     * @var array
     */
    protected $traitAlias = [];

    /**
     * @var array
     */
    protected $traitPrecedences = [];

    /**
     * @param Trait_ $trait
     */
    public function addTrait(Trait_ $trait)
    {
        $this->traits[] = $trait;

        if ($this instanceof Class_) {
            $this->pruneUnneededMethods();
        }
    }

    /**
     * @return Trait_[]
     */
    public function getTraits(): array
    {
        return $this->traits;
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
     * @param Trait_ $trait
     * @param string $method
     * @param string $newName
     * @param Visibility|null $visibility
     */
    public function aliasTrait(Trait_ $trait, string $method, string $newName, Visibility $visibility = null)
    {
        $this->traitAlias[$trait->getFqn()] = [
            'trait' => $trait->getName(),
            'method' => $method,
            'newName' => $newName,
            'visibility' => $visibility
        ];
    }

    /**
     * @return array
     */
    public function getAlias(): array
    {
        return $this->traitAlias;
    }

    /**
     * @param Trait_ $trait
     * @param string $method
     * @param Trait_[] $otherTraits
     */
    public function setTraitPrecedence(Trait_ $trait, string $method, array $otherTraits)
    {
        $this->traitPrecedences[$trait->getFqn()] = [
            'trait' => $trait->getName(),
            'method' => $method,
            'otherTraits' => $otherTraits
        ];
    }

    /**
     * @return array
     */
    public function getPrecedences(): array
    {
        return $this->traitPrecedences;
    }
}
