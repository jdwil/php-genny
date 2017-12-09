<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node\Traits;

use JDWil\PhpGenny\Builder\Node\HasNodeBehaviorInterface;

trait NodeBehaviorTrait
{
    /**
     * @var int
     */
    public $phpTargetVersion = 70;

    /**
     * @var bool
     */
    public $autoGenerateDocBlocks = false;

    /**
     * @var bool
     */
    protected $useStrict;

    /**
     * @var bool
     */
    protected $preferDefaultsSetInConstructor;

    /**
     * @param HasNodeBehaviorInterface $b
     */
    public function copyBehaviorFrom(HasNodeBehaviorInterface $b)
    {
        $this->autoGenerateDocBlocks = $b->getAutoGenerateDocBlocks();
        $this->phpTargetVersion = $b->getPhpTargetVersion();
        $this->useStrict = $b->getUseStrictTypes();
        $this->preferDefaultsSetInConstructor = $b->getPreferDefaultsSetInConstructor();
    }

    /**
     * @return $this
     */
    public function autoGenerateDocBlocks()
    {
        $this->autoGenerateDocBlocks = true;

        return $this;
    }

    /**
     * @param int $version
     */
    public function setPhpTargetVersion(int $version)
    {
        $this->phpTargetVersion = $version;
    }

    /**
     * @return int
     */
    public function getPhpTargetVersion(): int
    {
        return $this->phpTargetVersion;
    }

    /**
     * @return bool
     */
    public function getAutoGenerateDocBlocks(): bool
    {
        return $this->autoGenerateDocBlocks;
    }

    /**
     * @return $this
     */
    public function useStrictTypes()
    {
        $this->useStrict = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function getUseStrictTypes(): bool
    {
        return $this->useStrict;
    }

    /**
     * @return $this
     */
    public function preferDefaultsSetInConstructor()
    {
        $this->preferDefaultsSetInConstructor = true;

        return $this;
    }

    /**
     * @return bool
     */
    public function getPreferDefaultsSetInConstructor(): bool
    {
        return $this->preferDefaultsSetInConstructor;
    }
}
