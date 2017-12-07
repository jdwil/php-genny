<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node\Traits;

use PhpParser\Node\Stmt\Class_;

trait AbstractTrait
{
    /**
     * @var bool
     */
    protected $abstract;

    public function makeAbstract()
    {
        $this->abstract = true;

        return $this;
    }

    protected function addAbstractFlag(int $flags): int
    {
        if ($this->abstract) {
            $flags ^= Class_::MODIFIER_ABSTRACT;
        }

        return $flags;
    }
}
