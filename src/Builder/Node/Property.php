<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\DocBlockTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NestedNodeTrait;
use JDWil\PhpGenny\Builder\Node\Traits\VisibilityTrait;
use JDWil\PhpGenny\ValueObject\InternalType;
use JDWil\PhpGenny\ValueObject\Visibility;
use PhpParser\Comment\Doc;
use PhpParser\Node\Stmt\PropertyProperty;

class Property extends AbstractNode
{
    use NestedNodeTrait;
    use VisibilityTrait;
    use DocBlockTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var bool
     */
    protected $static;

    /**
     * @var AbstractNode
     */
    protected $default;

    /**
     * @var InternalType|Class_
     */
    protected $type;

    public static function new(string $name)
    {
        $ret = new Property();
        $ret->name = $name;
        $ret->static = false;
        $ret->visibility = Visibility::isPublic();

        return $ret;
    }

    public function done(): Class_
    {
        if (!$this->parent instanceof Class_) {
            throw new \Exception('Parent of Property must be an instance of Class_');
        }

        return $this->parent;
    }

    public function makeStatic()
    {
        $this->static = true;

        return $this;
    }

    public function setDefault(AbstractNode $default)
    {
        $this->default = $default;

        if ($default instanceof Scalar) {
            $this->setType($default->getInternalType());
        }

        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;

        if ($type instanceof InternalType) {
            $this->setComments(['@var ' . (string) $type]);
        } else if ($type instanceof \JDWil\PhpGenny\Type\Class_) {
            $this->setComments(['@var ' . $type->getName()]);
        }

        return $this;
    }

    public function getStatements()
    {
        $flags = $this->addVisibilityFlags(0);

        if ($this->static) {
            $flags ^= \PhpParser\Node\Stmt\Class_::MODIFIER_STATIC;
        }

        $default = null;
        if (null !== $this->default) {
            $default = $this->default->getStatements();
        }

        $ret = new \PhpParser\Node\Stmt\Property(
            $flags, [new PropertyProperty($this->name, $default)]
        );
        $ret->setDocComment(new Doc($this->getComments()));

        return $ret;
    }
}
