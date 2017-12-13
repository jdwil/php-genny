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

use JDWil\PhpGenny\ValueObject\InternalType;

/**
 * Class Function_
 */
class Function_
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $namespace;

    /**
     * @var string|null
     */
    protected $body;

    /**
     * @var InternalType|Class_|Interface_|string
     */
    protected $returnType;

    /**
     * Function_ constructor.
     * @param string $name
     * @param string|null $namespace
     * @param string $body
     * @param InternalType|Class_|Interface_|string $returnType
     */
    public function __construct(string $name, string $namespace = null, string $body = '', $returnType)
    {
        $this->name = $name;
        $this->namespace = $namespace;
        $this->body = $body;
        $this->returnType = $returnType;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return string|null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return Class_|Interface_|InternalType|string
     */
    public function getReturnType()
    {
        return $this->returnType;
    }

    /**
     * @param Class_|Interface_|InternalType|string $returnType
     */
    public function setReturnType($returnType)
    {
        $this->returnType = $returnType;
    }
}
