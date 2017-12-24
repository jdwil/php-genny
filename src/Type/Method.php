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

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\ValueObject\InternalType;
use JDWil\PhpGenny\ValueObject\Visibility;

/**
 * Class Method
 */
class Method
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
    protected $abstract;

    /**
     * @var bool
     */
    protected $final;

    /**
     * @var Parameter[]
     */
    protected $parameters;

    /**
     * @var InternalType[]|Class_[]|Interface_[]|string[]
     */
    protected $returnTypes;

    /**
     * @var Builder
     */
    protected $body;

    /**
     * Method constructor.
     * @param string $name
     * @param Visibility $visibility
     * @param bool $final
     * @param bool $abstract
     * @param array $parameters
     * @param array $returnTypes
     * @internal param Class_|Interface_|InternalType|string $returnType
     */
    public function __construct(
        string $name,
        Visibility $visibility = null,
        bool $final = false,
        bool $abstract = false,
        array $parameters = [],
        array $returnTypes = []
    ) {
        $this->name = $name;
        $this->visibility = $visibility ?? Visibility::isPublic();
        $this->final = $final;
        $this->abstract = $abstract;
        $this->parameters = $parameters;
        $this->returnTypes = $returnTypes;
        $this->body = new Builder();
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
     * @return Builder
     */
    public function getBody(): Builder
    {
        return $this->body;
    }

    /**
     * @param Parameter $parameter
     */
    public function addParameter(Parameter $parameter)
    {
        $this->parameters[] = $parameter;
    }

    /**
     * @return Parameter[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @param Parameter $parameter
     */
    public function removeParameter(Parameter $parameter)
    {
        $key = array_search($parameter, $this->parameters, true);
        if ($key !== false) {
            array_splice($this->parameters, $key, 1);
        }
    }

    /**
     * @return Class_[]|Interface_[]|InternalType[]|string[]
     */
    public function getReturnTypes(): array
    {
        return $this->returnTypes;
    }

    /**
     * @param Class_[]|Interface_[]|InternalType[]|string[] $returnTypes
     */
    public function setReturnTypes(array $returnTypes)
    {
        $this->returnTypes = $returnTypes;
    }

    /**
     * @param Class_|Interface_|InternalType|string $returnType
     */
    public function addReturnType($returnType)
    {
        $this->returnTypes[] = $returnType;
    }

    /**
     * @return Method
     */
    public function copy(): Method
    {
        $m = new Method($this->name);
        foreach ($this->parameters as $parameter) {
            $m->addParameter($parameter);
        }
        $m->setReturnTypes($this->returnTypes);
        $m->setAbstract($this->abstract);
        $m->setFinal($this->final);
        $m->setVisibility($this->visibility);
        $m->body->setNodes($this->body->getNodes());

        return $m;
    }
}
