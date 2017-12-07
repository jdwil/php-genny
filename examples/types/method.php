<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use JDWil\PhpGenny\Type\Method;
use JDWil\PhpGenny\Type\Parameter;
use JDWil\PhpGenny\ValueObject\InternalType;

$m = new Method('bar');

$m->isFinal(); // is false
$m->setFinal(true);
$m->isFinal(); // is true

$m->isAbstract(); // is false
$m->setAbstract(true);
$m->isAbstract(); // is true

$m->getName(); // is 'bar'
$m->setName('foo');
$m->getName(); // is 'foo'

$p = new Parameter(
    '$foo',
    InternalType::string(),
    'default'
);

$m->getParameters(); // is empty
$m->addParameter($p);
$m->getParameters(); // contains 1 element. contains $p.

exit(0);
