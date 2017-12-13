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

use JDWil\PhpGenny\Type\Interface_;
use JDWil\PhpGenny\Type\Method;

$i = new Interface_('Foo');

$i->setNamespace('Foo\\Bar');
$i->getNamespace(); // is 'Foo\Bar'

$interface = new Interface_('Bar');

$i->getExtends(); // is empty
$i->addExtend($interface);
$i->getExtends(); // contains 1 element
$i->getExtends()[0]->getName(); // is 'Bar'
$i->removeExtend($interface);
$i->getExtends(); // is empty

$method = new Method('foo');
$i->addMethod($method);
$i->getMethods(); // contains 1 element
$i->getMethods()[0]->getName(); // is 'foo'
$i->removeMethod($method);
$i->getMethods(); // is empty

exit(0);
