# PHP-Genny

#### Overview

PHP-Genny is a semantic code generation library. It provides a fluid builder
interface around php-parser's own code generation API's and, perhaps more interestingly,
provides API's for intelligently generating large graphs of interdependent objects.

#### Installation

```shell
composer require jdwil/php-genny
```

#### Docs

The full user documentation can be found 
[here](docs/user/php-genny.md).

#### Example

[unify]: # (skip)
```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use JDWil\PhpGenny\Type\Class_;
use JDWil\PhpGenny\Type\Interface_;
use JDWil\PhpGenny\Type\Method;
use JDWil\PhpGenny\Type\Property;
use JDWil\PhpGenny\ValueObject\InternalType;
use JDWil\PhpGenny\ValueObject\Visibility;

$b = new Builder();

// Construct a class.

$b
    ->namespace('My\\Classes')
    ->class('MyClass')
        ->makeFinal()
        ->makeAbstract()
        
        ->implements('SomeInterface')
        ->extends('SomeClass')
        
        ->property('foo')
            ->makePrivate()
            ->setType(InternalType::string())
            ->setDefault(Scalar::string('default'))
        ->done()
        
        ->method('getFoo')
            ->return(Variable::named('this')->property('foo'))
        ->done()
    ->done()
;

/**
 * Using the builder above, all nodes must be constructed in the proper order.
 * You can do more complex things using the Type classes...
 */

$someInterface = new Interface_('SomeInterface');
$someClass = new Class_('SomeClass');

$getFoo = new Method('getFoo');
$getFoo->getBody()->return(Variable::named('this')->property('foo'));

$class = new Class_('MyClass');
$class->setNamespace('My\\Classes');
$class->setFinal(true);
$class->setAbstract(true);
$class->implements($someInterface);
$class->setExtends($someClass);
$class->addProperty(
    new Property('foo', Visibility::isPrivate(), InternalType::string(), Scalar::string('default'))
);
$class->addMethod($getFoo);
```

#### TODO

1. Better coverage on tests.
1. Function Type support.
