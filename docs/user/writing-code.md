# Writing Code

```php
<?php

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

/**
 * creates '/tmp/My/Project/Interfaces/LoggingInterface.php'.
 * creates '/tmp/My/Project/Traits/LoggingTrait.php'.
 * creates '/tmp/My/Project/Classes/MyClass.php'.
 */
$writer->writeAll([
    $interface,
    $trait,
    $class
]);

`rm -Rf /tmp/My`;
```
