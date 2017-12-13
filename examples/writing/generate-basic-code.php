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

use JDWil\PhpGenny\Builder\BuilderFactory;
use JDWil\PhpGenny\Type\Class_;
use JDWil\PhpGenny\Type\Interface_;
use JDWil\PhpGenny\Type\Method;
use JDWil\PhpGenny\Type\Parameter;
use JDWil\PhpGenny\Type\Trait_;
use JDWil\PhpGenny\ValueObject\InternalType;
use JDWil\PhpGenny\Writer\TypeWriter;
use PhpParser\PrettyPrinter\Standard;

$logMethod = new Method('log');
$logMethod->addParameter(
    new Parameter('message', InternalType::string(), '')
);

$interface = new Interface_('LoggingInterface');
$interface->setNamespace('Interfaces');
$interface->addMethod($logMethod);

$trait = new Trait_('LoggingTrait');
$trait->setNamespace('Traits');
$trait->addMethod($logMethod);

$class = new Class_('MyClass');
$class->setNamespace('Classes');
$class->implements($interface);
$class->addTrait($trait);

$writer = new TypeWriter(
    new BuilderFactory(),
    new Standard()
);
$writer->setBaseDirectory('/tmp');
$writer->setNamespacePrefix('My\\Project');

$writer->writeAll([
    $interface,
    $trait,
    $class
]);
