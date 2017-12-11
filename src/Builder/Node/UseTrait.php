<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\NestedNodeTrait;
use JDWil\PhpGenny\ValueObject\Visibility;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\TraitUse;
use PhpParser\Node\Stmt\TraitUseAdaptation\Alias;
use PhpParser\Node\Stmt\TraitUseAdaptation\Precedence;

class UseTrait extends AbstractNode
{
    use NestedNodeTrait;

    /**
     * @var string[]
     */
    protected $traits;

    /**
     * @var array
     */
    protected $alias;

    /**
     * @var array
     */
    protected $precedence;

    /**
     * @var array|null
     */
    protected $lastAlias;

    /**
     * @var array|null
     */
    protected $lastUse;

    /**
     * @param array $traits
     * @return UseTrait
     */
    public static function new(array $traits): UseTrait
    {
        $ret = new static();
        $ret->traits = $traits;
        $ret->precedence = [];
        $ret->alias = [];

        return $ret;
    }

    /**
     * @return Class_|Trait_
     * @throws \Exception
     */
    public function done()
    {
        if (!$this->parent instanceof Class_ && !$this->parent instanceof Trait_) {
            throw new \Exception('Parent of UseTrait must be a Class_ or Trait_');
        }

        return $this->parent;
    }

    /**
     * @param string $trait
     * @param string $method
     * @return $this
     */
    public function alias(string $trait, string $method)
    {
        $this->lastAlias = [
            'trait' => $trait,
            'method' => $method
        ];

        return $this;
    }

    /**
     * @param string $name
     * @param Visibility|null $visibility
     * @return $this
     * @throws \Exception
     */
    public function as(string $name, Visibility $visibility = null)
    {
        if (null === $this->lastAlias) {
            throw new \Exception('You must call alias() before as()');
        }

        $this->alias[] = [
            'trait' => $this->lastAlias['trait'],
            'method' => $this->lastAlias['method'],
            'newName' => $name,
            'visibility' => $visibility
        ];

        $this->lastAlias = null;

        return $this;
    }

    /**
     * @param string $trait
     * @param string $method
     * @return $this
     */
    public function use(string $trait, string $method)
    {
        $this->lastUse = [
            'trait' => $trait,
            'method' => $method
        ];

        return $this;
    }

    /**
     * @param string|string[] $trait
     * @return $this
     * @throws \Exception
     */
    public function insteadOf($trait)
    {
        if (null === $this->lastUse) {
            throw new \Exception('You must call use() before insteadOf()');
        }

        if (is_string($trait)) {
            $trait = [$trait];
        }

        $this->precedence[] = [
            'trait' => $this->lastUse['trait'],
            'method' => $this->lastUse['method'],
            'traits' => $trait
        ];

        $this->lastUse = null;

        return $this;
    }

    /**
     * @return TraitUse
     */
    public function getStatements(): TraitUse
    {
        $adaptations = array_map(function ($a) {
            return new Precedence(
                new Name($a['trait']),
                $a['method'],
                array_map(function ($t) {
                    return new Name($t);
                }, $a['traits'])
            );
        }, $this->precedence);

        $adaptations = array_merge($adaptations, array_map(function ($a) {
            $visibility = null;
            if ($a['visibility'] instanceof Visibility) {
                $visibility = $a['visibility']->toPhpParserConstant();
            }

            return new Alias(
                new Name($a['trait']),
                $a['method'],
                $visibility,
                $a['newName']
            );
        }, $this->alias));

        return new TraitUse(
            array_map(function ($name) {
                return new Name($name);
            }, $this->traits),
            $adaptations
        );
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [];
    }
}
