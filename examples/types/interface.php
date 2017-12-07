<?php

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
