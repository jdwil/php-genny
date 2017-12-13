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

use JDWil\PhpGenny\Type\Class_;
use JDWil\PhpGenny\Type\Property;
use JDWil\PhpGenny\Type\Method;
use JDWil\PhpGenny\ValueObject\Visibility;
use JDWil\PhpGenny\ValueObject\InternalType;

$c = new Class_();

/**
 * Test namespace
 */
$c->setNamespace('Foo\\Bar');
$c->getNamespace(); // is 'Foo\Bar'

/**
 * Test abstract
 */
$c->isAbstract(); // is false
$c->setAbstract(true);
$c->isAbstract(); // is true

/**
 * Test final
 */
$c->isFinal(); // is false
$c->setFinal(true);
$c->isFinal(); // is true

/**
 * Test properties
 */
$property = new Property(
    'foo',
    Visibility::isPrivate(),
    InternalType::string(),
    'bar'
);
$c->addProperty($property);
$c->getProperties(); // contains 1 element. contains $property.
$c->addProperty($property);
$c->getProperties(); // contains 2 elements. contains $property.
$c->removeProperty($property);
$c->getProperties(); // contains 1 element. contains $property.
$c->removeProperty($property);
$c->getProperties(); // is empty

/**
 * Test methods
 */
$method = new Method('foo');
$c->addMethod($method);
$c->getMethods(); // contains 1 element. contains $method.
$c->addMethod($method);
$c->getMethods(); // contains 2 elements. contains $method.
$c->removeMethod($method);
$c->getMethods(); // contains 1 element. contains $method.
$c->removeMethod($method);
$c->getMethods(); // is empty

exit();
