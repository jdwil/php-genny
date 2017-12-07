<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node\Traits;

use PhpParser\Node\Stmt\Class_;

trait StaticTrait
{
    /**
     * @var bool
     */
    protected $static;

    /**
     * @return $this
     */
    public function makeStatic()
    {
        $this->static = true;

        return $this;
    }

    /**
     * @param int $flags
     * @return int
     */
    protected function addStaticFlag(int $flags): int
    {
        if ($this->static) {
            $flags ^= Class_::MODIFIER_STATIC;
        }

        return $flags;
    }
}
