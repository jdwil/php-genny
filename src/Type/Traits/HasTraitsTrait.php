<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type\Traits;

use JDWil\PhpGenny\Type\Trait_;
use JDWil\PhpGenny\ValueObject\Visibility;

/**
 * Trait HasTraitsTrait
 */
trait HasTraitsTrait
{
    /**
     * @var Trait_[]
     */
    protected $traits = [];

    /**
     * @var array
     */
    protected $traitAlias = [];

    /**
     * @var array
     */
    protected $traitPrecedences = [];

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

    /**
     * @param Trait_ $trait
     * @param string $method
     * @param string $newName
     * @param Visibility|null $visibility
     */
    public function aliasTrait(Trait_ $trait, string $method, string $newName, Visibility $visibility = null)
    {
        $this->traitAlias[$trait->getFqn()] = [
            'trait' => $trait->getName(),
            'method' => $method,
            'newName' => $newName,
            'visibility' => $visibility
        ];
    }

    /**
     * @return array
     */
    public function getAlias(): array
    {
        return $this->traitAlias;
    }

    /**
     * @param Trait_ $trait
     * @param string $method
     * @param Trait_[] $otherTraits
     */
    public function setTraitPrecedence(Trait_ $trait, string $method, array $otherTraits)
    {
        $this->traitPrecedences[$trait->getFqn()] = [
            'trait' => $trait->getName(),
            'method' => $method,
            'otherTraits' => $otherTraits
        ];
    }

    /**
     * @return array
     */
    public function getPrecedences(): array
    {
        return $this->traitPrecedences;
    }
}
