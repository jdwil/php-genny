<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node\Traits;

use PhpParser\Node\Stmt\Class_;

trait FinalTrait
{
    /**
     * @var bool
     */
    protected $final;

    public function makeFinal()
    {
        $this->final = true;

        return $this;
    }

    protected function addFinalFlag(int $flags): int
    {
        if ($this->final) {
            $flags ^= Class_::MODIFIER_FINAL;
        }

        return $flags;
    }
}
