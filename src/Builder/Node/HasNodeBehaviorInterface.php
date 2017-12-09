<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

interface HasNodeBehaviorInterface
{
    /**
     * @return $this
     */
    public function autoGenerateDocBlocks();

    /**
     * @param int $version
     */
    public function setPhpTargetVersion(int $version);

    /**
     * @param HasNodeBehaviorInterface $b
     * @return mixed
     */
    public function copyBehaviorFrom(HasNodeBehaviorInterface $b);

    /**
     * @return bool
     */
    public function getAutoGenerateDocBlocks(): bool;

    /**
     * @return int
     */
    public function getPhpTargetVersion(): int;

    /**
     * @return $this
     */
    public function useStrictTypes();

    /**
     * @return bool
     */
    public function getUseStrictTypes(): bool;

    /**
     * @return $this
     */
    public function preferDefaultsSetInConstructor();

    /**
     * @return bool
     */
    public function getPreferDefaultsSetInConstructor(): bool;
}
