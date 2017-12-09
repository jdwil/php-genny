<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;

class NewInstance extends AbstractNode
{
    /**
     * @var mixed
     */
    protected $name;

    /**
     * @var array
     */
    protected $arguments;

    /**
     * @param $name
     * @param array $arguments
     * @return NewInstance
     */
    public static function of($name, array $arguments = []): NewInstance
    {
        $ret = new static();
        $ret->name = $name;
        $ret->arguments = $arguments;

        return $ret;
    }

    /**
     * @return New_
     * @throws \Exception
     */
    public function getStatements(): New_
    {
        if ($this->name instanceof \JDWil\PhpGenny\Type\Class_) {
            $name = $this->name->getName();
        } else if ($this->name instanceof Class_) {
            $name = $this->name->getName();
        } else if (is_string($this->name)) {
            $name = $this->name;
        } else {
            throw new \Exception('Unknown type for class name');
        }

        return new New_(new Name($name), array_map(function ($arg) {
            if ($arg instanceof AbstractNode) {
                return $arg->getStatements();
            }

            return $arg;
        }, $this->arguments));
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [];
    }
}
