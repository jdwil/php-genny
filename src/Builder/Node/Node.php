<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\AssignmentOpTrait;
use JDWil\PhpGenny\Builder\Node\Traits\BinaryOpTrait;

class Node extends AbstractNode
{
    use AssignmentOpTrait;
    use BinaryOpTrait;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var array
     */
    protected $params;

    /**
     * @param string $type
     * @param array $params
     * @return Node
     */
    public static function new(string $type, array $params)
    {
        $ret = new Node();
        $ret->type = $type;
        $ret->params = $params;

        return $ret;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function getStatements()
    {
        return new $this->type(...array_map(function ($value) {
            if ($value instanceof AbstractNode) {
                return $value->getStatements();
            }

            return $value;
        }, $this->params));
    }
}
