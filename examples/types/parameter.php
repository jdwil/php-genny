<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use JDWil\PhpGenny\Type\Parameter;
use JDWil\PhpGenny\ValueObject\InternalType;

$p = new Parameter('$foo', InternalType::string(), 'default');

$p->getName(); // is '$foo'
$p->getType()->isString(); // is true
$p->getDefaultValue(); // is 'default'

$p = new Parameter('foo', 'mixed');

$p->getName(); // is '$foo'
$p->getType(); // is 'mixed'

exit(0);
