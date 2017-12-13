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

require_once __DIR__ . '/../../vendor/autoload.php';

use JDWil\PhpGenny\Type\Property;
use JDWil\PhpGenny\ValueObject\Visibility;
use JDWil\PhpGenny\ValueObject\InternalType;

$p = new Property('foo', Visibility::isProtected(), InternalType::string(), 'bar');

$p->getName(); // is 'foo'
$p->getType()->isString(); // is true
$p->getVisibility(); // is 'protected'
$p->getDefaultValue(); // is 'bar'

exit(0);
