<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

abstract class AbstractNodeContainer extends AbstractNode
{
    /**
     * @var AbstractNode[]
     */
    protected $nodes;

    /**
     * @param AbstractNode $node
     * @return self
     */
    public function addCode(AbstractNode $node): AbstractNodeContainer
    {
        $this->nodes[] = $node;

        return $this;
    }

    /**
     * @return AbstractNode[]
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }

    /**
     * @param AbstractNode[] $nodes
     * @return $this
     */
    public function setNodes(array $nodes)
    {
        $this->nodes = $nodes;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatements()
    {
        return array_map(function ($node) {
            if ($node instanceof AbstractNode) {
                return $node->getStatements();
            }

            return $node;
        }, $this->nodes);
    }
}
