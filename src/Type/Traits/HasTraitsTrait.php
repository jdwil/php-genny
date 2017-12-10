<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type\Traits;

use JDWil\PhpGenny\Type\Trait_;

trait HasTraitsTrait
{
    /**
     * @var Trait_[]
     */
    protected $traits;

    /**
     * @param Trait_ $trait
     */
    public function addTrait(Trait_ $trait)
    {
        $this->traits[] = $trait;
    }

    /**
     * @return Trait_[]
     */
    public function getTraits(): array
    {
        return $this->traits;
    }

    /**
     * @param Trait_ $trait
     */
    public function removeTrait(Trait_ $trait)
    {
        $key = array_search($trait, $this->traits, true);
        if ($key !== false) {
            array_splice($this->traits, $key, 1);
        }
    }
}
