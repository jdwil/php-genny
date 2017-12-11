<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

use JDWil\PhpGenny\ValueObject\Visibility;

interface HasTraitsInterface extends NamespaceInterface
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

    /**
     * @param Trait_ $trait
     * @param string $method
     * @param string $newName
     * @param Visibility|null $visibility
     */
    public function aliasTrait(Trait_ $trait, string $method, string $newName, Visibility $visibility = null);

    /**
     * @return array
     */
    public function getAlias(): array;

    /**
     * @param Trait_ $trait
     * @param string $method
     * @param Trait_[] $otherTraits
     */
    public function setTraitPrecedence(Trait_ $trait, string $method, array $otherTraits);

    /**
     * @return array
     */
    public function getPrecedences(): array;
}
