<?php

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
