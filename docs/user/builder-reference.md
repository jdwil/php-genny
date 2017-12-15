# Builder Reference

<a name="toc"/>

### Table of Contents

1. [Arrays](#arrays)
1. [Assignment](#assignment)
1. [Binary Operations](#binaryops)
1. [Casting](#casting)
1. [Classes](#classes)
1. [Do-While Loops](#dowhile)
1. [For Loops](#for)
1. [Foreach Loops](#foreach)
1. [If Statements](#if)
1. [Imports](#imports)
1. [Interfaces](#interfaces)
1. [Logic](#logic)
1. [Methods](#methods)
1. [Namespaces](#namespaces)
1. [NewInstance](#newinstance)
1. [Parameters](#parameters)
1. [Properties](#properties)
1. [Reference](#reference)
1. [ResultOf](#resultof)
1. [Scalar](#scalar)
1. [Switch Statements](#switch)
1. [Traits](#traits)
1. [Try/Catch/Finally](#try)
1. [Type](#type)
1. [Variable](#variable)
1. [While Loops](#while)
1. [Miscellanea](#misc)

<a name="arrays"/>

## Arrays

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Type;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->execute(Variable::named('array')->equals(Type::array()))
    ->execute(Variable::named('arrayWithValues')->equals(Type::array([Scalar::int(1), Scalar::string('foo')], false)))
    ->newLine()
    ->execute(Variable::named('array')->arrayIndex(Scalar::int(0))->equals(Scalar::float(1.1)))
    ->echo(Variable::named('arrayWithValues')->arrayIndex(Scalar::int(0)))
;

/**
 * returns:
 *
 * $array = [];
 * $arrayWithValues = array(1, 'foo');
 *
 * $array[0] = 1.1;
 * echo $arrayWithValues[0]; 
 */
$p->prettyPrint($b->getStatements());
```

<a name='assignment'/>

## Assignment

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Reference;
use JDWil\PhpGenny\Builder\Node\ResultOf;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->inlineComment('Basic assignment')
    ->execute(Variable::named('foo')->equals(Scalar::string('bar')))
    ->execute(Variable::named('foo')->dotEquals(Scalar::string('bar')))
    ->execute(Variable::named('int')->plusEquals(Scalar::int(1)))
    ->execute(Variable::named('int')->minusEquals(Scalar::int(1)))
    ->newLine()
    
    ->inlineComment('By reference')
    ->execute(Variable::named('foo')->assignReference(Variable::named('bar')))
    ->newLine()
        
    ->inlineComment('Assign from function result')
    ->execute(Variable::named('flag')->equals(ResultOf::is_array(Variable::named('var'))))
    ->newLine()
    
    ->inlineComment('Properties')
    ->execute(Variable::named('class')->property('property')->equals(Scalar::string('bar')))
    ->execute(Variable::named('this')->property('property')->equals(Scalar::string('When inside a class')))
    ->execute(Variable::named('class')->staticProperty('STATIC')->equals(Scalar::string('foo')))
    ->execute(Reference::self()->staticProperty('STATIC')->equals(Scalar::string('foo')))
    ->execute(Reference::static()->staticProperty('STATIC')->equals(Scalar::string('foo')))
    ->newLine()
    
    ->inlineComment('Array assignment')
    ->execute(Variable::named('array')->arrayIndex(Scalar::int(0))->equals(Scalar::string('foo')))
    ->execute(Variable::named('array')->arrayIndex(Scalar::string('index'))->equals(Scalar::string('foo')))
;

/**
 * returns:
 *
 * // Basic assignment
 * $foo = 'bar';
 * $foo .= 'bar';
 * $int += 1;
 * $int -= 1;
 * 
 * // By reference
 * $foo =& $bar;
 * 
 * // Assign from function result
 * $flag = is_array($var);
 * 
 * // Properties
 * $class->property = 'bar';
 * $this->property = 'When inside a class';
 * $class::$STATIC = 'foo';
 * self::$STATIC = 'foo';
 * static::$STATIC = 'foo';
 * 
 * // Array assignment
 * $array[0] = 'foo';
 * $array['index'] = 'foo';
 */
$p->prettyPrint($b->getStatements());
```

<a name="binaryops"/>

## Binary Operations

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Scalar;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$two = Scalar::int(2);

$b
    ->execute($two->plus($two))
    ->execute($two->minus($two))
    ->execute($two->multipliedBy($two))
    ->execute($two->dividedBy($two))
    ->execute($two->toThePowerOf($two))
    ->execute($two->mod($two))
    ->execute($two->shiftRight($two))
    ->execute($two->shiftLeft($two))
    ->execute($two->concat($two))
    ->execute($two->bitwiseOr($two))
    ->execute($two->bitwiseAnd($two))
    ->execute($two->bitwiseXor($two))
    ->execute($two->logicalOr($two))
    ->execute($two->logicalAnd($two))
    ->execute($two->logicalXor($two))
    ->execute($two->coalesce($two))
    ->execute($two->spaceship($two))
    ->execute($two->isEqualTo($two))
    ->execute($two->isIdenticalTo($two))
    ->execute($two->isNotEqualTo($two))
    ->execute($two->isNotIdenticalTo($two))
    ->execute($two->isLessThan($two))
    ->execute($two->isLessThanOrEqualTo($two))
    ->execute($two->isGreaterThan($two))
    ->execute($two->isGreaterThanOrEqualTo($two))
    ->execute($two->instanceOf($two))
;

/**
 * returns:
 *
 * 2 + 2;
 * 2 - 2;
 * 2 * 2;
 * 2 / 2;
 * 2 ** 2;
 * 2 % 2;
 * 2 >> 2;
 * 2 << 2;
 * 2 . 2;
 * 2 | 2;
 * 2 & 2;
 * 2 ^ 2;
 * 2 or 2;
 * 2 and 2;
 * 2 xor 2;
 * 2 ?? 2;
 * 2 <=> 2;
 * 2 == 2;
 * 2 === 2;
 * 2 != 2;
 * 2 !== 2;
 * 2 < 2;
 * 2 <= 2;
 * 2 > 2;
 * 2 >= 2;
 * 2 instanceof 2;
 */
$p->prettyPrint($b->getStatements());
```

<a name="casting"/>

## Casting

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Cast;
use JDWil\PhpGenny\Builder\Node\ResultOf;
use JDWil\PhpGenny\Builder\Node\Type;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->return(Cast::toInt(Variable::named('foo')))
    ->return(Cast::toBool(ResultOf::array_search(Variable::named('foo'), Variable::named('bar'), Type::true())))
    ->execute(Variable::named('flag')->equals(Cast::toBool(ResultOf::is_string(Variable::named('bar')))))
;

/**
 * returns:
 *
 * return (int) $foo;
 * return (bool) array_search($foo, $bar, true);
 * $flag = (bool) is_string($bar); 
 */
$p->prettyPrint($b->getStatements());
```

<a name="classes"/>

## Classes

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\ValueObject\InternalType;
use JDWil\PhpGenny\Builder\Node\Parameter;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use JDWil\PhpGenny\ValueObject\Visibility;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->class('MyClass')
        ->makeFinal()
        ->makeAbstract()
        ->extends('ExtendedClass')
        ->implements('ImplementedInterface')
        
        ->use(['TraitA', 'TraitB'])
            ->alias('TraitA', 'method1')->as('aliasedName', Visibility::isProtected())
            ->use('TraitB', 'method2')->insteadOf('TraitA')
        ->done()
        
        ->constant('MY_CONST', Scalar::int(0))->done()
        
        ->property('foo')
            ->makePrivate()
            ->setDefault(Scalar::int(1))
            ->setType(InternalType::int())
        ->done()
        
        ->method('getFoo')
            ->makePublic()
            ->makeFinal()
            ->add(Parameter::named('param1')->setType(InternalType::string())->setDefault(Scalar::string('default')))
            ->add(Parameter::named('byRef')->makeByRef())
            ->add(Parameter::named('variadic')->makeVariadic())
            ->echo(Variable::named('this')->property(Variable::named('param1')))
            ->return(Variable::named('this')->property('foo'))
        ->done()
    ->done()
;

/**
 * returns:
 *
 * abstract final class MyClass extends ExtendedClass implements ImplementedInterface
 * {
 *     use TraitA, TraitB {
 *         TraitB::method2 insteadof TraitA;
 *         TraitA::method1 as protected aliasedName;
 *     }
 *     const MY_CONST = 0;
 *     private $foo = 1;
 *     public final function getFoo(string $param1 = 'default', &$byRef, ...$variadic)
 *     {
 *         echo $this->{$param1};
 *         return $this->foo;
 *     }
 * }
 */
$p->prettyPrint($b->getStatements());
```

<a name="dowhile"/>

## Do-While Loops

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->do()
        ->execute(Variable::named('x')->postIncrement())
    ->while(Variable::named('x')->isLessThanOrEqualTo(Scalar::int(10)))
;

/**
 * returns:
 * 
 * do {
 *     $x++;
 * } while ($x <= 10);
 */
$p->prettyPrint($b->getStatements());
```

<a name="for"/>

## For Loops

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$x = Variable::named('x');
$zero = Scalar::int(0);
$ten = Scalar::int(10);

$b
    ->for($x->equals($zero), $x->isLessThanOrEqualTo($ten), $x->postIncrement())
        ->echo(Variable::named('x'))
    ->done()
;

/**
 * returns:
 * 
 * for ($x = 0; $x <= 10; $x++) {
 *     echo $x;
 * }
 */
$p->prettyPrint($b->getStatements());
```

<a name="foreach"/>

## Foreach Loops

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->foreach(Variable::named('x'), Variable::named('value'), Variable::named('key'))
        ->echo(Variable::named('value'))
    ->done()
    
    ->newLine()
    
    ->foreach(Variable::named('x'), Variable::named('value'), null, true)
        ->echo(Variable::named('value'))
    ->done()
;

/**
 * returns:
 * 
 * foreach ($x as $key => $value) {
 *     echo $value;
 * }
 * 
 * foreach ($x as &$value) {
 *     echo $value;
 * }
 */
$p->prettyPrint($b->getStatements());
```

<a name="if"/>

## If Statements

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->if(Variable::named('x')->isLessThan(Scalar::int(10)))
        ->echo('x is small')
    ->elseIf(Variable::named('x')->isGreaterThan(Scalar::int(100)))
        ->echo('x is big')
    ->else()
        ->echo('Dunno')
;

/**
 * returns:
 * 
 * if ($x < 10) {
 *     echo 'x is small';
 * } elseif ($x > 100) {
 *     echo 'x is big';
 * } else {
 *     echo 'Dunno';
 * }
 */
$p->prettyPrint($b->getStatements());
```

<a name="imports"/>

## Imports

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->use('Foo\\Bar')
    ->use('Foo\\Bar', 'Baz')
    ->useFunction('Foo\\func')
    ->useFunction('Foo\\func', 'aliasFunc')
;

/**
 * returns:
 * 
 * use Foo\Bar;
 * use Foo\Bar as Baz;
 * use function Foo\func;
 * use function Foo\func as aliasFunc;
 */
$p->prettyPrint($b->getStatements());
```

<a name="interfaces"/>

## Interfaces

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\ValueObject\InternalType;
use JDWil\PhpGenny\Builder\Node\Parameter;
use JDWil\PhpGenny\Builder\Node\Scalar;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->interface('MyInterface')
        ->extends('SomeOtherInterface')
        ->constant('MY_CONST', Scalar::int(0))->done()
        ->method('someMethod')
            ->add(Parameter::named('param1')->setType(InternalType::int())->setDefault(Scalar::int(10)))
            ->setReturnType(InternalType::string())
        ->done()
    ->done()
;

/**
 * returns:
 * 
 * interface MyInterface extends SomeOtherInterface
 * {
 *     const MY_CONST = 0;
 *     public function someMethod(int $param1 = 10) : string;
 * }
 */
$p->prettyPrint($b->getStatements());
```

<a name="logic"/>

## Logic

[Top](#toc)

The `Logic` class contains utility methods for dealing with logic issues.

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Logic;
use JDWil\PhpGenny\Builder\Node\NewInstance;
use JDWil\PhpGenny\Builder\Node\Reference;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->if(Logic::not(Variable::named('foo')->instanceOf(Reference::class('Bar'))))
        ->throw(NewInstance::of('\\Exception', [Scalar::string('There was a problem')]))
    ->done()
    
    ->newLine()
    
    ->if(Logic::bitwiseNot(Variable::named('foo')))
        ->throw(NewInstance::of('\\Exception', [Scalar::string('There was a problem')]))
    ->done()
;

/**
 * returns:
 * 
 * if (!$foo instanceof Bar) {
 *     throw new \Exception('There was a problem');
 * }
 * 
 * if (~$foo) {
 *     throw new \Exception('There was a problem');
 * }
 */
$p->prettyPrint($b->getStatements());
```

<a name="methods"/>

## Methods

[Top](#toc)

_See [Classes](#classes)_

<a name="namespaces"/>

## Namespaces

Namespace_ extends Builder and you can add most nodes to it that you can in builder, save another Namespace.

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->namespace('Foo')
        ->class('Bar')->done()
    ->done()
;

/**
 * returns:
 * 
 * namespace Foo;
 * 
 * class Bar
 * {
 * }
 */
$p->prettyPrint($b->getStatements());
```

<a name="newinstance"/>

## NewInstance

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\NewInstance;
use JDWil\PhpGenny\Type\Class_ as ClassType;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$classType = new ClassType('ClassType');
$classNode = (new Builder())->class('ClassNode');

$b
    ->execute(NewInstance::of('ClassName'))
    ->execute(NewInstance::of($classType))
    ->execute(NewInstance::of($classNode))
;

/**
 * returns:
 * 
 * new ClassName();
 * new ClassType();
 * new ClassNode();
 */
$p->prettyPrint($b->getStatements());
```

<a name="parameters"/>

## Parameters

[Top](#toc)

_See [Classes](#classes)_

<a name="properties"/>

## Properties

[Top](#toc)

_See [Classes](#classes)_

<a name="reference"/>

## Reference

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Reference;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->execute(Reference::class('Foo')->staticProperty('STATIC_PROPERTY'))
    ->execute(Reference::self()->staticProperty('STATIC_PROPERTY'))
    ->execute(Reference::static()->staticProperty('STATIC_PROPERTY'))
    ->execute(Reference::class('Foo')->constant('CONSTANT'))
    ->execute(Reference::self()->constant('CONSTANT'))
;

/**
 * returns:
 *
 * Foo::$STATIC_PROPERTY;
 * self::$STATIC_PROPERTY;
 * static::$STATIC_PROPERTY;
 * Foo::CONSTANT;
 * self::CONSTANT;
 */
$p->prettyPrint($b->getStatements());
```

<a name="resultof"/>

## ResultOf

Access the static methods of `ResultOf` to reference calls to internal functions.

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\NewInstance;
use JDWil\PhpGenny\Builder\Node\Reference;
use JDWil\PhpGenny\Builder\Node\ResultOf;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->execute(ResultOf::get_class(Variable::named('myVar')))
    ->execute(ResultOf::methodCall(Variable::named('myClass'), 'foo', Scalar::string('param1'), Variable::named('param2')))
    ->execute(ResultOf::staticMethodCall(Variable::named('myClass'), 'staticMethod', Scalar::int(0)))
    ->execute(ResultOf::staticMethodCall(Reference::class('F\\Q\\C'), 'staticMethod', Scalar::float(1.1)))
    ->execute(ResultOf::methodCall(NewInstance::of('MyClass'), 'foo', Scalar::int(0)))
;

/**
 * returns:
 *
 * get_class($myVar);
 * $myClass->foo('param1', $param2);
 * $myClass::staticMethod(0);
 * F\Q\C::staticMethod(1.1);
 * (new MyClass())->foo(0);
 */
$p->prettyPrint($b->getStatements());
```

<a name="scalar"/>

## Scalar

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Scalar;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->execute(Scalar::string('stringVal'))
    ->execute(Scalar::int(1))
    ->execute(Scalar::float(1.1))
;

/**
 * returns:
 *
 * 'stringVal';
 * 1;
 * 1.1;
 */
$p->prettyPrint($b->getStatements());
```

<a name="switch"/>

## Switch Statements

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->switch(Variable::named('foo'))
        ->case(Scalar::string('bar'))
            ->echo('Got bar')
            ->break()
        ->done()
        ->case(Scalar::string('baz'))
            ->echo('Got baz')
            ->break()
        ->done()
    ->done()
;

/**
 * returns:
 *
 * switch ($foo) {
 *     case 'bar':
 *         echo 'Got bar';
 *         break;
 *     case 'baz':
 *         echo 'Got baz';
 *         break;
 * }
 */
$p->prettyPrint($b->getStatements());
```

<a name="traits"/>

## Traits

_See [Properties](#properties)_

_See [Methods](#methods)_

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\ValueObject\InternalType;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->trait('MyTrait')
        ->use('OtherTrait')->done()
        ->property('property')
            ->setType(InternalType::string())
            ->setDefault(Scalar::string('default'))
        ->done()
        ->method('getProperty')
            ->return(Variable::named('this')->property('property'))
        ->done()
;

/**
 * returns:
 *
 * trait MyTrait
 * {
 *     use OtherTrait;
 *     public $property = 'default';
 *     public function getProperty()
 *     {
 *         return $this->property;
 *     }
 * }
 */
$p->prettyPrint($b->getStatements());
```

<a name="try"/>

## Try/Catch/Finally

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Func;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->try()
        ->execute(Variable::named('x')->equals(Func::call('myFunction', [])))
    ->catch(['\\Exception'], 'e')
        ->echo('Got an error')
    ->finally()
        ->unset(Variable::named('x'))
    ->done()
;

/**
 * returns:
 *
 * try {
 *     $x = myFunction();
 * } catch (\Exception $e) {
 *     echo 'Got an error';
 * } finally {
 *     unset($x);
 * }
 */
$p->prettyPrint($b->getStatements());
```

<a name="type"/>

## Type

You can reference PHP special types via the `Type` class.

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Type;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->execute(Type::true())
    ->execute(Type::false())
    ->execute(Type::null())
    ->execute(Type::array())
    ->execute(Type::array([Scalar::string('foo'), Scalar::string('bar')], false))
    ->execute(Type::list(Variable::named('x'), Variable::named('y'))->equals(Variable::named('array')))
;

/**
 * returns:
 *
 * true;
 * false;
 * null;
 * [];
 * array('foo', 'bar');
 * list($x, $y) = $array;
 */
$p->prettyPrint($b->getStatements());
```

<a name="variable"/>

## Variable

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->execute(Variable::named('x'))
;

/**
 * returns:
 *
 * $x;
 */
$p->prettyPrint($b->getStatements());
```

<a name="while"/>

## While Loops

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->while(Variable::named('x')->isLessThan(Scalar::int(10)))
        ->execute(Variable::named('x')->postIncrement())
    ->done()
;

/**
 * returns:
 *
 * while ($x < 10) {
 *     $x++;
 * }
 */
$p->prettyPrint($b->getStatements());
```

<a name="misc"/>

## Miscellanea

[Top](#toc)

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\NewInstance;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use PhpParser\PrettyPrinter\Standard;

$b = new Builder();
$p = new Standard();

$b
    ->inlineComment('Goto')
    ->label('label')
    ->goto('label')
    ->newLine()
    
    ->inlineComment('Halt compiler')
    ->haltCompiler('halt text')
    ->newLine()
    
    ->inlineComment('Throw')
    ->throw(NewInstance::of('\\Exception', [Scalar::string('Text')]))
    ->newLine()
    
    ->inlineComment('Output')
    ->print('Text')
    ->print(Scalar::string('Text'))
    ->echo('Text')
    ->newLine()
    
    ->inlineComment('Globals')
    ->global(Variable::named('global1'), Variable::named('global2'))
    ->newLine()
    
    ->inlineComment('Static variables')
    ->static(Variable::named('static1'), Variable::named('static2'))
    ->newLine()
    
    ->inlineComment('Unset')
    ->unset(Variable::named('var'))
    ->newLine()
    
    ->inlineComment('Yield')
    ->yield(Variable::named('foo'))
    ->yield(Variable::named('foo'), Scalar::string('baz'))
    ->yieldFrom(Variable::named('foo'))
    ->newLine()
    
    ->inlineComment('Exit')
    ->exit(Scalar::int(0))
    ->die(Scalar::int(0))
    ->newLine()
    
    ->inlineComment('Suppress error')
    ->suppressError(Variable::named('expression'))
    ->newLine()
    
    ->inlineComment('Inline HTML')
    ->inlineHtml('<html></html>')
    ->newLine()
    
    ->inlineComment('Declare')
    ->declare('strict_types', Scalar::int(0))
;

/**
 * returns:
 *
 * // Goto
 * label:
 * goto label;
 * 
 * // Halt compiler
 * __halt_compiler();halt text
 * 
 * // Throw
 * throw new \Exception('Text');
 * 
 * // Output
 * print 'Text';
 * print 'Text';
 * echo 'Text';
 * 
 * // Globals
 * global $global1, $global2;
 * 
 * // Static variables
 * static $static1, $static2;
 * 
 * // Unset
 * unset($var);
 * 
 * // Yield
 * (yield $foo);
 * (yield 'baz' => $foo);
 * yield from $foo;
 * 
 * // Exit
 * die(0);
 * die(0);
 * 
 * // Suppress error
 * @$expression;
 * 
 * // Inline HTML
 * ?>
 * <html></html><?php 
 * 
 * // Declare
 * declare (strict_types=0);
 */
$p->prettyPrint($b->getStatements());
```
