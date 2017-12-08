<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;

class Foreach_ extends Builder
{
    /**
     * @var AbstractNode
     */
    protected $subject;

    /**
     * @var AbstractNode
     */
    protected $valueVar;

    /**
     * @var AbstractNode|null
     */
    protected $keyVar;

    /**
     * @var bool
     */
    protected $byRef;

    /**
     * @param AbstractNode $subject
     * @param AbstractNode $valueVar
     * @param AbstractNode|null $keyVar
     * @param bool $byRef
     * @return Foreach_
     */
    public static function new(
        AbstractNode $subject,
        AbstractNode $valueVar,
        AbstractNode $keyVar = null,
        bool $byRef = false
    ): Foreach_ {
        $ret = new static();
        $ret->subject = $subject;
        $ret->valueVar = $valueVar;
        $ret->keyVar = $keyVar;
        $ret->byRef = $byRef;

        return $ret;
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Builder) {
            throw new \Exception('Parent of Foreach_ must be a Builder');
        }

        return $this->parent;
    }

    public function getStatements()
    {
        $params = [
            'byRef' => $this->byRef,
            'stmts' => parent::getStatements()
        ];

        if (null !== $this->keyVar) {
            $params['keyVar'] = $this->keyVar->getStatements();
        }

        return new \PhpParser\Node\Stmt\Foreach_(
            $this->subject->getStatements(),
            $this->valueVar->getStatements(),
            $params
        );
    }
}
