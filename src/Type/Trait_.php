<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

use JDWil\PhpGenny\Type\Traits\HasMethodsTrait;
use JDWil\PhpGenny\Type\Traits\HasNamespaceTrait;
use JDWil\PhpGenny\Type\Traits\HasPropertiesTrait;
use JDWil\PhpGenny\Type\Traits\HasTraitsTrait;

/**
 * Class Trait_
 */
class Trait_ implements HasPropertiesInterface, HasTraitsInterface, HasMethodsInterface
{
    use HasNamespaceTrait;
    use HasTraitsTrait;
    use HasPropertiesTrait;
    use HasMethodsTrait;

    /**
     * Class_ constructor.
     */
    public function __construct()
    {
        $this->properties = [];
        $this->methods = [];
    }
}
