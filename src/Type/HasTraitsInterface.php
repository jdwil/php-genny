<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

interface HasTraitsInterface
{
    /**
     * @param Trait_ $trait
     */
    public function addTrait(Trait_ $trait);

    /**
     * @return Trait_[]
     */
    public function getTraits(): array;

    /**
     * @param Trait_ $trait
     */
    public function removeTrait(Trait_ $trait);
}
