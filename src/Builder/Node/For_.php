<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;

class For_ extends Builder
{
    /**
     * @var AbstractNode|null
     */
    protected $init;

    /**
     * @var AbstractNode|null
     */
    protected $condition;

    /**
     * @var AbstractNode|null
     */
    protected $loop;

    public static function new(AbstractNode $init, AbstractNode $condition, AbstractNode $loop): For_
    {
        $ret = new static();
        $ret->init = $init;
        $ret->condition = $condition;
        $ret->loop = $loop;

        return $ret;
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Builder) {
            throw new \Exception('Parent of For_ must be a Builder');
        }

        return $this->parent;
    }

    public function getStatements()
    {
        $params = [];
        if (null !== $this->init) {
            if (is_array($this->init)) {
                $params['init'] = array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $this->init);
            } else {
                $params['init'] = [$this->init->getStatements()];
            }
        }

        if (null !== $this->condition) {
            if (is_array($this->condition)) {
                $params['cond'] = array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $this->condition);
            } else {
                $params['cond'] = [$this->condition->getStatements()];
            }
        }

        if (null !== $this->loop) {
            if (is_array($this->loop)) {
                $params['loop'] = array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $this->loop);
            } else {
                $params['loop'] = [$this->loop->getStatements()];
            }
        }

        $params['stmts'] = array_map(function (AbstractNode $node) {
            return $node->getStatements();
        }, $this->nodes);

        return new \PhpParser\Node\Stmt\For_($params);
    }
}
