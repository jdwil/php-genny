<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node\Traits;

use JDWil\PhpGenny\ValueObject\Visibility;
use PhpParser\Node\Stmt\Class_;

trait VisibilityTrait
{
    protected $visibility;

    public function makePrivate()
    {
        $this->visibility = Visibility::isPrivate();

        return $this;
    }

    public function makeProtected()
    {
        $this->visibility = Visibility::isProtected();

        return $this;
    }

    public function makePublic()
    {
        $this->visibility = Visibility::isPublic();

        return $this;
    }

    protected function addVisibilityFlags(int $flags): int
    {
        switch ((string) $this->visibility) {
            case Visibility::PUBLIC:
                $flags ^= Class_::MODIFIER_PUBLIC;
                break;

            case Visibility::PROTECTED:
                $flags ^= Class_::MODIFIER_PROTECTED;
                break;

            case Visibility::PRIVATE:
                $flags ^= Class_::MODIFIER_PRIVATE;
                break;
        }

        return $flags;
    }
}
