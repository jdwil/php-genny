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

class Parameter
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var InternalType|Class_|Interface_|string
     */
    protected $type;

    /**
     * @var mixed
     */
    protected $defaultValue;

    /**
     * Parameter constructor.
     * @param string $name
     * @param $type
     * @param null $defaultValue
     */
    public function __construct(string $name, $type, $defaultValue = null)
    {
        if ($name[0] === '$') {
            $name = (string) substr($name, 1);
        }

        $this->name = $name;
        $this->type = $type;
        $this->defaultValue = $defaultValue;
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
     * @return InternalType|Class_|Interface_|string
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
     * @return Scalar|Class_|Interface_|Type
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    /**
     * @param Scalar|Class_|Interface_|Type $defaultValue
     */
    public function setDefaultValue($defaultValue)
    {
        $this->defaultValue = $defaultValue;
    }
}
