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

use JDWil\PhpGenny\Type\Traits\HasMethodsTrait;
use JDWil\PhpGenny\Type\Traits\HasNamespaceTrait;
use JDWil\PhpGenny\Type\Traits\HasPropertiesTrait;
use JDWil\PhpGenny\Type\Traits\HasTraitsTrait;

/**
 * Class Trait_
 */
class Trait_ implements HasPropertiesInterface, HasTraitsInterface, HasMethodsInterface
{
    use HasNamespaceTrait;
    use HasTraitsTrait;
    use HasPropertiesTrait;
    use HasMethodsTrait;

    /**
     * Class_ constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->properties = [];
        $this->methods = [];
    }
}
