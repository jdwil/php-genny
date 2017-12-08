<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use PhpParser\Node\Expr\BitwiseNot;
use PhpParser\Node\Expr\BooleanNot;

class Logic
{
    /**
     * @param AbstractNode $node
     * @return Node
     */
    public static function not(AbstractNode $node)
    {
        return Node::new(BooleanNot::class, [$node->getStatements()]);
    }

    /**
     * @param AbstractNode $node
     * @return Node
     */
    public static function bitwiseNot(AbstractNode $node)
    {
        return Node::new(BitwiseNot::class, [$node->getStatements()]);
    }
}
