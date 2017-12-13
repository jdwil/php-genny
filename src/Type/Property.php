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

use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Type;
use JDWil\PhpGenny\ValueObject\InternalType;
use JDWil\PhpGenny\ValueObject\Visibility;

/**
 * Class Property
 */
class Property
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var Visibility
     */
    protected $visibility;

    /**
     * @var bool
     */
    protected $static;


    /**
     * @var InternalType|string
     */
    protected $type;

    /**
     * @var Class_|string
     */
    protected $defaultValue;

    /**
     * Property constructor.
     * @param string $name
     * @param Visibility|null $visibility
     * @param mixed $type
     * @param mixed $default
     * @param bool $static
     */
    public function __construct(
        string $name,
        Visibility $visibility = null,
        $type = null,
        $default = null,
        bool $static = false
    ) {
        $this->name = $name;

        if (null === $visibility) {
            $visibility = Visibility::isPublic();
        }
        $this->visibility = $visibility;

        if (null === $type) {
            $type = InternalType::mixed();
        }
        $this->type = $type;

        $this->defaultValue = $default;
        $this->static = $static;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return Visibility
     */
    public function getVisibility(): Visibility
    {
        return $this->visibility;
    }

    /**
     * @param Visibility $visibility
     */
    public function setVisibility(Visibility $visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return InternalType|string
     */
    public function getType()
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
     * @return Class_|Scalar|Type
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param Class_|Scalar|Type $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return bool
     */
    public function isStatic(): bool
    {
        return $this->static;
    }

    /**
     * @param bool $static
     */
    public function setStatic(bool $static)
    {
        $this->static = $static;
    }
}
