# Builder

PHP Genny comes with a fluid builder API that serves as a wrapper around 
PHP-Parser's own fluid interface. The builder works with the "Standard"
pretty printer from Php-Parser.

[unify]: # (setup, skip)
```php
<?php

use PhpParser\PrettyPrinter\Standard;

$prettyPrinter = new Standard();
```

You can add generate arbitrary code strings.

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Variable;
use JDWil\PhpGenny\Builder\Node\Scalar;

$b = new Builder();
$b->execute(Variable::named('foo')->equals(Scalar::string('bar')));

$prettyPrinter->prettyPrint($b->getStatements()); // returns: $foo = 'bar';

$b = new Builder();
$b->execute(Variable::named('foo')->plusEquals(Variable::named('bar')->plus(Scalar::int(1))));

$prettyPrinter->prettyPrint($b->getStatements()); // returns: $foo += $bar + 1;
```

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use JDWil\PhpGenny\Builder\Node\Parameter;
use JDWil\PhpGenny\ValueObject\InternalType;
use JDWil\PhpGenny\Builder\Node\Type;
use JDWil\PhpGenny\Builder\Node\NewInstance;

$b = new Builder();
$b
    ->declare('strict_types', Scalar::int(1))
    
    ->namespace('Foo\\Bar')
    
    ->use('Other\\Namespace\\ClassName')
    ->use('Some\\OtherInterface')
    
    ->class('MyClass')
        ->makeFinal()
        ->makeAbstract()
        ->extends('ClassName')
        ->implements('OtherInterface')
        ->implements('Fully\\Qualified\\SomeInterface')
        
        ->constant('MY_CONSTANT', Scalar::int(0))->done()
        
        ->property('FOO')
            ->makePrivate()
            ->makeStatic()
            ->setDefault(Scalar::int(10))
        ->done()
        ->property('bar')->done()
        
        ->method('myMethod')
            ->return(Variable::named('this')->property('bar')->plus(Scalar::int(1)))
        ->done()
        ->method('staticMethod')
            ->makeStatic()
            ->makeFinal()
            ->makeProtected()
            ->add(Parameter::named('param1')->setType(InternalType::string())->setDefault(Scalar::string('default')))
            ->execute(Variable::named('ret')->equals(Variable::named('param1')->concat(Scalar::string('-suffix'))))
            ->execute(Variable::named('foo')->equals(Type::null()))
            ->execute(Variable::named('baz')->equals(NewInstance::of('Foo')))
            ->return(Variable::named('ret'))
        ->done()
        ->method('abstractMethod')
            ->makeAbstract()
        ->done()
    ->done()
;

/**
 * returns:
 * 
 * <?php
 * 
 * declare (strict_types=1);
 * namespace Foo\Bar;
 * 
 * use Other\Namespace\ClassName;
 * use Some\OtherInterface;
 * abstract final class MyClass extends ClassName implements OtherInterface, Fully\Qualified\SomeInterface
 * {
 *     const MY_CONSTANT = 0;
 *     private static $FOO = 10;
 *     public $bar;
 *     public function myMethod()
 *     {
 *         return $this->bar + 1;
 *     }
 *     protected static final function staticMethod(string $param1 = 'default')
 *     {
 *         $ret = $param1 . '-suffix';
 *         return $ret;
 *     }
 *     public abstract function abstractMethod()
 *     {
 *     }
 * }
 */
$prettyPrinter->prettyPrintFile($b->getStatements());
```
